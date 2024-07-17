<div class="container">
  <div class="card">
    <div class="card-body">
      <div class="d-flex d-flex justify-content-between mb-4">
        <h5 class="card-title fw-semibold"><?= $cardTitle ?></h5>
      </div>
      <div class="row">
        <div class="col-md-2 mb-3">
          <select id="statusFilter" class="form-select select2">
            <option value="" disabled selected>Filter Status</option>
            <option value="">All</option>
            <option value="SENT">SENT</option>
            <option value="FAILED">FAILED</option>
            <option value="PENDING">PENDING</option>
          </select>
        </div>
      </div>
      <div class="table-responsive">
        <table id="email-log" class="table border table-striped table-bordered text-nowrap align-middle report-ws">
          <thead>
            <tr>
              <th>No</th>
              <th>Aksi</th>
              <th>Status</th>
              <th>Penerima</th>
              <th>Kegiatan</th>
              <th>Email</th>
              <th>Jenis</th>
              <th>Attachment</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($emailLogs as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <button class="btn btn-sm btn-warning resendMailQueue" data-id="<?= $row->id ?>"><i class="ti ti-brand-telegram"></i></button>
                </td>
                <td>
                  <?php if ($row->status === 'sent') : ?>
                    <span class="badge bg-success rounded-3 fw-semibold">SENT</span>
                  <?php elseif ($row->status === 'failed') : ?>
                    <span class="badge bg-danger rounded-3 fw-semibold">FAILED</span>
                  <?php else : ?>
                    <span class="badge bg-warning rounded-3 fw-semibold">PENDING</span>
                  <?php endif; ?>
                </td>
                <td><?= $row->registrant_fullname ?></td>
                <td><?= $row->ws_name ?></td>
                <td><?= $row->to ?></td>
                <td><?= $row->subject === 'Invoice' ? 'Invoice' :  'Bukti Pembayaran' ?></td>
                <td>
                  <a href="<?= base_url($row->attachment) ?>"><?= $row->registrant_key ?>.pdf</a>
                </td>

                <td><?= $row->updated_at ?></td>

              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="toast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toast-body"> </div>
    </div>
  </div>
</div>