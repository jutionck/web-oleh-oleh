<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?> <span class="text-primary"><?= $workshop->name ?></span></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <input type="hidden" name="ws_id" value="<?= $workshop->id ?>">
            <div class="row">
              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label for="namaKategoriPeserta" class="form-label">Kategori Peserta</label>
                    <select class="form-select select2 <?= form_error('pc_id[]') ? 'is-invalid' : ''; ?>" name="pc_id[]" id="namaKategoriPeserta" multiple="multiple">
                      <?php foreach ($participantCategories as $row) : ?>
                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                      <?php endforeach ?>
                    </select>
                    <div id="emailHelp" class="form-text">Bisa memasukkan lebih dari 1 (satu) kategori peserta jika harga sama</div>
                    <div class="invalid-feedback">
                      <?= form_error('pc_id[]'); ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="namaKategoriHarga" class="form-label">Kategori Harga</label>
                    <select class="form-select select2 <?= form_error('pt_id') ? 'is-invalid' : ''; ?>" name="pt_id">
                      <option value="" disabled selected>Pilih Kategori Harga</option>
                      <?php foreach ($priceTypes as $row) : ?>
                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                      <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                      <?= form_error('pt_id'); ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="text" name="price" id="price" class="form-control <?= form_error('price') ? 'is-invalid' : ''; ?>" onkeyup="formatRupiah(this)">
                    <div class="invalid-feedback">
                      <?= form_error('price'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= site_url('backoffice/events/detail/' . $event->id . '/participant-categories/' . $workshop->id) ?>" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>