 <!-- Bootstrap core JavaScript-->
 <script src="<?= base_url('asset/vendor/jquery/jquery.min.js'); ?> "></script>
    <script src="<?= base_url('asset/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?> "></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('asset/vendor/jquery-easing/jquery.easing.min.js'); ?> "></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('asset/js/sb-admin-2.min.js'); ?> "></script>
<script>
  // Tampilkan loading screen saat klik link atau submit form
  document.addEventListener('DOMContentLoaded', function () {
    const loading = document.getElementById('loading-screen');

    // Saat link diklik
    document.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function (e) {
        const href = a.getAttribute('href');
        if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
          loading.style.display = 'flex';
        }
      });
    });

    // Saat form disubmit
    document.querySelectorAll('form').forEach(function (form) {
      form.addEventListener('submit', function () {
        loading.style.display = 'flex';
      });
    });
  });
</script>

</body>

</html>