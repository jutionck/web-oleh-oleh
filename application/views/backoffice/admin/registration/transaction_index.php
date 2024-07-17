<div class="container-fluid">
  <?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      <?= $this->session->flashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php elseif ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-octagon me-1"></i>
      <?= $this->session->flashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <div class="card">
    <div class="card-body">
      <div class="invoiceing-box">
        <div class="invoice-header d-flex align-items-center border-bottom p-3">
          <h4 class="font-medium text-uppercase mb-0">Order ID <span class="text-primary"><?= $registration->registrant_key ?></span></h4>
          <div class="ms-auto">
            <h4 class="invoice-number text-center">
              <img src="<?= base_url('assets/qrcode/' . $qrCode) ?>" alt="Barcode" style="max-width: 100px; height: auto;" />
              <br />
              <?=
              $transaction->status === 'pending' ?
                '<span class="badge rounded-pill text-bg-danger">UNPAID</span>' : (
                  $transaction->status === 'paid' ?
                  '<span class="badge rounded-pill text-bg-success">PAID</span>' : (
                    $transaction->status === 'uploaded' ?
                    '<span class="badge rounded-pill text-bg-info">UPLOADED</span>' : (
                      $transaction->status === 'underpaid' ?
                      '<span class="badge rounded-pill text-bg-warning">UNDERPAID</span>' :
                      '<span class="badge rounded-pill text-bg-primary">OVERPAID</span>'
                    )
                  )
                )
              ?>
            </h4>
          </div>
        </div>
        <div class="p-3" id="custom-invoice">
          <div class="invoice-123" id="printableArea">
            <div class="row pt-3">
              <div class="col-md-12">
                <div class="chat-list chat active-chat">
                  <div class="row">
                    <div class="col-4 mb-7">
                      <p class="mb-1 fs-2">Nama</p>
                      <h6 class="fw-semibold mb-0"><?= $registration->registrant_fullname ?></h6>
                      <p class="mb-0"><?= $registration->pc_name ?></p>
                    </div>
                    <div class="col-4 mb-7">
                      <p class="mb-1 fs-2">Nama Sertifikat</p>
                      <h6 class="fw-semibold mb-0"><?= $registration->registrant_fullname_with_title ?></h6>
                    </div>
                    <div class="col-4 mb-9">
                      <p class="mb-1 fs-2">Institusi</p>
                      <h6 class="fw-semibold mb-0"><?= $registration->registrant_institute ?></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4 mb-7">
                      <p class="mb-1 fs-2">No Handphone</p>
                      <h6 class="fw-semibold mb-0"><?= $registration->registrant_nohp ?></h6>
                    </div>
                    <div class="col-4 mb-7">
                      <p class="mb-1 fs-2">Email</p>
                      <h6 class="fw-semibold mb-0"><?= $registration->registrant_email ?></h6>
                    </div>
                    <div class="col-4 mb-9">
                      <p class="mb-1 fs-2">Alamat</p>
                      <h6 class="fw-semibold mb-0"><?= $registration->r_name ?></h6>
                    </div>
                  </div>
                  <div class="mb-4">
                    <p class="mb-2 fs-2">Catatan</p>
                    <p class="mb-3 text-dark">
                      Peserta <span class="text-primary"><?= ucwords($registration->registrant_status) ?></span>
                    </p>
                  </div>
                  <?php if ($registration->registrant_status === 'didaftarkan') : ?>
                    <div class="row border-bottom">
                      <div class="col-4 mb-7">
                        <p class="mb-1 fs-2">Sponsor</p>
                        <h6 class="fw-semibold mb-0"><?= $registration->company_didaftarkan ?></h6>
                      </div>
                      <div class="col-4 mb-7">
                        <p class="mb-1 fs-2">Contact Person / No Handphone</p>
                        <h6 class="fw-semibold mb-0"><?= $registration->fullname_didaftarkan ?> / <?= $registration->nohp_didaftarkan ?></h6>
                      </div>
                      <div class="col-4 mb-9">
                        <p class="mb-1 fs-2">Email</p>
                        <h6 class="fw-semibold mb-0"><?= $registration->email_didaftarkan ?></h6>
                      </div>
                    </div>
                  <?php else : ?>
                    <div class="border-bottom"></div>
                  <?php endif ?>
                </div>
              </div>
              <div class="col-md-12">
                <div class="table-responsive mt-5" style="clear: both">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;
                      foreach ($details as $row) : ?>
                        <tr>
                          <td class="text-center"><?= $no++ ?></td>
                          <td><?= $row->ws_name ?: $row->venue_name  ?></td>
                          <td class="text-end"><?= number_format($row->wrd_price, 0) ?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="2" class="fs-4 fw-bold text-end">Sub Total</td>
                        <td class="fs-4 fw-bold text-end"><?= number_format($subTotal, 0) ?></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="fs-4 fw-bold text-end">Diskon</td>
                        <td class="fs-4 fw-bold text-end"><?= number_format($transaction->discount, 0) ?></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="fs-4 fw-bold text-end">Unique Payment</td>
                        <td class="fs-4 fw-bold text-end"><?= $registration->registration_unique_payment ?></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="fs-6 fw-bolder text-end">Total</td>
                        <td class="fs-6 fw-bolder text-end"><?= $transaction->discount > 0 ? number_format(($transaction->total - $transaction->discount), 0) : number_format($transaction->total, 0) ?></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="fs-4 fw-bold text-end">Dibayarkan</td>
                        <td class="fs-4 fw-bold text-end"><?= $transaction->transfer_amount ? number_format($transaction->transfer_amount + $transaction->transfer_amount_remaining, 0) : 0 ?></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="fs-4 fw-bold text-end">Sisa</td>
                        <td class="fs-4 fw-bold text-end">
                          <?php
                          $sisa = $transaction->total - $transaction->discount -  $transaction->transfer_amount - $transaction->transfer_amount_remaining;
                          if ($sisa < 0) {
                            echo '<span class="text-success">Lebih Bayar: ' . number_format(abs($sisa), 0) . '</span>';
                          } else {
                            echo number_format($sisa, 0);
                          }
                          ?>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <?php if ($transaction->transfer_date) : ?>
                <div class="col-md-12">
                  <div class="clearfix"></div>
                  <figure>
                    <figcaption class="blockquote-footer mt-2">
                      <cite title="Source Title">Pembayaran menggunakan <mark><?= $transaction->pm_name ?></mark> pada tanggal <mark><?= indonesianDate($transaction->transfer_date, 'D MMMM Y') ?></mark></cite>
                    </figcaption>
                  </figure>
                </div>
              <?php endif ?>
              <div class="col-md-12">
                <div class="clearfix"></div>
                <div class="text-end">
                  <a href="<?= site_url('backoffice/registrants') ?>" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Batal</a>
                  <a href="<?= site_url('backoffice/registrants/edit/' . $registration->id) ?>" class="btn btn-warning ms-6" title="Ubah Data"><i class="ti ti-edit"></i> Edit Registrasi</a>
                  <?php if ($transaction->status !== 'pending') : ?>
                    <a href="<?= site_url('backoffice/export/invoicePayment/' . $registration->id) ?>" target="_blank" class="btn btn-success ms-6"><i class="ti ti-cloud-download"></i> Download</a>
                  <?php endif ?>
                  <?php if ($transaction->status === 'paid' || $transaction->status === 'underpaid') : ?>
                    <a href="<?= site_url('backoffice/registrants/edit-payment/' . $registration->id) ?>" class="btn btn-secondary ms-6" title="Ubah Data Pembayaran"><i class="ti ti-edit"></i> Edit Pembayaran</a>
                  <?php endif ?>

                  <?php
                  $buttonClass = "btn btn-primary btn-default print-page ms-6";
                  $buttonDisabled = "";
                  $buttonOnClick = "";
                  $buttonText = "<span><i class='ti ti-check fs-5'></i> Validasi Pembayaran</span>";

                  if ($registration->payment_status  === 'pending' || $registration->payment_status === 'uploaded') {
                    $buttonOnClick = "data-bs-toggle='modal' data-bs-target='#paymentModal'";
                  } elseif ($transaction->status === 'underpaid') {
                    $buttonClass = "btn btn-danger btn-default print-page ms-6";
                    $buttonOnClick = "data-bs-toggle='modal' data-bs-target='#paymentRemainingModal'";
                    $buttonText = "<span><i class='ti ti-check fs-5'></i> Validasi Kurang Bayar</span>";
                  } else if ($registration->payment_status  === 'paid') {
                    $buttonClass = "btn btn-danger btn-default print-page ms-6";
                    $buttonDisabled = "disabled";
                    $buttonText = "<span><i class='ti ti-check fs-5'></i> Sudah Validasi</span>";
                  }
                  ?>
                  <button class="<?= $buttonClass ?>" type="button" <?= $buttonOnClick ?> <?= $buttonDisabled ?>>
                    <?= $buttonText ?>
                  </button>
                </div>
              </div>
              <!-- Validasi Paid -->
              <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="paymentModalLabel">Validasi Pembayaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="<?= site_url('backoffice/registrants/transaction/' . $transaction->wsr_id . '/validation') ?>" method="POST">
                        <input type="hidden" value="<?= $registration->id ?>" name="registrant_id">
                        <input type="hidden" value="<?= $transaction->id ?>" name="transaction_id">
                        <input type="hidden" value="<?= $transaction->total ?>" name="transaction_total">
                        <div class="mb-3">
                          <label for="paymentMethod" class="form-label">Cara Pembayaran</label>
                          <select id="paymentMethod" class="form-select" name="pm_id" required>
                            <option value="" disabled selected>Pilih Pembayaran</option>
                            <?php foreach ($payments as $row) : ?>
                              <option value="<?= $row->id ?>"><?= $row->name ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="transferDate" class="form-label">Tanggal Transfer</label>
                          <input type="date" class="form-control" id="transferDate" name="transfer_date">
                        </div>
                        <div class="mb-3">
                          <label for="discount" class="form-label">Potongan</label>
                          <input type="text" class="form-control" id="discount" name="discount" onkeyup="formatRupiah(this)">
                        </div>
                        <div class="mb-3">
                          <label for="amountTransferred" class="form-label">Jumlah Transfer</label>
                          <input type="text" class="form-control" id="amountTransferred" name="transfer_amount" onkeyup="formatRupiah(this)">
                        </div>
                        <div class="mb-3">
                          <label for="reference" class="form-label">Ref</label>
                          <input type="text" class="form-control" id="reference" name="ref">
                          <input type="hidden" class="form-control" id="free" name="free" value="">
                        </div>
                        <div class="mb-3">
                          <label for="sponsor" class="form-label">Sponsor</label>
                          <input type="text" class="form-control" id="sponsor" name="sponsor" value="<?= set_value('company_didaftarkan') ? set_value('company_didaftarkan') : $registration->company_didaftarkan; ?>">
                        </div>
                        <div class="mb-3">
                          <label for="sponsor_contact" class="form-label">Contact</label>
                          <input type="text" class="form-control" id="sponsor_contact" name="sponsor_contact" value="<?= set_value('fullname_didaftarkan') ? set_value('fullname_didaftarkan') : $registration->fullname_didaftarkan; ?>">
                        </div>
                        <div class="mb-3">
                          <label for="no_hp" class="form-label">No Handphone</label>
                          <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= set_value('nohp_didaftarkan') ? set_value('nohp_didaftarkan') : $registration->nohp_didaftarkan; ?>">
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email</label>
                          <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email_didaftarkan') ? set_value('email_didaftarkan') : $registration->email_didaftarkan; ?>">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">OK</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Validasi Underpaid -->
              <div class="modal fade" id="paymentRemainingModal" tabindex="-1" aria-labelledby="paymentRemainingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="paymentRemainingModalLabel">Validasi Pembayaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="<?= site_url('backoffice/registrants/transaction-remaining/' . $transaction->wsr_id . '/validation') ?>" method="POST">
                        <input type="hidden" value="<?= $registration->id ?>" name="registrant_id">
                        <input type="hidden" value="<?= $transaction->id ?>" name="transaction_id">
                        <input type="hidden" value="<?= $transaction->total ?>" name="transaction_total">
                        <input type="hidden" value="<?= $transaction->transfer_amount ?>" name="transfer_amount">
                        <input type="hidden" value="<?= $transaction->discount ?>" name="discount">
                        <div class="mb-3">
                          <label for="paymentMethod" class="form-label">Cara Pembayaran</label>
                          <select id="paymentMethod" class="form-select" name="pm_id" required>
                            <option value="" disabled selected>Pilih Pembayaran</option>
                            <?php foreach ($payments as $row) : ?>
                              <option value="<?= $row->id ?>"><?= $row->name ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="transferDateRemaining" class="form-label">Tanggal Transfer</label>
                          <input type="date" class="form-control" id="transferDateRemaining" name="transfer_date_remaining" required>
                        </div>
                        <div class="mb-3">
                          <label for="amountTransferredRemain" class="form-label">Jumlah Transfer</label>
                          <input type="text" class="form-control" id="amountTransferredRemain" name="transfer_amount_remaining" onkeyup="formatRupiah(this)">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary">OK</button>
                        </div>
                      </form>
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
</div>