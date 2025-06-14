<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // (opsional) load library/session/model di sini
        $this->load->library('session');
        $this->load->library('form_validation');
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

        // Ambil data obat dari database
        $data['obat'] = $this->db->get('obat')->result_array();

        // Tampilkan halaman kasir
        $this->load->view('admin/components/header', $data);
        $this->load->view('admin/kasir', $data);
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

    // Simpan ke tabel transaksi
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

    // Simpan detail transaksi
    foreach ($keranjang as $item) {
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

        // Update stok obat
        $this->db->set('stok', 'stok - ' . $item['qty'], FALSE)
                 ->where('id_produk_obat', $item['id'])
                 ->update('obat');
    }

    // Redirect ke struk
    $this->session->set_flashdata('success', 'Transaksi berhasil disimpan!');
    redirect('admin/kasir/cetak_struk/' . $kode_transaksi);
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

    $this->load->view('admin/pages/kasir/struk', $data);
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
        ->order_by('tanggal_transaksi', 'DESC')
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

    $this->load->view('admin/components/header', $data);
    $this->load->view('admin/pages/kasir/laporan', $data);
}




   
}
