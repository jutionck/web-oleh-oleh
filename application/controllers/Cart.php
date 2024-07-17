<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('cart');
    $this->load->model('Cart_model');
    $this->load->model('Order_model');
    $this->load->model('Product_model');
    $this->load->library('session');
  }

  public function add_to_cart()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      echo json_encode(['error' => 'User not logged in']);
      return;
    }

    $product_id = $this->input->post('id');
    $name = $this->input->post('name');
    $price = $this->input->post('price');
    $qty = $this->input->post('qty');

    $cart = $this->Cart_model->get_cart_by_user_id($user_id);
    if (!$cart) {
      $cart_id = $this->Cart_model->create_cart($user_id);
    } else {
      $cart_id = $cart->id;
    }

    $this->Cart_model->add_item_to_cart($cart_id, $product_id, $qty, $price);

    // Get the updated cart items
    $cart_items = $this->Cart_model->get_cart_items($cart_id);
    $total_items = 0;
    foreach ($cart_items as $item) {
      $total_items += $item->quantity;
    }

    $response = array(
      'total_items' => $total_items
    );

    echo json_encode($response);
  }

  public function get_cart_items()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      echo json_encode(['items' => []]);
      return;
    }

    $cart = $this->Cart_model->get_cart_by_user_id($user_id);
    if (!$cart) {
      echo json_encode(['items' => []]);
      return;
    }

    $cart_items = $this->Cart_model->get_cart_items($cart->id);
    foreach ($cart_items as &$item) {
      $item->image_url = base_url('assets/official/images/products/' . $item->image_url);
    }

    $response = array(
      'items' => $cart_items
    );

    echo json_encode($response);
  }



  public function remove_from_cart()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      echo json_encode(['error' => 'User not logged in']);
      return;
    }

    $rowid = $this->input->post('id');

    $cart = $this->Cart_model->get_cart_by_user_id($user_id);
    if ($cart) {
      $this->Cart_model->clear_cart($cart->id);
    }

    $response = array(
      'total_items' => $this->cart->total_items()
    );

    echo json_encode($response);
  }

  public function checkout()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      echo json_encode(['error' => 'User not logged in']);
      return;
    }

    $cart = $this->Cart_model->get_cart_by_user_id($user_id);
    if (!$cart) {
      echo json_encode(['error' => 'No items in cart']);
      return;
    }

    $cart_items = $this->Cart_model->get_cart_items($cart->id);
    if (empty($cart_items)) {
      echo json_encode(['error' => 'No items in cart']);
      return;
    }

    $total_price = 0;
    foreach ($cart_items as $item) {
      $total_price += $item->quantity * $item->price;
    }

    $order_id = $this->Order_model->create_order($user_id, $total_price);
    foreach ($cart_items as $item) {
      $this->Order_model->add_order_item($order_id, $item->product_id, $item->quantity, $item->price);
    }

    $this->Cart_model->clear_cart($cart->id);

    echo json_encode(['success' => 'Order placed successfully']);
  }
}
