<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=" . $title . ".xls");
header("Pragma: no-cache");
header("Expires:0");

?>
<div style="text-align: center;">
  <h3>
    DAFTAR RESERVASI HOTEL <br>
    PITHOGSI 16 2024
  </h3>
  <p><?= indonesianDate(@$row->interview_date, 'dddd, D MMMM Y') ?></p>
</div>
<table border="1">
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
        <td><?= "'" . $row->wr_nik ?></td>
        <td><?= $row->wr_fullname ?></td>
        <td><?= $row->pev_name ?></td>
        <td><?= $row->pev_room_type ?></td>
        <td>
          <?= indonesianDate(@$row->wvr_check_in, 'D/M/Y') ?> <br>
          <?= indonesianDate(@$row->wvr_check_out, 'D/M/Y') ?>
        </td>
        <td><?= $row->wvr_total_night ?></td>
        <td><?= $row->wvr_number_of_room ?></td>
        <td><?= $row->wvr_room_price ?></td>
        <td><?= $row->wvr_total_hotel_fee ?></td>
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