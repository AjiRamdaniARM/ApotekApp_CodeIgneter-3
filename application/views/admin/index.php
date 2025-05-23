<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
       <?php include('components/sidebar.php') ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
              
                <!-- End of Topbar -->
                    <?php include('components/navbar.php') ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard Apotek</h1>

    <!-- Cards Row -->
    <div class="row">

        <!-- Total Obat -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Obat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">120</div>
                    </div>
                    <i class="fas fa-pills fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Stok Habis -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Stok Habis</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">340</div>
                    </div>
                    <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Statistik Penjualan Obat</h6>
        </div>
        <div class="card-body">
            <canvas id="salesChart" width="100%" height="40"></canvas>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Penjualan Obat',
                data: [50, 75, 60, 90, 100, 120],
                borderColor: 'rgba(78, 115, 223, 1)',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

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