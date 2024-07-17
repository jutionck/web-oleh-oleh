<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment</title>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $this->config->item('midtrans_client_key') ?>"></script>
</head>

<body>
  <div class="container mt-5">
    <h2>Payment</h2>
    <button id="pay-button">Pay Now</button>
  </div>

  <script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
      snap.pay('<?= $snap_token ?>', {
        onSuccess: function(result) {
          // Handle success
          console.log(result);
          window.location.href = "<?= site_url('checkout/success') ?>";
        },
        onPending: function(result) {
          // Handle pending
          console.log(result);
        },
        onError: function(result) {
          // Handle error
          console.log(result);
        },
        onClose: function() {
          // Handle close
          alert('You closed the popup without finishing the payment');
        }
      });
    });
  </script>
</body>

</html>