<section class="container d-flex align-items-center min-vh-100">
    <div class="row w-100">
       <!-- === component all button akses === -->
        <div class="col-lg-6 d-flex flex-column justify-content-center gap-5">
            <button onclick="window.location.href='<?= base_url('auth/loginAdmin') ?>'" class="btn bg-blue-1 text-white d-flex align-items-center gap-2 p-4">
                <i class="bi bi-person-badge"></i> Admin
            </button>
            <button onclick="window.location.href='<?= base_url('login/kasir') ?>'" class="btn bg-green-1 text-white d-flex align-items-center gap-2 p-4">
                <i class="bi bi-cash-stack"></i> Kasir
            </button>
            <button onclick="window.location.href='<?= base_url('login/owner') ?>'"  class="btn btn-warning d-flex align-items-center gap-2 p-4">
                <i class="bi bi-person-check"></i> Owner
            </button>
        </div>
        <!-- === component gambar === -->
        <div class="col-lg-6 d-flex justify-content-center">
            <img src="<?= base_url('asset/'); ?>img/png-illustrasi-akses.png" class=" w-75" alt="Hero Image">
        </div>
    </div>
</section>

<!-- === kode style css internal === -->
 <style>
  .bg-green-1 {
    background-color: #355B64;
    transition: background-color 0.3s ease-in-out;
    }
    .bg-green-1:hover {
        background-color: #2A474F; /* Warna lebih gelap saat hover */
    }

    .bg-blue-1 {
        background-color: #205C9A;
        transition: background-color 0.3s ease-in-out;
    }
    .bg-blue-1:hover {
        background-color: #174678; /* Warna lebih gelap saat hover */
    }

 </style>