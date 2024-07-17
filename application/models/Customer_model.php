<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function get_customer_by_user_id($user_id)
  {
    $this->db->select('customers.*, provinces.name as province_name, regencies.name as regency_name, districts.name as district_name, villages.name as village_name');
    $this->db->from('customers');
    $this->db->join('provinces', 'provinces.id = customers.province_id');
    $this->db->join('regencies', 'regencies.id = customers.regency_id');
    $this->db->join('districts', 'districts.id = customers.district_id');
    $this->db->join('villages', 'villages.id = customers.village_id');
    $this->db->where('customers.user_id', $user_id);
    $query = $this->db->get();
    return $query->row();
  }


  public function insert_customer($data)
  {
    $this->db->insert('customers', $data);
  }

  public function update_customer($user_id, $data)
  {
    $this->db->where('user_id', $user_id);
    $this->db->update('customers', $data);
  }
}
