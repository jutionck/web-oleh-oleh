
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Discount extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/General_model', 'GM');
    $this->redirect = 'backoffice/discounts';
  }

  public function index()
  {
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'     => 'Backoffice | Provinsi',
        'cardTitle' => 'Data Diskon',
        'discount'  => $this->GM->getDiscount(),
      ];
      $page = '/backoffice/admin/general/discount_index';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'id'              => $data['id'],
        'discount_price'  => $data['discount_price'],
        'start_date'      => $data['start_date'],
        'end_date'        => $data['end_date'],
      ];
      $save = $this->GM->save('discounts', $setValue);
      if ($save > 0) {
        $this->session->set_flashdata('success', '<b>Data berhasil disimpan</b>');
      } else {
        $this->session->set_flashdata('error', '<b>Server sedang sibuk, silahkan coba lagi</b>');
      }
      redirect($this->redirect);
    }
  }


  private function _validation()
  {
    $this->form_validation->set_rules(
      'discount_price',
      'Harga diskon',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'start_date',
      'Tanggal mulai diskon',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'end_date',
      'Tanggal selesai diskon',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );
  }
}
