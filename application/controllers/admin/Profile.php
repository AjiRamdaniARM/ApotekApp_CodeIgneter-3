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
}
