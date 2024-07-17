<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="priceTypeName" class="form-label">Tipe Harga</label>
                  <input type="hidden" name="pt_id" id="pt_id" value="<?= $price->id ?>">
                  <input type="text" class="form-control" id="priceTypeName" name="name" value="<?= $price->name ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopType" class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
                  <select name="type" id="workshopType" class="form-select <?= form_error('type') ? 'is-invalid' : ''; ?>">
                    <option value="" disabled selected>Tipe Kegiatan</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                  </select>
                  <div class="invalid-feedback">
                    <?= form_error('type'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopStart" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                  <input type="date" class="form-control <?= form_error('start_date') ? 'is-invalid' : ''; ?>" id="workshopStart" name="start_date" aria-describedby="emailHelp">
                  <div class="invalid-feedback">
                    <?= form_error('start_date'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopEnd" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                  <input type="date" class="form-control <?= form_error('end_date') ? 'is-invalid' : ''; ?>" id="workshopEnd" name="end_date" aria-describedby="emailHelp">
                  <div class="invalid-feedback">
                    <?= form_error('end_date'); ?>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= site_url('backoffice/price-types/' . $price->id . '/detail') ?>" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>