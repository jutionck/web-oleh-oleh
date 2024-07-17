<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function get_product_by_id($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('products');
    return $query->row();
  }

  public function get_all_products()
  {
    $query = $this->db->get('products');
    return $query->result();
  }
}
