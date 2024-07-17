<div class="container mt-5">
  <h2>Riwayat Belanja</h2>
  <?php foreach ($orders as $order) : ?>
    <div class="card mb-4">
      <div class="card-header">
        <strong>Order ID:</strong> <?= $order->id ?>
        <span class="float-end"><strong>Tanggal:</strong> <?= date('d M Y', strtotime($order->created_at)) ?></span>
      </div>
      <div class="card-body">
        <h5 class="card-title">Detail Order</h5>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($order->items as $item) : ?>
              <tr>
                <td>
                  <img src="<?= base_url('assets/official/images/products/') . $item->image_url ?>" alt="<?= $item->name ?>" style="width: 50px; height: 50px;">
                  <?= $item->name ?>
                </td>
                <td><?= $item->quantity ?></td>
                <td><?= number_format($item->price, 2) ?></td>
                <td><?= number_format($item->quantity * $item->price, 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p><strong>Alamat Pengiriman:</strong> <?= $order->address ?></p>
        <p><strong>Payment Method:</strong> <?= ucfirst($order->payment_method) ?></p>
        <p><strong>Total Harga:</strong> <?= number_format($order->total_price, 2) ?></p>
        <p><strong>Status:</strong> <?= ucfirst($order->status) ?></p>
        <?php if ($order->payment_method == 'cod' && $order->status == 'pending') : ?>
          <a href="<?= site_url('order/confirm_payment/' . $order->id) ?>" class="btn btn-primary">Confirm Payment</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>