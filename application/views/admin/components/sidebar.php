    <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">APOTEK APP</div>
            </a>

             <!-- Heading -->
            <div class="sidebar-heading">
                Administrator
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/admin') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Nav Penyedia Item -->
             <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/penyedia') ?>">
                   <i class="fa-solid fa-boxes-packing"></i>
                    <span>Penyedia</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Profile
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('admin/profile') ?>">
                    <i class="fas fa-user"></i>
                    <span>Profile Saya</span>
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- logout button -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('admin/admin/logout ') ?>">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Keluar Akun</span>
                </a>
            </li>

        
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->