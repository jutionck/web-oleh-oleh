<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $bankAccount->id ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name" class="form-label">Nama Bank <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= set_value('name') ? set_value('name') : $bankAccount->name; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('name'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="number" class="form-label">Nomor Rekening <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('number') ? 'is-invalid' : ''; ?>" id="number" name="number" value="<?= set_value('number') ? set_value('number') : $bankAccount->number; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('number'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="branch" class="form-label">Cabang <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('branch') ? 'is-invalid' : ''; ?>" id="branch" name="branch" value="<?= set_value('branch') ? set_value('branch') : $bankAccount->branch; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('branch'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="account_name" class="form-label">Nama Penerima <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('account_name') ? 'is-invalid' : ''; ?>" id="account_name" name="account_name" value="<?= set_value('account_name') ? set_value('account_name') : $bankAccount->account_name; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('account_name'); ?>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url($redirect) ?>" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>