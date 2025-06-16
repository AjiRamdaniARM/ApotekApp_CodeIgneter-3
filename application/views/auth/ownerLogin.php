<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 p-4">

                <!-- === Breadcrumb === -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb bg-light rounded-pill px-3 py-2">
                        <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="#">Masuk</a></li>
                        <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Owner</li>
                    </ol>
                </nav>

                <!-- === Flash Message === -->
                <?php if ($this->session->flashdata('message')): ?>
                    <?= $this->session->flashdata('message'); ?>
                <?php endif; ?>

                <!-- === Profile Image === -->
                <div class="text-center mb-4">
                    <img src="https://i.pinimg.com/736x/13/44/88/1344881a0b7b7b4a766621adbaafa811.jpg"
                        class="rounded-circle  shadow" 
                        style="width: 120px; height: 120px; object-fit: cover; margin-left: 11em"
                        alt="Foto Profil Admin">
                    <h5 class="mt-3 fw-semibold text-primary">Login Owner</h5>
                </div>


                <!-- === Form === -->
                <form action="<?= base_url('auth/loginAdmin') ?>" method="POST" class="px-1">

                    <!-- Hidden Role -->
                    <input type="hidden" name="akses" value="owner">

                    <!-- Email -->
                    <div class="mb-3" style="display: none;">
                        <label for="email" class="form-label text-muted">Email</label>
                        <input type="email" value="<?= $email['email'] ?>" class="form-control rounded-pill px-4 py-2" name="email" id="email" placeholder="Email Anda" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <div class="input-group">
                            <input type="password" class="form-control rounded-start-pill px-4 py-2" id="password" name="password" placeholder="Kata Sandi Anda" required>
                            <span class="input-group-text rounded-end-pill" onclick="togglePassword()" style="cursor: pointer;">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(32, 92, 154, 0.25);
        border-color: #205C9A;
    }

    .breadcrumb {
        font-size: 0.85rem;
        background-color: #f5f8ff;
    }

    .card {
        background-color: #ffffff;
        transition: 0.3s ease-in-out;
    }

    .btn-primary {
        background-color: #205C9A;
        border-color: #205C9A;
    }

    .btn-primary:hover {
        background-color: #174678;
        border-color: #174678;
    }
</style>
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