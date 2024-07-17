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
        <button id="addUserButton" class="btn btn-primary">Tambah</button>
      </div>
      <table id="example" class="table border table-striped table-bordered text-nowrap align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Status</th>
            <th>Terakhir Login</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($users as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row->name ?></td>
              <td><?= $row->username ?></td>
              <td>
                <?= ($row->is_active == 'active') ?
                  '<span class="badge rounded-pill text-bg-primary">Aktif</span>' :
                  '<span class="badge rounded-pill text-bg-dark">Tidak Aktif</span>' ?>
              </td>
              <td><?= $row->last_login ?></td>
              <td>
                <button class="btn btn-sm btn-warning editUserButton" data-id="<?= $row->id ?>" data-name="<?= $row->name ?>" data-username="<?= $row->username ?>" data-status="<?= $row->is_active ?>">Edit</button>
                <button class="btn btn-sm btn-danger delete-user" data-id="<?= $row->id ?>">Hapus</button>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <div class="modal fade" id="addEditUserModal" tabindex="-1" aria-labelledby="addEditUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addEditUserModalLabel">Form</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="addEditUserForm">
                <div class="mb-3">
                  <label for="name" class="form-label">Nama</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i></span>
                  </div>
                  <small id="passwordHelpBlock" class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                </div>
                <div class="mb-3" id="status-container" style="display: none;">
                  <label for="is_active" class="form-label">Status</label>
                  <select class="form-select" id="is_active" name="is_active">
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                  </select>
                </div>
                <input type="hidden" id="user_id" name="id">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary" id="saveUserButton">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>