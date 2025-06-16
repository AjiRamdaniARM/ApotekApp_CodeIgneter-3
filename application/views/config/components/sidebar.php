<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">APOTEK APP</div>
    </a>

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">



    <?php if ($this->session->userdata('akses') == 'admin'): ?>
        <!-- Menu khusus ADMIN -->
         
         <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/dashboard') ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Beranda</span>
            </a>
         </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/penyedia') ?>">
                <i class="fa-solid fa-boxes-packing"></i>
                <span>Penyedia</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/obat') ?>">
                <i class="fa-solid fa-pills"></i>
                <span>Obat</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/kasir') ?>">
                <i class="fa-solid fa-cash-register"></i>
                <span>Kasir</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/kasir/laporan') ?>">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>Laporan</span>
            </a>
        </li>

    <?php elseif ($this->session->userdata('akses') == 'kasir'): ?>
        <!-- Menu khusus KASIR -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/kasir') ?>">
                <i class="fa-solid fa-cash-register"></i>
                <span>Transaksi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/kasir/laporan') ?>">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>Laporan</span>
            </a>
        </li>

    <?php elseif ($this->session->userdata('akses') == 'owner'): ?>
       
        <!-- Menu khusus OWNER -->
         <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/admin') ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/kasir/laporan') ?>">
                <i class="fa-solid fa-file-lines"></i>
                <span>Laporan Penjualan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('config/obat') ?>">
                <i class="fa-solid fa-capsules"></i>
                <span>Data Obat</span>
            </a>
        </li>
    <?php endif; ?>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Profile
    </div>

    <!-- Nav Item - Profile -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('config/profile') ?>">
            <i class="fas fa-user"></i>
            <span>Profile Saya</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('config/dashboard/logout') ?>">
            <i class="fas fa-right-from-bracket"></i>
            <span>Keluar Akun</span>
        </a>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
