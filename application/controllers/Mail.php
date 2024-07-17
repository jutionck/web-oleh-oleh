
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mail extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
	}


	public function emailTemplate()
	{
		return $this->load->view('backoffice/admin/email/template');
	}

	public function invoice()
	{
		return $this->load->view('backoffice/admin/email/invoice');
	}
}
