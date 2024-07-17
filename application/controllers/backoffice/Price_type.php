
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Price_type extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/General_model', 'GM');
    $this->load->model('backoffice/Price_type_model', 'PTM');
  }

  public function index()
  {
    $data = [
      'title'       => 'Backoffice | Kategori Harga',
      'cardTitle'   => 'Data Kategori Harga',
      'prices'      => $this->GM->getPriceType()->result(),
    ];
    $page = '/backoffice/admin/price_type/index';
    pageBackend($page, $data);
  }

  public function detail($id)
  {
    $price = $this->GM->getPriceType($id)->row();
    $data = [
      'title'       => 'Backoffice | Kategori Harga',
      'cardTitle'   => 'Detail Kategori Harga',
      'price'       => $price,
      'prices'      => $this->PTM->getPriceTypeDetailByID($id)->result(),
    ];
    $page = '/backoffice/admin/price_type/detail_index';
    pageBackend($page, $data);
  }

  public function detailAdd($id)
  {
    $price = $this->GM->getPriceType($id)->row();
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'         => 'Backoffice | Kategori Harga',
        'cardTitle'     => 'Tambah Data',
        'price'         => $price,
      ];
      $page = '/backoffice/admin/price_type/detail_add';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'type'        => $data['type'],
        'pt_id'       => $data['pt_id'],
        'start_date'  => $data['start_date'],
        'end_date'    => $data['end_date'],
      ];
      $save = $this->GM->save('price_types_detail', $setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect('backoffice/price-types/' . $price->id . '/detail');
    }
  }

  public function detailUpdate($id, $priceDetailID)
  {
    $price = $this->GM->getPriceType($id)->row();
    $priceDetail = $this->PTM->get($priceDetailID);
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'         => 'Backoffice | Kategori Harga',
        'cardTitle'     => 'Ubah Data',
        'price'         => $price,
        'priceDetail'   => $priceDetail,
      ];
      $page = '/backoffice/admin/price_type/detail_edit';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'id'          => $data['id'],
        'type'        => $data['type'],
        'pt_id'       => $data['pt_id'],
        'start_date'  => $data['start_date'],
        'end_date'    => $data['end_date'],
      ];
      $save = $this->GM->save('price_types_detail', $setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Tambah data berhasil</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect('backoffice/price-types/' . $price->id . '/detail');
    }
  }

  public function add()
  {
    if ($this->input->is_ajax_request()) {
      $data = $this->input->post();
      $setValue = [
        'name'    => $data['name'],
      ];
      $save = $this->GM->save('price_types', $setValue);
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
      ];
      $save = $this->GM->save('price_types', $setValue);
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
    $data = $this->GM->getPriceType($id)->row();
    if ($data) {
      $delete = $this->GM->delete('price_types', ['id' => $id]);
      if ($delete > 0) {
        $this->session->set_flashdata('success', 'Data berhasil di hapus');
      } else {
        $this->session->set_flashdata('error', 'Server data sedang sibuk, silahkan coba lagi');
      }
    } else {
      $this->session->set_flashdata('error', 'Data yang anda masukan tidak ada');
    }
    redirect('backoffice/price-types');
  }

  private function _validation()
  {
    $this->form_validation->set_rules(
      'type',
      'Jenis kegiatan',
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
        'required'    => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'end_date',
      'Tanggal selesai',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );
  }
}
