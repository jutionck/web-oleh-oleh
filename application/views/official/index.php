<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?= base_url('assets/official/images/banner-1.jpg') ?>" class="d-block w-100" alt="..." />
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/official/images/banner-2.jpg') ?>" class="d-block w-100" alt="..." />
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Main Content -->
<div class="container mt-4">
  <!-- Recommendations Section -->
  <div class="row mt-4" id="product-container">
    <div class="col-12">
      <h3>Rekomendasi baru</h3>
    </div>
    <!-- Product Cards -->
    <?php foreach ($products as $product) : ?>
      <div class="col-md-4 mb-4">
        <div class="product-card position-relative">
          <div class="image-container position-relative">
            <img src="<?= base_url('assets/official/images/products/') . $product->image_url ?>" class="img-fluid" alt="Product Image">
            <a href="#" class="btn-view" data-bs-toggle="modal" data-bs-target="#productModal-<?= $product->id ?>">VIEW DETAILS</a>
          </div>
          <div class="card-content">
            <div class="price-name">
              <h5><?= $product->name ?></h5>
              <p class="price"><?= number_format($product->price, 0) ?></p>
            </div>
            <?php
            if ($product->category_name === 'Makanan') {
              echo '<span class="badge rounded-pill text-bg-primary">' . $product->category_name . '</span>';
            } else if ($product->category_name === 'Minuman') {
              echo '<span class="badge rounded-pill text-bg-warning">' . $product->category_name . '</span>';
            } else if ($product->category_name === 'Kerajinan') {
              echo '<span class="badge rounded-pill text-bg-success">' . $product->category_name . '</span>';
            }
            ?>
          </div>
        </div>
      </div>

      <!-- Product Modal -->
      <div class="modal fade productModalClass" id="productModal-<?= $product->id ?>" tabindex="-1" aria-labelledby="productModalLabel-<?= $product->id ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="productModalLabel-<?= $product->id ?>"><?= $product->name ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex">
              <div class="product-details me-4" style="flex: 1;">
                <h3 class="product-title"><?= number_format($product->price, 0) ?></h3>
                <p><span class="badge bg-success">In Stock</span></p>
                <p class="product-description"><?= $product->description ?></p>
                <div class="d-flex">
                  <div class="input-group me-3" style="width: 100px;">
                    <button class="btn btn-outline-secondary decrease-qty" type="button" data-id="<?= $product->id ?>">-</button>
                    <input type="text" class="form-control text-center qty-input" data-id="<?= $product->id ?>" value="1">
                    <button class="btn btn-outline-secondary increase-qty" type="button" data-id="<?= $product->id ?>">+</button>
                  </div>
                  <button class="btn btn-dark btn-cart me-2 add-to-cart" data-id="<?= $product->id ?>" data-name="<?= $product->name ?>" data-price="<?= $product->price ?>">Add To Cart</button>
                </div>
              </div>
              <div id="carouselExampleIndicators-<?= $product->id ?>" class="carousel slide" data-bs-ride="carousel" style="flex: 1;">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators-<?= $product->id ?>" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators-<?= $product->id ?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators-<?= $product->id ?>" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="<?= base_url('assets/official/images/products/') . $product->image_url ?>" class="d-block w-100" alt="Product Image">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators-<?= $product->id ?>" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators-<?= $product->id ?>" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php endforeach ?>
  </div>
  <div class="text-center mt-3 mb-3">
    <div class="loader" id="loader"></div>
    <button class="btn btn-primary" id="load-more">Muat Lainnya</button>
  </div>
</div>

