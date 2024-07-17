<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;

class Email_processor extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('backoffice/Setting_model', 'SM');
    $this->load->model('backoffice/Email_queue_model', 'EM');
  }

  public function processQueue()
  {
    $emails = $this->EM->getPendingEmails();
    $result = [
      'processed' => 0,
      'sent' => 0,
      'failed' => 0,
      'message' => 'No pending emails to process.'
    ];

    if (count($emails) > 0) {
      foreach ($emails as $email) {
        $result['processed']++;
        if ($this->sendEmail($email->to, $email->subject, $email->message, $email->attachment)) {
          $this->EM->updateEmailStatus($email->id, 'sent');
          $result['sent']++;
        } else {
          $this->EM->updateEmailStatus($email->id, 'failed');
          $result['failed']++;
        }
      }
      $result['message'] = 'Email processing completed.';
    }

    header('Content-Type: application/json');
    echo json_encode($result);
  }

  private function sendEmail($to, $subject, $message, $attachment)
  {
    $account = $this->SM->GetEmailAccount();
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host = $account->host;
      $mail->SMTPAuth = true;
      $mail->Username = $account->username;
      $mail->Password = $account->password;
      $mail->SMTPSecure = $account->smtp_secure;
      $mail->Port = $account->port;
      $mail->setFrom($account->set_from_address, $account->set_from_name);
      $mail->addBCC($account->email_forward);
      $mail->addAddress($to);

      $mail->Subject = $subject;
      $mail->msgHtml($message);
      if ($attachment) {
        $mail->addAttachment($attachment);
      }

      $mail->send();
      return true;
    } catch (Exception $e) {
      error_log("Mailer Error: " . $mail->ErrorInfo);
      return false;
    }
  }
}
