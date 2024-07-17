<div class="container mt-5">
  <h2>Checkout</h2>
  <form id="checkout-form" action="<?= site_url('checkout/place_order') ?>" method="post">
    <div class="row">
      <div class="col-md-8">
        <h4>Shipping Information</h4>
        <?php if (!$customer) : ?>
          <div class="form-floating mb-3">
            <select class="form-select" id="province" name="province" required>
              <option value="">Select Province</option>
              <?php foreach ($provinces as $province) : ?>
                <option value="<?= $province->id ?>"><?= $province->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select" id="regency" name="regency" required>
              <option value="">Select Regency</option>
            </select>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select" id="district" name="district" required>
              <option value="">Select District</option>
            </select>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select" id="village" name="village" required>
              <option value="">Select Village</option>
            </select>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="address" name="address" required>
            <label for="floatingInput">Alamat Lengkap</label>
          </div>
        <?php else : ?>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" value="<?= $customer->province_name ?>" name="province" readonly>
            <label for="floatingInput">Provinsi</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" value="<?= $customer->regency_name ?>" name="regency" readonly>
            <label for="floatingInput">Kabupaten</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" value="<?= $customer->district_name ?>" name="district" readonly>
            <label for="floatingInput">Kecamatan</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" value="<?= $customer->village_name ?>" name="village" readonly>
            <label for="floatingInput">Kelurahan</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" value="<?= $customer->address ?>" name="address" readonly>
            <label for="floatingInput">Alamat Lengkap</label>
          </div>
        <?php endif; ?>
        <h4>Payment Method</h4>
        <div class="form-floating mb-3">
          <select class="form-select" name="payment_method" id="payment_method" required>
            <option value="cod">Cash on Delivery (COD)</option>
            <option value="bank_transfer">Bank Transfer</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <h4>Order Summary</h4>
        <ul class="list-group">
          <?php $total = 0; ?>
          <?php foreach ($cart_items as $item) : ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <img src="<?= base_url('assets/official/images/products/') . $item->image_url ?>" alt="<?= $item->name ?>" style="width: 50px; height: 50px;">
              <?= $item->name ?> (<?= $item->quantity ?>x) - <?= number_format($item->price, 2) ?>
              <?php $total += $item->quantity * $item->price; ?>
            </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Total:</span>
            <span class="fw-bold"><?= number_format($total, 2) ?></span>
          </li>
        </ul>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-dark btn-block mt-3" id="place-order">Proses</button>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function() {
    $('.form-select').select2();

    $('#province').change(function() {
      var province_id = $(this).val();
      $.ajax({
        url: '<?= site_url('checkout/get_regencies') ?>',
        method: 'POST',
        data: {
          province_id: province_id
        },
        success: function(data) {
          $('#regency').html('<option value="">Select Regency</option>');
          $.each(JSON.parse(data), function(key, value) {
            $('#regency').append('<option value="' + value.id + '">' + value.name + '</option>');
          });
          $('#regency').trigger('change');
        }
      });
    });

    $('#regency').change(function() {
      var regency_id = $(this).val();
      $.ajax({
        url: '<?= site_url('checkout/get_districts') ?>',
        method: 'POST',
        data: {
          regency_id: regency_id
        },
        success: function(data) {
          $('#district').html('<option value="">Select District</option>');
          $.each(JSON.parse(data), function(key, value) {
            $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
          });
          $('#district').trigger('change');
        }
      });
    });

    $('#district').change(function() {
      var district_id = $(this).val();
      $.ajax({
        url: '<?= site_url('checkout/get_villages') ?>',
        method: 'POST',
        data: {
          district_id: district_id
        },
        success: function(data) {
          $('#village').html('<option value="">Select Village</option>');
          $.each(JSON.parse(data), function(key, value) {
            $('#village').append('<option value="' + value.id + '">' + value.name + '</option>');
          });
          $('#village').trigger('change');
        }
      });
    });

    $('#checkout-form').submit(function(e) {
      e.preventDefault();

      var payment_method = $('#payment_method').val();
      if (payment_method === 'cod') {
        this.submit();
      } else {
        $.ajax({
          url: '<?= site_url('checkout/place_order') ?>',
          method: 'POST',
          data: $(this).serialize(),
          success: function(data) {
            var response = JSON.parse(data);
            if (response.snap_token) {
              snap.pay(response.snap_token, {
                onSuccess: function(result) {
                  window.location.href = '<?= site_url('checkout/success') ?>';
                },
                onPending: function(result) {
                  window.location.href = '<?= site_url('checkout/success') ?>';
                },
                onError: function(result) {
                  alert('Payment failed');
                },
                onClose: function() {
                  alert('Payment popup closed');
                }
              });
            }
          }
        });
      }
    });
  });
</script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $this->config->item('midtrans_client_key') ?>"></script>