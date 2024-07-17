
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank_account extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/General_model', 'GM');
    $this->redirect = 'backoffice/bank-accounts';
  }

  public function index()
  {
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'         => 'Backoffice | Akun Bank',
        'cardTitle'     => 'Data Bank',
        'redirect'      => $this->redirect,
        'bankAccount'   => $this->GM->getBankAccount()->row(),
      ];
      $page = '/backoffice/admin/general/bank_index';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'id'            => $data['id'],
        'name'          => $data['name'],
        'branch'        => $data['branch'],
        'number'        => $data['number'],
        'account_name'  => $data['account_name'],
      ];
      $save = $this->GM->save('bank_accounts', $setValue);
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
      'name',
      'Nama bank',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'branch',
      'Cabang',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'number',
      'Nomor rekening',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'account_name',
      'Atas nama',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );
  }
}
