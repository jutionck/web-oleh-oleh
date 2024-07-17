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
            <th>Kode</th>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($provinces as $row) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row->code ?></td>
              <td><?= $row->name ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>