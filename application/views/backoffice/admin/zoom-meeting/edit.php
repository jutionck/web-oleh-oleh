<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <input type="hidden" name="id" id="id" value="<?= @$zoom->id ?>">
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="ws_id" class="form-label">Nama Kegiatan <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('ws_id') ? 'is-invalid' : ''; ?>" value=" <?= $zoom->ws_name ?>" readonly>
                  <input type="hidden" name="ws_id" value="<?= $zoom->workshop_id ?>">
                  <div class="invalid-feedback">
                    <?= form_error('ws_id'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="link" class="form-label">Link Zoom </label>
                  <input type="url" class="form-control" id="link" name="link" value="<?= set_value('link') ? set_value('link') : @$zoom->link; ?>">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= site_url($redirectURL) ?>" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>