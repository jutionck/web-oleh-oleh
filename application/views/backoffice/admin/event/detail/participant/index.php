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
        <h5 class="card-title fw-semibold"><?= $cardTitle ?> <span class="text-primary"><?= $workshop->name ?></span></h5>
        <div class="d-flex d-flex d-flex justify-content-end">
          <a href="<?= site_url('backoffice/events/detail/' . $event->id) ?>" class="btn btn-dark me-1">Kembali</a>
          <a href="<?= site_url('backoffice/events/detail/' . $event->id . '/participant-categories/' . $workshop->id . '/add') ?>" class="btn btn-primary">Tambah</a>
        </div>
      </div>
      <div class="table-responsive">
        <table id="example" class="table border table-striped table-bordered text-nowrap align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Peserta</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($workshopParticipants as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->pc_name ?></td>
                <td><?= $row->pt_name ?></td>
                <td><?= number_format($row->price, 0) ?></td>
                <td>
                  <a class="btn btn-sm btn-success" href="<?= site_url('backoffice/events/detail/' . $event->id . '/participant-categories/' . $workshop->id . '/edit/' . $row->id) ?>" title="Edit Data"><i class="ti ti-edit"></i></a>
                  <button class="btn btn-sm btn-danger delete-workshop-participant" data-id="<?= $row->id ?>" data-event="<?= $event->id ?>" data-workshop="<?= $workshop->id ?>" title="Hapus Data"><i class="ti ti-trash"></i></button>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>