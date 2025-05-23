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
        $data['title'] = 'Dashboard'; // === for header === 
        $data['subTitle'] = 'Dashboard Admin';
        $data['pengguna'] = $this->db->get_where('pengguna',['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('admin/components/header', $data);
        $this->load->view('admin/index', $data);
    }

    public function logout() {
 		$this->session->sess_destroy();
		$this->session->set_flashdata('logout', 'Anda telah berhasil logout.');
		redirect('auth');
	}
   
}
