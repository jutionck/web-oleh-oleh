<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<?= @$materialCertificate->id ?>">
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="ws_id" class="form-label">Nama Kegiatan <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('ws_id') ? 'is-invalid' : ''; ?>" value=" <?= $materialCertificate->ws_name ?>" readonly>
                  <input type="hidden" name="ws_id" value="<?= $materialCertificate->workshop_id ?>">
                  <div class="invalid-feedback">
                    <?= form_error('ws_id'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="link" class="form-label">Link Materi</label>
                  <input type="url" class="form-control" id="link" name="link" value="<?= set_value('link') ? set_value('link') : @$materialCertificate->link; ?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="link" class="form-label">Status Sertifikat</label>
                  <select name="is_certificate_active" id="is_certificate_active" class="form-select <?= form_error('is_certificate_active') ? 'is-invalid' : ''; ?>">
                    <option value="1" <?= isset($materialCertificate->is_certificate_active) && $materialCertificate->is_certificate_active == 1 ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= !isset($materialCertificate->is_certificate_active) || $materialCertificate->is_certificate_active == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>

              <div class="col-md-12" id="certificate_file_container" style="display: <?= isset($materialCertificate->is_certificate_active) && $materialCertificate->is_certificate_active == 1 ? 'block' : 'none'; ?>;">
                <div class="mb-3">
                  <label for="certificate_file" class="form-label">File Sertifikat</label>
                  <input type="file" class="form-control" id="certificate_file" name="certificate_file">
                  <?php if (!empty($materialCertificate->certificate_file)) : ?>
                    <div class="mt-3">
                      <?php if (in_array(pathinfo($materialCertificate->certificate_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) : ?>
                        <img src="<?= base_url('assets/certificate/' . $materialCertificate->certificate_file) ?>" alt="Sertifikat" class="img-fluid" width="50%">
                      <?php elseif (pathinfo($materialCertificate->certificate_file, PATHINFO_EXTENSION) === 'pdf') : ?>
                        <embed src="<?= base_url('assets/certificate/' . $materialCertificate->certificate_file) ?>" type="application/pdf" width="100%">
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
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
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const isCertificateActiveSelect = document.getElementById("is_certificate_active");
    const certificateFileContainer = document.getElementById("certificate_file_container");

    isCertificateActiveSelect.addEventListener("change", function() {
      if (this.value == "1") {
        certificateFileContainer.style.display = "block";
      } else {
        certificateFileContainer.style.display = "none";
      }
    });
  });
</script>