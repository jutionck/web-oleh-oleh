<div class="container">
  <div class="card mt-5">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="table-responsive">
        <table class="table border table-striped table-bordered text-nowrap align-middle tb-uppercase report-ws">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Ketegori Peserta</th>
              <th>Jenis</th>
              <th>Waktu</th>
              <th>Kuota</th>
              <th>REG</th>
              <th>SISA</th>
              <th>REREG</th>
              <th>CERT</th>
              <th>VALIDATED</th>
              <th>UPLOADED</th>
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
                <td><?= $row->ws_name ?></td>
                <td><?= $row->pc_name ?></td>
                <td><?= $row->jenis ?></td>
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
                <td><?= $row->qty ?></td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#regModal" data-workshop-id="<?= $row->ws_id ?>" data-pc-id="<?= $row->vwowp_pc_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->wr_registrant_count ?></a>
                </td>
                <td class="text-center"><?= $row->qty - $row->wr_registrant_count ?></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#paidModal" data-workshop-id="<?= $row->ws_id ?>" data-pc-id="<?= $row->vwowp_pc_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->wr_paid_payment ?></a>
                </td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#uploadedModal" data-workshop-id="<?= $row->ws_id ?>" data-pc-id="<?= $row->vwowp_pc_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->wr_uploaded_payment ?></a>
                </td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#unpaidModal" data-workshop-id="<?= $row->ws_id ?>" data-pc-id="<?= $row->vwowp_pc_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->wr_pending_payment ?></a>
                </td>
                <td class="text-center">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#underpaidModal" data-workshop-id="<?= $row->ws_id ?>" data-pc-id="<?= $row->vwowp_pc_id ?>" data-workshop-name="<?= $row->ws_name ?>"><?= $row->wr_underpaid_payment ?></a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="6" class="text-end">Jumlah</th>
              <th class="text-center"><?= $totalReg ?></th>
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th class="text-center"></th>
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
  <div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="regModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/offline-workshop/detail_reg') ?>
    </div>
  </div>

  <!-- Modal for PAID/VALIDATE -->
  <div class="modal fade" id="paidModal" tabindex="-1" aria-labelledby="paidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/offline-workshop/detail_paid') ?>
    </div>
  </div>

  <!-- Modal for UPLOADED -->
  <div class="modal fade" id="uploadedModal" tabindex="-1" aria-labelledby="uploadedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/offline-workshop/detail_uploaded') ?>
    </div>
  </div>

  <!-- Modal for UNPAID -->
  <div class="modal fade" id="unpaidModal" tabindex="-1" aria-labelledby="unpaidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/offline-workshop/detail_unpaid') ?>
    </div>
  </div>

  <!-- Modal for UNDERPAID -->
  <div class="modal fade" id="underpaidModal" tabindex="-1" aria-labelledby="underpaidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-custom modal-dialog-centered modal-dialog-scrollable">
      <?php $this->load->view('backoffice/admin/report/offline-workshop/detail_underpaid') ?>
    </div>
  </div>

</div>