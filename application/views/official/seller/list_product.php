<div class="container mt-5">
  <h2>Product List</h2>
  <?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
  <?php endif; ?>
  <a href="<?= site_url('seller/product/add') ?>" class="btn btn-primary mb-3">Add Product</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Description</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($products)) : ?>
        <?php foreach ($products as $key => $product) : ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->category_name ?></td>
            <td><?= number_format($product->price, 2) ?></td>
            <td><?= $product->description ?></td>
            <td>
              <?php if ($product->image_url) : ?>
                <img src="<?= base_url('assets/upload/' . $product->image_url) ?>" alt="<?= $product->name ?>" style="width: 70px; height: 70px;">
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= site_url('productcontroller/edit_product/' . $product->id) ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="<?= site_url('productcontroller/delete_product/' . $product->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else : ?>
        <tr>
          <td colspan="7" class="text-center">No products found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>