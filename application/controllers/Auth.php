<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->database(); 
		$this->load->model('User_model'); 
		$this->load->library('session');
	}

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['title'] = "Apotek Login";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login(); 
		}
	}

	private function _login() 
	{
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);

		$pengguna = $this->User_model->get_user_by_email($email); // ini return stdClass

		if ($pengguna) {
			// Gunakan akses objek -> bukan array []
			if (password_verify($password, $pengguna->kata_sandi)) {
				$data = [
					'email'        => $pengguna->email,
					'akses'        => $pengguna->akses,
					'id_pengguna'  => $pengguna->id_pengguna
				];
				$this->session->set_userdata($data);

				// Redirect sesuai akses
				switch ($pengguna->akses) {
					case 'admin':
						 redirect('admin/admin');
						break;
					case 'owner':
						redirect('owner/dashboard');
						break;
					case 'kasir':
						redirect('kasir/dashboard');
						break;
					default:
						$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Role tidak dikenali!</div>');
						redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak terdaftar!</div>');
			redirect('auth');
		}
	}

	public function registration()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
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
