<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition:attachment; filename=" . $title . ".xls");
header("Pragma: no-cache");
header("Expires:0");

?>
<div style="text-align: center;">
  <h3>
    VALIDASI PEMBAYARAN <br>
    <?= $registrant->w_name ?>
  </h3>
  <p><?= indonesianDate(@$row->interview_date, 'dddd, D MMMM Y') ?></p>
</div>
<table border="1">
  <thead>
    <tr>
      <th>NO</th>
      <th>NIK</th>
      <th>NAMA</th>
      <th>NAMASERT</th>
      <th>KATEGORI</th>
      <th>TGL DAFTAR</th>
      <th>KOTA</th>
      <th>PROVINSI</th>
      <th>INSTITUSI</th>
      <th>HP REGISTRAN</th>
      <th>EMAIL REGISTRAN</th>
      <th>JENIS</th>
      <th>HARGA</th>
      <th>REF</th>
      <th>TGL TRANSFER</th>
      <th>BANK</th>
      <th>JUMLAH TRANSFER</th>
      <th>DISKON</th>
      <th>STATUS</th>
      <th>TGL VALIDASI</th>
      <th>NM SPONSOR</th>
      <th>CP</th>
      <th>HP</th>
      <th>EMAIL</th>
      <th>REREG DATE</th>
      <th>REREG BY</th>
      <th>REREG OPR</th>
      <th>CERT DATE</th>
      <th>CERT BY</th>
      <th>CERT OPR</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    foreach ($registrants as $row) : ?>
      <tr>

        <td><?= $no++ ?></td>
        <td><?= $row->wr_nik ? "'" . $row->wr_nik : ''; ?></td>
        <td><?= $row->wr_fullname ?></td>
        <td><?= $row->wr_fullname_title ?></td>
        <td><?= $row->pc_name ?></td>
        <td><?= indonesianDate(@$row->wr_registrant_date, 'dddd, D MMMM Y') ?></td>
        <td><?= $row->regency ?></td>
        <td><?= $row->province ?></td>
        <td><?= $row->wr_institute ?></td>
        <td><?= $row->wr_nohp ?></td>
        <td><?= $row->wr_email ?></td>
        <td><?= $row->ws_jenis ?></td>
        <td><?= $row->wpcp_price ?></td>
        <td><?= $row->wt_ref ?></td>
        <td><?= indonesianDate(@$row->wt_transfer_date, 'dddd, D MMMM Y') ?></td>
        <td><?= $row->pm_name ?></td>
        <td><?= $row->wt_transfer_amount ?></td>
        <td><?= $row->wt_discount ?></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    <?php endforeach ?>
  </tbody>
</table>