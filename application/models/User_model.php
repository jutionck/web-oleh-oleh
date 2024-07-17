<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function get_user($username)
  {
    $this->db->where('username', $username);
    $query = $this->db->get('users');
    return $query->row();
  }

  public function get_user_by_email($email)
  {
    $this->db->where('email', $email);
    $query = $this->db->get('users');
    return $query->row();
  }

  public function create_user($data)
  {
    $this->db->insert('users', $data);
  }
}
