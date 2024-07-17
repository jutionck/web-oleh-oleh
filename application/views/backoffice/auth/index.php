<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card mb-0">
            <div class="card-body">
              <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                <img src="<?= base_url('assets/images/') ?>logo-event.png" width="180" alt="">
              </a>
              <p class="text-center">Silakan masuk untuk melanjutkan</p>
              <?php if ($this->session->flashdata('errorusername')) : ?>
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                  <i class="bi bi-exclamation-triangle me-1"></i>
                  <?= $this->session->flashdata('errorusername'); ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif ?>
              <form method="POST" action="<?= base_url('backoffice/authentication/login') ?>">
                <div class="mb-3">
                  <label for="inputUsername" class="form-label">Username</label>
                  <input type="text" class="form-control" id="inputUsername" aria-describedby="emailHelp" name="username">
                </div>
                <div class="mb-4 position-relative">
                  <label for="inputPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="inputPassword" name="password">
                  <i class="bi bi-eye password-toggle-icon" style="position: absolute; right: 10px; top: 38px; cursor: pointer;"></i>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" id="loginButton">Masuk</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>