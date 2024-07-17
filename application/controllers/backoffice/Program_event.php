
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Program_event extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/Event_model', 'EM');
    $this->load->model('backoffice/General_model', 'GM');
    $this->redirect = 'backoffice/events/detail/';
  }

  // Event Start ----
  public function index()
  {
    $events = $this->EM->get();
    $data = [
      'title'     => 'Backoffice | Data Event',
      'cardTitle' => 'Data Program Event',
      'events'    => $events->result(),
    ];
    $page = '/backoffice/admin/event/index';
    pageBackend($page, $data);
  }

  public function add()
  {
    if ($this->input->is_ajax_request()) {
      $data = $this->input->post();
      $setValue = [
        'name'    => $data['name'],
        'status'  => $data['status'],
      ];
      $save = $this->EM->save($setValue);
      if ($save) {
        $this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
        echo json_encode(array('success' => true, 'message' => 'Data berhasil ditambah'));
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
        echo json_encode(array('success' => false, 'message' => 'Gagal menambah data.'));
      }
    } else {
      echo json_encode(array('success' => false, 'message' => 'Gagal memproses data.'));
    }
  }

  public function edit()
  {
    if ($this->input->is_ajax_request()) {
      $data = $this->input->post();
      $setValue = [
        'id'      => $data['id'],
        'name'    => $data['name'],
        'status'  => $data['status'],
      ];
      $save = $this->EM->save($setValue);
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

  public function delete($id)
  {
    $data = $this->GM->getProgramEvent($id)->row();
    if ($data) {
      $delete = $this->GM->delete('program_events', ['id' => $id]);
      if ($delete > 0) {
        $this->session->set_flashdata('success', 'Data berhasil di hapus');
      } else {
        $this->session->set_flashdata('error', 'Server sedang sibuk, silahkan coba lagi');
      }
    } else {
      $this->session->set_flashdata('error', 'Data yang anda masukan tidak ada');
    }
    redirect('backoffice/events');
  }
  // Event End ----

  // Workshop Start -----
  public function detail($id)
  {
    $event = $this->EM->get($id)->row();
    $eventWorkshops = $this->EM->getEventWorkshop($event->id);
    $data = [
      'title'             => 'Backoffice | Detail Data Event',
      'cardTitle'         => 'Detail Data Program Event',
      'event'             => $event,
      'eventWorkshops'    => $eventWorkshops,
    ];
    $page = '/backoffice/admin/event/detail/workshop/index';
    pageBackend($page, $data);
  }

  public function createWorkshop()
  {
    $this->_validation('workshop');
    if ($this->form_validation->run() === false) {
      $data = [
        'title'                 => 'Backoffice | Data Event',
        'cardTitle'             => 'Tambah Data Program Event',
        'participantCategories' => $this->GM->getParticipantCategory()->result(),
        'priceTypes'            => $this->GM->getPriceType()->result(),
      ];
      $page = '/backoffice/admin/event/detail/workshop/add';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $eventID = $data['pe_id'];
      $setValue = [
        'name'        => $data['name'],
        'type'        => $data['type'],
        'venue'       => $data['venue'],
        'start_date'  => $data['start_date'],
        'end_date'    => ($data['end_date'] !== "" ? $data['end_date'] : NULL),
        'qty'         => $data['qty'],
        'pe_id'       => $eventID,
      ];
      $save = $this->EM->saveEventWorkshop($setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect . $eventID);
    }
  }

  public function updateWorkshop($workshopID)
  {
    $workshop = $this->EM->getWorkshopByID($workshopID)->row();
    $this->_validation('workshop');
    if ($this->form_validation->run() === false) {
      $data = [
        'title'     => 'Backoffice | Data Event',
        'cardTitle' => 'Ubah Data Program Event',
        'workshop'  => $workshop,
      ];
      $page = '/backoffice/admin/event/detail/workshop/edit';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $eventID = $data['pe_id'];
      $setValue = [
        'id'          => $data['id'],
        'name'        => $data['name'],
        'type'        => $data['type'],
        'venue'       => $data['venue'],
        'start_date'  => $data['start_date'],
        'end_date'    => ($data['end_date'] !== "" ? $data['end_date'] : NULL),
        'qty'         => $data['qty'],
        'pe_id'       => $eventID,
      ];
      $save = $this->EM->saveEventWorkshop($setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Ubah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect . $eventID);
    }
  }

  public function deleteWorkshop($eventID, $id)
  {
    $data = $this->GM->getWorkshop($id)->row();
    if ($data) {
      $delete = $this->GM->delete('workshops', ['id' => $id]);
      if ($delete > 0) {
        $this->session->set_flashdata('success', 'Data berhasil di hapus');
      } else {
        $this->session->set_flashdata('error', 'Server data sedang sibuk, silahkan coba lagi');
      }
    } else {
      $this->session->set_flashdata('error', 'Data yang anda masukan tidak ada');
    }
    redirect($this->redirect . $eventID);
  }
  // Workshop End ----

  // Participant Category Start ----
  public function participantWorkshop($eventID, $workshopID)
  {
    $event = $this->EM->get($eventID)->row();
    $workshop = $this->EM->getWorkshopByID($workshopID)->row();
    $workshopParticipants = $this->EM->getWorkshopParticipantCategoryByWorkshopID($workshopID)->result();
    $data = [
      'title'                 => 'Backoffice | Detail Data Event',
      'cardTitle'             => 'Detail Data Program Event',
      'event'                 => $event,
      'workshop'              => $workshop,
      'workshopParticipants'  => $workshopParticipants,
    ];
    $page = '/backoffice/admin/event/detail/participant/index';
    pageBackend($page, $data);
  }

  public function participantWorkshopAdd($eventID, $workshopID)
  {
    $event = $this->EM->get($eventID)->row();
    $workshop = $this->EM->getWorkshopByID($workshopID)->row();
    $this->_validation('participantCategory');
    if ($this->form_validation->run() === false) {
      $data = [
        'title'                 => 'Backoffice | Detail Data Event',
        'cardTitle'             => 'Form Kategori Peserta Event',
        'workshop'              => $workshop,
        'event'                 => $event,
        'participantCategories' => $this->GM->getParticipantCategory()->result(),
        'priceTypes'            => $this->GM->getPriceType()->result(),
      ];

      $page = '/backoffice/admin/event/detail/participant/add';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $participant_categories = $data['pc_id'];
      $success = true;

      foreach ($participant_categories as $participant_category) {
        $participantData = [
          'ws_id' => $data['ws_id'],
          'pc_id' => $participant_category,
          'pt_id' => $data['pt_id'],
          'price' => removeDots($data['price']),
        ];

        if (!$this->EM->saveEventWorkshopParticipant($participantData)) {
          $success = false;
          break;
        }
      }

      if ($success) {
        $this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect . $eventID . '/participant-categories/' . $workshopID);
    }
  }

  public function participantWorkshopUpdate($eventID, $workshopID, $id)
  {
    $event = $this->EM->get($eventID)->row();
    $workshop = $this->EM->getWorkshopByID($workshopID)->row();
    $workshopParicipant = $this->EM->getWorkshopParticipantCategoryByID($id);
    $this->_validation('participantCategory');
    if ($this->form_validation->run() === false) {
      $data = [
        'title'                 => 'Backoffice | Detail Data Event',
        'cardTitle'             => 'Form Kategori Peserta Event',
        'workshop'              => $workshop,
        'event'                 => $event,
        'workshopParicipant'    => $workshopParicipant,
        'participantCategories' => $this->GM->getParticipantCategory()->result(),
        'priceTypes'            => $this->GM->getPriceType()->result(),
      ];

      $page = '/backoffice/admin/event/detail/participant/edit';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'id'    => $data['id'],
        'ws_id' => $data['ws_id'],
        'pc_id' => $data['pc_id'],
        'pt_id' => $data['pt_id'],
        'price' => removeDots($data['price']),
      ];

      $save = $this->EM->saveEventWorkshopParticipant($setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Ubah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect . $eventID . '/participant-categories/' . $workshopID);
    }
  }

  public function participantWorkshopDelete($eventID, $workshopID, $id)
  {
    $data = $this->EM->getWorkshopParticipantCategoryByID($id);
    if ($data) {
      $delete = $this->GM->delete('workshop_participant_category_prices', ['id' => $id]);
      if ($delete > 0) {
        $this->session->set_flashdata('success', 'Data berhasil di hapus');
      } else {
        $this->session->set_flashdata('error', 'Server data sedang sibuk, silahkan coba lagi');
      }
    } else {
      $this->session->set_flashdata('error', 'Data yang anda masukan tidak ada');
    }
    redirect($this->redirect . $eventID . '/participant-categories/' . $workshopID);
  }

  private function _validation($type)
  {

    if ($type == 'workshop') {
      $this->form_validation->set_rules(
        'name',
        'Nama kegiatan',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'type',
        'Lokasi kegoatan',
        'trim|required',
        [
          'required'    => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'start_date',
        'Tanggal mulai kegiatan',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'qty',
        'Kuota kegiatan',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'venue',
        'Tempat kegiatan',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );
    } else if ($type === 'priceType') {
      $this->form_validation->set_rules(
        'pt_id',
        'Tipe harga',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'start_date',
        'Tanggal mulai',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'end_date',
        'Tanggal mulai',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );
    } else if ($type === 'participantCategory') {
      $this->form_validation->set_rules(
        'pc_id[]',
        'Peserta',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'pt_id',
        'Tipe harga',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );

      $this->form_validation->set_rules(
        'price',
        'Harga',
        'trim|required',
        [
          'required' => '%s wajib di isi',
        ]
      );
    }
  }
}
