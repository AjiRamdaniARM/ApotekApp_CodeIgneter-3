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
        if (!empty($tanggal_masuk)) {
            $this->db->where('DATE(dibuat_di)', $tanggal_masuk); // cocokkan hanya bagian tanggal
        }
          if (!empty($keyword)) {
        $this->db->like('nama_penyedia', $keyword);
        }
        $data['penyedia'] = $this->db->get('penyedia')->result_array();

        // Data lain
        $data['title'] = 'Data Penyedia';
        $data['subTitle'] = 'Pengelolaan Data';
        $data['pengguna'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        // Load views
        $this->load->view('admin/components/header', $data);
        $this->load->view('admin/penyedia', $data);
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
            $this->load->view('admin/components/header', $data);
            $this->load->view('admin/pages/penyedia/create', $data);
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
            redirect('admin/penyedia');
        }
    }

     // === component controller edited === //
    public function edited($id)
    {
        $data['title'] = 'Data Penyedia';
        $data['subTitle'] = 'Edit Data';
        $data['pengguna'] = $this->db->get_where('pengguna', ['email' => $this->session->userdata('email')])->row_array();

        // Ambil data karyawan berdasarkan ID
        $data['penyedia'] = $this->db->get_where('penyedia', ['id_penyedia' => $id])->row_array();

        if (!$data['penyedia']) {
            // Jika data tidak ditemukan
            redirect('admin/penyedia');
        }

        // Jika form disubmit
        if ($this->input->post()) {
            $updateData = [
                'nama_penyedia'       => $this->input->post('nama_penyedia'),
                'no_telp'      => $this->input->post('no_telp'),
                'alamat'    => $this->input->post('alamat'),
                'catatan'    => $this->input->post('catatan')
            ];

            $this->db->where('id_penyedia', $id);
            $this->db->update('penyedia', $updateData);

            $this->session->set_flashdata('success', 'Data penyedia berhasil diperbarui!');
            redirect('admin/penyedia');
        }

        // Tampilkan view edit
        $this->load->view('admin/components/header', $data);
        $this->load->view('admin/pages/penyedia/edited', $data);
    }

     // === component controller delete === //
    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->Penyedia_model->delete($id);
            $this->session->set_flashdata('success','Data Penyedia berhasil dihapus');
        }
        redirect('admin/penyedia');
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
        $html = $this->load->view('admin/pages/penyedia/penyedia_pdf', $data, true);

        // Load Dompdf
        $this->load->library('dompdf_gen');

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();

        $this->dompdf->stream("laporan_penyedia.pdf", array("Attachment" => false));
    }



}

