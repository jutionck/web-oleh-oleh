<div class="container">
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
      </div>
      <div class="table-responsive">
        <table class="table border table-striped table-bordered text-nowrap align-middle report-ws">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Kegiatan</th>
              <th>Link Materi</th>
              <th>Status Sertifikat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($materialCertificates as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->ws_name ?> <?= ($row->ws_type === 'online') ?
                                            '<span class="badge font-medium bg-primary-subtle text-dark">Online</span>' :
                                            '<span class="badge font-medium bg-dark-subtle">Offline</span>' ?></td>
                <td>
                  <?php if ($row->link) :  ?>
                    <a href="<?= $row->link ?>" target="_blank">Link Materi</a> <i class="ti ti-copy ms-2" style="cursor: pointer; font-size: 1.5em;" onclick="copyToClipboard('<?= $row->link ?>')"></i>
                  <?php endif ?>
                </td>
                <td>
                  <?= ((int)$row->is_certificate_active === 1) ?
                    '<span class="badge font-medium bg-success">Aktif</span>' :
                    '<span class="badge font-medium bg-danger">Tidak Aktif</span>' ?>
                </td>
                <td>
                  <a class="btn btn-sm btn-warning editZoomMeetingButton" href="<?= site_url('backoffice/material-and-certificate/edit/' . $row->workshop_id) ?>">Edit</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="d-flex d-flex justify-content-between mb-4">
        <h5 class="card-title fw-semibold">Log Download</h5>
      </div>
      <div class="table-responsive">
        <table id="example" class="table border table-striped table-bordered text-nowrap align-middle report-ws">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Peserta</th>
              <th>Kegiatan</th>
              <th>Jenis</th>
              <th>Jumlah Download</th>
              <th>Download Terakhir</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($downloadLogs as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->registrant_fullname_with_title ?></td>
                <td><?= $row->ws_name ?></td>
                <td>
                  <?= $row->file_type === 'materi' ?
                    '<span class="badge font-medium bg-success">Materi</span>' :
                    '<span class="badge font-medium bg-primary">Sertifikat</span>' ?>
                </td>
                <td><?= $row->download_count ?></td>
                <td><?= indonesianDate($row->downloaded_at, 'D MMMM Y, HH:mm') ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="copyToast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Link copied to clipboard!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script>
  function copyToClipboard(text) {
    const elem = document.createElement('textarea');
    elem.value = text;
    document.body.appendChild(elem);
    elem.select();
    document.execCommand('copy');
    document.body.removeChild(elem);
    const toastEl = document.getElementById('copyToast');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
  }
</script>