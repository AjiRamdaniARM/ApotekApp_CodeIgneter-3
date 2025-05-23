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
        $this->load->view('admin/components/header', $data);
        $this->load->view('admin/profile', $data);
    }
    public function edit() {
        $data['title'] = 'Profile Saya';
        $data['subTitle'] = 'Profile Pengguna';
        $data['pengguna'] = $this->db->get_where('pengguna',['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('admin/components/header', $data);
        $this->load->view('admin/pages/profile/edit', $data);
    }

    public function update() {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        	if ($this->form_validation->run() == false) {
			$data['title'] = "Apotek User Registration";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
		} else {
			echo 'data berhasil ditambahkan!';
		}
    }
}

