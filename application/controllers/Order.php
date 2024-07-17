<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Order_model');
    $this->load->library('session');
  }

  public function history()
  {
    $user_id = $this->session->userdata('user_id');
    if (!$user_id) {
      redirect('auth/login');
    }

    $data['title'] = 'Riwayat Belanja';
    $data['order_history'] = $this->Order_model->get_order_history_by_user_id($user_id);

    $page = '/official/history-order/index';
    pageOfficial($page, $data);
  }
}
