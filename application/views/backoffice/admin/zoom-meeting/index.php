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
        <table id="example" class="table border table-striped table-bordered text-nowrap align-middle report-ws">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Kegiatan</th>
              <th>Link Zoom</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($zooms as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->ws_name ?></td>
                <td>
                  <?php if ($row->link) :  ?>
                    <a href="<?= $row->link ?>" target="_blank">Link Zoom Meeting</a> <i class="ti ti-copy ms-2" style="cursor: pointer; font-size: 1.5em;" onclick="copyToClipboard('<?= $row->link ?>')"></i>
                  <?php endif ?>
                </td>
                <td>
                  <a class="btn btn-sm btn-warning editZoomMeetingButton" href="<?= site_url('backoffice/zoom-meeting/edit/' . $row->workshop_id) ?>">Edit</a>
                </td>
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