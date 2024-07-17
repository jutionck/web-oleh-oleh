<div class="container">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="table-responsive">
        <table class="table border table-striped table-bordered text-nowrap align-middle tb-uppercase report-ws">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Jenis</th>
              <th>Waktu</th>
              <th>Kuota</th>
              <th>Registrasi</th>
              <th>Sisa</th>
              <th>Rereg</th>
              <th>Cert</th>
              <th>Validated</th>
              <th>Uploaded</th>
              <th>Unpaid</th>
              <th>Underpaid</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($registrations as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->ws_name ?> </td>
                <td><?= $row->pe_name ?></td>
                <td>
                  <?php if (empty($row->ws_end_date)) : ?>
                    <?= indonesianDate($row->ws_start_date, 'D MMMM Y') ?>
                  <?php elseif (date('m', strtotime($row->ws_start_date)) === date('m', strtotime($row->ws_end_date))) : ?>
                    <?= indonesianDate($row->ws_start_date, 'D') ?> -
                    <?= indonesianDate($row->ws_end_date, 'D MMMM Y') ?>
                  <?php else : ?>
                    <?= indonesianDate($row->ws_start_date, 'D MMMM') ?> -
                    <?= indonesianDate($row->ws_end_date, 'D MMMM Y') ?>
                  <?php endif ?>
                </td>
                <td class="text-center"><?= $row->ws_qty ?></td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#allRegModal" data-workshop-id="<?= $row->ws_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->wr_registrant_count ?></a>
                </td>
                <td class="text-center"><?= $row->ws_remaining ?></td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#allPaidModal" data-workshop-id="<?= $row->ws_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->paid_payment ?></a>
                </td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#allUploadedModal" data-workshop-id="<?= $row->ws_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->uploaded_payment ?></a>
                </td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#allUnpaidModal" data-workshop-id="<?= $row->ws_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->pending_payment ?></a>
                </td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#allUnderpaidModal" data-workshop-id="<?= $row->ws_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->underpaid_payment ?></a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4" class="text-end">Jumlah</th>
              <th class="text-center"><?= $totalAll ?></th>
              <th class="text-center"><?= $totalReg ?></th>
              <th class="text-center"><?= $totalRemain ?></th>
              <th class="text-center">-</th>
              <th class="text-center">-</th>
              <th class="text-center"><?= $totalPaid ?></th>
              <th class="text-center"><?= $totalUploaded ?></th>
              <th class="text-center"><?= $totalUnpaid ?></th>
              <th class="text-center"><?= $totalUnderPaid ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal for REG -->
  <div class="modal fade" id="allRegModal" tabindex="-1" aria-labelledby="allRegModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/all-workshop/detail_reg') ?>
    </div>
  </div>

  <!-- Modal for PAID/VALIDATE -->
  <div class="modal fade" id="allPaidModal" tabindex="-1" aria-labelledby="allPaidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/all-workshop/detail_paid') ?>
    </div>
  </div>

  <!-- Modal for UPLOADED -->
  <div class="modal fade" id="allUploadedModal" tabindex="-1" aria-labelledby="allUploadedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/all-workshop/detail_uploaded') ?>
    </div>
  </div>

  <!-- Modal for UNPAID -->
  <div class="modal fade" id="allUnpaidModal" tabindex="-1" aria-labelledby="allUnpaidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/all-workshop/detail_unpaid') ?>
    </div>
  </div>

  <!-- Modal for UNDERPAID -->
  <div class="modal fade" id="allUnderpaidModal" tabindex="-1" aria-labelledby="allUnderpaidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/all-workshop/detail_underpaid') ?>
    </div>
  </div>

</div>