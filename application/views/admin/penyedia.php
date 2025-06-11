
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include('components/sidebar.php'); ?>

        <!-- === Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- End of Topbar -->
                <?php include('components/navbar.php') ?>
                <!-- Begin Page Content --> <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $subTitle ?></h1>

                    <!-- === component alert ===  -->
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                            <div><?= $this->session->flashdata('success'); ?></div>
                            <i class="fas fa-times text-dark ms-3" style="cursor:pointer;" onclick="this.closest('.alert').remove();"></i>
                        </div>
                    <?php endif; ?>
                    <!-- === end component alert ===  -->
                      
                    <!-- component table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Tabel Supplier</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <a href="<?= base_url('admin/penyedia/create') ?>" class="btn btn-primary">Tambah Data</a>
                                <form method="GET" class="form-inline">
                                    <input 
                                        type="search" 
                                        name="keyword" 
                                        value="" 
                                        placeholder="Cari..." 
                                        class="form-control mr-2"
                                    >
                                    <input 
                                        type="date" 
                                        name="tanggal_masuk" 
                                        value="<?= $this->input->get('tanggal_masuk'); ?>" 
                                        class="form-control mr-2"
                                    >
                                    <a href="<?= base_url('admin/penyedia/report_pdf?keyword=' . $this->input->get('keyword') . '&tanggal_masuk=' . $this->input->get('tanggal_masuk')) ?>" target="_blank" class="btn btn-danger mr-2">
                                        Cetak PDF
                                    </a>

                                  
                                    <button type="submit" class="btn btn-primary">
                                        Cari
                                    </button>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Supplier</th>
                                            <th>Telepone</th>
                                            <th>Alamat</th>
                                            <th>Suplai Obat</th>
                                            <th>Catatan</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Aksi</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($penyedia as $row): 
                                        // === formated tanggal indonesia === //
                                            $tanggal_dari_db = $row['dibuat_di']; // Misal: "2025-06-12 10:30:00"
                                            $nama_bulan = array(
                                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                            );

                                            $timestamp = strtotime($tanggal_dari_db);
                                            $tanggal = date('d', $timestamp); // Ambil tanggal (contoh: 12)
                                            $bulan_angka = date('m', $timestamp); // Ambil angka bulan (contoh: 06)
                                            $tahun = date('Y', $timestamp); // Ambil tahun (contoh: 2025)

                                            $bulan_indonesia = $nama_bulan[$bulan_angka]; // Konversi angka bulan ke nama Indonesia
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_penyedia'] ?></td>
                                            <td><?= $row['no_telp'] ?></td>
                                            <td><?= $row['alamat'] ?></td>
                                            <td>0</td>
                                            <td><?= !empty($row['catatan']) ? $row['catatan'] : '-' ?></td>
                                            <td><?= $tanggal . ' ' . $bulan_indonesia . ' ' . $tahun ?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" href="<?= base_url('admin/penyedia/edited/'.$row['id_penyedia']) ?>">
                                                    <i class="fas fa-edit"></i> 
                                                </a>
                                               <form action="<?= base_url('admin/penyedia/delete/'.$row['id_penyedia']) ?>" method="post" style="display:inline;" class="form-delete">
                                                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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

    <script>
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // stop form submit dulu

                Swal.fire({
                    title: 'Yakin hapus data?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kalau user klik "Ya", submit form secara manual
                        form.submit();
                    }
                });
            });
        });
    </script>


</body>
</html>