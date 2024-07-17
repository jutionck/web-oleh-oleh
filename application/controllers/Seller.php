<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Order_model');
    $this->load->model('Product_model');
  }

  public function index()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id || $this->session->userdata('role') !== 'seller') {
      redirect('auth/login');
    }

    $data['title'] = 'Data Penjualan';
    $data['orders'] = $this->Order_model->get_orders_by_seller($user_id);

    $page = '/official/seller/index';
    pageOfficial($page, $data);
  }
}
