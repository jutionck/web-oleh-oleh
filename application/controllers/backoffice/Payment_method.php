<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_method extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->redirect = 'backoffice/payment-methods';
    $this->load->model('backoffice/General_model', 'GM');
  }

  public function index()
  {
    $data = [
      'title'       => 'Backoffice | Metode Pembayaran',
      'cardTitle'   => 'Data Metode Pembayaran',
      'redirectURL' => $this->redirect,
      'payments'    => $this->GM->getPaymentMethod()->result()
    ];
    $page = '/backoffice/admin/payment/index';
    pageBackend($page, $data);
  }

  public function add()
  {
    if ($this->input->is_ajax_request()) {
      $data = $this->input->post();
      $setValue = [
        'name'      => $data['name'],
        'is_active' => $data['is_active'],
      ];
      $save = $this->GM->save('payment_methods', $setValue);
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
        'id'        => $data['id'],
        'name'      => $data['name'],
        'is_active' => $data['is_active'],
      ];
      $save = $this->GM->save('payment_methods', $setValue);
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
    $data = $this->GM->getPaymentMethod($id)->row();
    if ($data) {
      $delete = $this->GM->delete('payment_methods', ['id' => $id]);
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
}
