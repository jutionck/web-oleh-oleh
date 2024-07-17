<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('General_model', 'GM');
    $this->load->model('User_model', 'UM');
    $this->load->library('session');
  }

  public function login()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->UM->get_user_by_email($email);

    if ($user && password_verify($password, $user->password)) {
      $this->session->set_userdata('user_id', $user->id);
      $this->session->set_userdata('username', $user->username);
      $this->session->set_userdata('fullname', $user->fullname);
      $this->session->set_userdata('role', $user->role);
      redirect('');
    } else {
      $this->session->set_flashdata('error', 'Invalid email or password');
      redirect('auth/login');
    }
  }

  public function register()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $role = $this->input->post('role');

    if ($this->UM->get_user_by_email($email)) {
      $this->session->set_flashdata('error_register', 'Email already exists');
      redirect('auth/login');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $data = array(
      'username' => $email,
      'email' => $email,
      'password' => $hashed_password,
      'role' => $role,
    );

    $this->UM->create_user($data);
    $this->session->set_flashdata('success', 'Registration successful, please login');
    redirect('');
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect();
  }
}
