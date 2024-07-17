<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('official/General_model', 'GM');
    $this->load->model('backoffice/Setting_model', 'SM');
    $this->load->model('backoffice/Registration_model', 'RM');
    $this->load->model('backoffice/Export_model', 'EM');
  }

  public function index()
  {
    $registration = $this->RM->getRegistrantWithTransaction(1)->row();
    $registrantDetails = $this->RM->getConfirmationData(1)->result();
    $subTotal = 0;
    foreach ($registrantDetails as $row) {
      $subTotal += $row->wrd_price;
    }
    $transaction = $this->RM->getWorkshopTransactionByWorkshopID(1)->row();
    $qrCode = 'assets/qrcode/' . $registration->registrant_key . '.png';
    $data = [
      'registration'  => $registration,
      'details'       => $registrantDetails,
      'transaction'   => $transaction,
      'subTotal'      => $subTotal,
      'qrCode'        => $qrCode,
    ];

    $page = '/backoffice/admin/email/invoice';
    pageBackend($page, $data);
  }

  public function invoice($workshopID)
  {
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4-P',
      'setAutoBottomMargin' => 'stretch',
      'default_font_size' => 7,
      'default_font' => 'dejavusans'
    ]);
    $decryptedId = decodeEncrypt($workshopID);
    $confirmations = $this->RM->getConfirmationData($decryptedId)->result();
    $uniquePayment = $confirmations[0]->registration_unique_payment;
    $totalPrice = 0;
    $emailTo = [];
    foreach ($confirmations as $confirmation) {
      $totalPrice += $confirmation->wrd_price;
      $emailTo[] = $confirmation->registrant_email;
    }
    $data = [
      'confirmations'    => $confirmations,
      'confirmation'     => $confirmation,
      'uniquePayment'    => $uniquePayment,
      'totalPrice'       => $totalPrice + $uniquePayment,
      'accountBank'      => $this->SM->GetBankAccount(),
    ];
    $view = $this->load->view('backoffice/admin/email/index', $data, TRUE);
    $mpdf->SetTitle("INVOICE");
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($view);
    $mpdf->Output("INVOICE_" . $confirmation->registrant_key . '.pdf', 'I');
  }

  function invoicePayment($id)
  {
    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4-P',
      'setAutoBottomMargin' => 'stretch',
      'default_font_size' => 7,
      'default_font' => 'dejavusans'
    ]);
    $registration = $this->RM->getRegistrantWithTransaction($id)->row();
    $registrantDetails = $this->RM->getConfirmationData($id)->result();
    $subTotal = 0;
    foreach ($registrantDetails as $row) {
      $subTotal += $row->wrd_price;
    }
    $transaction = $this->RM->getWorkshopTransactionByWorkshopID($id)->row();
    $qrCode = 'assets/qrcode/' . $registration->registrant_key . '.png';
    $data = [
      'registration'  => $registration,
      'details'       => $registrantDetails,
      'transaction'   => $transaction,
      'subTotal'      => $subTotal,
      'qrCode'        => $qrCode,
    ];

    // Menambahkan gambar dari lokal server
    $mpdf->Image('assets/qrcode/H2LEJ.png', 0, 0, 210, 297, 'png', '', true, false);
    $view = $this->load->view('backoffice/admin/email/invoice', $data, TRUE);
    $mpdf->SetTitle("INVOICE");
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($view);
    $mpdf->Output("INVOICE_" . $registration->registrant_key . '.pdf', 'I');
  }

  public function invoiceWA($key)
  {
    $pdfFileName = $key . '.pdf';
    $filePath = FCPATH . 'assets/order-payment/' . $pdfFileName;
    if (file_exists($filePath)) {
      force_download($filePath, NULL);
    } else {
      show_404();
    }
  }

  public function paymentWA($key)
  {
    $pdfFileName = $key . '.pdf';
    $filePath = FCPATH . 'assets/invoice/' . $pdfFileName;
    if (file_exists($filePath)) {
      force_download($filePath, NULL);
    } else {
      show_404();
    }
  }

  // Excel All Workshop
  public function allWorkshopReg($workshopID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID)->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID)->row();
    $data   =   [
      'title'       => 'Daftar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_all_registrant', $data);
  }

  public function allWorkshopPaid($workshopID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, null, 'paid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, null, 'paid')->row();
    $data   =   [
      'title'       => 'Validasi_Pembayaran_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_paid_registrant', $data);
  }

  public function allWorkshopUnpaid($workshopID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, null, 'pending')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, null, 'pending')->row();
    $data   =   [
      'title'       => 'Belum_Bayar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_unpaid_registrant', $data);
  }

  public function allWorkshopUnderpaid($workshopID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, null, 'underpaid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, null, 'underpaid')->row();
    $data   =   [
      'title'       => 'Kurang_Bayar_Peserta_' . @$registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_underpaid_registrant', $data);
  }

  // Excel Offline Workshop
  public function offlineWorkshopReg($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID)->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID)->row();
    $data   =   [
      'title'       => 'Daftar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_all_registrant', $data);
  }

  public function offlineWorkshopPaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'paid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'paid')->row();
    $data   =   [
      'title'       => 'Validasi_Pembayaran_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_paid_registrant', $data);
  }

  public function offlineWorkshopUnpaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'pending')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'pending')->row();
    $data   =   [
      'title'       => 'Belum_Bayar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_unpaid_registrant', $data);
  }

  public function offlineWorkshopUnderpaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'underpaid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'underpaid')->row();
    $data   =   [
      'title'       => 'Kurang_Bayar_Peserta_' . @$registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_underpaid_registrant', $data);
  }

  // Excel Online Workshop
  public function onlineWorkshopReg($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID)->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID)->row();
    $data   =   [
      'title'       => 'Daftar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_all_registrant', $data);
  }

  public function onlineWorkshopPaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'paid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'paid')->row();
    $data   =   [
      'title'       => 'Validasi_Pembayaran_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_paid_registrant', $data);
  }

  public function onlineWorkshopUnpaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'pending')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'pending')->row();
    $data   =   [
      'title'       => 'Belum_Bayar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_unpaid_registrant', $data);
  }

  public function onlineWorkshopUnderpaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'underpaid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'underpaid')->row();
    $data   =   [
      'title'       => 'Kurang_Bayar_Peserta_' . @$registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_underpaid_registrant', $data);
  }

  // Excel Simposium
  public function simposiumReg($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID)->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID)->row();
    $data   =   [
      'title'       => 'Daftar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_all_registrant', $data);
  }

  public function simposiumPaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'paid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'paid')->row();
    $data   =   [
      'title'       => 'Validasi_Pembayaran_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_paid_registrant', $data);
  }

  public function simposiumUnpaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'pending')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'pending')->row();
    $data   =   [
      'title'       => 'Belum_Bayar_Peserta_' . $registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_unpaid_registrant', $data);
  }

  public function simposiumUnderpaid($workshopID, $categoryID)
  {
    $registrants = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'underpaid')->result();
    $registrant = $this->EM->getWorkshopRegistrant($workshopID, $categoryID, 'underpaid')->row();
    $data   =   [
      'title'       => 'Kurang_Bayar_Peserta_' . @$registrant->w_name . '_' . date('m_Y'),
      'registrants' => $registrants,
      'registrant' => $registrant
    ];
    $this->load->view('backoffice/admin/export/workshop_underpaid_registrant', $data);
  }

  public function venues()
  {
    $reservations = $this->EM->getReservationHotel();
    $data   =   [
      'title'         => 'Daftar_Reservasi_Hotel_Pithogsi16' . date('m_Y'),
      'reservations'  => $reservations,
    ];
    $this->load->view('backoffice/admin/export/venues', $data);
  }
}
