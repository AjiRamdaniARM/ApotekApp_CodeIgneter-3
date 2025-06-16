<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyedia extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // (opsional) load library/session/model di sini
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('Penyedia_model'); // Pastikan ini ada
		$this->load->database(); 
    }

    // === component controller view === //
   public function index()
    {
        $keyword = $this->input->get('keyword');
        $tanggal_masuk = $this->input->get('tanggal_masuk');

        // SELECT dengan COUNT untuk jumlah suplai
       $this->db->select('penyedia.*,
        COUNT(obat.id_produk_obat) AS jumlah_suplai,
        SUM(CASE WHEN obat.status = "terima" THEN 1 ELSE 0 END) AS jumlah_terima,
        SUM(CASE WHEN obat.status = "tolak" THEN 1 ELSE 0 END) AS jumlah_tolak,
        SUM(CASE WHEN obat.status = "proses" THEN 1 ELSE 0 END) AS jumlah_proses
        ');
        $this->db->from('penyedia');
        $this->db->join('barang_masuk', 'barang_masuk.id_penyedia = penyedia.id_penyedia', 'left');
        $this->db->join('obat', 'obat.kode_obat = barang_masuk.kode_obat', 'left');

        if (!empty($tanggal_masuk)) {
            $this->db->where('DATE(penyedia.dibuat_di)', $tanggal_masuk);
        }
        if (!empty($keyword)) {
            $this->db->like('penyedia.nama_penyedia', $keyword);
        }

        $this->db->group_by('penyedia.id_penyedia');
        $data['penyedia'] = $this->db->get()->result_array();


        // Data tambahan
        $data['title'] = 'Data Penyedia';
        $data['subTitle'] = 'Pengelolaan Data';
        $data['pengguna'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        // Load views
        $this->load->view('config/components/header', $data);
        $this->load->view('config/penyedia', $data);
    }


    // === component controller create === //
    public function create() {
        // Data umum untuk view
        $data['title'] = 'Data Penyedia';
        $data['subTitle'] = 'Pengelolaan Data';
        $data['pengguna'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        // Aturan validasi
        $this->form_validation->set_rules('nama_penyedia', 'Nama Penyedia', 'required|trim|min_length[3]|is_unique[penyedia.nama_penyedia]',[
            'required'   => 'Nama. Penyedia wajib diisi.',
            'is_unique' => 'Nama penyedia sudah terdaftar. Silakan gunakan nama lain.',
            'min_length' => 'Nama. Penyedia minimal harus {param} digit.', // {param} = 3
        ]);
        $this->form_validation->set_rules('no_telp', 'No. Telepon', 'required|trim|numeric|min_length[12]|max_length[13]', [
            'required'   => 'No. Telepon wajib diisi.',
            'numeric'    => 'No. Telepon hanya boleh berisi angka.',
            'min_length' => 'No. Telepon minimal harus {param} digit.', // {param} = 12
            'max_length' => 'No. Telepon maksimal harus {param} digit.', // {param} = 13
        ]);

        // Jalankan validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal validasi, tampilkan form dengan error
            $this->load->view('config/components/header', $data);
            $this->load->view('config/pages/penyedia/create', $data);
        } else {
            // Jika validasi sukses, simpan data
            $postData = [
                'nama_penyedia' => $this->input->post('nama_penyedia'),
                'no_telp'       => $this->input->post('no_telp'),
                'alamat'        => $this->input->post('alamat'),
                'catatan'       => $this->input->post('catatan'),
                'dibuat_di'     => date('Y-m-d H:i:s'),
            ];
            $this->Penyedia_model->insert($postData);

            // Set flashdata notifikasi sukses
            $this->session->set_flashdata('success', 'Data penyedia berhasil ditambahkan.');

            // Redirect ke halaman daftar penyedia
            redirect('config/penyedia');
        }
    }

     // === component controller edited === //
    public function edited($id)
    {
        $data['title'] = 'Data Penyedia';
        $data['subTitle'] = 'Edit Data';
        $data['pengguna'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        // Ambil data penyedia berdasarkan ID
        $penyedia = $this->db->get_where('penyedia', ['id_penyedia' => $id])->row_array();
        if (!$penyedia) {
            // Redirect jika data tidak ditemukan
            redirect('config/penyedia');
        }
        $data['penyedia'] = $penyedia;

        // Cek jika form disubmit
        if ($this->input->post()) {

            // Jika nama penyedia tidak berubah, hilangkan is_unique
            $namaInput = $this->input->post('nama_penyedia');
            $isUnique = ($namaInput != $penyedia['nama_penyedia']) ? '|is_unique[penyedia.nama_penyedia]' : '';

            // Aturan validasi
            $this->form_validation->set_rules('nama_penyedia', 'Nama Penyedia', 'required|trim|min_length[3]' . $isUnique, [
                'required'   => 'Nama penyedia wajib diisi.',
                'is_unique'  => 'Nama penyedia sudah terdaftar. Silakan gunakan nama lain.',
                'min_length' => 'Nama penyedia minimal harus {param} karakter.',
            ]);

            $this->form_validation->set_rules('no_telp', 'No. Telepon', 'required|trim|numeric|min_length[12]|max_length[13]', [
                'required'   => 'No. Telepon wajib diisi.',
                'numeric'    => 'No. Telepon hanya boleh berisi angka.',
                'min_length' => 'No. Telepon minimal harus {param} digit.',
                'max_length' => 'No. Telepon maksimal harus {param} digit.',
            ]);

            if ($this->form_validation->run() === TRUE) {
                // Jika validasi sukses, update data
                $updateData = [
                    'nama_penyedia' => $namaInput,
                    'no_telp'       => $this->input->post('no_telp'),
                    'alamat'        => $this->input->post('alamat'),
                    'catatan'       => $this->input->post('catatan')
                ];

                $this->db->where('id_penyedia', $id);
                $this->db->update('penyedia', $updateData);

                $this->session->set_flashdata('success', 'Data penyedia berhasil diperbarui!');
                redirect('config/penyedia');
            }
        }

        // Tampilkan form edit
        $this->load->view('config/components/header', $data);
        $this->load->view('config/pages/penyedia/edited', $data);
    }


     // === component controller delete === //
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->Penyedia_model->delete($id);
            $this->session->set_flashdata('success','Data Penyedia berhasil dihapus');
        }
        redirect('config/penyedia');
    }

     // === component controller report file PDF === //
    public function report_pdf()
    {
        $keyword = $this->input->get('keyword');
        $tanggal_masuk = $this->input->get('tanggal_masuk');

        $this->db->from('penyedia');

        if (!empty($keyword)) {
            $this->db->like('nama_penyedia', $keyword);
        }

        if (!empty($tanggal_masuk)) {
            $this->db->where('DATE(dibuat_di)', $tanggal_masuk);
        }

        $data['penyedia'] = $this->db->get()->result_array();

        // Load view to HTML
        $html = $this->load->view('config/pages/penyedia/penyedia_pdf', $data, true);

        // Load Dompdf
        $this->load->library('dompdf_gen');

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        $this->dompdf->stream("laporan_penyedia.pdf", array("Attachment" => false));
    }



}

