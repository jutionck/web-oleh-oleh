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
    $this->db->select('products.*, categories.name as category_name');
    $this->db->from('products');
    $this->db->join('categories', 'products.category_id = categories.id');
    $this->db->order_by('products.created_at', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_all_categories()
  {
    $query = $this->db->get('categories');
    return $query->result();
  }

  public function insert_product($data)
  {
    $this->db->insert('products', $data);
    return $this->db->insert_id();
  }

  public function insert_product_image($data)
  {
    $this->db->insert('product_images', $data);
  }
}
