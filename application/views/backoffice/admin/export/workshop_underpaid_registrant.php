<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=" . $title . ".xls");
header("Pragma: no-cache");
header("Expires:0");

?>
<div style="text-align: center;">
  <h3>
    KURANG BAYAR <br>
    <?= $registrant->w_name ?>
  </h3>
  <p><?= indonesianDate(@$row->interview_date, 'dddd, D MMMM Y') ?></p>
</div>
<table border="1">
  <thead>
    <tr>
      <th>No</th>
      <th>PEMBAYARAN</th>
      <th>NIK</th>
      <th>REGISTRAN</th>
      <th>KATEGORI</th>
      <th>REF</th>
      <th>TGL TRANSFER</th>
      <th>BANK</th>
      <th>BIAYA</th>
      <th>JUMLAH TRANSFER</th>
      <th>DISKON</th>
      <th>KURANG BAYAR</th>
      <th>STATUS</th>
      <th>TGL VALIDASI</th>
      <th>NM SPONSOR</th>
      <th>CP</th>
      <th>HP</th>
      <th>EMAIL</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    foreach ($registrants as $row) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row->w_name ?></td>
        <td><?= $row->wr_nik ? "'" . $row->wr_nik : ''; ?></td>
        <td><?= $row->wr_fullname ?></td>
        <td><?= $row->pc_name ?></td>
        <td><?= $row->wt_ref ?></td>
        <td><?= indonesianDate(@$row->wt_transfer_date, 'dddd, D MMMM Y') ?></td>
        <td><?= $row->pm_name ?></td>
        <td><?= $row->wpcp_price ?></td>
        <td><?= $row->wt_transfer_amount ?></td>
        <td><?= $row->wt_discount ?></td>
        <td><?= $row->wt_transfer_amount - $row->wt_discount ?></td>
        <td>
          <?=
          $row->wt_status === 'pending' ?
            'Belum Bayar' : ($row->wt_status === 'paid' ?
              'Paid <br> Validated' : ($row->wt_status === 'underpaid' ? 'Kurang Bayar' : '<span class="badge rounded-pill text-bg-dark">ERROR</span>'))
          ?>
        </td>
        <td><?= indonesianDate(@$row->wt_updated_at, 'dddd, D MMMM Y') ?></td>
        <td><?= $row->wt_sponsor ?></td>
        <td><?= $row->wt_sponsor_contact ?></td>
        <td><?= $row->wt_nohp ?></td>
        <td><?= $row->wt_email ?></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>