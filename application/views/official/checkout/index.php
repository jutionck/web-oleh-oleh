<div class="container mt-5">
  <h2>Checkout</h2>
  <form action="<?= site_url('checkout/place_order') ?>" method="post">
    <div class="row">
      <div class="col-md-8">
        <h4>Shipping Information</h4>
        <?php if (!$customer) : ?>
          <div class="form-group">
            <label for="province">Province:</label>
            <select class="form-select" id="province" name="province" required>
              <option value="">Select Province</option>
              <?php foreach ($provinces as $province) : ?>
                <option value="<?= $province->id ?>"><?= $province->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="regency">Regency:</label>
            <select class="form-select" id="regency" name="regency" required>
              <option value="">Select Regency</option>
            </select>
          </div>
          <div class="form-group">
            <label for="district">District:</label>
            <select class="form-select" id="district" name="district" required>
              <option value="">Select District</option>
            </select>
          </div>
          <div class="form-group">
            <label for="village">Village:</label>
            <select class="form-select" id="village" name="village" required>
              <option value="">Select Village</option>
            </select>
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
        <?php else : ?>
          <div class="form-group">
            <label for="province">Province:</label>
            <input type="text" class="form-control" value="<?= $customer->province_name ?>" disabled>
          </div>
          <div class="form-group">
            <label for="regency">Regency:</label>
            <input type="text" class="form-control" value="<?= $customer->regency_name ?>" disabled>
          </div>
          <div class="form-group">
            <label for="district">District:</label>
            <input type="text" class="form-control" value="<?= $customer->district_name ?>" disabled>
          </div>
          <div class="form-group">
            <label for="village">Village:</label>
            <input type="text" class="form-control" value="<?= $customer->village_name ?>" disabled>
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" value="<?= $customer->address ?>" disabled>
          </div>
        <?php endif; ?>
        <h4>COD</h4>
        <div class="form-group">
          <select class="form-select" name="payment_method" required>
            <option value="cod">Cash on Delivery (COD)</option>
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
          <li class="list-group-item">Total: <?= number_format($total, 2) ?></li>
        </ul>
        <button type="submit" class="btn btn-primary btn-block mt-3">Place Order</button>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function() {
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
        }
      });
    });
  });
</script>