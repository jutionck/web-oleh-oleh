<div class="container mt-5">
  <h2>Tambah Produk</h2>
  <form action="<?= site_url('productcontroller/add_product') ?>" method="post" enctype="multipart/form-data">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="name" name="name" required>
      <label for="floatingInput">Nama Produk</label>
    </div>
    <div class="form-floating mb-3">
      <select class="form-select" id="category" name="category_id" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $category) : ?>
          <option value="<?= $category->id ?>"><?= $category->name ?></option>
        <?php endforeach; ?>
      </select>
      <label for="floatingInput">Pilih Kategori</label>
    </div>
    <div class="form-floating mb-3">
      <input type="number" class="form-control" id="price" name="price" required>
      <label for="floatingInput">Harga Produk</label>
    </div>
    <div class="form-floating mb-3">
      <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
      <label for="floatingInput">Deskripsi Produk</label>
    </div>
    <div class="form-floating mb-3">
      <input type="file" class="form-control-file" id="image" name="image[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
  </form>
</div>