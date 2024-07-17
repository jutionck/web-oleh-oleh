<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bukti Konfirmasi Validasi Pembayaran PIT HOGSI 16</title>
  <style>
    body {
      font-family: Helvetica, sans-serif;
      font-size: 13px;
    }

    .container {
      max-width: 680px;
      margin: 0 auto;
    }

    .logotype {
      background: #000;
      color: #fff;
      width: 75px;
      height: 75px;
      line-height: 75px;
      text-align: center;
      font-size: 11px;
    }

    .column-title {
      background: #eee;
      text-transform: uppercase;
      padding: 15px 5px 15px 15px;
      font-size: 11px;
    }

    .column-detail {
      border-top: 1px solid #eee;
      border-bottom: 1px solid #eee;
    }

    .column-header {
      background: #eee;
      text-transform: uppercase;
      padding: 15px;
      font-size: 11px;
      border-right: 1px solid #eee;
    }

    .row {
      padding: 7px 14px;
      border-left: 1px solid #eee;
      border-right: 1px solid #eee;
      border-bottom: 1px solid #eee;
    }

    .alert {
      background: #ffd9e8;
      padding: 20px;
      margin: 20px 0;
      line-height: 22px;
      color: #333;
    }

    .socialmedia {
      background: #eee;
      padding: 20px;
      display: inline-block;
    }

    img.responsive {
      width: 100%;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <div class="container">
    <img src="https://raw.githubusercontent.com/jutionck/image_projects/main/pit_hogsi16.jpg" alt="Kop Surat" class="responsive">
    <br /><br />
    <table width="100%" style="border-collapse: collapse;">
      <tr>
        <td>
          <h3>Hai, <span style="color: #730d73;"><?= $registration->registrant_fullname ?></span></h3>
          <p>Berikut Bukti Konfirmasi Validasi Pembayaran PIT HOGSI 16 </p>
        </td>
        <td style="text-align: center;">
          <?php if ($transaction->status === 'paid') : ?>
            <img src="./assets/qrcode/<?= $registration->registrant_key ?>.png" alt="Barcode" style="max-width: 100px; height: auto;" />
          <?php endif ?>
          <p style="margin-top: 5px; font-weight: bold;">
            <?=
            $transaction->status === 'paid' ?
              '<span class="badge rounded-pill text-bg-success">PAID</span>' :
              '<span class="badge rounded-pill text-bg-DANGER">UNDERPAID</span>'
            ?>
          </p>
        </td>
      </tr>
    </table>
    <br />
    <table width="100%" style="border-collapse: collapse">
      <tr>
        <td widdth="50%" style="background: #eee; padding: 20px">
          <strong>Tanggal:</strong> <?= date('d/m/Y') ?> <br />
          <strong>Tipe Pembayaran:</strong> <?= $transaction->pm_name ?>
        </td>
        <td style="background: #eee; padding: 20px">
          <strong>Order ID:</strong> <?= $registration->registrant_key ?><br />
          <strong>E-mail:</strong> <?= $registration->registrant_email ?>
        </td>
      </tr>
    </table>
    <br />
    <h3>Deskripsi Pemesanan</h3>

    <table width="100%" style="border-collapse: collapse; border-bottom: 1px solid #eee">
      <tr>
        <td width="20%" class="column-header">No</td>
        <td width="40%" class="column-header">Deskripsi</td>
        <td width="20%" class="column-header">Tanggal</td>
        <td width="20%" class="column-header">Harga</td>
      </tr>
      <?php $no = 1;
      foreach ($details as $row) : ?>
        <tr>
          <td class="row"><?= $no++ ?></td>
          <td class="row"><?= $row->ws_name ?: $row->venue_name  ?></td>
          <td class="row">
            <?php
            if ($row->ws_name !== null) {
              echo 'Tanggal Pelaksanaan: <br>' . indonesianDate($row->ws_start_date, 'D MMMM Y');
              if (!empty($row->ws_end_date)) {
                echo ' s.d ' . indonesianDate($row->ws_end_date, 'D MMMM Y');
              }
            }

            if ($row->venue_name !== null) {
              echo 'Check-in & Check-out: <br>' . indonesianDate($row->wvr_check_in, 'D MMMM Y');
              if (!empty($row->wvr_check_out)) {
                echo ' s.d ' . indonesianDate($row->wvr_check_out, 'D MMMM Y');
              }
            }
            ?>
          </td>
          <td style="text-align: right" class="row"><?= number_format($row->wrd_price, 0) ?></td>
        </tr>
      <?php endforeach ?>
    </table>
    <br />
    <table width="100%" style="background: #eee; padding: 20px">
      <tr>
        <td>
          <table width="100%" style="text-align: right">
            <tr>
              <td><strong>Sub Total:</strong></td>
              <td style="text-align: right"><?= number_format($subTotal, 0) ?></td>
            </tr>
            <tr>
              <td><strong>Diskon:</strong></td>
              <td style="text-align: right"><?= number_format($transaction->discount, 0) ?></td>
            </tr>
            <tr>
              <td><strong>Unique Payment:</strong></td>
              <td style="text-align: right"><?= $registration->registration_unique_payment ?></td>
            </tr>
            <?php if ($transaction->status === 'underpaid') : ?>
              <tr>
                <td><strong>Total:</strong></td>
                <td style="text-align: right"><?= $transaction->discount > 0 ? number_format(($transaction->total - $transaction->discount), 0) : number_format($transaction->total, 0) ?></td>
              </tr>
              <tr>
                <td><strong>Jumlah Dibayarkan:</strong></td>
                <td style="text-align: right; color:green"><?= number_format($transaction->transfer_amount, 0) ?></td>
              </tr>
              <tr>
                <td><strong>Kurang Bayar:</strong></td>
                <td style="text-align: right; color:red"><?= (number_format(($subTotal - $transaction->discount - $transaction->transfer_amount) + $registration->registration_unique_payment, 0)) ?></td>
              </tr>
            <?php else : ?>
              <tr>
                <td><strong>Total:</strong></td>
                <td style="text-align: right"><?= $transaction->discount > 0 ? number_format(($transaction->total - $transaction->discount), 0) : number_format($transaction->total, 0) ?></td>
              </tr>
            <?php endif ?>
          </table>

        </td>
      </tr>
    </table>
    <hr />
    <p>
      <?php
      $paidPayment = 'Simpan bukti ini untuk konfirmasi kehadiran saat acara (offline).';
      $underPaidPayment = 'Mohon melakukan sisa pembayaran agar terdaftar sebagai peserta PIT HOGSI 16. Upload bukti pembayaran di website resmi <a href="https://pithogsi16.com/registrasi.html" target="_blank">https://pithogsi16.com/registrasi.html</a>';
      ?>
      <strong> Note</strong>: <?= $transaction->status === 'paid' ?  $paidPayment : $underPaidPayment ?>
    </p>
  </div>
</body>

</html>