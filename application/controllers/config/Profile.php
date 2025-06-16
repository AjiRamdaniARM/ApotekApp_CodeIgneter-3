<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
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
        $data['title'] = 'Profile Saya';
        $data['subTitle'] = 'Profile Pengguna';
        $data['pengguna'] = $this->db->get_where('pengguna',['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('config/components/header', $data);
        $this->load->view('config/profile', $data);
    }
    public function edit() {
        $data['title'] = 'Profile Saya';
        $data['subTitle'] = 'Profile Pengguna';
        $data['pengguna'] = $this->db->get_where('pengguna',['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('config/components/header', $data);
        $this->load->view('config/pages/profile/edit', $data);
    }

    public function update()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->index(); // kalau gagal validasi, tampilkan form ulang
        } else {
            $nama = htmlspecialchars($this->input->post('nama', true));
            $email = $this->input->post('email', true);
            $password = $this->input->post('password');

            $data = [
                'nama' => $nama,
                'email' => $email
            ];

            // Cek jika password baru diisi, maka update password
            if (!empty($password)) {
                $data['kata_sandi'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // Update data di tabel 'pengguna'
            $this->db->where('email', $this->session->userdata('email'));
            $this->db->update('pengguna', $data);

            // Perbarui session email (jika email berubah)
            $this->session->set_userdata('email', $email);

            $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
            redirect('config/profile');
        }
    }
}

