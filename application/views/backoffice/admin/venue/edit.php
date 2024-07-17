<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $venue->id ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name" class="form-label">Nama Hotel <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?= set_value('name') ? set_value('name') : $venue->name; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('name'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="room_type" class="form-label">Tipe Kamar <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('room_type') ? 'is-invalid' : ''; ?>" id="room_type" name="room_type" value="<?= set_value('room_type') ? set_value('room_type') : $venue->room_type; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('room_type'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="price" class="form-label">Harga Kamar <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('price') ? 'is-invalid' : ''; ?>" id="price" name="price" onkeyup="formatRupiah(this)" value="<?= set_value('price') ? set_value('price') : $venue->price; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('price'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="pe_id" class="form-label">Kegiatan</label>
                  <input type="hidden" class="form-control" id="pe_id" name="pe_id" value="<?= $event->id ?>">
                  <input type="text" class="form-control" id="pe_name" value="<?= $event->name ?>" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="qty" class="form-label">Kuota</label>
                  <input type="text" class="form-control" id="qty" name="qty" value="<?= $venue->qty ?>">
                </div>
              </div>
              <div class="col-md-6">
                <label for="pe_id" class="form-label">Status</label>
                <div class="form-check form-switch mb-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="venueStatus" <?php echo ($venue->is_active == 1) ? 'checked' : ''; ?>>
                  <input type="hidden" name="is_active" id="is_active" value="<?php echo $venue->is_active; ?>">
                  <label class="form-check-label" for="venueStatus"> <span id="active-text">Aktif</span> / <span id="inactive-text">Tidak Aktif</span></label>
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
  function toggleVenueStatus() {
    const isChecked = document.getElementById("venueStatus").checked;
    document.getElementById("is_active").value = isChecked ? "1" : "0";
    document.getElementById("active-text").style.fontWeight = isChecked ? "bold" : "normal";
    document.getElementById("inactive-text").style.fontWeight = isChecked ? "normal" : "bold";
  }

  const venueStatusCheckbox = document.getElementById("venueStatus");
  if (venueStatusCheckbox) {
    venueStatusCheckbox.addEventListener("change", toggleVenueStatus);
    toggleVenueStatus();
  }
</script>