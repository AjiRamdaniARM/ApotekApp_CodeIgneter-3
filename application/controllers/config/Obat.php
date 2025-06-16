<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // (opsional) load library/session/model di sini
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Obat_model'); // Pastikan ini ada
        $this->load->model('barang_masuk'); // Pastikan ini ada
		$this->load->database(); 
    }

    public function index()
    {
        $keyword = $this->input->get('keyword');
        $status = $this->input->get('status');
        $tanggal_masuk = $this->input->get('tanggal_masuk');
        $this->db->select('obat.*, kategori_obat.nama_tipe,barang_masuk.*,penyedia.*,barang_masuk.dibuat_di as tanggal_masuk');
        $this->db->from('obat');
        $this->db->join('kategori_obat', 'kategori_obat.id_kategori_obat = obat.id_kategori_obat');
        $this->db->join('barang_masuk', 'barang_masuk.kode_obat = obat.kode_obat');
        $this->db->join('penyedia', 'penyedia.id_penyedia = barang_masuk.id_penyedia');
        if (!empty($keyword)) {
            $this->db->like('obat.nama', $keyword);
        }
       if (!empty($tanggal_masuk)) {
            $this->db->where('DATE(barang_masuk.dibuat_di)', $tanggal_masuk);
        }
       if (!empty($status)) {
            $this->db->where('obat.status', $status);
        }

        $data['obat'] = $this->db->get()->result_array();

        $data['title'] = 'Data Obat';
        $data['subTitle'] = 'Pengelolaan Data Obat';
        $data['pengguna'] = $this->db->get_where('pengguna',['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('config/components/header', $data);
        $this->load->view('config/obat', $data);
    }

    public function create() {
        $data['title'] = 'Data create';
        $data['subTitle'] = 'Create Data Obat';
        $data['kategori'] = $this->db->get('kategori_obat')->result_array(); // ambil semua kategori
        $data['penyedia'] = $this->db->get('penyedia')->result_array(); // ambil semua kategori
        $data['pengguna'] = $this->db->get_where('pengguna',['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('config/components/header', $data);
        $this->load->view('config/pages/obat/create', $data);
    }

private function generate_kode_obat() {
    $this->db->select('RIGHT(obat.kode_obat, 4) as kode', false);
    $this->db->order_by('kode_obat', 'DESC');
    $this->db->limit(1);
    $query = $this->db->get('obat'); // ambil data terakhir

    if ($query->num_rows() > 0) {
        $data = $query->row();
        $kode = intval($data->kode) + 1;
    } else {
        $kode = 1; // jika belum ada data
    }

    $kode_max = str_pad($kode, 4, "0", STR_PAD_LEFT); // 0001, 0002, dst
    return "OBT" . $kode_max;
}


   public function post() {
    // Ambil data pengguna terlebih dahulu
    $pengguna = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();
    $kode_obat = $this->generate_kode_obat();
    // Cek apakah data pengguna ditemukan
    if (!$pengguna) {
        show_error('Data pengguna tidak ditemukan.');
        return;
    }
    // Ambil input id_penyedia
    $id_penyedia = $this->input->post('id_penyedia');
    if (empty($id_penyedia)) {
        show_error('ID Penyedia tidak boleh kosong.');
        return;
    }

    // Data untuk tabel `obat`
    $data = [
        'kode_obat' => $kode_obat,
        'nama' => $this->input->post('nama'),
        'id_kategori_obat' => $this->input->post('id_kategori_obat'),
        'harga_pembelian' => preg_replace('/[^0-9]/', '', $this->input->post('harga_pembelian')),
        'harga_penjualan' => preg_replace('/[^0-9]/', '', $this->input->post('harga_penjualan')),
        'tanggak_kadaluarsa' => $this->input->post('tanggak_kadaluarsa'),
        'stok' => $this->input->post('stok'),
        'status' => $this->input->post('status'),
        'tipe_obat' => $this->input->post('tipe_obat'),
        'dibuat_di' => date('Y-m-d H:i:s'),
        'diperbarui_di' => date('Y-m-d H:i:s'),
    ];


    // Insert data ke tabel obat
    $this->db->insert('obat', $data);

    // Data untuk tabel `barang_masuk`
    $data2 = [
        'id_penyedia' => $id_penyedia,
        'id_pengguna' => $pengguna['id_pengguna'],
        'kode_obat' => $kode_obat
    ];

    // Insert data ke tabel barang_masuk
    $this->db->insert('barang_masuk', $data2);
    // Set flashdata notifikasi sukses
    $this->session->set_flashdata('success', 'Data Obat berhasil ditambahkan.');
    redirect('config/obat');
}

    public function edited($id) {
        $data['title'] = 'Data edited obat';
        $data['subTitle'] = 'Edited Data Obat';
        $data['kategori'] = $this->db->get('kategori_obat')->result_array(); // ambil semua kategori
        $data['penyedia'] = $this->db->get('penyedia')->result_array(); // ambil semua kategori

        // === Fungsi get data sesuai id === //
        $obat = $this->db->get_where('obat', ['id_produk_obat' => $id])->row_array();
        $data['kategoriSelect'] = $this->db->get_where('kategori_obat', [
                'id_kategori_obat' => $obat['id_kategori_obat']
            ])->row_array(); // ambil semua kategori
        if (!$obat) {
            show_error("Data obat dengan ID $id tidak ditemukan.");
        }
        $data['obat'] = $obat;
        // Ambil data barang masuk berdasarkan kode_obat
        $barangMasuk = $this->db->get_where('barang_masuk', ['kode_obat' => $obat['kode_obat']])->row_array();
        $data['barangMasuk'] = $barangMasuk; // simpan kalau ingin dipakai di view

        // Cek apakah ada data barang masuk, lalu ambil penyedia-nya
            $data['penyediaSelect'] = $this->db->get_where('penyedia', [
                'id_penyedia' => $barangMasuk['id_penyedia']
            ])->row_array();
       


        $data['pengguna'] = $this->db->get_where('pengguna',['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('config/components/header', $data);
        $this->load->view('config/pages/obat/edited', $data);
    }

    public function edited_post($id) {
    // Ambil data pengguna
    $pengguna = $this->db->get_where('pengguna', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    if (!$pengguna) {
        show_error('Data pengguna tidak ditemukan.');
        return;
    }

    // Ambil input id_penyedia
    $id_penyedia = $this->input->post('id_penyedia');
    if (empty($id_penyedia)) {
        show_error('ID Penyedia tidak boleh kosong.');
        return;
    }

    // Data yang akan diupdate ke tabel `obat`
    $data = [
        'nama' => $this->input->post('nama'),
        'id_kategori_obat' => $this->input->post('id_kategori_obat'),
        'harga_pembelian' => preg_replace('/[^0-9]/', '', $this->input->post('harga_pembelian')),
        'harga_penjualan' => preg_replace('/[^0-9]/', '', $this->input->post('harga_penjualan')),
        'tanggak_kadaluarsa' => $this->input->post('tanggak_kadaluarsa'),
        'stok' => $this->input->post('stok'),
        'status' => $this->input->post('status'),
        'tipe_obat' => $this->input->post('tipe_obat'),
        'diperbarui_di' => date('Y-m-d H:i:s'),
    ];

    // Update data di tabel obat berdasarkan ID
    $this->db->where('id_produk_obat', $id);
    $this->db->update('obat', $data);

    // Update data penyedia di tabel barang_masuk (opsional)
    $obat = $this->db->get_where('obat', ['id_produk_obat' => $id])->row_array();
    $barang_masuk = $this->db->get_where('barang_masuk', ['kode_obat' => $obat['kode_obat']])->row_array();
    
    if ($barang_masuk) {
        $data2 = [
            'id_penyedia' => $id_penyedia,
            'id_pengguna' => $pengguna['id_pengguna'],
        ];
        
        $this->db->where('kode_obat', $barang_masuk['kode_obat']);
        $this->db->update('barang_masuk', $data2);
    }

    // Notifikasi sukses
    $this->session->set_flashdata('success', 'Data Obat berhasil diperbarui.');
    redirect('config/obat');
}

public function report_pdf()
{
    $keyword = $this->input->get('keyword');
    $status = $this->input->get('status');
    $tanggal_masuk = $this->input->get('tanggal_masuk');

    $this->db->select('obat.*, kategori_obat.nama_tipe, barang_masuk.*, penyedia.*, barang_masuk.dibuat_di as tanggal_masuk');
    $this->db->from('obat');
    $this->db->join('kategori_obat', 'kategori_obat.id_kategori_obat = obat.id_kategori_obat');
    $this->db->join('barang_masuk', 'barang_masuk.kode_obat = obat.kode_obat');
    $this->db->join('penyedia', 'penyedia.id_penyedia = barang_masuk.id_penyedia');

    if (!empty($keyword)) {
        $this->db->like('obat.nama', $keyword);
    }

    if (!empty($tanggal_masuk)) {
        $this->db->where('DATE(barang_masuk.dibuat_di)', $tanggal_masuk);
    }

    if (!empty($status)) {
        $this->db->where('obat.status', $status);
    }

    $data['obat'] = $this->db->get()->result_array();

    // Load view ke HTML
    $html = $this->load->view('config/pages/obat/obat_pdf', $data, true);

    // Load Dompdf
    $this->load->library('dompdf_gen');

    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4', 'portrait');
    $this->dompdf->render();

    $this->dompdf->stream("laporan_obat.pdf", array("Attachment" => false));
}


 public function delete($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data obat terlebih dahulu sebelum dihapus
        $obat = $this->db->get_where('obat', ['id_produk_obat' => $id])->row_array();

        if ($obat) {
            $kode_obat = $obat['kode_obat'];

            // Hapus dari tabel obat
            $this->Obat_model->delete($id);

            // Hapus dari tabel barang_masuk jika model tersedia
            $this->barang_masuk->delete_by_kode_obat($kode_obat);

            $this->session->set_flashdata('success', 'Data Obat berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Data Obat tidak ditemukan');
        }
    }

    redirect('config/obat');
}

}

