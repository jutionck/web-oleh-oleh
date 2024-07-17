<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=" . $title . ".xls");
header("Pragma: no-cache");
header("Expires:0");

?>
<div style="text-align: center;">
  <h3>
    DAFTAR PESERTA BELUM BAYAR <br>
    <?= $registrant->w_name ?>
  </h3>
  <p><?= indonesianDate(@$row->interview_date, 'dddd, D MMMM Y') ?></p>
</div>
<table border="1">
  <thead>
    <tr>
      <th>No</th>
      <th>NIK</th>
      <th>REGISTRAN</th>
      <th>KATEGORI</th>
      <th>TITLE</th>
      <th>JENIS</th>
      <th>TGL DAFTAR</th>
      <th>HARGA</th>
      <th>STAT BAYAR</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    foreach ($registrants as $row) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row->wr_nik ? "'" . $row->wr_nik : ''; ?></td>
        <td><?= $row->wr_fullname ?></td>
        <td><?= $row->pc_name ?></td>
        <td><?= $row->w_name ?></td>
        <td><?= $row->ws_jenis ?></td>
        <td><?= indonesianDate(@$row->wr_registrant_date, 'dddd, D MMMM Y') ?></td>
        <td><?= $row->wpcp_price ?></td>
        <td>Belum Bayar</td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>