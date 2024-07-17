<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./index.html" class="text-nowrap logo-img mt-4">
        <img src="<?= base_url('assets/images/') ?>logo-event.png" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Home</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/dashboard') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">GENERAL</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/users') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-user"></i>
            </span>
            <span class="hide-menu">User</span>
          </a>
        </li>
        <!-- <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/provinces') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-layout-kanban"></i>
            </span>
            <span class="hide-menu">Provinsi</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/regencies') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-layout-kanban"></i>
            </span>
            <span class="hide-menu">Kabupaten</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/email-accounts') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-mail"></i>
            </span>
            <span class="hide-menu">Email</span>
          </a>
        </li> -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/bank-accounts') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-credit-card"></i>
            </span>
            <span class="hide-menu">Bank</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'payment-methods' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(2)  === 'payment-methods' ? 'active' : '') ?>" href="<?= site_url('backoffice/payment-methods') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-wallet"></i>
            </span>
            <span class="hide-menu">Metode Pembayaran</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/companies') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-list-details"></i>
            </span>
            <span class="hide-menu">Perusahaan</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/participant-categories') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-user-plus"></i>
            </span>
            <span class="hide-menu">Kategori Peserta</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'price-types' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(2)  === 'price-types' ? 'active' : '') ?>" href="<?= site_url('backoffice/price-types') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-currency-dollar"></i>
            </span>
            <span class="hide-menu">Kategori Harga</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">PROGRAM</span>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'venues' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(2)  === 'venues' ? 'active' : '') ?>" href="<?= site_url('backoffice/venues') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Venue</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(3)  === 'detail' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(3)  === 'detail' ? 'active' : '') ?>" href="<?= site_url('backoffice/events') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-cards"></i>
            </span>
            <span class="hide-menu">Event</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'registrants' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(2)  === 'registrants' ? 'active' : '') ?>" href="<?= site_url('backoffice/registrants') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-archive"></i>
            </span>
            <span class="hide-menu">Pendaftar</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'email-logs' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(2)  === 'email-logs' ? 'active' : '') ?>" href="<?= site_url('backoffice/email-logs') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-mail"></i>
            </span>
            <span class="hide-menu">Email Log</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'zoom-meeting' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(2)  === 'zoom-meeting' ? 'active' : '') ?>" href="<?= site_url('backoffice/zoom-meeting') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-brand-zoom"></i>
            </span>
            <span class="hide-menu">Zoom Meeting</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'material-and-certificate' ? 'selected' : '') ?>">
          <a class="sidebar-link <?= ($this->uri->segment(2)  === 'material-and-certificate' ? 'active' : '') ?>" href="<?= site_url('backoffice/material-and-certificate') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-layout"></i>
            </span>
            <span class="hide-menu">Materi & Sertifikat</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($this->uri->segment(2)  === 'rereg-certificates' ? 'selected' : '') ?>">
          <a class=" sidebar-link <?= ($this->uri->segment(2)  === 'rereg-certificates' ? 'active' : '') ?>" aria-expanded="false" href="<?= site_url('backoffice/rereg-certificates') ?>">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Rereg & Sertifikat</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">QUICK</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('backoffice/registrant-no-nik') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-user-plus"></i>
            </span>
            <span class="hide-menu">Pendaftar + NIK</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">REPORT</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/report-all-workshop') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-border-outer"></i>
            </span>
            <span class="hide-menu">All Workshop</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/report-online-workshop') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-app-window"></i>
            </span>
            <span class="hide-menu">Workshop Online</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/report-offline-workshop') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-box-align-left"></i>
            </span>
            <span class="hide-menu">Workshop Offline</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/report-symposium') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-file-analytics"></i>
            </span>
            <span class="hide-menu">Simposium</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= site_url('backoffice/report-venues') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-layout"></i>
            </span>
            <span class="hide-menu">Golden tulip</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">BACKUP</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('backoffice/backup-database') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Database</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">AUTH</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('backoffice/auth/logout') ?>" aria-expanded="false">
            <span>
              <i class="ti ti-logout"></i>
            </span>
            <span class="hide-menu">Logout</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
<div class="body-wrapper">