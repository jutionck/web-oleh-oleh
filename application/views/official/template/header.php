<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BeliYuk - Web Oleh-oleh</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="shortcut icon" href="<?= base_url('assets/official/') ?>images/logooo.png" type="image/x-icon" />
  <link rel="stylesheet" href="<?= base_url('assets/official/') ?>css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <header class="bg-light py-3">
    <div class="container d-flex align-items-center justify-content-between">
      <a class="navbar-brand" href="<?= site_url() ?>">
        <img src="<?= base_url('assets/official/') ?>images/logooo.png" alt="OLX" height="40" />
      </a>
      <div class="location-dropdown">
        <input class="form-control" type="text" placeholder="Jakarta Selatan, Jakarta" aria-label="Location" />
        <div class="location-dropdown-menu">
          <div class="mb-2">
            <i class="fas fa-map-marker-alt"></i> Lokasi saat ini
            <div>Pasar Minggu, Jakarta Selatan, ...</div>
          </div>
          <hr />
          <div>LOKASI TERKINI</div>
          <div><i class="fas fa-map-marker-alt"></i> Pasar Minggu</div>
        </div>
      </div>
      <form class="d-flex ms-3 flex-grow-1">
        <input class="form-control me-2" type="search" placeholder="Temukan Mobil, Handphone, dan lainnya ..." aria-label="Search" />
        <button class="btn btn-outline-success" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>

      <div class="icon-container ms-3">
        <div class="position-relative">
          <a href="#" class="d-flex align-items-center cart-icon" id="cartIcon">
            <i class="fas fa-shopping-bag fa-2x"></i>
            <span class="badge">0</span>
          </a>
          <div class="cart-dropdown" id="cartDropdown">
            <div class="cart-summary">TOTAL: <span id="cartTotal">0</span></div>
            <div class="cart-actions">
              <div class="d-grid gap-2">
                <a href="" class="btn btn-outline-dark">Checkout</a>
              </div>
            </div>
          </div>
        </div>

        <?php if ($this->session->userdata('username')) : ?>
          <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $this->session->userdata('fullname') ?>
          </button>
          <ul class="dropdown-menu" style="z-index: 1050;">
            <li><a class="dropdown-item" href="<?= site_url('order/history') ?>">Riwayat Pemesanan</a></li>
            <li><a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Logout</a></li>
          </ul>
        <?php else : ?>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal">
            Login/Register
          </button>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <div class="modal fade" id="authModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="authModalLabel">Login / Register</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="authTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
            </li>
          </ul>
          <div class="tab-content" id="authTabContent">

            <div class="tab-pane fade show active mt-3" id="login" role="tabpanel" aria-labelledby="login-tab">
              <form action="<?= site_url('auth/login') ?>" method="post">
                <div class="form-floating mb-3">
                  <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                  <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                  <label for="floatingPassword">Password</label>
                </div>
                <?php if ($this->session->flashdata('error')) : ?>
                  <div class="alert alert-danger mt-3"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </form>
            </div>

            <!-- Register Form -->
            <div class="tab-pane fade mt-3" id="register" role="tabpanel" aria-labelledby="register-tab">
              <form action="<?= site_url('auth/register') ?>" method="post">
                <div class="form-floating mb-3">
                  <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                  <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                  <label for="floatingPassword">Password</label>
                </div>
                <div class="form-floating mb-3">
                  <select name="role" id="" class="form-select">
                    <option value="seller">Penjual</option>
                    <option value="customer">Pembeli</option>
                  </select>
                  <label for="floatingPassword">Daftar Sebagai</label>
                </div>
                <?php if ($this->session->flashdata('error')) : ?>
                  <div class="alert alert-danger mt-3"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Register</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Alert Modal -->
  <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5>Anda harus login untuk menambahkan item ke keranjang.</h5>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Fetch and display cart items on page load
      fetchCartItems();

      // Add to Cart event listener
      $(document).on('click', '.add-to-cart', function() {
        <?php if (!$this->session->userdata('username')) : ?>
          $('#productModal').modal('hide');
          $('#alertModal').modal('show');
        <?php else : ?>
          let id = $(this).data('id');
          let name = $(this).data('name');
          let price = $(this).data('price');
          let qty = $('.qty-input[data-id="' + id + '"]').val();

          $.ajax({
            url: "<?= site_url('cart/add_to_cart') ?>",
            method: "POST",
            data: {
              id: id,
              name: name,
              price: price,
              qty: qty
            },
            dataType: "json",
            success: function(response) {
              $('#cartIcon .badge').text(response.total_items); // Update cart icon with total items
              fetchCartItems(); // Refresh cart items
            }
          });
        <?php endif; ?>
      });

      // Fetch and display cart items
      function fetchCartItems() {
        $.ajax({
          url: "<?= site_url('cart/get_cart_items') ?>",
          method: "GET",
          dataType: "json",
          success: function(response) {
            let cartItems = '';
            let total = 0;
            let checkoutUrl = "<?= site_url('checkout') ?>";

            $.each(response.items, function(index, item) {
              let itemTotal = item.quantity * item.price;
              cartItems += `
                            <div class="cart-item">
                                <img src="${item.image_url}" alt="${item.name}" style="width: 70px; height: 70px;" />
                                <div class="cart-item-details">
                                    <h5>${item.name}</h5>
                                    <p>${item.quantity}x - ${item.price}</p>
                                </div>
                                <a href="#" class="text-danger remove-from-cart" data-id="${item.rowid}"><i class="fas fa-times"></i></a>
                            </div>
                        `;
              total += itemTotal;
            });

            $('#cartDropdown').html(cartItems);
            $('#cartDropdown').append(`
                        <div class="cart-summary">TOTAL: <span id="cartTotal">${total.toFixed(2)}</span></div>
                        <div class="d-grid gap-2 mt-3">
                              <a href="${checkoutUrl}" class="btn btn-outline-dark">Checkout</a>
                        </div>
                    `);
          }
        });
      }

      // Checkout event listener
      $(document).on('click', '#checkoutButton', function() {
        $.ajax({
          url: "<?= site_url('cart/checkout') ?>",
          method: "POST",
          dataType: "json",
          success: function(response) {
            if (response.success) {
              alert(response.success);
              fetchCartItems(); // Refresh cart items
            } else {
              alert(response.error);
            }
          }
        });
      });

      // Increase quantity event listener
      $(document).on('click', '.increase-qty', function() {
        let id = $(this).data('id');
        let input = $('.qty-input[data-id="' + id + '"]');
        let currentValue = parseInt(input.val());
        input.val(currentValue + 1);
      });

      // Decrease quantity event listener
      $(document).on('click', '.decrease-qty', function() {
        let id = $(this).data('id');
        let input = $('.qty-input[data-id="' + id + '"]');
        let currentValue = parseInt(input.val());
        if (currentValue > 1) {
          input.val(currentValue - 1);
        }
      });

      // Remove from cart event listener
      $(document).on('click', '.remove-from-cart', function() {
        let rowid = $(this).data('id');

        $.ajax({
          url: "<?= site_url('cart/remove_from_cart') ?>",
          method: "POST",
          data: {
            id: rowid
          },
          dataType: "json",
          success: function(response) {
            $('#cartIcon .badge').text(response.total_items); // Update cart icon with total items
            fetchCartItems(); // Refresh cart items
          }
        });
      });
    });
  </script>