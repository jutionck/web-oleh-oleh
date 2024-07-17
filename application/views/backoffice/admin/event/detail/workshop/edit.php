<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Form</h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <input type="hidden" name="pe_id" value="<?= $this->uri->segment(4) ?>">
            <input type="hidden" name="id" value="<?= $workshop->id ?>">
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="workshopName" class="form-label">Nama Kegiatan <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>" id="workshopName" name="name" value="<?= set_value('name') ? set_value('name') : $workshop->name; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('name'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopStart" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                  <input type="date" class="form-control <?= form_error('start_date') ? 'is-invalid' : ''; ?>" id="workshopStart" name="start_date" value="<?= set_value('start_date') ? set_value('start_date') : $workshop->start_date; ?>">
                  <div class=" invalid-feedback">
                    <?= form_error('start_date'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopEnd" class="form-label">Tanggal Selesai</label>
                  <input type="date" class="form-control" id="workshopEnd" name="end_date" value="<?= set_value('end_date') ? set_value('end_date') : $workshop->end_date; ?>">
                  <div id="emailHelp" class="form-text">Abaikan ini jika kegiatan hanya 1 hari</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopType" class="form-label">Tipe Kegiatan <span class="text-danger">*</span></label>
                  <select name="type" id="workshopType" class="form-select <?= form_error('type') ? 'is-invalid' : ''; ?>">
                    <option value="" disabled>Tipe Kegiatan</option>
                    <option value="online" <?= ($workshop->type == 'online') ? 'selected' : '' ?>>Online</option>
                    <option value="offline" <?= ($workshop->type == 'offline') ? 'selected' : '' ?>>Offline</option>
                  </select>

                  <div class="invalid-feedback">
                    <?= form_error('type'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="workshopQty" class="form-label">Kuota <span class="text-danger">*</span></label>
                  <input type="number" name="qty" id="workshopQty" class="form-control <?= form_error('qty') ? 'is-invalid' : ''; ?>" value="<?= set_value('qty') ? set_value('qty') : $workshop->qty; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('qty'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="workshopVenue" class="form-label">Venue <span class="text-danger">*</span></label>
                  <input type="text" name="venue" id="workshopVenue" class="form-control <?= form_error('venue') ? 'is-invalid' : ''; ?>" value="<?= set_value('venue') ? set_value('venue') : $workshop->venue; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('venue'); ?>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= site_url('backoffice/events/detail/' .  $this->uri->segment(4)) ?>" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>