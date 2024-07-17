
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
  }

  public function index()
  {
    $data = [
      'title'  => 'Backoffice | Dashboard',
    ];
    $page = '/backoffice/admin/dashboard';
    pageBackend($page, $data);
  }
}
