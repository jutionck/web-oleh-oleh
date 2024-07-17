<div class="container-fluid">
  <?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      <?= $this->session->flashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php elseif ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i>
      <?= $this->session->flashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <div class="card">
    <div class="card-body">
      <div class="d-flex d-flex justify-content-between mb-4">
        <h5 class="card-title fw-semibold"><?= $cardTitle ?></h5>
        <div class="d-flex justify-content-end">
          <a href="<?= site_url($redirectURL . '/add') ?>" class="btn btn-primary">Tambah</a>
          <button class="btn btn-dark ms-1 editPeriodButton" data-id="<?= $period->id ?>" data-start="<?= $period->start_date ?>" data-end="<?= $period->end_date ?>">Periode</button>
        </div>
      </div>
      <div class="table-responsive">
        <table id="example" class="table border table-striped table-bordered text-nowrap align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Kegiatan</th>
              <th>Venue</th>
              <th>Tipe Kamar</th>
              <th>Harga</th>
              <th>Kuota</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($venues as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->pe_name ?></td>
                <td><?= $row->name ?></td>
                <td><?= $row->room_type ?></td>
                <td><?= number_format($row->price, 0) ?></td>
                <td><?= $row->qty ?></td>
                <td><?= $row->is_active ? '<span class="badge text-bg-success">Aktif</span>' : '<span class="badge text-bg-dark">Tidak Aktif</span>' ?></td>
                <td>
                  <a class="btn btn-sm btn-warning" href="<?= site_url($redirectURL . '/edit/' . $row->id) ?>">Edit</a>
                  <button type="button" class="btn btn-sm btn-danger delete-venue" data-id="<?= $row->id ?>">Hapus</button>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
        <div class="modal fade" id="addEditPeriodModal" tabindex="-1" aria-labelledby="addEditModalPeriodLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addEditModalPeriodLabel">Form Periode Booking Hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="addEditPeriodForm">
                  <input type="hidden" id="period_id" name="id">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="savePeriodButton">Simpan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>