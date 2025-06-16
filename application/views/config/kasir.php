<body id="page-top">
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include('components/sidebar.php'); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <!-- Navbar -->
        <?php include('components/navbar.php'); ?>

        <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800">Kasir Obat</h1>

          <!-- Flash Message -->
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
              <div><?= $this->session->flashdata('success'); ?></div>
              <i class="fas fa-times text-dark ms-3" style="cursor:pointer;" onclick="this.closest('.alert').remove();"></i>
            </div>
          <?php endif; ?>

          <!-- Card Form -->
          <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6 class="m-0 font-weight-bold text-primary">Form Transaksi Obat</h6>
            </div>

            <div class="card-body">
              <!-- Obat Selector -->
              <div class="mb-3">
                <label for="obat-select">Cari dan Tambahkan Obat</label>
                <select id="obat-select" class="form-control" style="width:100%;">
                  <option value="">Pilih Obat</option>
                  <?php foreach ($obat as $o): ?>
                    <option 
                      value="<?= $o['id_produk_obat'] ?>"
                      data-nama="<?= $o['nama'] ?>"
                      data-harga="<?= $o['harga_penjualan'] ?>"
                      data-stok="<?= $o['stok'] ?>">
                      <?= $o['nama'] ?> - Stok: <?= $o['stok'] ?> - Rp <?= number_format($o['harga_penjualan'], 0, ',', '.') ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <button onclick="tambahObat()" class="btn btn-primary mt-2">Tambah ke Keranjang</button>
              </div>

              <!-- Form Transaksi -->
              <form id="form-transaksi" method="post" action="<?= base_url('config/kasir/simpan_transaksi') ?>">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>Nama Obat</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="keranjang-body"></tbody>
                  </table>
                </div>

                <!-- Total Bayar -->
                <p class="font-weight-bold mt-3">Total: Rp <span id="total">0</span></p>
                <input type="text" name="bayar" class="form-control mb-2" placeholder="Jumlah Bayar" required 
    oninput="formatRupiah(this, 'Rp. '); hitungKembalian(this.value)">

                <p class="font-weight-bold">Kembalian: <span id="kembalian">0</span></p>

                <input type="hidden" name="total_hidden" id="total_hidden">
                <input type="hidden" name="keranjang_data" id="keranjang_data">

                <button type="submit" class="btn btn-success btn-block mt-3">Simpan Transaksi</button>
              </form>
            </div>
          </div>

        </div><!-- .container-fluid -->
      </div><!-- #content -->
    </div><!-- #content-wrapper -->
  </div><!-- #wrapper -->

  <!-- Scroll to Top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Yakin ingin keluar?</h5>
          <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">Klik "Logout" untuk keluar dari sesi ini.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
  <script src="<?= base_url('vendor/startbootstrap-sb-admin-2-gh-pages/js/sb-admin-2.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function formatRupiah(el, prefix) {
    let number_string = el.value.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa  = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // Tambahkan titik jika ada ribuan
    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

    el.value = prefix + rupiah;
}
</script>
  <script>
    $(function() {
      $('#obat-select').select2();
    });

    let keranjang = [];

    function tambahObat() {
      const select = $('#obat-select option:selected');
      const id = select.val();
      const nama = select.data('nama');
      const harga = parseInt(select.data('harga'));
      const stok = parseInt(select.data('stok'));

      if (!id) return;

      const index = keranjang.findIndex(item => item.id === id);
      if (index >= 0) {
        if (keranjang[index].qty < stok) keranjang[index].qty++;
      } else {
        keranjang.push({ id, nama, harga, qty: 1 });
      }

      renderKeranjang();
    }

    function renderKeranjang() {
      let html = '', total = 0;

      keranjang.forEach((item, i) => {
        const subtotal = item.harga * item.qty;
        total += subtotal;
        html += `
          <tr>
            <td>${item.nama}</td>
            <td>Rp ${item.harga.toLocaleString()}</td>
            <td><input type="number" min="1" value="${item.qty}" onchange="ubahQty(${i}, this.value)"></td>
            <td>Rp ${subtotal.toLocaleString()}</td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusItem(${i})">Hapus</button></td>
          </tr>`;
      });

      $('#keranjang-body').html(html);
      $('#total').text(total.toLocaleString());
      $('#total_hidden').val(total);
      $('#keranjang_data').val(JSON.stringify(keranjang));
    }

    function ubahQty(index, qty) {
      qty = parseInt(qty);
      if (qty > 0) {
        keranjang[index].qty = qty;
        renderKeranjang();
      }
    }

    function hapusItem(index) {
      keranjang.splice(index, 1);
      renderKeranjang();
    }

    function hitungKembalian(bayarFormatted) {
    // Hilangkan 'Rp.' dan titik ribuan
    let bayar = bayarFormatted.replace(/[^0-9]/g, '');
    bayar = parseInt(bayar || 0);

    const total = parseInt($('#total_hidden').val() || 0);
    const kembalian = bayar - total;

    $('#kembalian').text('Rp ' + kembalian.toLocaleString('id-ID'));
}

  </script>
</body>
