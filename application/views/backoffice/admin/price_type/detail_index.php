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
        <h5 class="card-title fw-semibold"><?= $cardTitle ?> <span class="text-primary"><?= $price->name ?></span></h5>
        <div class="d-flex d-flex d-flex justify-content-end">
          <a href="<?= site_url('backoffice/price-types') ?>" class="btn btn-dark me-1">Kembali</a>
        </div>
      </div>
      <table id="example" class="table border table-striped table-bordered text-nowrap align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Jenis Kegiatan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($prices as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row->type ?></td>
              <td><?= indonesianDate($row->start_date, 'D MMMM Y') ?></td>
              <td><?= indonesianDate($row->end_date, 'D MMMM Y') ?></td>
              <td>
                <a class="btn btn-sm btn-warning" href="<?= site_url('backoffice/price-types/' . $price->id . '/detail/edit/' . $row->id) ?>">Edit</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>