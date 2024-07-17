
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_page extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('General_model', 'GM');
		$this->load->library('session');
	}

	public function index()
	{
		$data = [
			'title'			=> 'BeliYuk - Web Oleh-oleh',
			'products'	=> $this->GM->getProductImage(3, 0)->result(),
		];
		$page = '/official/index';
		pageOfficial($page, $data);
	}

	public function loadMore()
	{
		$offset = $this->input->post('offset');
		$products = $this->GM->getProductImage(3, $offset)->result();
		echo json_encode($products);
	}

	public function add_to_cart()
	{
		if (!$this->session->userdata('customer_id')) {
			echo json_encode(array('status' => 'not_logged_in'));
			return;
		}

		$customer_id = $this->session->userdata('customer_id');
		$order_data = array(
			'customer_id' => $customer_id,
			'total_price' => 0,
			'status' => 'pending',
			'payment_method' => 'cod',
			'created_at' => date('Y-m-d H:i:s')
		);

		$order_id = $this->GM->create_order($order_data);

		$item_data = array(
			'order_id' => $order_id,
			'product_id' => $this->input->post('id'),
			'quantity' => $this->input->post('qty'),
			'price' => $this->input->post('price')
		);

		$this->GM->add_order_items($order_id, array($item_data));

		$total_items = $this->GM->get_order_total_items($customer_id);
		echo json_encode(array('status' => 'success', 'total_items' => $total_items));
	}

	public function get_cart_items()
	{
		$cart_items = $this->cart->contents();
		$response = array(
			'items' => $cart_items
		);

		echo json_encode($response);
	}

	public function remove_from_cart()
	{
		$rowid = $this->input->post('id');

		$data = array(
			'rowid' => $rowid,
			'qty' => 0
		);

		$this->cart->update($data);

		$response = array(
			'total_items' => $this->cart->total_items()
		);

		echo json_encode($response);
	}
}
