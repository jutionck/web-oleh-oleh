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
      <div class="d-flex d-flex justify-content-between mb-4">
        <h5 class="card-title fw-semibold"><?= $cardTitle ?> <span class="text-primary"><?= $event->name ?></span></h5>
        <div class="d-flex d-flex d-flex justify-content-end">
          <a href="<?= site_url('backoffice/events') ?>" class="btn btn-dark me-1">Kembali</a>
          <a href="<?= site_url('backoffice/events/detail/' . $event->id . '/add') ?>" class="btn btn-primary">Tambah</a>
        </div>
      </div>
      <div class="table-responsive">
        <table id="example" class="table border table-striped table-bordered text-nowrap align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Aksi</th>
              <th>Kegiatan</th>
              <th>Tanggal Pelaksanaan</th>
              <th>Kuota</th>
              <th>Venue</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($eventWorkshops as $row) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <a href="<?= site_url('backoffice/events/detail/' . $row->pe_id . '/participant-categories/' . $row->id) ?>" class="btn btn-sm btn-info" title="Kategori Peserta"><i class="ti ti-user-plus"></i></a>
                  <a class="btn btn-sm btn-success" href="<?= site_url('backoffice/events/detail/' . $row->pe_id . '/edit/' . $row->id) ?>" title="Edit Data"><i class="ti ti-edit"></i></a>
                  <button class="btn btn-sm btn-danger delete-workshop" data-id="<?= $row->id ?>" data-event="<?= $row->pe_id ?>" title="Hapus Data"><i class="ti ti-trash"></i></button>
                </td>
                <td>
                  <?= $row->name ?> <?= ($row->type === 'online') ?
                                      '<span class="badge font-medium bg-primary-subtle text-dark">Online</span>' :
                                      '<span class="badge font-medium bg-dark-subtle">Offline</span>' ?>
                </td>
                <td>
                  <?php if (empty($row->end_date)) : ?>
                    <?= indonesianDate($row->start_date, 'D MMMM Y') ?>
                  <?php elseif (date('m', strtotime($row->start_date)) === date('m', strtotime($row->end_date))) : ?>
                    <?= indonesianDate($row->start_date, 'D') ?> -
                    <?= indonesianDate($row->end_date, 'D MMMM Y') ?>
                  <?php else : ?>
                    <?= indonesianDate($row->start_date, 'D MMMM') ?> -
                    <?= indonesianDate($row->end_date, 'D MMMM Y') ?>
                  <?php endif ?>
                </td>
                <td><?= $row->qty ?></td>
                <td><?= $row->venue ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>