<script>
  $(document).ready(function() {
    let offset = 3;
    $('#load-more').on('click', function() {
      $('#loader').show();
      $.ajax({
        url: "<?= site_url('product/load_more') ?>",
        method: "POST",
        data: {
          offset: offset
        },
        dataType: "json",
        success: function(response) {
          let html = '';
          $.each(response, function(index, product) {
            html += `<div class="col-md-4 mb-4">
                            <div class="product-card position-relative">
                              <div class="image-container position-relative">
                                <img src="<?= base_url('assets/official/images/products/') ?>${product.image_url}" class="img-fluid" alt="Product Image">
                                <a href="#" class="btn-view" data-bs-toggle="modal" data-bs-target="#productModal-${product.id}">VIEW DETAILS</a>
                              </div>
                              <div class="card-content">
                                <div class="price-name">
                                  <h5>${product.name}</h5>
                                  <p class="price">${product.price.toLocaleString()}</p>
                                </div>`;
            if (product.category_name === 'Makanan') {
              html += `<span class="badge rounded-pill text-bg-primary">${product.category_name}</span>`;
            } else if (product.category_name === 'Minuman') {
              html += `<span class="badge rounded-pill text-bg-warning">${product.category_name}</span>`;
            } else if (product.category_name === 'Kerajinan') {
              html += `<span class="badge rounded-pill text-bg-success">${product.category_name}</span>`;
            }
            html += `</div>
                            </div>
                          </div>
                          <div class="modal fade" id="productModal-${product.id}" tabindex="-1" aria-labelledby="productModalLabel-${product.id}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="productModalLabel-${product.id}">${product.name}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex">
                                  <div class="product-details me-4" style="flex: 1;">
                                    <h3 class="product-title">${product.price.toLocaleString()}</h3>
                                    <p class="product-description">${product.description}</p>
                                    <div class="d-flex">
                                      <div class="input-group me-3" style="width: 100px;">
                                        <button class="btn btn-outline-secondary decrease-qty" type="button" data-id="${product.id}">-</button>
                                        <input type="text" class="form-control text-center qty-input" data-id="${product.id}" value="1">
                                        <button class="btn btn-outline-secondary increase-qty" type="button" data-id="${product.id}">+</button>
                                      </div>
                                      <button class="btn btn-dark btn-cart me-2 add-to-cart" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}">Add To Cart</button>
                                    </div>
                                  </div>
                                  <div id="carouselExampleIndicators-${product.id}" class="carousel slide" data-bs-ride="carousel" style="flex: 1;">
                                    <div class="carousel-indicators">
                                      <button type="button" data-bs-target="#carouselExampleIndicators-${product.id}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                      <button type="button" data-bs-target="#carouselExampleIndicators-${product.id}" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                      <button type="button" data-bs-target="#carouselExampleIndicators-${product.id}" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                      <div class="carousel-item active">
                                        <img src="<?= base_url('assets/official/images/products/') ?>${product.image_url}" class="d-block w-100" alt="Product Image">
                                      </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators-${product.id}" data-bs-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators-${product.id}" data-bs-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Next</span>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>`;
          });
          $('#product-container').append(html);
          offset += 3;
          $('#loader').hide();
        },
        error: function() {
          $('#loader').hide();
        }
      });
    });

    // // Menambahkan event listener untuk tombol Add To Cart
    // $(document).on('click', '.add-to-cart', function() {
    //   let id = $(this).data('id');
    //   let name = $(this).data('name');
    //   let price = $(this).data('price');
    //   let qty = $('.qty-input[data-id="' + id + '"]').val();

    //   $.ajax({
    //     url: "<?= site_url('cart/add_to_cart') ?>",
    //     method: "POST",
    //     data: {
    //       id: id,
    //       name: name,
    //       price: price,
    //       qty: qty
    //     },
    //     dataType: "json",
    //     success: function(response) {
    //       $('#cartIcon .badge').text(response.total_items); // Update ikon keranjang dengan jumlah item
    //     }
    //   });
    // });

    // // Menambahkan event listener untuk tombol quantity
    // $(document).on('click', '.increase-qty', function() {
    //   let id = $(this).data('id');
    //   let input = $('.qty-input[data-id="' + id + '"]');
    //   let currentValue = parseInt(input.val());
    //   input.val(currentValue + 1);
    // });

    // $(document).on('click', '.decrease-qty', function() {
    //   let id = $(this).data('id');
    //   let input = $('.qty-input[data-id="' + id + '"]');
    //   let currentValue = parseInt(input.val());
    //   if (currentValue > 1) {
    //     input.val(currentValue - 1);
    //   }
    // });
  });
</script>