<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <div class="row gy-4">
            <div class="col-md-7">
              <div class="col-md-12 mt-3">
                <span class="registration-title text-muted">Rincian Biaya</span>
              </div>
              <div class="col-md-12 mt-3">
                <table class="table">
                  <thead class="table-light">
                    <tr>
                      <th>No</th>
                      <th>Deskripsi</th>
                      <th>Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($confirmations as $row) : ?>
                      <?php if (!empty($row->ws_name)) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $row->ws_name ?></td>
                          <td><?= number_format($row->wrd_price, 0) ?></td>
                        </tr>
                      <?php endif; ?>
                      <?php if (!empty($row->venue_name)) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td><?= $row->venue_name ?></td>
                          <td><?= number_format($row->wrd_price, 0) ?></td>
                        </tr>
                      <?php endif; ?>
                    <?php endforeach ?>
                    <tr>
                      <td></td>
                      <td>Unique Payment Verification Codes</td>
                      <td><?= $uniquePayment ?></td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
                      <td id="totalAkhir">Rp<?= number_format($totalPrice, 0) ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="col-md-5" id="paymentFormContainer">
              <div class="col-md-12 mt-3 mb-3">
                <span class="registration-title text-muted">Pilih Pembayaran</span>
              </div>
              <form action="<?= site_url('backoffice/registrants/send-mail/' . $this->uri->segment(4) . '/' . $paymentStatus) ?>" class="row g-2" method="POST">
                <div class="col-md-9">
                  <select class="form-select" id="paymentMethod" name="paymentMethod" require>
                    <option value="" disabled selected>Pilih Pembayaran</option>
                    <option value="manualTransfer">Transfer Manual</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <button type="submit" class="btn btn-success">Proses</button>
                </div>
              </form>
              <div class="mt-3" id="paymentInfo"> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>