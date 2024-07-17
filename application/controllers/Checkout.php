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

    // Simpan informasi pengiriman jika belum ada
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

    $order_data = array(
      'customer_id' => $user_id,
      'total_price' => $total_price,
      'status' => 'pending',
      'payment_method' => $this->input->post('payment_method') ? $this->input->post('payment_method') : 'COD'
    );

    $order_id = $this->Order_model->create_order($user_id, $total_price, 'pending', $this->input->post('payment_method'));
    foreach ($cart_items as $item) {
      $this->Order_model->add_order_item($order_id, $item->product_id, $item->quantity, $item->price);
    }

    $this->Cart_model->clear_cart($cart->id);

    redirect('checkout/success');
  }

  public function success()
  {
    $data = [
      'title'      => 'BeliYuk - Web Oleh-oleh',
    ];
    $page = '/official/checkout/order_success';
    pageOfficial($page, $data);
  }
}
