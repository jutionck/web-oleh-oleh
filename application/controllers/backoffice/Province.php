
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Province extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/General_model', 'GM');
  }

  public function index()
  {
    $data = [
      'title'     => 'Backoffice | Provinsi',
      'cardTitle' => 'Data Provinsi',
      'provinces' => $this->GM->getProvince()->result()
    ];
    $page = '/backoffice/admin/general/province_index';
    pageBackend($page, $data);
  }
}
