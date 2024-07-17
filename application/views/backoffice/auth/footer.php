<script src="<?= base_url('assets/backoffice') ?>/js/script.js"></script>
<script src="<?= base_url('assets/backoffice') ?>/libs/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url('assets/backoffice') ?>/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('.password-toggle-icon').click(function() {
      // Mengganti class untuk mengubah ikon
      $(this).toggleClass('bi-eye');
      $(this).toggleClass('bi-eye-slash');
      let input = $($(this).prev('input'));
      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
      } else {
        input.attr('type', 'password');
      }
    });
  });
</script>
</body>

</html>