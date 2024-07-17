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
        <button id="addParticipantButton" class="btn btn-primary">Tambah</button>
      </div>
      <table id="example" class="table border table-striped table-bordered text-nowrap align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($participantCategories as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row->name ?></td>
              <td>
                <button class="btn btn-sm btn-warning editParticipantButton" data-id="<?= $row->id ?>" data-name="<?= $row->name ?>">Edit</button>
                <button class="btn btn-sm btn-danger delete-participant-category" data-id="<?= $row->id ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <div class="modal fade" id="addEditParticipantModal" tabindex="-1" aria-labelledby="addEditModalParticipantLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addEditModalParticipantLabel">Form Kategori Peserta</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="addEditParticipantForm">
                <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="name" name="name">
                </div>
                <input type="hidden" id="province_id" name="id">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary" id="saveParticipantButton">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>