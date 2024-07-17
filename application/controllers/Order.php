<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Order_model');
    $this->load->model('Customer_model');
    $this->load->library('session');
  }

  public function history()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      redirect('auth/login');
    }

    $orders = $this->Order_model->get_orders_by_user_id($user_id);
    foreach ($orders as $order) {
      $order->items = $this->Order_model->get_order_items($order->id);
    }

    $data = [
      'title' => 'Riwayat Belanja',
      'orders' => $orders
    ];

    $page = '/official/order/history';
    pageOfficial($page, $data);
  }

  public function confirm_payment($order_id)
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      redirect('');
    }
    $data = [
      'status' => 'completed'
    ];
    $this->Order_model->update_order_status($order_id, $data);
    redirect('order/history');
  }
}
