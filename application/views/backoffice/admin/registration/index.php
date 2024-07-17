<div class="container">
  <div class="card">
    <ul class="nav nav-fill nav-tabs" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="fill-tab-0" data-bs-toggle="tab" href="#fill-tabpanel-0" role="tab" aria-controls="fill-tabpanel-0" aria-selected="true"> Data Pendaftar Registrasi </a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="fill-tab-1" data-bs-toggle="tab" href="#fill-tabpanel-1" role="tab" aria-controls="fill-tabpanel-1" aria-selected="false"> Laporan Pendaftar Lengkap </a>
      </li>
    </ul>
    <div class="card-body">
      <div class="tab-content" id="tab-content">
        <div class="tab-pane active" id="fill-tabpanel-0" role="tabpanel" aria-labelledby="fill-tab-0">
          <div class="d-flex d-flex justify-content-between mb-4">
            <h5 class="card-title fw-semibold"><?= $cardTitle ?></h5>
            <a href="<?= site_url('backoffice/registrants/add') ?>" class="btn btn-primary">Tambah</a>
          </div>
          <form action="" method="GET">
            <div class="row">
              <div class="col-md-4 mb-3">
                <select name="regency" id="namaKabupaten" class="form-select select2">
                  <option value="" disabled selected>Pilih Kabupaten</option>
                  <?php foreach ($regencies as $row) : ?>
                    <option value="<?= $row->id ?>"><?= $row->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <select name="paymentStatus" id="paymentStatus" class="form-select">
                  <option value="" disabled selected>Status Pembayaran</option>
                  <option value="pending">UNPAID</option>
                  <option value="uploaded">UPLOADED</option>
                  <option value="paid">PAID</option>
                  <option value="underpaid">UNDERPAID</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <a href="<?= site_url('backoffice/registrants') ?>" class="btn btn-warning">RESET</a>
              </div>
            </div>
          </form>
          <div class="table-responsive">
            <table id="example" class="table border table-striped table-bordered text-nowrap align-middle report-ws">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Aksi</th>
                  <th>Status</th>
                  <th>Nama</th>
                  <th>NIK</th>
                  <th>Status Peserta</th>
                  <th>Alamat & Email</th>
                  <th>Telp</th>
                  <th>Institusi</th>
                  <th>Regitrasi Key</th>
                  <th>Total Pembayaran</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($registrations as $row) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td>
                      <button class="btn btn-sm btn-warning send-email-btn" data-id="<?= $row->id ?>" data-status="<?= $row->wt_status ?>" title="Kirim Ulang Invoice"><i class="ti ti-mail"></i></button>
                      <a href="<?= createWhatsappLink(
                                  $row->registrant_fullname,
                                  $row->registrant_nohp,
                                  $row->wt_total,
                                  $bankAccount,
                                  $row->registrant_key,
                                  $row->payment_status,
                                ) ?>" class="btn btn-sm btn-success" title="Kirim Invoice Whatsapp" target="_blank"><i class="bi bi-whatsapp"></i></a>
                      <button class="btn btn-sm btn-primary detail-btn" data-bs-toggle="modal" data-bs-target="#detailModal" data-registrant-id="<?= $row->id ?>" data-created="<?= indonesianDate($row->created_at, 'D MMMM Y') ?>" title="Detail"><i class="bi bi-eye"></i></button>
                      <a href="<?= base_url('assets/upload/' . $row->document_upload) ?>" class="btn btn-sm btn-success" title="Bukti Pembayaran"><i class="bi bi-cloud-download"></i></a>
                      <a href="<?= base_url('assets/upload/' . $row->document_upload_remaining) ?>" class="btn btn-sm btn-dark" title="Bukti Sisa Pembayaran"><i class="bi bi-cloud-download"></i></a>
                      <a href="<?= site_url('backoffice/registrants/transaction/' . $row->id) ?>" class="btn btn-sm btn-dark" title="Transaksi"><i class="ti ti-receipt"></i></a>
                      <button class="btn btn-sm btn-danger delete-transaction" title="Hapus Transaksi" data-id="<?= $row->id ?>"><i class="ti ti-trash"></i></button>
                    </td>
                    <td>
                      <?=
                      $row->wt_status === 'pending' ?
                        '<span class="badge rounded-pill text-bg-danger">UNPAID</span>' : ($row->wt_status === 'uploaded' ?
                          '<span class="badge rounded-pill text-bg-info">UPLOADED</span>' : ($row->wt_status === 'paid' ?
                            '<span class="badge rounded-pill text-bg-success">PAID</span>' : ($row->wt_status === 'underpaid' ? '<span class="badge rounded-pill text-bg-warning">UNDERPAID</span>' : '<span class="badge rounded-pill text-bg-dark">ERROR</span>')))
                      ?>
                    </td>
                    <td>
                      <?= $row->registrant_fullname ?>
                    </td>
                    <td><?= $row->registrant_nik ?></td>
                    <td><?= $row->pc_name ?></td>
                    <td>
                      <?= $row->r_name ?> <br />
                      <?= $row->registrant_email ?>
                    </td>
                    <td><?= $row->registrant_nohp ?></td>
                    <td><?= $row->registrant_institute ?></td>
                    <td><?= $row->registrant_key ?></td>
                    <td style="text-align: right;"> <span style="margin-right: 38px;">Rp.</span> <?= number_format($row->wt_total, 0) ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="table-responsive">
                      <table class="table border table-striped table-bordered text-nowrap align-middle">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                          </tr>
                        </thead>
                        <tbody> </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="fill-tabpanel-1" role="tabpanel" aria-labelledby="fill-tab-1">
          <div class="d-flex d-flex justify-content-between mb-4">
            <h5 class="card-title fw-semibold">Laporan Data Pendaftar Lengkap</h5>
          </div>
          <div class="table-responsive">
            <table id="registrant-report" class="table border table-striped table-bordered text-nowrap align-middle report-ws">
              <thead>
                <tr>
                  <th>No</th>
                  <th>REF</th>
                  <th>ORDER ID</th>
                  <th>NIK</th>
                  <th>NAMA</th>
                  <th>NAMASERT</th>
                  <th>KATEGORI</th>
                  <th>TITLE</th>
                  <th>TGL DAFTAR</th>
                  <th>KOTA</th>
                  <th>PROVINSI</th>
                  <th>INSTITUSI</th>
                  <th>HP REGISTRAN</th>
                  <th>EMAIL REGISTRAN</th>
                  <th>JENIS</th>
                  <th>HARGA</th>
                  <th>JLH TRANSFER</th>
                  <th>STAT BAYAR</th>
                  <th>TGL TRANSFER</th>
                  <th>BANK</th>
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
                <?php
                $no = 1;
                foreach ($registrationFull as $row) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row->wt_ref) ?></td>
                    <td><?= htmlspecialchars($row->wr_registrant_key) ?></td>
                    <td><?= htmlspecialchars($row->wr_nik) ?></td>
                    <td><?= htmlspecialchars($row->wr_fullname) ?></td>
                    <td><?= htmlspecialchars($row->wr_fullname_title) ?></td>
                    <td><?= htmlspecialchars($row->pc_name) ?></td>
                    <td><?= htmlspecialchars($row->w_name) ?></td>
                    <td><?= indonesianDate($row->wr_registrant_date, 'D MMMM Y') ?></td>
                    <td><?= htmlspecialchars($row->regency) ?></td>
                    <td><?= htmlspecialchars($row->province) ?></td>
                    <td><?= htmlspecialchars($row->wr_institute) ?></td>
                    <td><?= htmlspecialchars($row->wr_nohp) ?></td>
                    <td><?= htmlspecialchars($row->wr_email) ?></td>
                    <td><?= htmlspecialchars($row->ws_jenis) ?></td>
                    <td style="text-align: right;"> <span style="margin-right: 38px;">Rp.</span> <?= number_format($row->wpcp_price, 0) ?></td>
                    <td style="text-align: right;"> <span style="margin-right: 38px;">Rp.</span> <?= number_format($row->wt_transfer_amount, 0) ?></td>
                    <td>
                      <?php
                      switch ($row->wt_status) {
                        case 'pending':
                          echo "Belum Bayar";
                          break;
                        case 'paid':
                          echo "Paid <br> Validated";
                          break;
                        case 'underpaid':
                          echo "Kurang Bayar";
                          break;
                        case 'uploaded':
                          echo "Upload bukti bayar";
                          break;
                        default:
                          echo '<span class="badge rounded-pill text-bg-dark">-</span>';
                          break;
                      }
                      ?>
                    </td>
                    <td><?= indonesianDate($row->wt_transfer_date, 'D MMMM Y') ?></td>
                    <td><?= htmlspecialchars($row->pm_name) ?></td>
                    <td><?= htmlspecialchars($row->wt_sponsor) ?></td>
                    <td><?= htmlspecialchars($row->wt_sponsor_contact) ?></td>
                    <td><?= htmlspecialchars($row->wt_nohp) ?></td>
                    <td><?= htmlspecialchars($row->wt_email) ?></td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="table-responsive">
                      <table class="table border table-striped table-bordered text-nowrap align-middle">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                          </tr>
                        </thead>
                        <tbody> </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>