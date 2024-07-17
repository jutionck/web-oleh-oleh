
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rereg_certificate extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
  }

  public function index()
  {
    $data = [
      'title'  => 'Backoffice | Reregistrasi & Sertifikat',
      'cardTitle'  => 'Reregistrasi & Sertifikat',
    ];
    $page = '/backoffice/admin/rereg-certificate/index';
    pageBackend($page, $data);
  }
}
