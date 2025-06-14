<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
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
    $data['title'] = 'Dashboard';
    $data['subTitle'] = 'Dashboard Admin';
    $data['pengguna'] = $this->db->get_where('pengguna', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    // Total pendapatan hari ini
$today = date('Y-m-d'); // ambil tanggal hari ini, misal: 2025-06-14
$data['total_today'] = $this->db->select_sum('total_harga') // total dari kolom total_harga
    ->where('DATE(tanggal_transaksi)', $today) // hanya ambil yang tanggalnya hari ini
    ->get('transaksi') // dari tabel transaksi
    ->row()->total_harga ?? 0; // ambil hasilnya, default 0 jika tidak ada

// Total semua pendapatan dari semua transaksi
$data['total_all'] = $this->db->select_sum('total_harga') // hitung semua total_harga
    ->get('transaksi') // dari tabel transaksi
    ->row()->total_harga ?? 0; // default 0 kalau kosong


    // Total Obat
    $data['total_obat'] = $this->db->count_all('obat');

    // Stok Habis
    $data['stok_habis'] = $this->db->where('stok', 0)->count_all_results('obat');

    // Total Transaksi
    $data['total_transaksi'] = $this->db->count_all('transaksi');

    // Total Pendapatan Hari Ini
    $today = date('Y-m-d');
    $data['total_today'] = $this->db->select_sum('total_harga')
        ->where('DATE(tanggal_transaksi)', $today)
        ->get('transaksi')->row()->total_harga ?? 0;

    // Total Semua Pendapatan
    $data['total_all'] = $this->db->select_sum('total_harga')->get('transaksi')->row()->total_harga ?? 0;

    // Data Pendapatan per Bulan (12 bulan terakhir)
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

    // Label bulan untuk chart (Jan, Feb, ...)
    $data['chart_labels'] = json_encode([
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ]);

    // Load view
    $this->load->view('admin/components/header', $data);
    $this->load->view('admin/index', $data);
}



    public function logout() {
 		$this->session->sess_destroy();
		$this->session->set_flashdata('logout', 'Anda telah berhasil logout.');
		redirect('auth');
	}
   
}
