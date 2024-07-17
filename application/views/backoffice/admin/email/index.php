<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invoice</title>
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
          <h3>Hai, <span style="color: #730d73;"><?= $confirmation->registrant_fullname ?></span></h3>
          <p>
            Berikut kami sampaikan detail pemesanan pada kegiatan PIT HOGSI 16
          </p>
        </td>
        <td style="text-align: center;">
          <p style="margin-top: 5px; font-weight: bold;">
            <span class="badge rounded-pill text-bg-warning">UNPAID</span>
          </p>
        </td>
      </tr>
    </table>
    <br />
    <table width="100%" style="border-collapse: collapse">
      <tr>
        <td widdth="50%" style="background: #eee; padding: 20px">
          <strong>Tanggal:</strong> <?= date('d/m/Y') ?> <br />
          <strong>Tipe Pembayaran:</strong> Transfer
        </td>
        <td style="background: #eee; padding: 20px">
          <strong>Order ID:</strong> <?= $confirmation->registrant_key ?><br />
          <strong>E-mail:</strong> <?= $confirmation->registrant_email ?>
        </td>
      </tr>
    </table>
    <br />
    <h3>Deskripsi Pemesanan</h3>

    <table width="100%" style="border-collapse: collapse; border-bottom: 1px solid #eee">
      <tr>
        <td width="20%" class="column-header">No</td>
        <td width="40%" class="column-header">Deskripsi</td>
        <td width="20%" class="column-header">Waktu</td>
        <td width="20%" class="column-header">Harga</td>
      </tr>
      <?php $no = 1;
      foreach ($confirmations as $row) : ?>
        <tr>
          <td class="row"><?= $no++ ?></td>
          <td class="row"><?= $row->ws_name ?: $row->venue_name;
                          ?></td>
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
              <td><strong>Unique Payment:</strong></td>
              <td style="text-align: right"><?= $uniquePayment ?></td>
            </tr>
            <tr>
              <td><strong>Total:</strong></td>
              <td style="text-align: right"><?= number_format($totalPrice, 0) ?></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br>
    <h3>Informasi Bank</h3>
    <table width="100%" style="
					border-top: 1px solid #eee;
					border-bottom: 1px solid #eee;
					padding: 0 0 8px 0;
				">
      <tr>
        <td>
          Bank Transfer/ATM Ke:
          <br>
          <strong>Bank <?= $accountBank->name ?> Cabang <?= $accountBank->branch ?></strong>
          <br>
          <strong>No. <?= $accountBank->number ?></strong>
          <br>
          Atas Nama: <?= $accountBank->account_name ?>
        </td>
        <td></td>
      </tr>
    </table>
    <br />
    <hr />
    <p>
      <strong> Note</strong>: Konfirmasi bukti pembayaran ke email <span style="color: #730d73;">registrasi@pithogsi16.com</span> atau wa <span style="color: #730d73;"> 081282868612</span> atau upload bukti pembayaran di website resmi <a href="https://pithogsi16.com/registrasi.html" target="_blank">https://pithogsi16.com/registrasi.html</a> untuk mendapatkan validasi pembayaran.
    </p>
  </div>
</body>

</html>