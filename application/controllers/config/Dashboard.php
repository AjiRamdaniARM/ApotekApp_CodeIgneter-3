<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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

    // Ambil data pengguna dari session
    $email = $this->session->userdata('email');
    $pengguna = $this->db->get_where('pengguna', ['email' => $email])->row_array();

    $data['pengguna'] = $pengguna;
    $akses = $pengguna['akses'];

    // Buat subtitle sesuai role
    if ($akses === 'admin') {
        $data['subTitle'] = 'Dashboard Admin';
    } elseif ($akses === 'kasir') {
        $data['subTitle'] = 'Dashboard Kasir';
    } elseif ($akses === 'owner') {
        $data['subTitle'] = 'Dashboard Owner';
    } else {
        show_error('Akses tidak dikenali.');
    }

    // Semua role dapat lihat total transaksi & pendapatan
    $today = date('Y-m-d');

    $data['total_today'] = $this->db->select_sum('total_harga')
        ->where('DATE(tanggal_transaksi)', $today)
        ->get('transaksi')->row()->total_harga ?? 0;

    $data['total_all'] = $this->db->select_sum('total_harga')
        ->get('transaksi')->row()->total_harga ?? 0;

    // Data khusus admin
    if ($akses === 'admin' || 'owner') {
        $data['total_obat'] = $this->db->count_all('obat');
        $data['stok_habis'] = $this->db->where('stok', 0)->count_all_results('obat');
        $data['total_transaksi'] = $this->db->count_all('transaksi');

        // Data chart pendapatan per bulan
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
        $data['chart_labels'] = json_encode([
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ]);
    }

    // Load view sesuai role
    $this->load->view('config/components/header', $data);

    if ($akses === 'admin') {
        $this->load->view('config/index', $data);
    } elseif ($akses === 'kasir') {
        $this->load->view('config/kasir', $data);
    } elseif ($akses === 'owner') {
        $this->load->view('config/index', $data);
    }

}

    public function logout() {
 		$this->session->sess_destroy();
		$this->session->set_flashdata('logout', 'Anda telah berhasil logout.');
		redirect('auth');
	}
   
}
