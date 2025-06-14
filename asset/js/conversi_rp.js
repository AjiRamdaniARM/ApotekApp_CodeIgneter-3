
            const hargaInput = document.getElementById('harga_pembelian');
    const hargaJual = document.getElementById('harga_jual');

    function formatRupiah(input) {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^,\d]/g, '');
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            this.value = 'Rp ' + rupiah;
        });
    }

    // Jalankan format rupiah di dua input
    formatRupiah(hargaInput);
    formatRupiah(hargaJual);

    // Bersihkan format saat form disubmit
    document.querySelector('form').addEventListener('submit', function () {
        hargaInput.value = hargaInput.value.replace(/[^0-9]/g, '');
        hargaJual.value = hargaJual.value.replace(/[^0-9]/g, '');
    });
    