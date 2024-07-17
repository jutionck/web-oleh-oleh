
<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;

class Registration extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/Registration_model', 'RM');
    $this->load->model('backoffice/General_model', 'GM');
    $this->load->model('official/General_model', 'OGM');
    $this->load->model('backoffice/Setting_model', 'SM');
    $this->load->model('backoffice/Email_queue_model', 'EM');
  }

  public function index()
  {
    if ($this->input->is_ajax_request()) {
      $kabupaten = $this->input->post('regency');
      $paymentStatus = $this->input->post('paymentStatus');
      if ($kabupaten || $paymentStatus) {
        $registrations = $this->RM->searchRegistrantByNameOrRegency($kabupaten, $paymentStatus)->result();
      } else {
        $registrations = $this->RM->getRegistrantWithTransaction()->result();
      }

      foreach ($registrations as $item) {
        $item->whatsapp_link = createWhatsappLink(
          $item->registrant_fullname,
          $item->registrant_nohp,
          $item->wt_total,
          $this->GM->getBankAccount()->row(),
          $item->registrant_key,
          $item->payment_status,
        );
      }
      echo json_encode(['registrations' => $registrations]);
    } else {
      $registrations = $this->RM->getRegistrantWithTransaction()->result();
      $registrationFull = $this->RM->getRegistrantFull();
      $regencies = $this->GM->getRegency()->result();
      $data = [
        'title'             => 'Backoffice | Data Peserta',
        'cardTitle'         => 'Data Peserta Registrasi',
        'regencies'         => $regencies,
        'registrations'     => $registrations,
        'registrationFull'  => $registrationFull,
        'bankAccount'     => $this->GM->getBankAccount()->row(),
      ];
      $page = '/backoffice/admin/registration/index';
      pageBackend($page, $data);
    }
  }

  // Invoice
  function sendMail()
  {
    $wrID = $this->input->post('id');
    $status = $this->input->post('status');

    if (!$wrID) {
      echo json_encode(['status' => 'error', 'message' => 'ID is required']);
      return;
    }

    if ($status === 'pending') {
      $confirmations = $this->RM->getConfirmationData($wrID)->result();
      $uniquePayment = $confirmations[0]->registration_unique_payment;
      $emailTo = $confirmations[0]->registrant_email;
      $pdfFilePath = $confirmations[0]->registrant_key;
      $totalPrice = 0;
      foreach ($confirmations as $confirmation) {
        $totalPrice += $confirmation->wrd_price;
      }

      $data = [
        'confirmations'    => $confirmations,
        'confirmation'     => $confirmation,
        'uniquePayment'    => $uniquePayment,
        'totalPrice'       => $totalPrice + $uniquePayment,
        'accountBank'      => $this->SM->GetBankAccount(),
      ];

      $message = $this->load->view("backoffice/admin/email/index", $data, TRUE);
      $subject = "Invoice";
      $this->EM->addToQueue($emailTo, $subject, $message, 'assets/order-payment/' . $pdfFilePath . '.pdf', $confirmations[0]->registrant_key);
      echo json_encode(['status' => 'success', 'message' => 'Invoice berhasil masuk ke dalam antrian email']);
    } else if ($status === 'paid' || $status === 'underpaid') {
      $status = $this->sendTransactionEmail($wrID);
      if ($status) {
        echo json_encode(['status' => 'success', 'message' => 'Bukti Konfirmasi Validasi berhasil dikirim diemail']);
      } else {
        echo json_encode(['status' => 'success', 'message' => 'Bukti Konfirmasi Validasi berhasil dikirim diemail']);
      }
    }
  }


  public function sendMailUpdate($id, $status)
  {
    $wrID = decodeEncrypt($id);
    if (!$wrID) {
      echo json_encode(['status' => 'error', 'message' => 'ID is required']);
      return;
    }

    $confirmations = $this->RM->getConfirmationData($wrID)->result();
    $uniquePayment = $confirmations[0]->registration_unique_payment;
    $emailTo = $confirmations[0]->registrant_email;
    $pdfFilePath = $confirmations[0]->registrant_key;
    $totalPrice = 0;
    foreach ($confirmations as $confirmation) {
      $totalPrice += $confirmation->wrd_price;
    }

    $data = [
      'confirmations'    => $confirmations,
      'confirmation'     => $confirmation,
      'uniquePayment'    => $uniquePayment,
      'totalPrice'       => $totalPrice + $uniquePayment,
      'accountBank'      => $this->SM->GetBankAccount(),
    ];

    if ($status === 'pending' || $status === 'uploaded') {
      $subject = "Invoice";
      $message = $this->load->view("backoffice/admin/email/index", $data, TRUE);
      $attachment = 'assets/order-payment/' . $pdfFilePath . '.pdf';
    } else if ($status === 'paid' || $status === 'underpaid') {
      $subject = "Bukti Konfirmasi Validasi Pembayaran PIT HOGSI 16";

      $registration = $this->RM->getRegistrantWithTransaction($wrID)->row();
      $registrantDetails = $this->RM->getConfirmationData($wrID)->result();
      $subTotal = array_sum(array_column($registrantDetails, 'wrd_price'));
      $transaction = $this->RM->getWorkshopTransactionByWorkshopID($wrID)->row();
      $qrCode = 'assets/qrcode/' . $registration->registrant_key . '.png';

      $dataEmail = [
        'registration'  => $registration,
        'details'       => $registrantDetails,
        'transaction'   => $transaction,
        'subTotal'      => $subTotal,
        'qrCode'        => $qrCode,
      ];

      $message = $this->load->view("backoffice/admin/email/invoice", $dataEmail, TRUE);
      $attachment = 'assets/invoice/' . $registration->registrant_key . '.pdf';
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Invalid status']);
      return;
    }

    if ($this->EM->addToQueue($emailTo, $subject, $message, $attachment, $confirmations[0]->registrant_key)) {
      redirect('backoffice/registrants/transaction/' . $wrID);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Email already in queue or failed to add to queue']);
    }
  }

  public function detail()
  {
    $rID = $this->input->post('id');
    $registrantDetails = $this->RM->getConfirmationData($rID);
    if ($registrantDetails) {
      $detailsArray = $registrantDetails->result();
      echo json_encode([
        'status' => 'success',
        'data' => $detailsArray
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Tidak dapat mengambil data registrant.'
      ]);
    }
  }

  public function transaction($id)
  {
    $registration = $this->RM->getRegistrantWithTransaction($id)->row();
    $registrantDetails = $this->RM->getConfirmationData($id)->result();
    $payments = $this->GM->getPaymentMethod('', 1)->result();
    $subTotal = 0;
    foreach ($registrantDetails as $row) {
      $subTotal += $row->wrd_price;
    }
    $transaction = $this->RM->getWorkshopTransactionByWorkshopID($id)->row();
    $qrCode = generateQRCode($registration->registrant_key);

    $data = [
      'title'         => 'Backoffice | Data Transaksi',
      'registration'  => $registration,
      'details'       => $registrantDetails,
      'transaction'   => $transaction,
      'subTotal'      => $subTotal,
      'payments'      => $payments,
      'qrCode'        => $qrCode,
    ];
    $page = '/backoffice/admin/registration/transaction_index';
    pageBackend($page, $data);
  }

  public function transactionDelete($id)
  {
    // Mengecek apakah data registrant dengan ID tertentu ada
    $dataExists = $this->RM->getRegistrantWithTransaction($id)->num_rows();

    if ($dataExists > 0) {
      // Menggunakan transaksi untuk memastikan semua query penghapusan berhasil
      $this->db->trans_start();

      $this->GM->delete('workshop_registrants', ['id' => $id]);
      $this->GM->delete('workshop_registrant_details', ['wr_id' => $id]);
      $this->GM->delete('workshop_transactions', ['wsr_id' => $id]);
      $this->GM->delete('workshop_venue_reservations', ['wsr_id' => $id]);

      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
        // Jika salah satu query gagal, transaksi akan melakukan rollback
        $this->session->set_flashdata('error', 'Server data sedang sibuk, silahkan coba lagi');
      } else {
        // Jika semua query berhasil, transaksi akan di commit
        $this->session->set_flashdata('success', 'Data berhasil di hapus');
      }
    } else {
      $this->session->set_flashdata('error', 'Data yang anda masukan tidak ada');
    }

    // Redirect ke halaman sebelumnya
    redirect('backoffice/registrants');
  }

  public function transactionValidation($id)
  {
    $data = $this->input->post();
    $this->processTransaction($id, $data, false);
    $this->redirectToTransaction($id);
  }

  public function transactionValidationRemaining($id)
  {
    $data = $this->input->post();
    $this->processTransaction($id, $data, true);
    $this->redirectToTransaction($id);
  }

  private function processTransaction($id, $data, $isRemaining)
  {
    $paymentStatus = $this->calculatePaymentStatus($data, $isRemaining);

    $setValue1 = [
      'id' => $data['registrant_id'],
      'payment_status' => $paymentStatus,
    ];

    $setValue2 = $this->prepareTransactionData($data, $paymentStatus, $isRemaining);

    $saveWorkshopRegistrant = $this->GM->save('workshop_registrants', $setValue1);
    $saveWorkshopTransaction = $this->GM->save('workshop_transactions', $setValue2);

    $this->setFlashMessages($saveWorkshopRegistrant, $saveWorkshopTransaction);
    $this->sendTransactionEmail($id);
  }

  private function calculatePaymentStatus($data, $isRemaining)
  {
    if ($isRemaining) {
      return ((int)$data['transaction_total'] - (int)removeDots($data['transfer_amount']) - (int)removeDots($data['discount']) === (int)removeDots($data['transfer_amount_remaining']) ? 'paid' : 'underpaid');
    } else if ($data['free'] === 'free') {
      return ((int)$data['transaction_total'] - (int)$data['transaction_total'] === 0 ? 'paid' : 'underpaid');
    } else {
      return ((int)$data['transaction_total'] - (int)removeDots($data['discount']) === (int)removeDots($data['transfer_amount']) ? 'paid' : 'underpaid');
    }
  }

  private function prepareTransactionData($data, $paymentStatus, $isRemaining)
  {
    if ($isRemaining) {
      return [
        'id'                        => $data['transaction_id'],
        'status'                    => $paymentStatus,
        'transfer_date_remaining'   => $data['transfer_date_remaining'],
        'transfer_amount_remaining' => (int)removeDots($data['transfer_amount_remaining']),
      ];
    } else {
      if (!empty($data['free'] === 'free')) {
        $data['transfer_date'] = date('Y-m-d');
        $data['transfer_amount'] = 0;
        $data['transaction_total'] = 0;
      }

      return [
        'id'              => $data['transaction_id'],
        'status'          => $paymentStatus,
        'pm_id'           => $data['pm_id'],
        'ref'             => $data['ref'],
        'sponsor'         => $data['sponsor'],
        'sponsor_contact' => $data['sponsor_contact'],
        'no_hp'           => $data['no_hp'],
        'email'           => $data['email'],
        'transfer_date'   => $data['transfer_date'],
        'total'           => $data['transaction_total'],
        'discount'        => removeDots($data['discount']),
        'transfer_amount' => removeDots($data['transfer_amount']),
      ];
    }
  }

  private function setFlashMessages($saveRegistrant, $saveTransaction)
  {
    if ($saveRegistrant > 0 && $saveTransaction > 0) {
      $this->session->set_flashdata('success', '<b>Data berhasil disimpan</b>');
    } else {
      $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
    }
  }

  private function sendTransactionEmail($id)
  {
    $registration = $this->RM->getRegistrantWithTransaction($id)->row();
    $registrantDetails = $this->RM->getConfirmationData($id)->result();
    $subTotal = array_sum(array_column($registrantDetails, 'wrd_price'));
    $transaction = $this->RM->getWorkshopTransactionByWorkshopID($id)->row();
    $qrCode = 'assets/qrcode/' . $registration->registrant_key . '.png';

    $dataEmail = [
      'registration'  => $registration,
      'details'       => $registrantDetails,
      'transaction'   => $transaction,
      'subTotal'      => $subTotal,
      'qrCode'        => $qrCode,
    ];

    $emailTo = $registration->registrant_email;
    $subject = "Bukti Konfirmasi Validasi Pembayaran PIT HOGSI 16";
    $message = $this->load->view("backoffice/admin/email/invoice", $dataEmail, TRUE);
    $pdfFilePath = $this->generatePdf($dataEmail);

    if ($pdfFilePath) {
      $this->EM->addToQueue($emailTo, $subject, $message, $pdfFilePath, $registration->registrant_key);
    }
  }

  private function redirectToTransaction($id)
  {
    redirect('backoffice/registrants/transaction/' . $id);
  }

  private function sendNotificationEmail($emailTo, $subject, $data)
  {
    $pdfFilePath = $this->generatePdf($data);
    if ($pdfFilePath) {
      return $this->setupAndSendEmail($emailTo, $subject, $data, $pdfFilePath);
    }
    return false;
  }

  private function generatePdf($data)
  {
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4-P',
      'setAutoBottomMargin' => 'stretch',
      'default_font_size' => 7,
      'default_font' => 'dejavusans'
    ]);

    $view = $this->load->view('backoffice/admin/email/invoice', $data, TRUE);
    $mpdf->SetTitle("INVOICE");
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($view);

    $pdfFileName = $data['registration']->registrant_key . '.pdf';
    $pdfFilePath = 'assets/invoice/' . $pdfFileName;

    $mpdf->Output($pdfFilePath, 'F');

    return file_exists($pdfFilePath) ? $pdfFilePath : false;
  }

  private function setupAndSendEmail($emailTo, $subject, $data, $pdfFilePath)
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
      $mail->addBCC($emailTo);

      $mail->Subject = $subject;
      $mail->msgHtml($this->load->view("backoffice/admin/email/invoice", $data, TRUE));
      $mail->addAttachment($pdfFilePath);

      $mail->send();
      return true;
    } catch (Exception $e) {
      error_log("Mailer Error: " . $mail->ErrorInfo);
      return false;
    }
  }

  public function viewRegistrantNoNIK()
  {
    $data = [
      'title'       => 'Backoffice | Pendaftar + NIK',
      'cardTitle'   => 'Data Pendaftar + NIK',
      'registrants' => $this->RM->getRegistrantNoNIK(),
    ];
    $page = '/backoffice/admin/registration/no_nik';
    pageBackend($page, $data);
  }

  public function editRegistrantNoNIK()
  {
    if ($this->input->is_ajax_request()) {
      $data = $this->input->post();
      $setValue = [
        'registrant_nik'    => $data['registrant_nik'],
        'registrant_email'  => $data['registrant_email'],
      ];
      $save = $this->RM->updateRegistrantNIK($setValue);
      if ($save) {
        $this->session->set_flashdata('success', '<b>Ubah data berhasil</b>');
        echo json_encode(array('success' => true, 'message' => 'Data berhasil dirubah'));
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
        echo json_encode(array('success' => false, 'message' => 'Gagal merubah data.'));
      }
    } else {
      echo json_encode(array('success' => false, 'message' => 'Gagal memproses data.'));
    }
  }

  public function checkNIKExists()
  {
    $nik = $this->input->post('nik');
    $email = $this->input->post('email');
    $is_unique = $this->RM->isExistNIK($nik, $email);
    echo json_encode(['is_unique' => $is_unique]);
  }
}
