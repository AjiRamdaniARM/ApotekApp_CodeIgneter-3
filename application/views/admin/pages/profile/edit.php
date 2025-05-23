<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
         <?php $this->load->view('admin/components/sidebar'); ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                     <?php $this->load->view('admin/components/navbar'); ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $subTitle ?></h1>

                    <!-- Profile Card -->
                   <form action="<?= base_url('admin/profile/update') ?>" method="post">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Profile Picture -->
                                    <div class="col-md-3 text-center">
                                        <img src="<?= base_url('vendor/'); ?>startbootstrap-sb-admin-2-gh-pages/img/undraw_profile_2.svg" class="img-fluid rounded-circle mb-3" alt="Profile Picture">
                                    </div>

                                    <!-- Form Input Profil -->
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $pengguna['nama'] ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="<?= $pengguna['email'] ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="akses">Role / Akses</label>
                                            <select class="form-control" name="akses" id="akses" required>
                                                <option value="admin" <?= $pengguna['akses'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="user" <?= $pengguna['akses'] == 'user' ? 'selected' : '' ?>>User</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Sandi Baru (kosongkan jika tidak ingin mengubah)</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="********">
                                        </div>

                                        <button type="submit" class="btn btn-success mt-3">Simpan Perubahan</button>
                                        <a href="<?= base_url('admin/profile') ?>" class="btn btn-secondary mt-3">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>



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