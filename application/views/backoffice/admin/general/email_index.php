<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4"><?= $cardTitle ?></h5>
      <div class="card">
        <div class="card-body">
          <form action="" method="POST">
            <input type="hidden" name="id" value="<?= $emailAccount->id ?>">
            <div class="row">
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="host" class="form-label">Host <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('host') ? 'is-invalid' : ''; ?>" id="host" name="host" value="<?= set_value('host') ? set_value('host') : $emailAccount->host; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('host'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="username" class="form-label">Username <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= set_value('username') ? set_value('username') : $emailAccount->username; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('username'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="password" class="form-label">Password <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" value="<?= set_value('password') ? set_value('password') : $emailAccount->password; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('password'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="smtp_secure" class="form-label">SMTP Secure <span class="text-danger">*</span> </label>
                  <select name="smtp_secure" id="smtp_secure" class="form-select">
                    <option value="ssl" <?= $emailAccount->smtp_secure === 'ssl' ? 'selected' : '' ?>>SSL</option>
                    <option value="tls" <?= $emailAccount->smtp_secure === 'tls' ? 'selected' : '' ?>>TLS</option>
                  </select>
                  <div class="invalid-feedback">
                    <?= form_error('smtp_secure'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="port" class="form-label">Port <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('port') ? 'is-invalid' : ''; ?>" id="port" name="port" value="<?= set_value('port') ? set_value('port') : $emailAccount->port; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('port'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="set_from_address" class="form-label">Email Pengirim <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('set_from_address') ? 'is-invalid' : ''; ?>" id="set_from_address" name="set_from_address" value="<?= set_value('set_from_address') ? set_value('set_from_address') : $emailAccount->set_from_address; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('set_from_address'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="set_from_name" class="form-label">Nama Pengirim <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('set_from_name') ? 'is-invalid' : ''; ?>" id="set_from_name" name="set_from_name" value="<?= set_value('set_from_name') ? set_value('set_from_name') : $emailAccount->set_from_name; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('set_from_name'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="email_forward" class="form-label">Email Terusan <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?= form_error('email_forward') ? 'is-invalid' : ''; ?>" id="email_forward" name="email_forward" value="<?= set_value('email_forward') ? set_value('email_forward') : $emailAccount->email_forward; ?>">
                  <div class="invalid-feedback">
                    <?= form_error('email_forward'); ?>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= site_url($redirect) ?>" class="btn btn-dark">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>