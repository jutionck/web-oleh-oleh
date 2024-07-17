
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Err_page extends CI_Controller
{
	public function index()
	{
		$this->load->view('errors/err_page');
	}
}
