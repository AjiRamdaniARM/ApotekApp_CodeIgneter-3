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
    <h6 class="m-0 font-weight-bold text-primary">Input Data Obat</h6>
  </div>
  <div class="card-body">
    <form method="post" action="<?= base_url('admin/obat/edited_post/'.$obat['id_produk_obat']) ?>">
        <!-- === input obat === -->
        <div class="form-group">
            <label>Nama Obat</label>
            <input type="text" name="nama" value="<?= $obat['nama'] ?>" class="form-control" required>
        </div>

        <!-- === input kategori obat === -->
        <div class="form-group">
            <label>Kategori Obat</label>
            <select name="id_kategori_obat" class="form-control" required>
            <option value="<?= $kategoriSelect['id_kategori_obat'] ?>"><?= $kategoriSelect['nama_tipe'] ?></option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori_obat'] ?>"><?= $k['nama_tipe'] ?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <!-- === input pembelian obat === -->
        <div class="form-group">
            <label>Harga Pembelian</label>
            <input type="text" id="harga_pembelian" value="Rp.<?= number_format($obat['harga_pembelian'], 0, ',', '.') ?>"   name="harga_pembelian" min="0" class="form-control" required>
        </div>

        <!-- === input penjualan obat === -->
        <div class="form-group">
            <label>Harga Penjualan</label>
            <input type="text" id="harga_jual" value="Rp.<?= number_format($obat['harga_penjualan'], 0, ',', '.') ?>" name="harga_penjualan" min="0" class="form-control" required>
        </div>

        <!-- === input tanggal kedaluarsa obat === -->
        <div class="form-group">
            <label>Tanggal Kadaluarsa</label>
            <input type="date"  value="<?= date('Y-m-d', strtotime($obat['tanggak_kadaluarsa'])) ?>"  name="tanggak_kadaluarsa" class="form-control" required>
        </div>

         <!-- === input data stok obat === -->
        <div class="form-group">
            <label>Stok</label>
            <input type="number" value="<?= $obat['stok'] ?>" name="stok" class="form-control" min="0" required>
        </div>

         <!-- === input status obat === -->
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
            <option value="<?= $obat['status'] ?>"><?= $obat['status'] ?> ( Dipilih )</option>
            <option value="proses">Proses</option>
            <option value="terima">Terima</option>
            <option value="tolak">Tolak</option>
            </select>
        </div>

         <!-- === input tipe obat === -->
        <div class="form-group">
            <label>Tipe Obat</label>
            <select name="tipe_obat" class="form-control" required>
            <option value="tablet">Tablet</option>
            <option value="kapsul">Kapsul</option>
            <option value="sirup">Sirup</option>
            <option value="krim">Krim</option>
            <option value="injeksi">Injeksi</option>
            </select>
        </div>

         <!-- === input supplier obat === -->
        <div class="form-group">
            <label>Penyedia Obat</label>
            <select name="id_penyedia" class="form-control" required>
            <option value="<?= $penyediaSelect['id_penyedia'] ?>"><?= $penyediaSelect['nama_penyedia'] ?></option>
            <?php foreach ($penyedia as $p): ?>
                <option value="<?= $p['id_penyedia'] ?>"><?= $p['nama_penyedia'] ?></option>
            <?php endforeach; ?>
            </select>
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
    <script src="<?= base_url('asset/'); ?>js/conversi_rp.js"></script>

</body>

</html> 