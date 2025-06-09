<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card my-5">
                <form action="<?= base_url('auth/loginAdmin') ?>" method="POST" class="card-body p-lg-5">
                    <!-- === component breadcrumb === -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="">Masuk</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Admin</li>
                        </ol>
                    </nav>

                    <!-- === component alert === -->
                    <?php if ($this->session->flashdata('message')): ?>
                        <?= $this->session->flashdata('message'); ?>
                    <?php endif; ?>


                    <!-- === profile image === -->
                    <div class="text-center">
                        <img src="https://i.pinimg.com/736x/13/44/88/1344881a0b7b7b4a766621adbaafa811.jpg"
                            class="img-fluid img-thumbnail rounded-circle my-3"
                            width="200px" alt="Foto Profil Admin">
                    </div>

                    <!-- === input role admin === -->
                    <input type="hidden" name="akses" value="admin">

                    <!-- === nama input === -->
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda" required>
                    </div>

                    <!-- === password input === -->
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi Anda" required>
                            <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <!-- === Submit Button === -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.classList.remove("bi-eye");
      toggleIcon.classList.add("bi-eye-slash");
    } else {
      passwordInput.type = "password";
      toggleIcon.classList.remove("bi-eye-slash");
      toggleIcon.classList.add("bi-eye");
    }
  }
</script>
