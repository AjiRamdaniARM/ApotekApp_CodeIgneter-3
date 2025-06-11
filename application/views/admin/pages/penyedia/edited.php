<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php $this->load->view('admin/components/sidebar'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- End of Topbar -->
                 <?php $this->load->view('admin/components/navbar'); ?>

                <!-- Begin Page Content --> <!-- Begin Page Content -->
                <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $subTitle ?></h1>

    <!-- component table -->
   <div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Input Data Supplier</h6>
  </div>
  <div class="card-body">
    <form method="post" action="<?= base_url('admin/penyedia/edited/'.$penyedia['id_penyedia']) ?>">
      <div class="form-group mb-3">
        <label for="nama">Nama Penyedia</label>
        <input type="text" class="form-control" id="nama" name="nama_penyedia" placeholder="Masukkan nama penyedia"  value="<?= isset($penyedia['nama_penyedia']) ? $penyedia['nama_penyedia'] : '' ?>"
       required>
        <br>
        <?php echo form_error('nama_penyedia','<div class="alert alert-danger">', '</div>'); ?>
      </div>

      <div class="form-group mb-3">
        <label for="no_telp">No. Telepon</label>
        <input type="tel" class="form-control" id="no_telp" name="no_telp" value="<?= isset($penyedia['no_telp']) ? $penyedia['no_telp'] : '' ?>" placeholder="Masukkan nomor telepon">
        <br>
        <?php echo form_error('no_telp','<div class="alert alert-danger">', '</div>'); ?>
      </div>

      <div class="form-group mb-3">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" value="<?= isset($penyedia['alamat']) ? $penyedia['alamat'] : '' ?>" placeholder="Masukkan alamat penyedia"></textarea>
      </div>

      <div class="form-group mb-3">
        <label for="catatan">Catatan</label>
        <textarea class="form-control" id="catatan" name="catatan" rows="2" value="<?= isset($penyedia['catatan']) ? $penyedia['catatan'] : '' ?>" placeholder="Catatan tambahan (opsional)"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
  </div>
</div>

</div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('vendor/'); ?>startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('vendor/'); ?>startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('vendor/'); ?>startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('vendor/'); ?>startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js"></script>

</body>

</html>