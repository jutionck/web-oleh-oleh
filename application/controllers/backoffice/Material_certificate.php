<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material_certificate extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->redirect = 'backoffice/material-and-certificate';
    $this->load->model('backoffice/General_model', 'GM');
    $this->load->model('backoffice/Registration_model', 'RM');
  }

  public function index()
  {
    $data = [
      'title'                 => 'Backoffice | Materi dan Sertifikat',
      'cardTitle'             => 'Data Materi dan Sertifikat',
      'materialCertificates'  => $this->GM->GetMaterialCertificateForEvent()->result(),
      'downloadLogs'          => $this->RM->getDownloadLogs(),
    ];
    $page = '/backoffice/admin/material-certificate/index';
    pageBackend($page, $data);
  }

  public function update($id)
  {
    $materialCertificate = $this->GM->GetMaterialCertificateForEventByWorkshopId($id)->row();
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'               => 'Backoffice | Data Materi dan Sertifikat',
        'cardTitle'           => 'Ubah Data Materi dan Sertifikat',
        'materialCertificate' => $materialCertificate,
        'workshops'           => $this->GM->getWorkshop(null, null)->result(),
        'redirectURL'         => $this->redirect,
      ];
      $page = '/backoffice/admin/material-certificate/edit';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $certificateFile = $materialCertificate->certificate_file;
      $fontFile = $materialCertificate->font_file;

      // Handle certificate file upload
      if (!empty($_FILES['certificate_file']['name'])) {
        $new_name = "certificate_" . $data['ws_id'];
        $config['upload_path'] = './assets/certificate/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['file_name'] = $new_name;
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('certificate_file')) {
          $this->session->set_flashdata('error', $this->upload->display_errors());
          redirect($this->redirect);
          return;
        }

        $certificateFile = $this->upload->data('file_name');
      }

      // Remove certificate file if deactivated
      if ($data['is_certificate_active'] == 0 && !empty($materialCertificate->certificate_file)) {
        $filePath = './assets/certificate/' . $materialCertificate->certificate_file;
        if (file_exists($filePath)) {
          unlink($filePath);
        }
        $certificateFile = null;
      }

      $setValue = [
        'ws_id'                 => $data['ws_id'],
        'link'                  => $data['link'],
        'is_certificate_active' => $data['is_certificate_active'],
        'certificate_file'      => $certificateFile,
      ];

      if (!empty($data['id'])) {
        $setValue['id'] = $data['id'];
      }

      $save = $this->GM->saveOnlineWorkshop('workshop_material_certificate', $setValue);
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
