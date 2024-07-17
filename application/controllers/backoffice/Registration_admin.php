<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;

class Registration_admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/Registration_admin_model', 'GM');
    $this->load->model('backoffice/Setting_model', 'SM');
    $this->load->model('backoffice/Registration_model', 'RM');
    $this->load->model('backoffice/Email_queue_model', 'EM');
  }

  public function index()
  {
    $data = [
      'title'                   => 'Backoffice | Form Data Registrasi',
      'cardTitle'               => 'Registrasi Data Peserta',
      'participantCategories'   => $this->GM->GetParticipantCategory()->result(),
      'provinces'               => $this->GM->GetProvince(),
      'companies'               => $this->GM->GetCompany()->result(),
      'venues'                  => $this->GM->GetVenue()->result(),
    ];
    $page = '/backoffice/admin/registration/add';
    pageBackend($page, $data);
  }

  public function getKabupatenByProvinsi()
  {
    $postData = $this->input->post();
    $data = $this->GM->GetRegency($postData);
    echo json_encode($data);
  }

  public function getWorkshopPriceByCategoryID()
  {
    $categoryId = $this->input->post('categoryId');
    $workshops = $this->GM->GetParticipantWorkshop($categoryId)->result();
    if (!empty($workshops)) {
      echo json_encode(array('success' => true, 'workshops' => $workshops));
    } else {
      echo json_encode(array('success' => false, 'message' => 'Tidak ada workshop tersedia untuk kategori peserta ini.'));
    }
  }

  public function getVenuePrice()
  {
    if ($this->input->is_ajax_request() && $this->input->post()) {
      $postData = $this->input->post('hotelId');
      $venueData = $this->GM->GetVenue($postData)->row();
      if (!empty($venueData)) {
        echo json_encode([
          'status' => 'success',
          'data' => $venueData
        ]);
      } else {
        echo json_encode([
          'status' => 'error',
          'message' => 'No data found for the provided venue identifier.'
        ]);
      }
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request type.'
      ]);
    }
  }

  // Start --> Create
  public function proccess()
  {
    $data = $this->input->post();
    $registrantId = $this->saveRegistrant($data);
    $details = array();

    if (isset($data['wpc']) && !empty($data['wpc'])) {
      foreach ($data['wpc'] as $wpc_id) {
        $workshop = $this->GM->getParticipantWorkshopByParticipantCategory($wpc_id)->row();
        $details[] = array(
          'wr_id'    => $registrantId,
          'wpc_id'  => $wpc_id,
          'pev_id'  => null,
          'price'   => $workshop->wpc_price
        );
      }
    }

    if (isset($data['pev_id']) && !empty($data['pev_id'])) {
      $details[] = array(
        'wr_id'   => $registrantId,
        'wpc_id'  => null,
        'pev_id'  => $data['pev_id'],
        'price'   => convertCurrencyIDRToNumber($data['tota_hotel_fee']),
      );
    }

    $dataHotel = [
      'wsr_id'           => $registrantId,
      'pev_id'           => $data['pev_id'],
      'room_price'       => $data['room_price'],
      'number_of_room'   => $data['number_of_room'],
      'check_in'         => $data['check_in'],
      'check_out'        => $data['check_out'],
      'total_night'      => $data['total_night'],
      'tota_hotel_fee'   => convertCurrencyIDRToNumber($data['tota_hotel_fee']),
    ];
    $saveHotelReservation = $this->RM->saveWorkshopVenueReservation($dataHotel);
    $save = $this->saveWorkshopRegistrantDetails($details);

    if ($save > 0 && $saveHotelReservation > 0) {
      $this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
    } else {
      $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
    }

    redirect('backoffice/registrants/confirmation/' . encodeEncrypt($registrantId));
  }

  private function saveRegistrant($data)
  {
    $setValue = array(
      'pc_id'                           => $data['registrant_category'],
      'registrant_nik'                  => htmlspecialchars($data['registrant_nik']),
      'registrant_fullname'             => htmlspecialchars($data['registrant_fullname']),
      'registrant_fullname_with_title'  => htmlspecialchars($data['registrant_fullname_with_title']),
      'registrant_institute'            => htmlspecialchars($data['registrant_institute']),
      'registrant_nohp'                 => $data['registrant_nohp'],
      'registrant_email'                => $data['registrant_email'],
      'registrant_province_id'          => $data['registrant_province_id'],
      'registrant_regency_id'           => $data['registrant_regency_id'],
      'registrant_key'                  => strtoupper($data['registrant_key']),
      'registrant_status'               => $data['registrant_status'],
      'registration_unique_payment'     => $data['registration_unique_payment']
    );

    if ($data['registrant_status'] == 'didaftarkan') {
      $setValue['fullname_didaftarkan'] = htmlspecialchars($data['fullname_didaftarkan']);
      $setValue['email_didaftarkan']     = $data['email_didaftarkan'];
      $setValue['nohp_didaftarkan']     = $data['nohp_didaftarkan'];
      $setValue['company_didaftarkan']  = htmlspecialchars($data['company_didaftarkan']);
    }
    return $this->RM->saveRegistrant($setValue);
  }

  private function saveWorkshopRegistrantDetails($details)
  {
    $this->RM->saveWorkshopRegistrantDetails($details);
  }

  public function confirmation($id)
  {
    $decryptedId = decodeEncrypt($id);
    $confirmations = $this->RM->getConfirmationData($decryptedId)->result();
    $uniquePayment = $confirmations[0]->registration_unique_payment;
    $totalPrice = 0;
    foreach ($confirmations as $confirmation) {
      $totalPrice += $confirmation->wrd_price;
    }

    $setValue = [
      'wsr_id'   => $decryptedId,
      'total'   => $totalPrice + $uniquePayment,
    ];

    $currentTransaction = $this->RM->getLastTransaction($decryptedId);
    if (empty($currentTransaction)) {
      $this->RM->saveWorkshopTransaction($setValue);
    }

    $data = [
      'title'           => 'Backoffice | Konfirmasi Registrasi',
      'cardTitle'       => 'Konfirmasi Registrasi Peserta',
      'confirmations'   => $confirmations,
      'uniquePayment'   => $uniquePayment,
      'totalPrice'      => $totalPrice + $uniquePayment,
    ];
    $page = '/backoffice/admin/registration/confirmation';
    pageBackend($page, $data);
  }
  // End --> Create

  // Start --> Update
  public function update($id)
  {
    $workshopRegistrant = $this->GM->GetWorkshopRegistrationByID($id);
    $workshopRegistrantDetailRow = $this->GM->GetWorkshopRegistrationDetailByID($id)->row();
    $workshopRegistrantDetailResult = $this->GM->GetWorkshopRegistrationDetailByID($id)->result();
    $workshopRegistrantDetailResultAll = $this->GM->GetWorkshopRegistrationDetailByCategoryID($id, $workshopRegistrant->pc_id)->result();

    $selectedWorkshopsAssoc = [];
    foreach ($workshopRegistrantDetailResult as $row) {
      $selectedWorkshopsAssoc[$row->wpc_id] = true;
    }

    foreach ($workshopRegistrantDetailResultAll as $workshop) {
      if (!isset($selectedWorkshopsAssoc[$workshop->wpc_id])) {
        $workshopRegistrantDetailResult[] = $workshop;
      }
    }

    $data = [
      'title' => 'Backoffice | Form Data Registrasi',
      'cardTitle' => 'Registrasi Data Peserta',
      'workshopRegistrant' => $workshopRegistrant,
      'workshopRegistrantDetailRow' => $workshopRegistrantDetailRow,
      'workshopRegistrantDetailResult' => $workshopRegistrantDetailResult,
      'workshopRegistrantVenue' => $this->GM->GetVenueByRegistrant($id),
      'workshopRegistrantVenueReservation' => $this->GM->GetVenueReservation($id),
      'selectedWorkshops' => array_keys($selectedWorkshopsAssoc),
      'participantCategories' => $this->GM->GetParticipantCategory()->result(),
      'provinces' => $this->GM->GetProvince(),
      'companies' => $this->GM->GetCompany()->result(),
      'venues' => $this->GM->GetVenue()->result(),
    ];

    $page = '/backoffice/admin/registration/edit';
    pageBackend($page, $data);
  }

  public function proccessUpdate()
  {
    $data = $this->input->post();
    if (empty($data['workshop_registrant_id'])) {
      $this->session->set_flashdata('error', '<b>ID registrant tidak ditemukan.</b>');
      redirect('backoffice/registrants');
      return;
    }

    $workshopRegistrantId = $data['workshop_registrant_id'];
    $this->saveRegistrantUpdate($data);
    $details = [];

    if (!empty($data['wpc'])) {
      foreach ($data['wpc'] as $wpc_id) {
        $workshop = $this->GM->getParticipantWorkshopByParticipantCategory($wpc_id)->row();
        $details[] = [
          'wr_id'    => $workshopRegistrantId,
          'wpc_id'   => $wpc_id,
          'pev_id'   => null,
          'price'    => $workshop->wpc_price
        ];
      }
    }

    if (!empty($data['hotel_reservation'])) {
      $details[] = [
        'wr_id'   => $workshopRegistrantId,
        'wpc_id'  => null,
        'pev_id'  => $data['pev_id'],
        'price'   => convertCurrencyIDRToNumber($data['tota_hotel_fee']),
      ];

      $dataHotel = [
        'wsr_id'           => $workshopRegistrantId,
        'pev_id'           => $data['pev_id'],
        'room_price'       => $data['room_price'],
        'number_of_room'   => $data['number_of_room'],
        'check_in'         => $data['check_in'],
        'check_out'        => $data['check_out'],
        'total_night'      => $data['total_night'],
        'tota_hotel_fee'   => convertCurrencyIDRToNumber($data['tota_hotel_fee']),
      ];
      $lastReserved = $this->RM->getHotelReservation($workshopRegistrantId);
      if ($lastReserved) {
        $saveHotelReservation = $this->RM->saveWorkshopVenueReservationUpdate($dataHotel);
      } else {
        $saveHotelReservation = $this->RM->saveWorkshopVenueReservation($dataHotel);
      }
    } else {
      $saveHotelReservation = $this->RM->cleanVenueReservation($workshopRegistrantId);
    }

    $save = $this->saveWorkshopRegistrantUpdateDetails($details, $workshopRegistrantId);
    if ($save && $saveHotelReservation) {
      $this->session->set_flashdata('success', '<b>Update data berhasil</b>');
    } else {
      $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
    }

    redirect('backoffice/registrants/confirmation-update/' . encodeEncrypt($workshopRegistrantId));
  }

  private function saveRegistrantUpdate($data)
  {
    $setValue = array(
      'id'                              => $data['workshop_registrant_id'],
      'pc_id'                           => $data['registrant_category'],
      'registrant_nik'                  => htmlspecialchars($data['registrant_nik']),
      'registrant_fullname'             => htmlspecialchars($data['registrant_fullname']),
      'registrant_fullname_with_title'  => htmlspecialchars($data['registrant_fullname_with_title']),
      'registrant_institute'            => htmlspecialchars($data['registrant_institute']),
      'registrant_nohp'                 => $data['registrant_nohp'],
      'registrant_email'                => $data['registrant_email'],
      'registrant_province_id'          => $data['registrant_province_id'],
      'registrant_regency_id'           => $data['registrant_regency_id'],
      'registrant_status'               => $data['registrant_status'],
      'registration_unique_payment'     => $data['registration_unique_payment']
    );

    if ($data['registrant_status'] == 'didaftarkan') {
      $setValue['fullname_didaftarkan'] = htmlspecialchars($data['fullname_didaftarkan']);
      $setValue['email_didaftarkan']     = $data['email_didaftarkan'];
      $setValue['nohp_didaftarkan']     = $data['nohp_didaftarkan'];
      $setValue['company_didaftarkan']  = htmlspecialchars($data['company_didaftarkan']);
    }
    return $this->RM->saveRegistrantUpdate($setValue);
  }

  private function saveWorkshopRegistrantUpdateDetails($details, $ids)
  {
    $result = $this->RM->cleanRegistrationDetail($ids);
    if ($result) {
      $this->RM->saveWorkshopRegistrantDetails($details);
    }
  }

  public function confirmationUpdate($id)
  {
    $decodedId = decodeEncrypt($id);
    $confirmationData = $this->RM->getConfirmationData($decodedId)->result();
    $uniquePayment = $confirmationData[0]->registration_unique_payment;
    $totalPrice = array_sum(array_column($confirmationData, 'wrd_price'));
    $finalTotalPrice = 0;

    $lastTransaction = $this->RM->getLastTransaction($decodedId);

    $paymentMethods = ["Cash", "Bank Transfer", "GL", "Credit Card", "EDC"];
    $paymentMethodIds = $this->RM->getPaymentMethodIds($paymentMethods);
    $isSpecifiedMethod = in_array($lastTransaction->pm_id, $paymentMethodIds);

    $status = 'pending';
    if ($lastTransaction->status === 'pending' || $lastTransaction->status === 'uploaded') {
      $finalTotalPrice = $totalPrice + $uniquePayment;
      $status = $lastTransaction->status;
    } else {
      $finalTotalPrice = $totalPrice + (int) substr($lastTransaction->total, -3);
      $totalUpdate = $finalTotalPrice - $lastTransaction->total;
      $status = ($totalUpdate > 0) ? 'underpaid' : 'paid';
    }

    if (!$isSpecifiedMethod && isset($lastTransaction->pm_id)) {
      $status = 'paid';
      $finalTotalPrice = 0;
    }

    $transactionUpdate = [
      'wsr_id'       => $decodedId,
      'total'        => isset($finalTotalPrice) ? $finalTotalPrice : $lastTransaction->total,
      'total_last'   => $lastTransaction->total,
      'status'       => $status,
      'is_revision'  => $lastTransaction->is_revision + 1,
    ];

    $workshopRehgistrationPaymentStatus = [
      'id'             => $decodedId,
      'payment_status' => $status,
    ];

    $this->RM->saveWorkshopUpdateTransaction($transactionUpdate);
    $this->RM->saveRegistrantUpdate($workshopRehgistrationPaymentStatus);

    $data = [
      'title'         => 'Backoffice | Konfirmasi Registrasi',
      'cardTitle'     => 'Konfirmasi Registrasi Peserta',
      'confirmations' => $confirmationData,
      'uniquePayment' => $uniquePayment,
      'totalPrice'    => $totalPrice + $uniquePayment,
      'paymentStatus' => $lastTransaction->status
    ];

    $page = '/backoffice/admin/registration/confirmation_update';
    pageBackend($page, $data);
  }
  // End --> Update

  public function sendNotification($workshopID)
  {
    $decryptedId = decodeEncrypt($workshopID);
    $confirmations = $this->RM->getConfirmationData($decryptedId)->result();
    $uniquePayment = $confirmations[0]->registration_unique_payment;
    $totalPrice = 0;
    $emailTo = [];
    foreach ($confirmations as $confirmation) {
      if (isset($confirmation->email_didaftarkan)) {
        array_push($emailTo, $confirmation->email_didaftarkan);
      }
      $totalPrice += $confirmation->wrd_price;
      array_push($emailTo, $confirmation->registrant_email);
    }

    $data = [
      'confirmations'    => $confirmations,
      'confirmation'     => $confirmation,
      'uniquePayment'    => $uniquePayment,
      'totalPrice'       => $totalPrice + $uniquePayment,
      'accountBank'      => $this->SM->GetBankAccount(),
    ];

    $this->sendMail($emailTo, "Invoice", $data);
    redirect('backoffice/registrants');
  }

  private function sendMail($emailTo, $subject, $data)
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

    $view = $this->load->view('backoffice/admin/email/index', $data, TRUE);
    $mpdf->SetTitle("INVOICE");
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($view);

    $pdfFileName = $data['confirmation']->registrant_key . '.pdf';
    $pdfFilePath = 'assets/order-payment/' . $pdfFileName;

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
      foreach ($emailTo as $recipient) {
        $mail->addBCC($recipient);
      }

      $mail->Subject = $subject;
      $mail->msgHtml($this->load->view("backoffice/admin/email/index", $data, TRUE));
      $mail->addAttachment($pdfFilePath);

      $mail->send();
      return true;
    } catch (Exception $e) {
      error_log("Mailer Error: " . $mail->ErrorInfo);
      return false;
    }
  }

  public function updatePayment($id)
  {
    $registration = $this->RM->getRegistrantWithTransaction($id)->row();
    $transaction = $this->GM->GetTransaction($id);
    $payments = $this->GM->getPaymentMethod('', 1)->result();

    $data = [
      'title'         => 'Backoffice | Form Data Pembayaran',
      'cardTitle'     => 'Form Data Pembayaran',
      'registration'  => $registration,
      'transaction'   => $transaction,
      'payments'      => $payments,

    ];

    $page = '/backoffice/admin/registration/edit_payment';
    pageBackend($page, $data);
  }

  public function updatePaymentProccess($id)
  {
    $data = $this->input->post();
    $status = $this->calculatePaymentStatus($data);
    $setValue = [
      'wsr_id'                    => $id,
      'total'                     => (int)removeDots($data['transfer_amount']) + (int)removeDots($data['transfer_amount_remaining']),
      'total_last'                => $data['transaction_total'],
      'status'                    => $status,
      'pm_id'                     => $data['pm_id'],
      'ref'                       => $data['ref'],
      'sponsor'                   => $data['sponsor'],
      'sponsor_contact'           => $data['sponsor_contact'],
      'no_hp'                     => $data['no_hp'],
      'email'                     => $data['email'],
      'transfer_date'             => $data['transfer_date'],
      'transfer_date_remaining'   => $data['transfer_date_remaining'],
      'discount'                  => (int)removeDots($data['discount']),
      'transfer_amount'           => (int)removeDots($data['transfer_amount']),
      'transfer_amount_remaining' => (int)removeDots($data['transfer_amount_remaining']),
    ];
    $save = $this->RM->updateTransactionInvoiceByRegistrantId($setValue);

    $registrationUpdate = [
      'id'             => $id,
      'payment_status' => $status,
    ];
    $this->RM->saveRegistrantUpdate($registrationUpdate);

    if ($save > 0) {
      $this->session->set_flashdata('success', '<b>Ubah data berhasil</b>');
      $this->addToEmailQueue($id);
    } else {
      $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
    }

    redirect('backoffice/registrants/transaction/' . $id);
  }

  private function calculatePaymentStatus($data)
  {
    $totalPayment = (int)removeDots($data['transfer_amount']) + (int)removeDots($data['transfer_amount_remaining']);
    $expectedPayment = (int)$data['transaction_total'] - (int)removeDots($data['discount']);

    if ($totalPayment < $expectedPayment) {
      return 'underpaid';
    } elseif ($totalPayment == $expectedPayment) {
      return 'paid';
    } else {
      return 'overpaid';
    }
  }

  private function addToEmailQueue($id)
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

    $pdfFilePath = $this->generatePdfAfterUpdatePayment($dataEmail);
    if ($pdfFilePath) {
      $message = $this->load->view("backoffice/admin/email/invoice", $dataEmail, TRUE);
      $subject = "Bukti Konfirmasi Validasi Pembayaran PIT HOGSI 16";
      $this->EM->addToQueue($registration->registrant_email, $subject, $message, $pdfFilePath, $registration->registrant_key);
    }
  }

  private function generatePdfAfterUpdatePayment($data)
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
}
