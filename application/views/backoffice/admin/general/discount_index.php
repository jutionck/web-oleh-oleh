<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $discount->id ?>">
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="dicountPrice" class="form-label">Harga <span class="text-danger">*</span> </label>
                  <input type="number" class="form-control <?= form_error('discount_price') ? 'is-invalid' : ''; ?>" id="dicountPrice" name="discount_price" value="<?= set_value('discount_price') ? set_value('discount_price') : $discount->discount_price; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('discount_price'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="dicountStart" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                  <input type="date" class="form-control <?= form_error('start_date') ? 'is-invalid' : ''; ?>" id="dicountStart" name="start_date" value="<?= set_value('start_date') ? set_value('start_date') : $discount->start_date; ?>">
                  <div class=" invalid-feedback">
                    <?= form_error('start_date'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopEnd" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="workshopEnd" name="end_date" value="<?= set_value('end_date') ? set_value('end_date') : $discount->end_date; ?>">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('backoffice/discounts') ?>" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>