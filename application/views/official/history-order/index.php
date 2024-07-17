<div class="container mt-5">
  <h2>Riwayat Belanja</h2>
  <?php if (empty($order_history)) : ?>
    <p>Belum ada riwayat belanja.</p>
  <?php else : ?>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order_history as $order) : ?>
            <tr>
              <td><?= date('d M Y', strtotime($order->created_at)) ?></td>
              <td>
                <img src="<?= base_url('assets/official/images/products/') . $order->image_url ?>" alt="<?= $order->product_name ?>" style="width: 50px; height: 50px;">
                <?= $order->product_name ?>
              </td>
              <td><?= $order->quantity ?></td>
              <td><?= number_format($order->price, 2) ?></td>
              <td><?= number_format($order->quantity * $order->price, 2) ?></td>
              <td><?= ucfirst($order->status) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>