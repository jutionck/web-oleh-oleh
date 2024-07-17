<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="d-flex d-flex justify-content-between mb-4">
        <h5 class="card-title fw-semibold"><?= $cardTitle ?></h5>
      </div>
      <table id="example" class="table border table-striped table-bordered text-nowrap align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Provinsi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($regencies as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row->name ?></td>
              <td><?= $row->province_name ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>