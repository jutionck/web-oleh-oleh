<div class="container">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="table-responsive">
        <table class="table border table-striped table-bordered text-nowrap align-middle tb-uppercase report-ws">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Venue</th>
              <th>Tipe Kamar</th>
              <th>Harga Kamar</th>
              <th>Kuota</th>
              <th>Terpakai</th>
              <th>Sisa</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($reservationOfDate as $row) :
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row->Tanggal ?></td>
                <td><?= $row->HotelName ?></td>
                <td><?= $row->RoomType ?></td>
                <td><?= number_format($row->RoomPrice, 0) ?></td>
                <td class="text-center"><?= $row->Kuota ?></td>
                <td class="text-center"><?= $row->Terpakai ?></td>
                <td class="text-center"><?= $row->Sisa ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="5" class="text-end">Jumlah</th>
              <th class="text-center"><?= $RsvTotal ?></th>
              <th class="text-center"><?= $RsvTerpakai ?></th>
              <th class="text-center"><?= $RsvSisa ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="d-flex d-flex justify-content-between mb-4">
        <h5 class="card-title fw-semibold">Rekap Reservasi Hotel</h5>
        <a href="<?= site_url('backoffice/export-venues') ?>" class="btn btn-success">Download</a>
      </div>
      <div class="table-responsive">
        <table class="table border table-striped table-bordered text-nowrap align-middle tb-uppercase report-ws">
          <thead>
            <tr>
              <th>NO</th>
              <th>NIK</th>
              <th>REGISTRAN</th>
              <th>HOTEL</th>
              <th>KAMAR</th>
              <th>CI & CO</th>
              <th>JLH HARI</th>
              <th>JLH KAMAR</th>
              <th>HRG.KAMAR</th>
              <th>TOTAL RP</th>
              <th>SPONSOR</th>
              <th>CP/HP</th>
              <th>TANGGAL</th>
              <th>STATUS</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($reservations as $row) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $row->wr_nik ?></td>
                <td><?= $row->wr_fullname ?></td>
                <td><?= $row->pev_name ?></td>
                <td><?= $row->pev_room_type ?></td>
                <td>
                  <?= indonesianDate(@$row->wvr_check_in, 'D/M/Y') ?> <br>
                  <?= indonesianDate(@$row->wvr_check_out, 'D/M/Y') ?>
                </td>
                <td><?= $row->wvr_total_night ?></td>
                <td><?= $row->wvr_number_of_room ?></td>
                <td><?= number_format($row->wvr_room_price, 0) ?></td>
                <td><?= number_format($row->wvr_total_hotel_fee, 0) ?></td>
                <td><?= $row->wt_sponsor ?></td>
                <td><?= $row->wt_cp ? $row->wt_cp . '/' . $row->wt_nohp : '' ?></td>
                <td><?= indonesianDate(@$row->wvr_created_at, 'D/M/Y') ?></td>
                <td>
                  <?=
                  $row->wt_status === 'pending' ?
                    'Belum Bayar' : ($row->wt_status === 'paid' ?
                      'Paid <br> Validated' : ($row->wt_status === 'underpaid' ? 'Kurang Bayar' : '<span class="badge rounded-pill text-bg-dark">ERROR</span>'))
                  ?>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>