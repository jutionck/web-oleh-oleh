<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold"><?= $cardTitle ?></h5>
      <p>Klik tombol di bawah ini untuk melakukan backup database.</p>
      <button id="backupButton" class="btn btn-primary">Backup Now</button>
      <div class="progress mt-3" style="height: 25px;">
        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
      </div>
      <div id="backupMessage" class="mt-3"></div>
    </div>
  </div>
</div>