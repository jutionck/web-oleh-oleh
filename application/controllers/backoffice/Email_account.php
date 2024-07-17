
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_account extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    cek_login('admin');
    $this->load->model('backoffice/General_model', 'GM');
    $this->redirect = 'backoffice/email-accounts';
  }

  public function index()
  {
    $this->_validation();
    if ($this->form_validation->run() === false) {
      $data = [
        'title'         => 'Backoffice | Akun Email',
        'cardTitle'     => 'Data Email',
        'redirect'      => $this->redirect,
        'emailAccount'  => $this->GM->getEmailAccount()->row(),
      ];
      $page = '/backoffice/admin/general/email_index';
      pageBackend($page, $data);
    } else {
      $data = $this->input->post();
      $setValue = [
        'id'                => $data['id'],
        'host'              => $data['host'],
        'username'          => $data['username'],
        'password'          => $data['password'],
        'smtp_secure'       => $data['smtp_secure'],
        'port'              => $data['port'],
        'set_from_address'  => $data['set_from_address'],
        'email_forward'     => $data['email_forward'],
      ];
      $save = $this->GM->save('email_accounts', $setValue);
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
      'host',
      'Host email',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'username',
      'Username email',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'password',
      'Password email',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'smtp_secure',
      'SMTP Secure',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'port',
      'PORT',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'set_from_address',
      'Email pengirim',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'set_from_name',
      'Nama email pengirim',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );

    $this->form_validation->set_rules(
      'email_forward',
      'Email terusan',
      'trim|required',
      [
        'required' => '%s wajib di isi',
      ]
    );
  }
}
