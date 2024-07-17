
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/General_model', 'GM');
    $this->load->model('backoffice/Report_model', 'RM');
    $this->load->model('backoffice/Export_model', 'EM');
  }

  // All Workshop
  public function index()
  {
    $registrations = $this->RM->getWorkshopRegistrantWithCount()->result();
    $totalAll = 0;
    $totalRemain = 0;
    $totalReg = 0;
    $totalUnpaid = 0;
    $totalPaid = 0;
    $totalUploaded = 0;
    $totalUnderPaid = 0;

    foreach ($registrations as $r) {
      $totalAll += $r->ws_qty;
      $totalRemain += $r->ws_remaining;
      $totalReg += $r->wr_registrant_count;
      $totalUnpaid += $r->pending_payment;
      $totalPaid += $r->paid_payment;
      $totalUploaded += $r->uploaded_payment;
      $totalUnderPaid += $r->underpaid_payment;
    }
    $data = [
      'title'           => 'Backoffice | Rekap Data Semua Workshop',
      'cardTitle'       => 'Rekap Data Semua Workshop',
      'registrations'   => $registrations,
      'totalAll'        => $totalAll,
      'totalRemain'     => $totalRemain,
      'totalReg'        => $totalReg,
      'totalUnpaid'     => $totalUnpaid,
      'totalPaid'       => $totalPaid,
      'totalUploaded'   => $totalUploaded,
      'totalUnderPaid'  => $totalUnderPaid,
    ];
    $page = '/backoffice/admin/report/all-workshop/index';
    pageBackend($page, $data);
  }

  public function detailAllWorkshopReg()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $registrants = $this->EM->getWorkshopRegistrant($wsID)->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }


  public function detailAllWorkshopPaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, null, 'paid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailUploaded()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, null, 'uploaded')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailAllWorkshopUnpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, null, 'pending')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailAllWorkshopUnderpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, null, 'underpaid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  // Online Workshop
  public function onlineWorkshop()
  {
    $registrations = $this->RM->getWorkshopOnlineWithParticipants();
    $totalReg = 0;
    $totalUnpaid = 0;
    $totalPaid = 0;
    $totalUploaded = 0;
    $totalUnderPaid = 0;

    foreach ($registrations as $r) {
      $totalReg += $r->wr_registrant_count;
      $totalUnpaid += $r->wr_pending_payment;
      $totalPaid += $r->wr_paid_payment;
      $totalUploaded += $r->wr_uploaded_payment;
      $totalUnderPaid += $r->wr_underpaid_payment;
    }

    $data = [
      'title'           => 'Backoffice | Rekap Data Online Workshop',
      'cardTitle'       => 'Rekap Data Online Workshop',
      'registrations'   => $registrations,
      'totalReg'        => $totalReg,
      'totalUnpaid'     => $totalUnpaid,
      'totalPaid'       => $totalPaid,
      'totalUploaded'       => $totalUploaded,
      'totalUnderPaid'  => $totalUnderPaid,
    ];
    $page = '/backoffice/admin/report/online-workshop/index';
    pageBackend($page, $data);
  }

  public function detailOnlineWorkshopReg()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID)->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailOnlineWorkshopPaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'paid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailUploadedNew()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'uploaded')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailOnlineWorkshopUnpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'pending')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailOnlineWorkshopUnderpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'underpaid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  // Offline Workshop
  public function offlineWorkshop()
  {
    $registrations = $this->RM->getWorkshopOfflineWithParticipants();
    $totalReg = 0;
    $totalUnpaid = 0;
    $totalPaid = 0;
    $totalUploaded = 0;
    $totalUnderPaid = 0;

    foreach ($registrations as $r) {
      $totalReg += $r->wr_registrant_count;
      $totalUnpaid += $r->wr_pending_payment;
      $totalPaid += $r->wr_paid_payment;
      $totalUploaded += $r->wr_uploaded_payment;
      $totalUnderPaid += $r->wr_underpaid_payment;
    }

    $data = [
      'title'           => 'Backoffice | Rekap Data Offline Workshop',
      'cardTitle'       => 'Rekap Data Offline Workshop',
      'registrations'   => $registrations,
      'totalReg'        => $totalReg,
      'totalUnpaid'     => $totalUnpaid,
      'totalPaid'       => $totalPaid,
      'totalUploaded'   => $totalUploaded,
      'totalUnderPaid'  => $totalUnderPaid,
    ];
    $page = '/backoffice/admin/report/offline-workshop/index';
    pageBackend($page, $data);
  }

  public function detailOfflineWorkshopReg()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID)->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailOfflineWorkshopPaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'paid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailOfflineWorkshopUnpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'pending')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailOfflineWorkshopUnderpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'underpaid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  // Symposioum
  public function symposium()
  {
    $registrations = $this->RM->getSimposiumWithParticipants();
    $totalReg = 0;
    $totalUnpaid = 0;
    $totalPaid = 0;
    $totalUploaded = 0;
    $totalUnderPaid = 0;

    foreach ($registrations as $r) {
      $totalReg += $r->wr_registrant_count;
      $totalUnpaid += $r->wr_pending_payment;
      $totalPaid += $r->wr_paid_payment;
      $totalUploaded += $r->wr_uploaded_payment;
      $totalUnderPaid += $r->wr_underpaid_payment;
    }

    $data = [
      'title'           => 'Backoffice | Rekap Data Symposium',
      'cardTitle'       => 'Rekap Data Symposium',
      'registrations'   => $registrations,
      'totalReg'        => $totalReg,
      'totalUnpaid'     => $totalUnpaid,
      'totalPaid'       => $totalPaid,
      'totalUploaded'   => $totalUploaded,
      'totalUnderPaid'  => $totalUnderPaid,
    ];
    $page = '/backoffice/admin/report/symposium/index';
    pageBackend($page, $data);
  }

  public function detailSimposiumReg()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID)->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailSimposiumPaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'paid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailSimposiumUnpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'pending')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function detailSimposiumUnderpaid()
  {
    if ($this->input->is_ajax_request()) {
      $wsID = $this->input->post('workshop');
      $pcID = $this->input->post('id');
      $registrants = $this->EM->getWorkshopRegistrant($wsID, $pcID, 'underpaid')->result();
      header('Content-Type: application/json');
      echo json_encode($registrants);
    } else {
      show_404();
    }
  }

  public function venue()
  {
    $period = $this->GM->getVenuePeriod();
    $reservationOfDate = $this->RM->getHotelData($period->start_date, $period->end_date)->result();
    $total = 0;
    $terpakai = 0;
    $sisa = 0;

    foreach ($reservationOfDate as $row) {
      $total += $row->Kuota;
      $terpakai += $row->Terpakai;
      $sisa += $row->Sisa;
    }


    // Detail
    $reservations = $this->EM->getReservationHotel();
    $data = [
      'title'               => 'Backoffice | Rekap Reservasi Hotel Tanggal',
      'cardTitle'           => 'Rekap Reservasi Hotel Tanggal',
      'reservationOfDate'   => $reservationOfDate,
      'reservations'        => $reservations,
      'RsvTotal'            => $total,
      'RsvTerpakai'         => $terpakai,
      'RsvSisa'             => $sisa,
    ];
    $page = '/backoffice/admin/report/venue/index';
    pageBackend($page, $data);
  }
}
