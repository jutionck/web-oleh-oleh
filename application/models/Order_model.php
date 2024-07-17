<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function create_order($customer_id, $total_price, $status, $payment_method)
  {
    $data = array(
      'customer_id' => $customer_id,
      'total_price' => $total_price,
      'status' => $status,
      'payment_method' => $payment_method,
      'created_at' => date('Y-m-d H:i:s')
    );
    $this->db->insert('orders', $data);
    return $this->db->insert_id();
  }

  public function add_order_item($order_id, $product_id, $quantity, $price)
  {
    $data = array(
      'order_id' => $order_id,
      'product_id' => $product_id,
      'quantity' => $quantity,
      'price' => $price
    );
    $this->db->insert('order_items', $data);
  }

  public function get_order_items($order_id)
  {
    $this->db->select('order_items.*, products.name, products.image_url');
    $this->db->from('order_items');
    $this->db->join('products', 'order_items.product_id = products.id');
    $this->db->where('order_items.order_id', $order_id);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_orders_by_customer($customer_id)
  {
    $this->db->where('customer_id', $customer_id);
    $query = $this->db->get('orders');
    return $query->result();
  }

  public function get_order_history_by_user_id($user_id)
  {
    $this->db->select('orders.*, order_items.*, products.name as product_name, products.image_url');
    $this->db->from('orders');
    $this->db->join('order_items', 'order_items.order_id = orders.id');
    $this->db->join('products', 'products.id = order_items.product_id');
    $this->db->where('orders.customer_id', $user_id);
    $this->db->order_by('orders.created_at', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }

  public function update_order_status($order_id, $data)
  {
    $this->db->where('id', $order_id);
    $this->db->update('orders', $data);
  }
}
