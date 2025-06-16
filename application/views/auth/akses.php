<!-- === Stylish Role Selection Section === -->
<section class="container d-flex align-items-center justify-content-center min-vh-100 ">
  <div class="row w-100  p-5" >
    
    <!-- === Akses Buttons with modern style === -->
    <div class="col-lg-6 d-flex flex-column justify-content-center gap-4 px-4">
      <h2 class="fw-bold mb-4">Masuk Sebagai</h2>

      <!--  === akses admin  === -->
      <button onclick="window.location.href='<?= base_url('auth/loginAdmin') ?>'" 
              class="btn btn-lg rounded-4 d-flex align-items-center justify-content-start gap-3 px-4 py-3 text-white shadow-sm border-0"
              style="background: linear-gradient(135deg, #6C63FF, #8E85F3);">
        <i class="bi bi-person-badge fs-4"></i>
        <span class="fs-5">Admin</span>
      </button>

      <!--  === akses kasir  === -->
      <button onclick="window.location.href='<?= base_url('auth/loginKasir') ?>'" 
              class="btn btn-lg rounded-4 d-flex align-items-center justify-content-start gap-3 px-4 py-3 text-white shadow-sm border-0"
              style="background: linear-gradient(135deg, #00B894, #00CEC9);">
        <i class="bi bi-cash-stack fs-4"></i>
        <span class="fs-5">Kasir</span>
      </button>

      <!--  === akses owner  === -->
      <button onclick="window.location.href='<?= base_url('auth/loginOwner') ?>'" 
              class="btn btn-lg rounded-4 d-flex align-items-center justify-content-start gap-3 px-4 py-3 text-dark shadow-sm border-0"
              style="background: linear-gradient(135deg, #FFEAA7, #FAB1A0);">
        <i class="bi bi-person-check fs-4"></i>
        <span class="fs-5">Owner</span>
      </button>
    </div>

    <!-- === Lottie Animation Section === -->
    <div class="col-lg-6 d-flex justify-content-center align-items-center">
      <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
      <dotlottie-player 
        src="https://lottie.host/9b8d5798-b2fe-45bd-a53a-a69152c23105/3ETyFIDua5.lottie" 
        background="transparent" 
        speed="1"  
        loop autoplay></dotlottie-player>
    </div>
  </div>
</section>
