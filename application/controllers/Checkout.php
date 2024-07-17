<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Cart_model');
    $this->load->model('Order_model');
    $this->load->model('Customer_model');
    $this->load->model('Location_model');
    $this->load->library('session');
    $this->load->config('midtrans');
    $this->load->helper('url');

    // Load Midtrans library
    require_once(APPPATH . 'vendor/autoload.php');
    \Midtrans\Config::$serverKey = $this->config->item('midtrans_server_key');
    \Midtrans\Config::$isProduction = $this->config->item('midtrans_is_production');
    \Midtrans\Config::$isSanitized = $this->config->item('midtrans_is_sanitized');
    \Midtrans\Config::$is3ds = $this->config->item('midtrans_is_3ds');
  }

  public function index()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      redirect('auth/login');
    }

    $cart = $this->Cart_model->get_cart_by_user_id($user_id);
    if (!$cart) {
      return;
    }

    $customer = $this->Customer_model->get_customer_by_user_id($user_id);
    if ($customer) {
      $data['customer'] = $customer;
    } else {
      $data['customer'] = null;
      $data['provinces'] = $this->Location_model->get_provinces();
    }

    $data['title'] = 'BeliYuk - Web Oleh-oleh';
    $data['cart_items'] = $this->Cart_model->get_cart_items($cart->id);
    $page = '/official/checkout/index';
    pageOfficial($page, $data);
  }

  public function get_regencies()
  {
    $province_id = $this->input->post('province_id');
    $regencies = $this->Location_model->get_regencies_by_province($province_id);
    echo json_encode($regencies);
  }

  public function get_districts()
  {
    $regency_id = $this->input->post('regency_id');
    $districts = $this->Location_model->get_districts_by_regency($regency_id);
    echo json_encode($districts);
  }

  public function get_villages()
  {
    $district_id = $this->input->post('district_id');
    $villages = $this->Location_model->get_villages_by_district($district_id);
    echo json_encode($villages);
  }

  public function place_order()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      redirect('auth/login');
    }

    $cart = $this->Cart_model->get_cart_by_user_id($user_id);
    if (!$cart) {
      redirect('checkout');
    }

    $cart_items = $this->Cart_model->get_cart_items($cart->id);
    if (empty($cart_items)) {
      redirect('checkout');
    }

    $total_price = 0;
    foreach ($cart_items as $item) {
      $total_price += $item->quantity * $item->price;
    }

    $customer = $this->Customer_model->get_customer_by_user_id($user_id);
    if (!$customer) {
      $customer_data = array(
        'user_id' => $user_id,
        'province_id' => $this->input->post('province'),
        'regency_id' => $this->input->post('regency'),
        'district_id' => $this->input->post('district'),
        'village_id' => $this->input->post('village'),
        'address' => $this->input->post('address')
      );
      $this->Customer_model->insert_customer($customer_data);
    } else {
      $customer_data = array(
        'province_id' => $this->input->post('province'),
        'regency_id' => $this->input->post('regency'),
        'district_id' => $this->input->post('district'),
        'village_id' => $this->input->post('village'),
        'address' => $this->input->post('address')
      );
      $this->Customer_model->update_customer($user_id, $customer_data);
    }

    $payment_method = $this->input->post('payment_method');

    $order_id = $this->Order_model->create_order($user_id, $total_price, 'pending', $payment_method);

    foreach ($cart_items as $item) {
      $this->Order_model->add_order_item($order_id, $item->product_id, $item->quantity, $item->price);
    }

    if ($payment_method == 'cod') {
      $this->Cart_model->clear_cart_items($cart->id);
      $this->Cart_model->delete_cart($cart->id);
      redirect('checkout/success');
    } else {
      $transaction_details = array(
        'order_id' => $order_id,
        'gross_amount' => $total_price,
      );

      $item_details = array();
      foreach ($cart_items as $item) {
        $item_details[] = array(
          'id' => $item->product_id,
          'price' => $item->price,
          'quantity' => $item->quantity,
          'name' => $item->name
        );
      }

      $customer_details = array(
        'first_name' => $this->session->userdata('username'),
        'email' => $this->session->userdata('email'),
        'phone' => "08123456789",
        'shipping_address' => array(
          'first_name' => $this->session->userdata('username'),
          'address' => $customer_data['address'],
          'city' => $customer->regency_name,
          'postal_code' => "12345",
          'phone' => "08123456789",
          'country_code' => 'IDN'
        )
      );

      $transaction_data = array(
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details
      );

      try {
        $snapToken = \Midtrans\Snap::getSnapToken($transaction_data);
        echo json_encode(['snap_token' => $snapToken]);
      } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
      }
    }
  }

  public function payment_callback()
  {
    $json_result = file_get_contents('php://input');
    $result = json_decode($json_result, true);

    if ($result) {
      $order_id = $result['order_id'];
      $transaction_status = $result['transaction_status'];
      $payment_type = $result['payment_type'];
      $fraud_status = isset($result['fraud_status']) ? $result['fraud_status'] : null;

      $data = array(
        'status' => $transaction_status,
        'payment_method' => $payment_type,
      );

      $this->Order_model->update_order_status($order_id, $data);
      if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
        $order = $this->Order_model->get_order_by_id($order_id);
        if ($order) {
          $this->Cart_model->clear_cart_by_user_id($order->customer_id);
        }
      }
    }
  }

  public function success()
  {
    // $user_id = $this->session->userdata('user_id');

    // if ($user_id) {
    //   $cart_id = $this->Cart_model->get_cart_id_by_user_id($user_id);
    //   $this->Cart_model->clear_cart_items($cart_id);
    //   $this->Cart_model->delete_cart($cart_id);
    // }
    $data = [
      'title' => 'BeliYuk - Web Oleh-oleh',
    ];
    $page = '/official/checkout/order_success';
    pageOfficial($page, $data);
  }
}
