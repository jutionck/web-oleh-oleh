<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General_model extends CI_Model
{

  public function getProductImage($limit, $offset)
  {
    $this->db->select('p.id, p.name, p.description, p.image_url, c.name as category_name, p.price');
    $this->db->from('products p');
    $this->db->join('categories c', 'c.id = p.category_id');
    $this->db->limit($limit, $offset);
    return $this->db->get();
  }

  public function getProductImageDetail($productId)
  {
    $this->db->select('p.id, p.name, p.description, pi.image_url, c.name as category_name, p.price');
    $this->db->from('products p');
    $this->db->join('product_images pi', 'pi.product_id = p.id');
    $this->db->join('users u', 'u.id = p.seller_id');
    $this->db->join('categories c', 'c.id = p.category_id');
    $this->db->where('p.id', $productId);
    return $this->db->get();
  }

  public function create_order($data)
  {
    $this->db->insert('orders', $data);
    return $this->db->insert_id();
  }

  public function add_order_items($order_id, $items)
  {
    foreach ($items as $item) {
      $item['order_id'] = $order_id;
      $this->db->insert('order_items', $item);
    }
  }

  public function get_order_total_items($customer_id)
  {
    $this->db->select('COUNT(*) as total_items');
    $this->db->from('order_items oi');
    $this->db->join('orders o', 'oi.order_id = o.id');
    $this->db->where('o.customer_id', $customer_id);
    $query = $this->db->get();
    return $query->row()->total_items;
  }

  public function get_product_by_id($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('products');
    return $query->row();
  }
}
