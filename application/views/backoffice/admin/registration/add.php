<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form class="needs-validation" action="<?= site_url('backoffice/registrants/proccess') ?>" method="POST">
            <div class="row">
              <div class="col-md-12 form-group">
                <span class="registration-title text-muted">Yang Mendaftarkan</span>
                <div class="form-check form-switch mt-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                  <input type="hidden" name="registrant_status" id="registration_type" value="sendiri">
                  <label class="form-check-label" for="flexSwitchCheckChecked"> <span id="sendiri-text">Daftar Sendiri</span> / <span id="didaftarkan-text">Didaftarkan</span></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <input type="text" name="fullname_didaftarkan" class="form-control" id="fullname_didaftarkan" placeholder="Nama Lengkap">
              </div>
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <input type="email" class="form-control" name="email_didaftarkan" id="email_didaftarkan" placeholder="Email">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <input type="text" class="form-control" name="nohp_didaftarkan" id="nohp_didaftarkan" placeholder="No Handphone">
              </div>
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <select id="namaPerusahaanSelect" class="form-select select2" aria-label="Nama Perusahaan" name="company_didaftarkan">
                  <option value="" disabled selected>Pilih Perusahaan</option>
                  <?php foreach ($companies as $row) : ?>
                    <option value="<?= $row->name ?>"><?= $row->name ?></option>
                  <?php endforeach ?>
                </select>
                <label class="form-check-label form-text" for="namaPerusahaanSelect">
                  <i>Jika nama perusahaan tidak ada, bisa langsung ketik saja</i>
                </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <span class="registration-title text-muted">Kategori Peserta <span class="text-danger">*</span></span>
              </div>
              <div class="col-md-12 form-group mt-3">
                <select name="registrant_category" id="namaKategoriPeserta" class="form-select select2">
                  <option disabled selected>Kategori Peserta</option>
                  <?php foreach ($participantCategories as $row) : ?>
                    <option value="<?= $row->id ?>"><?= $row->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-12 mt-3">
                <span class="registration-title text-muted">Data Pribadi Peserta <span class="text-danger">*</span></span>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" name="registrant_fullname" class="form-control <?= form_error('registrant_fullname') ? 'is-invalid' : ''; ?>" id="fullname" placeholder="Nama" required>
                <div class="invalid-feedback">
                  <?= form_error('registrant_fullname'); ?>
                </div>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" class="form-control <?= form_error('registrant_fullname_with_title') ? 'is-invalid' : ''; ?>" name="registrant_fullname_with_title" id="fullname-with-title" placeholder="Nama Lengkap dan Gelar">
                <div class="invalid-feedback">
                  <?= form_error('registrant_fullname_with_title'); ?>
                </div>
                <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" id="sameAsName">
                  <label class="form-check-label form-text" for="sameAsName">
                    Sama dengan Nama <span class="badge text-bg-secondary fst-italic"> (di cetak untuk sertifikat)</span>
                  </label>
                </div>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" name="registrant_nik" class="form-control" id="registrant_nik" placeholder="NIK" required>
                <div id="nikError" class="errorNik"></div>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="email" name="registrant_email" class="form-control" id="registrant_email" placeholder="Email" required>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" name="registrant_institute" class="form-control" id="institute" placeholder="Institusi" required>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" class="form-control" name="registrant_nohp" id="registrant_hp" placeholder="No Handphone e.g 0821...." required>
              </div>
              <div class="col-md-6 form-group mt-3">
                <select id="namaProvinsi" class="form-select select2" aria-label="Provinsi" name="registrant_province_id" required>
                  <option value="" disabled selected>Pilih Provinsi</option>
                  <?php foreach ($provinces as $province) : ?>
                    <option value="<?= $province->code ?>"><?= $province->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-6 form-group mt-3">
                <select id="namaKabupaten" class="form-select select2" aria-label="Kabupaten" name="registrant_regency_id" required>
                  <option value="" disabled selected>Pilih Kabupaten</option>
                </select>
              </div>
              <div class="col-md-12 form-group mt-3">
                <input type="hidden" class="form-control-plaintext" name="registrant_key" id="registrant_generate_key" readonly>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <span class="registration-title text-muted">Pilih Kegiatan</span>
              </div>
              <div class="col-md-12 mt-3">
                <div class="table-responsive">
                  <table id="workshopTable" class="table">
                    <thead class="table-light">
                      <tr>
                        <th>Kegiatan</th>
                        <th>Harga</th>
                        <th>Pilih</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="table-scroll">
                  <table id="workshopTableBodyTable" class="table">
                    <tbody id="workshopTableBody">
                      <tr>
                        <td colspan="3">Pilih kategori peserta untuk melihat daftar workshop.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <span class="registration-title text-muted">Reservasi Hotel</span>
              </div>
              <div class="col-md-4 mt-3">
                <label for="hotelSelect" class="form-label">Hotel</label>
                <select class="form-select" id="hotelSelect" name="pev_id">
                  <option value="" disabled selected>Hotel dan Tipe Kamar</option>
                  <?php foreach ($venues as $row) : ?>
                    <option value="<?= $row->id ?>"><?= $row->name ?> - <?= $row->room_type ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-8 mt-3">
                <label for="roomPrice" class="form-label">Harga Kamar</label>
                <input type="text" class="form-control" id="roomPrice" placeholder="Pilih hotel terlebih dahulu" name="room_price" readonly>
              </div>
              <div class="col-md-4 mt-3">
                <label for="numberOfRooms" class="form-label">Jumlah Kamar</label>
                <input type="number" class="form-control" id="numberOfRooms" value="1" name="number_of_room">
              </div>
              <div class="col-md-4 mt-3">
                <label for="checkInDate" class="form-label">Check in</label>
                <input type="date" class="form-control" id="checkInDate" name="check_in" min="2024-10-09" max="2024-10-18">
              </div>
              <div class="col-md-4 mt-3">
                <label for="checkOutDate" class="form-label">Check Out</label>
                <input type="date" class="form-control" id="checkOutDate" name="check_out" min="2024-10-09" max="2024-10-18">
              </div>
              <div class="col-md-4 mt-3">
                <label for="totalNights" class="form-label">Total Malam</label>
                <input type="number" class="form-control" id="totalNights" value="0" readonly name="total_night">
              </div>
              <div class="col-md-8 mt-3">
                <label for="totalHotelFee" class="form-label">Total Biaya Hotel</label>
                <input type="text" class="form-control" id="totalHotelFee" name="tota_hotel_fee" placeholder="Rp. 0,-" readonly>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <span class="registration-title text-muted">Rincian Biaya</span>
              </div>
              <div class="col-md-12 mt-3">
                <table class=" table">
                  <thead class="table-light">
                    <tr>
                      <th>No</th>
                      <th>Deskripsi</th>
                      <th>Harga</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody id="rincianBiayaTableBody">
                  </tbody>
                  <tfoot>
                    <tr>
                      <td id="uniqueNumberNomor">1</td>
                      <td id="uniqueNumberDeskripsi">Unique Payment Verification Codes</td>
                      <td id="uniqueNumberHarga"></td>
                      <td id="uniqueNumberSubtotal"></td>
                      <input type="hidden" name="registration_unique_payment" id="registrant_unique_number" value="">
                    </tr>
                    <tr>
                      <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                      <td id="totalAkhir">Rp0</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="mt-4">
              <div class="d-grid gap-2">
                <button type="submit" id="submitBtn" class="btn btn-outline-primary">Kirim Pendaftaran</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>