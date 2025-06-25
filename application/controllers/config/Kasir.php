<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // (opsional) load library/session/model di sini
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('transaksi');
        $this->load->model('detail_transaksi');
		$this->load->database(); 
    }

    public function index()
    {
        $data['title'] = 'Kasir Obat'; // === untuk header halaman
        $data['subTitle'] = 'Kasir Penjualan Obat';

        // Ambil data pengguna yang sedang login
        $data['pengguna'] = $this->db->get_where('pengguna', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        // Ambil data obat dari database yang status-nya 'terima' dan belum expired
        $today = date('Y-m-d');
        $this->db->where('status', 'terima');
        $this->db->where('tanggak_kadaluarsa >=', $today);
        $data['obat'] = $this->db->get('obat')->result_array();


        // Tampilkan halaman kasir
        $this->load->view('config/components/header', $data);
        $this->load->view('config/kasir', $data);
    }
    public function simpan_transaksi()
    {
        $keranjang = json_decode($this->input->post('keranjang_data'), true);
        $total_harga = $this->input->post('total_hidden');
        $bayar = str_replace(['Rp.', '.', ' '], '', $this->input->post('bayar'));
        $id_pengguna = $this->session->userdata('id_pengguna');
        $tanggal_sekarang = date('Y-m-d H:i:s');

        // Generate kode transaksi unik
        $kode_transaksi = 'TRX' . date('YmdHis') . rand(100, 999);

        // ======= CEK STOK DULU SEBELUM SIMPAN TRANSAKSI =======
        foreach ($keranjang as $item) {
            $obat = $this->db->get_where('obat', ['id_produk_obat' => $item['id']])->row();
            if ($obat->stok < $item['qty']) {
                $this->session->set_flashdata('error', 'Stok tidak cukup untuk obat: ' . $obat->nama_obat);
                redirect('config/kasir'); // batalkan transaksi
                return;
            }
        }

        // ======= SIMPAN TRANSAKSI UTAMA =======
        $transaksi_data = [
            'transaksi_kode' => $kode_transaksi,
            'id_pengguna' => $id_pengguna,
            'total_harga' => $total_harga,
            'bayar' => $bayar,
            'metode_pembayaran' => 'Tunai',
            'tanggal_transaksi' => $tanggal_sekarang,
            'dibuat_di' => $tanggal_sekarang,
            'diperbarui_di' => $tanggal_sekarang,
        ];
        $this->db->insert('transaksi', $transaksi_data);

        // ======= SIMPAN DETAIL & KURANGI STOK =======
        foreach ($keranjang as $item) {
            // Simpan detail transaksi
            $detail = [
                'transaksi_kode' => $kode_transaksi,
                'id_produk_obat' => $item['id'],
                'harga' => $item['harga'],
                'jumlah' => $item['qty'],
                'total' => $item['harga'] * $item['qty'],
                'dibuat_di' => $tanggal_sekarang,
                'diperbarui_di' => $tanggal_sekarang,
            ];
            $this->db->insert('detail_transaksi', $detail);

            // Kurangi stok secara aman
            $obat = $this->db->get_where('obat', ['id_produk_obat' => $item['id']])->row();
            $sisa_stok = max(0, $obat->stok - $item['qty']);

            $this->db->set('stok', $sisa_stok)
                    ->where('id_produk_obat', $item['id'])
                    ->update('obat');
        }

        // Redirect ke struk
        $this->session->set_flashdata('success', 'Transaksi berhasil disimpan!');
        redirect('config/kasir/cetak_struk/' . $kode_transaksi);
    }


public function cetak_struk($kode_transaksi)
{
    // Ambil data transaksi
    $transaksi = $this->db->get_where('transaksi', ['transaksi_kode' => $kode_transaksi])->row_array();

    // Ambil data detail transaksi
    $this->db->select('d.*, o.nama');
    $this->db->from('detail_transaksi d');
    $this->db->join('obat o', 'o.id_produk_obat = d.id_produk_obat');
    $this->db->where('d.transaksi_kode', $kode_transaksi);
    $detail = $this->db->get()->result_array();

    $data['transaksi'] = $transaksi;
    $data['detail'] = $detail;

    $this->load->view('config/pages/kasir/struk', $data);
}

public function laporan()
{
    $data['title'] = 'Laporan Kasir';
    $data['subTitle'] = 'Riwayat Transaksi & Pendapatan';
    $data['pengguna'] = $this->db->get_where('pengguna', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    // Ambil semua transaksi
    $data['transaksi'] = $this->db->select('t.*, p.nama')
        ->from('transaksi t')
        ->join('pengguna p', 't.id_pengguna = p.id_pengguna')
        ->order_by('dibuat_di', 'DESC')
        ->get()->result_array();

    // Hitung total pendapatan hari ini
    $today = date('Y-m-d');
    $data['total_today'] = $this->db->select_sum('total_harga')
        ->where('DATE(tanggal_transaksi)', $today)
        ->get('transaksi')->row()->total_harga ?? 0;

    // Total semua pendapatan
    $data['total_all'] = $this->db->select_sum('total_harga')->get('transaksi')->row()->total_harga ?? 0;

    // Data pendapatan per bulan (12 bulan)
    $monthly = [];
    for ($i = 1; $i <= 12; $i++) {
        $month = str_pad($i, 2, '0', STR_PAD_LEFT);
        $year = date('Y');

        $start = "$year-$month-01";
        $end = date("Y-m-t", strtotime($start));

        $total = $this->db->select_sum('total_harga')
            ->where("tanggal_transaksi >=", $start)
            ->where("tanggal_transaksi <=", $end)
            ->get('transaksi')->row()->total_harga;

        $monthly[] = $total ? (int)$total : 0;
    }
    $data['chart_data'] = json_encode($monthly);

    $this->load->view('config/components/header', $data);
    $this->load->view('config/pages/kasir/laporan', $data);
}


public function laporan_pdf()
{
    $bulan = $this->input->get('bulan');
    $tahun = $this->input->get('tahun');

    $this->db->select('t.*, p.nama');
    $this->db->from('transaksi t');
    $this->db->join('pengguna p', 't.id_pengguna = p.id_pengguna');

    if (!empty($bulan) && !empty($tahun)) {
        $this->db->where('MONTH(tanggal_transaksi)', $bulan);
        $this->db->where('YEAR(tanggal_transaksi)', $tahun);
    }

    $data['transaksi'] = $this->db->order_by('tanggal_transaksi', 'DESC')->get()->result_array();

    $today = date('Y-m-d');
    $data['total_today'] = $this->db->select_sum('total_harga')
        ->where('DATE(tanggal_transaksi)', $today)
        ->get('transaksi')->row()->total_harga ?? 0;

    $data['total_all'] = $this->db->select_sum('total_harga')->get('transaksi')->row()->total_harga ?? 0;

    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;

    $html = $this->load->view('config/pages/kasir/laporan_pdf', $data, true);

    $this->load->library('dompdf_gen');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4', 'portrait');
    $this->dompdf->render();
    $this->dompdf->stream("laporan_transaksi.pdf", array("Attachment" => false));
}

public function hapus($kode_transaksi)
{
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
        // Cek apakah data transaksi dan detailnya ada
        $transaksi = $this->db->get_where('transaksi', ['transaksi_kode' => $kode_transaksi])->row_array();

        if ($transaksi) {
            // Hapus detail transaksi terlebih dahulu (jika banyak, pakai delete where)
            $this->db->delete('detail_transaksi', ['transaksi_kode' => $kode_transaksi]);

            // Hapus transaksi utama
            $this->db->delete('transaksi', ['transaksi_kode' => $kode_transaksi]);

            $this->session->set_flashdata('success', 'Data transaksi berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Data transaksi tidak ditemukan.');
        }
    } else {
        show_error('Metode tidak diizinkan', 405);
    }

    redirect('config/kasir/laporan');
}





   
}
