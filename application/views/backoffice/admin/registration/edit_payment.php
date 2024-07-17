<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="<?= site_url('backoffice/registrants/edit-payment-proccess/' . $transaction->wsr_id) ?>" method="POST">
            <input type="hidden" value="<?= $transaction->id ?>" name="transaction_id">
            <input type="hidden" value="<?= $transaction->wsr_id ?>" name="registrant_id">
            <input type="hidden" value="<?= $transaction->total ?>" name="transaction_total">
            <div class="mb-3">
              <label for="paymentMethodUpdate" class="form-label">Cara Pembayaran</label>
              <select id="paymentMethodUpdate" class="form-select" name="pm_id" required>
                <option value="" disabled selected>Pilih Pembayaran</option>
                <?php foreach ($payments as $row) : ?>
                  <option value="<?= $row->id ?>" <?= ($row->id == $transaction->pm_id) ? 'selected' : ''; ?>><?= $row->name ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="transferDateUpdate" class="form-label">Tanggal Transfer</label>
                  <input type="date" class="form-control" id="transferDateUpdate" name="transfer_date" value="<?= set_value('transfer_date') ? set_value('transfer_date') : $transaction->transfer_date; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="transferDateRemainingUpdate" class="form-label">Tanggal Transfer Kekurangan</label>
                  <input type="date" class="form-control" id="transferDateRemainingUpdate" name="transfer_date_remaining" value="<?= set_value('transfer_date_remaining') ? set_value('transfer_date_remaining') : $transaction->transfer_date_remaining; ?>">
                  <div id="emailHelp" class="form-text">Terisi jika pendaftar pernah kurang bayar (underpaid)</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="discountUpdate" class="form-label">Potongan</label>
                  <input type="text" class="form-control" id="discountUpdate" name="discount" value="<?= set_value('discount') ? set_value('discount') : $transaction->discount; ?>" onkeyup="formatRupiah(this)">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="amountTransferredUpdate" class="form-label">Jumlah Transfer</label>
                  <input type="text" class="form-control" id="amountTransferredUpdate" name="transfer_amount" value="<?= set_value('transfer_amount') ? set_value('transfer_amount') : $transaction->transfer_amount; ?>" onkeyup="formatRupiah(this)">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="amountTransferredRemainingUpdate" class="form-label">Jumlah Transfer Kekurangan</label>
                  <input type="text" class="form-control" id="amountTransferredRemainingUpdate" name="transfer_amount_remaining" value="<?= set_value('transfer_amount_remaining') ? set_value('transfer_amount_remaining') : $transaction->transfer_amount_remaining; ?>" onkeyup="formatRupiah(this)">
                  <div id="emailHelp" class="form-text">Terisi jika pendaftar pernah kurang bayar (underpaid)</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="reference" class="form-label">Ref</label>
                  <input type="text" class="form-control" id="reference" name="ref" value="<?= set_value('ref') ? set_value('ref') : $transaction->ref; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="sponsor" class="form-label">Sponsor</label>
                  <input type="text" class="form-control" id="sponsor" name="sponsor" value="<?= set_value('sponsor') ? set_value('sponsor') : $transaction->sponsor; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="sponsor_contact" class="form-label">Contact</label>
                  <input type="text" class="form-control" id="sponsor_contact" name="sponsor_contact" value="<?= set_value('sponsor_contact') ? set_value('sponsor_contact') : $transaction->sponsor_contact; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="no_hp" class="form-label">No Handphone</label>
                  <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= set_value('no_hp') ? set_value('no_hp') : $transaction->no_hp; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email') ? set_value('email') : $transaction->email; ?>">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <a href="<?= site_url('backoffice/registrants/transaction/' . $transaction->wsr_id) ?>" class="btn btn-dark">Batal</a>
              <button type="submit" class="btn btn-primary ms-6">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    function adjustInputsBasedOnMethod() {
      var selectedMethod = $("#paymentMethodUpdate option:selected").text().trim().toUpperCase();
      console.log("Selected Payment Method: " + selectedMethod); // Debugging untuk melihat metode yang terpilih
      var methodsRequiringDetails = ["GL", "CASH", "CREDIT CARD", "EDC", "BANK TRANSFER"];
      var showDetails = methodsRequiringDetails.includes(selectedMethod);

      $("#transferDateUpdate, #transferDateRemainingUpdate, #amountTransferredUpdate, #discountUpdate, #amountTransferredRemainingUpdate").closest(".mb-3").toggle(showDetails);
    }
    $("#paymentMethodUpdate").change(adjustInputsBasedOnMethod);

    $("#paymentMethodUpdate").trigger('change');
  });


  document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('discountUpdate')) {
      formatRupiah(document.getElementById('discountUpdate'));
    }
    if (document.getElementById('amountTransferredUpdate')) {
      formatRupiah(document.getElementById('amountTransferredUpdate'));
    }
    if (document.getElementById('amountTransferredRemainingUpdate')) {
      formatRupiah(document.getElementById('amountTransferredRemainingUpdate'));
    }
  });
</script>