<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form class="needs-validation" action="<?= site_url('backoffice/registrants/proccess-update') ?>" method="POST">
            <input type="hidden" name="workshop_registrant_id" value="<?= $workshopRegistrant->id ?>">
            <input type="hidden" name="registration_unique_payment" value="<?= $workshopRegistrant->registration_unique_payment ?>">
            <div class="row">
              <div class="col-md-12 form-group">
                <span class="registration-title text-muted">Yang Mendaftarkan</span>
                <div class="form-check form-switch mt-3">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo ($workshopRegistrant->registrant_status == 'didaftarkan') ? 'checked' : ''; ?>>
                  <input type="hidden" name="registrant_status" id="registration_type" value="<?php echo $workshopRegistrant->registrant_status; ?>">
                  <label class="form-check-label" for="flexSwitchCheckChecked">
                    <span id="sendiri-text">Daftar Sendiri</span> / <span id="didaftarkan-text">Didaftarkan</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <input type="text" name="fullname_didaftarkan" class="form-control" id="fullname_didaftarkan" placeholder="Nama Lengkap" value="<?= $workshopRegistrant->fullname_didaftarkan ?>">
              </div>
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <input type="email" class="form-control" name="email_didaftarkan" id="email_didaftarkan" placeholder="Email" value="<?= $workshopRegistrant->email_didaftarkan ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <input type="text" class="form-control" name="nohp_didaftarkan" id="nohp_didaftarkan" placeholder="No Handphone" value="<?= $workshopRegistrant->nohp_didaftarkan ?>">
              </div>
              <div class="col-md-6 form-group mt-3 didaftarkan-field" style="display: none;">
                <select id="namaPerusahaanSelect" class="form-select select2" aria-label="Nama Perusahaan" name="company_didaftarkan">
                  <option value="" disabled>Pilih Perusahaan</option>
                  <?php foreach ($companies as $row) : ?>
                    <option value="<?= $row->name ?>" <?= ($row->name == $workshopRegistrant->company_didaftarkan) ? 'selected' : ''; ?>>
                      <?= $row->name ?>
                    </option>
                  <?php endforeach; ?>
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
                    <option value="<?= $row->id ?>" <?= ($row->id == $workshopRegistrantDetailRow->pc_id) ? 'selected' : ''; ?>><?= $row->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-12 mt-3">
                <span class="registration-title text-muted">Data Pribadi Peserta <span class="text-danger">*</span></span>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" name="registrant_fullname" class="form-control" id="fullname" placeholder="Nama" value="<?= $workshopRegistrant->registrant_fullname ?>">
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" class="form-control" name="registrant_fullname_with_title" id="fullname-with-title" placeholder="Nama Lengkap dan Gelar" value="<?= $workshopRegistrant->registrant_fullname_with_title ?>">
                <label class="form-check-label form-text" for="namaPerusahaanSelect">
                  <i>Di cetak untuk sertifikat</i>
                </label>
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" name="registrant_nik" class="form-control" id="registrant_nik" placeholder="NIK" value="<?= $workshopRegistrant->registrant_nik ?>">
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="email" name="registrant_email" class="form-control" id="registrant_email" placeholder="Email" value="<?= $workshopRegistrant->registrant_email ?>">
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" name="registrant_institute" class="form-control" id="institute" placeholder="Institusi" value="<?= $workshopRegistrant->registrant_institute ?>">
              </div>
              <div class="col-md-6 form-group mt-3">
                <input type="text" class="form-control" name="registrant_nohp" id="registrant_hp" placeholder="No Handphone e.g 0821...." value="<?= $workshopRegistrant->registrant_nohp ?>">
              </div>
              <div class="col-md-6 form-group mt-3">
                <select id="namaProvinsi" class="form-select select2" aria-label="Provinsi" name="registrant_province_id">
                  <option value="" disabled selected>Pilih Provinsi</option>
                  <?php foreach ($provinces as $province) : ?>
                    <option value="<?= $province->code ?>" <?= ($province->code == $workshopRegistrant->registrant_province_id) ? 'selected' : ''; ?>><?= $province->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-6 form-group mt-3">
                <select id="namaKabupaten" class="form-select select2" aria-label="Kabupaten" name="registrant_regency_id">
                  <option value="" disabled selected>Pilih Kabupaten</option>
                </select>
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
                    <tbody>
                      <?php foreach ($workshopRegistrantDetailResult as $workshop) : ?>
                        <?php
                        $badgeClass = "";
                        switch ($workshop->pt_name) {
                          case "Early Bird":
                            $badgeClass = "bg-success";
                            break;
                          case "Normal":
                            $badgeClass = "bg-primary";
                            break;
                          case "Onsite":
                            $badgeClass = "bg-warning";
                            break;
                          default:
                            $badgeClass = "bg-secondary";
                            break;
                        }
                        $isChecked = in_array($workshop->wpc_id, $selectedWorkshops) ? 'checked' : '';
                        ?>
                        <tr>
                          <td>
                            <?= htmlspecialchars($workshop->ws_name) ?>
                            <ul>
                              <li class='fst-italic'>Tempat: <?= htmlspecialchars($workshop->ws_venue ?: "-") ?></li>
                              <li class='fst-italic'>Tanggal: <?= $workshop->ws_end_date !== null ? indonesianDate($workshop->ws_start_date, "D/M/Y") . " s.d " . indonesianDate($workshop->ws_end_date, "D/M/Y") : indonesianDate($workshop->ws_start_date, "D/M/Y") ?></li>
                              <li class='fst-italic'>Tipe: <span class='badge <?= $badgeClass ?>'><?= htmlspecialchars($workshop->pt_name) ?></span></li>
                            </ul>
                          </td>
                          <td><?= number_format($workshop->wpc_price, 0, ',', '.') ?> IDR</td>
                          <td>
                            <input type='checkbox' name='wpc[]' value='<?= $workshop->wpc_id ?>' <?= $isChecked ?> class='form-check-input workshop' data-workshop-date='<?= htmlspecialchars($workshop->ws_end_date ?: $workshop->ws_start_date) ?>'>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="hotelReservationCheck" name="hotel_reservation" checked>
                  <label class="form-check-label registration-title text-muted" for="hotelReservationCheck">
                    Reservasi Hotel
                  </label>
                </div>
              </div>
            </div>
            <div id="hotelReservationFields">
              <div class="row">
                <div class="col-md-4 mt-3">
                  <label for="hotelSelect" class="form-label">Hotel</label>
                  <select class="form-select" id="hotelSelect" name="pev_id">
                    <option value="" disabled selected>Hotel dan Tipe Kamar</option>
                    <?php foreach ($venues as $row) : ?>
                      <option value="<?= $row->id ?>" <?= ($row->id == @$workshopRegistrantVenue->pev_id) ? 'selected' : ''; ?>><?= $row->name ?> - <?= $row->room_type ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-md-8 mt-3">
                  <label for="roomPrice" class="form-label">Harga Kamar</label>
                  <input type="text" class="form-control" id="roomPrice" placeholder="Pilih hotel terlebih dahulu" name="room_price" value="<?= @$workshopRegistrantVenueReservation->room_price ?>" readonly>
                </div>
                <div class="col-md-4 mt-3">
                  <label for="numberOfRooms" class="form-label">Jumlah Kamar</label>
                  <input type="number" class="form-control" id="numberOfRooms" value="1" name="number_of_room" value="<?= @$workshopRegistrantVenueReservation->number_of_room ?>">
                </div>
                <div class="col-md-4 mt-3">
                  <label for="checkInDate" class="form-label">Check in</label>
                  <input type="date" class="form-control" id="checkInDate" name="check_in" min="2024-10-09" max="2024-10-18" value="<?= @$workshopRegistrantVenueReservation->check_in ?>">
                </div>
                <div class="col-md-4 mt-3">
                  <label for="checkOutDate" class="form-label">Check Out</label>
                  <input type="date" class="form-control" id="checkOutDate" name="check_out" min="2024-10-09" max="2024-10-18" value="<?= @$workshopRegistrantVenueReservation->check_out ?>">
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
<script>
  document.addEventListener("DOMContentLoaded", function() {
    "use strict";

    const isChecked = <?php echo ($workshopRegistrant->registrant_status == 'didaftarkan') ? 'true' : 'false'; ?>;
    const didaftarkanFields = document.querySelectorAll(".didaftarkan-field");

    function toggleFields(display) {
      didaftarkanFields.forEach(function(field) {
        field.style.display = display ? "block" : "none";
      });
    }

    document.getElementById("flexSwitchCheckChecked").checked = isChecked;

    toggleFields(isChecked);

    document.getElementById("flexSwitchCheckChecked").addEventListener("change", function() {
      toggleFields(this.checked);
      document.getElementById("registration_type").value = this.checked ? 'didaftarkan' : 'sendiri';
      document.getElementById("sendiri-text").style.fontWeight = this.checked ? "normal" : "bold";
      document.getElementById("didaftarkan-text").style.fontWeight = this.checked ? "bold" : "normal";
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    const hotelReservationCheck = document.getElementById('hotelReservationCheck');
    const hotelReservationFields = document.getElementById('hotelReservationFields');

    function toggleHotelReservationFields(enable) {
      if (enable) {
        hotelReservationFields.style.display = '';
        hotelReservationCheck.value = 1;
      } else {
        hotelReservationFields.style.display = 'none';
      }
    }

    hotelReservationCheck.addEventListener('change', function() {
      toggleHotelReservationFields(this.checked);
    });

    toggleHotelReservationFields(hotelReservationCheck.checked);
  });


  $(document).ready(function() {
    $("#namaProvinsi").change(function() {
      var province = $(this).val();
      $.ajax({
        url: backofficeURL + "backoffice/registrants/regencies",
        method: "post",
        data: {
          province: province
        },
        dataType: "json",
        success: function(response) {
          var kabupatenSelect = $("#namaKabupaten");
          kabupatenSelect.empty().append('<option value="" disabled selected>Pilih Kabupaten</option>');
          $.each(response, function(index, kabupaten) {
            kabupatenSelect.append($('<option>', {
              value: kabupaten.id,
              text: kabupaten.name
            }));
          });
          <?php if (isset($workshopRegistrant->registrant_regency_id)) : ?>
            kabupatenSelect.val('<?= $workshopRegistrant->registrant_regency_id; ?>');
          <?php endif; ?>
        }
      });
    });

    <?php if (isset($workshopRegistrant->registrant_province_id)) : ?>
      $("#namaProvinsi").val('<?= $workshopRegistrant->registrant_province_id; ?>').change();
    <?php endif; ?>
  });

  $(document).ready(function() {
    $('#hotelSelect').change(function() {
      var hotelId = $(this).val();
      if (hotelId) {
        $.ajax({
          url: '<?= base_url("backoffice/registrants/venue") ?>',
          type: 'POST',
          data: {
            hotelId: hotelId
          },
          dataType: 'json',
          success: function(response) {
            var price = response.data.price;
            $('#roomPrice').val(price);
          },
          error: function() {
            alert("Terjadi kesalahan saat mengambil data harga kamar.");
          }
        });
      } else {
        $('#roomPrice').val('');
      }
    });

    $('#hotelSelect').change();
  });

  $(document).ready(function() {
    function calculateTotalNights() {
      var checkInDate = new Date($('#checkInDate').val());
      var checkOutDate = new Date($('#checkOutDate').val());
      var difference = checkOutDate - checkInDate;
      var totalNights = difference / (1000 * 3600 * 24);
      $('#totalNights').val(totalNights);
      return totalNights;
    }

    function calculateTotalHotelFee() {
      var roomPrice = parseFloat($('#roomPrice').val());
      var numberOfRooms = parseInt($('#numberOfRooms').val());
      var totalNights = calculateTotalNights();
      var totalHotelFee = roomPrice * numberOfRooms * totalNights;
      totalHotelFee ? $('#totalHotelFee').val(`Rp. ${totalHotelFee.toLocaleString("id-ID") }`) : '';
    }

    calculateTotalHotelFee();

    $('#numberOfRooms, #checkInDate, #checkOutDate').change(function() {
      calculateTotalHotelFee();
    });
  });
</script>