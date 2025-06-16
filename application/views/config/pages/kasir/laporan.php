<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">

    <?php include(APPPATH . 'views/config/components/sidebar.php'); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php include(APPPATH . 'views/config/components/navbar.php'); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
                <p class="mb-4"><?= $subTitle ?></p>

                <!-- Summary Cards -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-3">
                            <div class="card-body">
                                <h5>Total Pendapatan Hari Ini</h5>
                                <h3>Rp <?= number_format($total_today ?? 0, 0, ',', '.') ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow mb-3">
                            <div class="card-body">
                                <h5>Total Pendapatan Keseluruhan</h5>
                                <h3>Rp <?= number_format($total_all ?? 0, 0, ',', '.') ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Transaksi Table -->
                <div class="card shadow mb-4">
            <form method="GET" action="<?= base_url('config/kasir/laporan_pdf') ?>" target="_blank" class="mb-3 px-3 py-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            <?php for ($b = 1; $b <= 12; $b++): ?>
                                <option value="<?= $b ?>"><?= date('F', mktime(0, 0, 0, $b, 1)) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="tahun" class="form-control">
                            <option value="">-- Pilih Tahun --</option>
                            <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('config/kasir/laporan_pdf?all=1') ?>" target="_blank" class="btn btn-secondary">
                            <i class="fas fa-file-alt"></i> Export Semua Data
                        </a>
                    </div>
                </div>
            </form>



                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Kasir</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksi as $t): ?>
                                    <tr>
                                        <td><?= $t['transaksi_kode'] ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($t['tanggal_transaksi'])) ?></td>
                                        <td><?= $t['nama'] ?></td>
                                        <td>Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></td>
                                        <td>
                                            <a href="<?= base_url('config/kasir/cetak_struk/' . $t['transaksi_kode']) ?>" target="_blank" class="btn btn-sm btn-primary">
                                                Struk
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Statistik Penjualan (Dummy Chart) -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik Penjualan Obat</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
            <!-- End Page Content -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Apotek App <?= date('Y') ?></span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: <?= $chart_data ?>,
                borderColor: 'rgba(78, 115, 223, 1)',
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js') ?>"></script>
</body>
