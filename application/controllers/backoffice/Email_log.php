<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_Log extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('backoffice/General_model', 'GM');
    $this->load->model('backoffice/Email_queue_model', 'EM');
  }

  public function index()
  {
    $data = [
      'title'     => 'Backoffice | Email Log',
      'cardTitle' => 'Data Email Log',
      'emailLogs' => $this->GM->getEmailLog()->result()
    ];
    $page = '/backoffice/admin/email-log/index';
    pageBackend($page, $data);
  }

  public function update()
  {
    $emailId = $this->input->post('id');
    $status = $this->input->post('status');

    if (!$emailId || !$status) {
      echo json_encode(['status' => 'error', 'message' => 'ID and status are required']);
      return;
    }

    $updateStatus = $this->GM->updateEmailLogStatus($emailId, $status);

    if ($updateStatus) {
      echo json_encode(['status' => 'success', 'message' => 'Email status updated']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update email status']);
    }
  }
}
