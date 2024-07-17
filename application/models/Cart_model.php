<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function get_cart_by_user_id($user_id)
  {
    $this->db->where('user_id', $user_id);
    $query = $this->db->get('carts');
    return $query->row();
  }

  public function create_cart($user_id)
  {
    $data = array(
      'user_id' => $user_id
    );
    $this->db->insert('carts', $data);
    return $this->db->insert_id();
  }

  public function add_item_to_cart($cart_id, $product_id, $quantity, $price)
  {
    // Check if the item already exists in the cart
    $this->db->where('cart_id', $cart_id);
    $this->db->where('product_id', $product_id);
    $query = $this->db->get('cart_items');

    if ($query->num_rows() > 0) {
      // Item exists, update the quantity
      $existing_item = $query->row();
      $new_quantity = $existing_item->quantity + $quantity;
      $this->db->where('id', $existing_item->id);
      $this->db->update('cart_items', array('quantity' => $new_quantity));
    } else {
      // Item does not exist, insert new item
      $data = array(
        'cart_id' => $cart_id,
        'product_id' => $product_id,
        'quantity' => $quantity,
        'price' => $price
      );
      $this->db->insert('cart_items', $data);
    }
  }

  public function get_cart_items($cart_id)
  {
    $this->db->select('cart_items.*, products.name, products.image_url');
    $this->db->from('cart_items');
    $this->db->join('products', 'cart_items.product_id = products.id');
    $this->db->where('cart_items.cart_id', $cart_id);
    $query = $this->db->get();
    return $query->result();
  }

  public function clear_cart($cart_id)
  {
    $this->db->where('cart_id', $cart_id);
    $this->db->delete('cart_items');
  }

  public function get_cart_id_by_user_id($user_id)
  {
    $this->db->select('id');
    $this->db->from('carts');
    $this->db->where('user_id', $user_id);
    $query = $this->db->get();
    return $query->row()->id;
  }

  public function clear_cart_by_user_id($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->delete('cart_items');
    $this->db->where('user_id', $user_id);
    $this->db->delete('carts');
  }

  public function clear_cart_items($cart_id)
  {
    $this->db->where('cart_id', $cart_id);
    $this->db->delete('cart_items');
  }

  public function delete_cart($cart_id)
  {
    $this->db->where('id', $cart_id);
    $this->db->delete('carts');
  }
}
