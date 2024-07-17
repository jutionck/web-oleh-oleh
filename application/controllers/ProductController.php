<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Product_model');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data = [
      'title'      => 'BeliYuk - Web Oleh-oleh',
      'products'  => $this->Product_model->get_all_products(),
    ];
    $page = '/official/seller/list_product';
    pageOfficial($page, $data);
  }

  public function add_product()
  {
    $this->form_validation->set_rules('name', 'Product Name', 'required');
    $this->form_validation->set_rules('category_id', 'Category', 'required');
    $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    $this->form_validation->set_rules('description', 'Description', 'required');

    if ($this->form_validation->run() == FALSE) {
      $data['categories'] = $this->Product_model->get_all_categories();

      $page = 'official/seller/add_product';
      pageOfficial($page, $data);
    } else {
      // Handle image upload
      $main_image_url = null;
      if (!empty($_FILES['image']['name'][0])) {
        $_FILES['file']['name'] = $_FILES['image']['name'][0];
        $_FILES['file']['type'] = $_FILES['image']['type'][0];
        $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][0];
        $_FILES['file']['error'] = $_FILES['image']['error'][0];
        $_FILES['file']['size'] = $_FILES['image']['size'][0];

        $uploadPath = './assets/upload/';
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
          $fileData = $this->upload->data();
          $main_image_url = $fileData['file_name'];
        }
      }

      $product_data = array(
        'name' => $this->input->post('name'),
        'category_id' => $this->input->post('category_id'),
        'price' => $this->input->post('price'),
        'description' => $this->input->post('description'),
        'seller_id' => $this->session->userdata('user_id'),
        'image_url' => $main_image_url // Save the main image in the products table
      );

      $product_id = $this->Product_model->insert_product($product_data);

      if ($product_id) {
        if (!empty($_FILES['image']['name'][0])) {
          $filesCount = count($_FILES['image']['name']);
          for ($i = 0; $i < $filesCount; $i++) {
            $_FILES['file']['name'] = $_FILES['image']['name'][$i];
            $_FILES['file']['type'] = $_FILES['image']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
            $_FILES['file']['error'] = $_FILES['image']['error'][$i];
            $_FILES['file']['size'] = $_FILES['image']['size'][$i];

            $uploadPath = './assets/upload/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
              $fileData = $this->upload->data();
              $uploadData = array(
                'product_id' => $product_id,
                'image_url' => $fileData['file_name']
              );
              $this->Product_model->insert_product_image($uploadData);
            }
          }
        }
        $this->session->set_flashdata('success', 'Product added successfully.');
        redirect('seller/product');
      } else {
        $this->session->set_flashdata('error', 'Failed to add product.');
        redirect('seller/product/add');
      }
    }
  }
}
