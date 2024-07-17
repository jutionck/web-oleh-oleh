<!-- application/views/official/seller/index.php -->

<div class="container mt-5">
  <h2>Data Penjualan</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Jenis Pembayaran</th>
        <th>Total</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order) : ?>
        <tr>
          <td><?= date('d M Y', strtotime($order->created_at)) ?></td>
          <td>
            <img src="<?= base_url('assets/official/images/products/' . $order->image_url) ?>" alt="<?= $order->name ?>" style="width: 50px; height: 50px;">
            <?= $order->name ?>
          </td>
          <td><?= $order->quantity ?></td>
          <td><?= number_format($order->price, 2) ?></td>
          <td><?= $order->payment_method ?></td>
          <td><?= number_format($order->quantity * $order->price, 2) ?></td>
          <td><?= ucfirst($order->status) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>