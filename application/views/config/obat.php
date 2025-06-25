
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
                            <h6 class="m-0 font-weight-bold text-primary"><?= $subTitle ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <a href="<?= base_url('config/obat/create') ?>" class="btn btn-primary">Tambah Data</a>
                                <form method="GET" class="form-inline">

                                    <!-- Keyword Pencarian -->
                                    <input 
                                        type="search" 
                                        name="keyword" 
                                        value="<?= $this->input->get('keyword'); ?>" 
                                        placeholder="Cari..." 
                                        class="form-control mr-2"
                                    >

                                    <!-- Filter Tanggal -->
                                    <input 
                                        type="date" 
                                        name="tanggal_masuk" 
                                        value="<?= $this->input->get('tanggal_masuk'); ?>" 
                                        class="form-control mr-2"
                                    >

                                    <!-- Filter Status -->
                                    <select name="status" class="form-control mr-2">
                                        <option value="">-- Semua Status --</option>
                                        <option value="terima" <?= $this->input->get('status') == 'terima' ? 'selected' : '' ?>>Terima</option>
                                        <option value="proses" <?= $this->input->get('status') == 'proses' ? 'selected' : '' ?>>Proses</option>
                                        <option value="tolak" <?= $this->input->get('status') == 'tolak' ? 'selected' : '' ?>>Tolak</option>
                                    </select>

                                    <!-- Tombol Cetak PDF -->
                                    <a href="<?= base_url('config/obat/report_pdf?keyword=' . $this->input->get('keyword') . '&tanggal_masuk=' . $this->input->get('tanggal_masuk') . '&status=' . $this->input->get('status')) ?>" target="_blank" class="btn btn-danger mr-2">
                                        Cetak PDF
                                    </a>

                                    <!-- Tombol Cari -->
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
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>ID Kategori</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Tipe Obat</th>
                            <th>Penyedia</th>
                            <th>Status</th>
                            <th>Tanggal Masuk</th>
                            <th>Expired</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                  <tbody>
                    <?php if (!empty($obat)) : ?>
                        <?php $no = 1; foreach ($obat as $row) :
                            // Format tanggal masuk dan tanggal kadaluarsa
                            $tanggal_dibuat_obj = date_create($row['tanggal_masuk']);
                            $tanggal_kadaluarsa_obj = date_create($row['tanggak_kadaluarsa']);

                            $tanggal_dibuat = date_format($tanggal_dibuat_obj, 'd');
                            $bulan_dibuat = date_format($tanggal_dibuat_obj, 'm');
                            $tahun_dibuat = date_format($tanggal_dibuat_obj, 'Y');

                            $tanggal_kadaluarsa = date_format($tanggal_kadaluarsa_obj, 'd');
                            $bulan_kadaluarsa = date_format($tanggal_kadaluarsa_obj, 'm');
                            $tahun_kadaluarsa = date_format($tanggal_kadaluarsa_obj, 'Y');

                            $bulan_indonesia = [
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];

                            $tgl_dibuat_format = $tanggal_dibuat . ' ' . $bulan_indonesia[$bulan_dibuat] . ' ' . $tahun_dibuat;
                            $tgl_kadaluarsa_format = $tanggal_kadaluarsa . ' ' . $bulan_indonesia[$bulan_kadaluarsa] . ' ' . $tahun_kadaluarsa;

                            // Tentukan status (cek expired)
                            $status = strtolower($row['status']);
                            $today = date('Y-m-d');

                            // Jika kadaluarsa sudah lewat, ubah status ke 'expired'
                            if (strtotime($row['tanggak_kadaluarsa']) < strtotime($today)) {
                                $status = 'expired';
                            }

                            // Badge color
                            $badgeColor = 'gray'; // default
                            $textColor = 'white';

                            if ($status == 'terima') {
                                $badgeColor = 'green';
                            } elseif ($status == 'proses') {
                                $badgeColor = 'orange';
                            } elseif ($status == 'tolak') {
                                $badgeColor = 'red';
                            } elseif ($status == 'expired') {
                                $badgeColor = '#6c757d'; // abu-abu gelap (dark gray)
                            }
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['kode_obat']; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['nama_tipe']; ?></td>
                                <td>Rp<?= number_format($row['harga_pembelian'], 0, ',', '.'); ?></td>
                                <td>Rp<?= number_format($row['harga_penjualan'], 0, ',', '.'); ?></td>
                                <td><?= $row['stok']; ?></td>
                                <td><?= $row['tipe_obat']; ?></td>
                                <td><?= $row['nama_penyedia']; ?></td>
                                <td>
                                    <span style="
                                        background-color: <?= $badgeColor ?>;
                                        color: <?= $textColor ?>;
                                        padding: 4px 10px;
                                        border-radius: 999px;
                                        font-size: 12px;
                                        font-weight: bold;
                                        display: inline-block;
                                        text-transform: capitalize;
                                    ">
                                        <?= $status ?>
                                    </span>
                                </td>
                                <td><?= $tgl_dibuat_format ?></td>
                                <td><?= $tgl_kadaluarsa_format ?></td>
                                <td>
                                    <a href="<?= base_url('config/obat/edited/' . $row['id_produk_obat']); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('config/obat/delete/' . $row['id_produk_obat']); ?>" method="post" class="d-inline form-delete" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="13" class="text-center">Tidak ada data obat ditemukan.</td>
                        </tr>
                    <?php endif; ?>
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