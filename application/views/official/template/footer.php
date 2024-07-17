</div>
<footer class="bg-light text-center text-lg-start mt-auto">
  <div class="container p-4">
    <div class="row">
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">BeliYuk - Web Oleh-oleh</h5>
        <p>Beli, jual, dan temukan apa saja menggunakan aplikasi di handphone Anda.</p>
      </div>
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase">Follow Us</h5>
        <a href="#" class="me-3 text-dark"><i class="fab fa-facebook"></i></a>
        <a href="#" class="me-3 text-dark"><i class="fab fa-twitter"></i></a>
        <a href="#" class="me-3 text-dark"><i class="fab fa-instagram"></i></a>
        <a href="#" class="me-3 text-dark"><i class="fab fa-linkedin"></i></a>
      </div>
    </div>
  </div>
  <div class="text-center p-3 bg-dark text-white">
    © 2024 BeliYuk - Web Oleh-oleh
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document
    .getElementById("cartIcon")
    .addEventListener("mouseenter", function() {
      document.getElementById("cartDropdown").classList.add("active");
    });

  document
    .getElementById("cartIcon")
    .addEventListener("mouseleave", function() {
      document.getElementById("cartDropdown").classList.remove("active");
    });

  document
    .getElementById("cartDropdown")
    .addEventListener("mouseenter", function() {
      document.getElementById("cartDropdown").classList.add("active");
    });

  document
    .getElementById("cartDropdown")
    .addEventListener("mouseleave", function() {
      document.getElementById("cartDropdown").classList.remove("active");
    });
</script>
</body>

</html>