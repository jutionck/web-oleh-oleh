
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Regency extends CI_Controller
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
      'cardTitle' => 'Data Kabupaten',
      'regencies' => $this->GM->getRegencyWithProvince()->result()
    ];
    $page = '/backoffice/admin/general/regency_index';
    pageBackend($page, $data);
  }
}
