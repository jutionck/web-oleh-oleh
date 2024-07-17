<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zoom_meeting extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->redirect = 'backoffice/zoom-meeting';
    $this->load->model('backoffice/General_model', 'GM');
  }

  public function index()
  {
    $data = [
      'title'     => 'Backoffice | Zoom Meeting',
      'cardTitle' => 'Data Zoom Meeting Event Online',
      'zooms'     => $this->GM->GetOnlineWorkshopEvents()->result(),
    ];
    $page = '/backoffice/admin/zoom-meeting/index';
    pageBackend($page, $data);
  }

  public function update($id)
  {
    $zoom = $this->GM->GetOnlineWorkshopEventsByWorkshopId($id)->row();
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'       => 'Backoffice | Data Zoom Meeting',
        'cardTitle'   => 'Ubah Data Zoom Meeting',
        'zoom'        => $zoom,
        'workshops'   => $this->GM->getWorkshop(null, 'Online')->result(),
        'redirectURL' => $this->redirect,
      ];
      $page = '/backoffice/admin/zoom-meeting/edit';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'ws_id'       => $data['ws_id'],
        'link'        => $data['link']
      ];
      if (!empty($data['id'])) {
        $setValue['id'] = $data['id'];
      }
      $save = $this->GM->saveOnlineWorkshop('workshop_online_event', $setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Ubah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect);
    }
  }

  private function _validation()
  {
    $this->form_validation->set_rules(
      'ws_id',
      'Nama Kegiatan',
      'required',
      array('required' => '%s wajib di isi')
    );
  }
}
