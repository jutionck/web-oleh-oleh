<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Venue extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->redirect = 'backoffice/venues';
    $this->load->model('backoffice/General_model', 'GM');
  }

  public function index()
  {
    $data = [
      'title'       => 'Backoffice | Hotel',
      'cardTitle'   => 'Data Hotel',
      'redirectURL' => $this->redirect,
      'venues'      => $this->GM->getVenueWithEvent()->result(),
      'period'      => $this->GM->getVenuePeriod(),
    ];
    $page = '/backoffice/admin/venue/index';
    pageBackend($page, $data);
  }

  public function period()
  {
    if ($this->input->is_ajax_request()) {
      $data = $this->input->post();
      $setValue = [
        'id'          => $data['id'],
        'start_date'  => $data['start_date'],
        'end_date'    => $data['end_date'],
      ];
      $save = $this->GM->save('venue_periods', $setValue);
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

  public function add()
  {
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'         => 'Backoffice | Data Hotel',
        'cardTitle'     => 'Tambah Data Hotel',
        'event'         => $this->GM->getOfflineEvent(),
        'redirectURL'   => $this->redirect,
      ];
      $page = '/backoffice/admin/venue/add';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'name'        => $data['name'],
        'room_type'   => $data['room_type'],
        'price'       => removeDots($data['price']),
        'pe_id'       => $data['pe_id'],
        'qty'         => $data['qty'],
        'is_active'   => $data['is_active'],
      ];
      $save = $this->GM->save('program_event_venues', $setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect);
    }
  }

  public function update($id)
  {
    $venue = $this->GM->getVenue($id)->row();
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'       => 'Backoffice | Data Hotel',
        'cardTitle'   => 'Ubah Data Hotel',
        'venue'       => $venue,
        'redirectURL' => $this->redirect,
        'event'       => $this->GM->getOfflineEvent(),
      ];
      $page = '/backoffice/admin/venue/edit';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'id'          => $data['id'],
        'name'        => $data['name'],
        'room_type'   => $data['room_type'],
        'price'       => removeDots($data['price']),
        'pe_id'       => $data['pe_id'],
        'qty'         => $data['qty'],
        'is_active'   => $data['is_active'],
      ];
      $save = $this->GM->save('program_event_venues', $setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Ubah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect);
    }
  }

  public function delete($id)
  {
    $data = $this->GM->getVenue($id)->row();
    if ($data) {
      $delete = $this->GM->delete('program_event_venues', ['id' => $id]);
      if ($delete > 0) {
        $this->session->set_flashdata('success', 'Data berhasil di hapus');
      } else {
        $this->session->set_flashdata('error', 'Server data sedang sibuk, silahkan coba lagi');
      }
    } else {
      $this->session->set_flashdata('error', 'Data yang anda masukan tidak ada');
    }
    redirect($this->redirect);
  }

  private function _validation()
  {
    $this->form_validation->set_rules(
      'name',
      'Nama kamar',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'room_type',
      'Tipe kamar',
      'trim|required',
      [
        'required'    => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'price',
      'Harga kamar',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );
  }
}
