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
			$data['title'] = "Apotek Akses";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('components/navbar', $data);
			$this->load->view('auth/akses');
			$this->load->view('templates/auth_footer');
	}

	public function loginAdmin() 
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['email'] = $this->db->get_where('pengguna', ['akses' => 'admin'])->row_array();
			$data['title'] = "Apotek Akses";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('components/navbar', $data);
			$this->load->view('auth/adminLogin');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login(); 
		}
	}

	public function loginKasir() 
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['email'] = $this->db->get_where('pengguna', ['akses' => 'kasir'])->row_array();
			$data['title'] = "Apotek Akses";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('components/navbar', $data);
			$this->load->view('auth/kasirLogin');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login(); 
		}
	}

	public function loginOwner() 
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['email'] = $this->db->get_where('pengguna', ['akses' => 'owner'])->row_array();
			$data['title'] = "Apotek Akses";
			$this->load->view('templates/auth_header', $data);
			$this->load->view('components/navbar', $data);
			$this->load->view('auth/ownerLogin');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login(); 
		}
	}

	private function _login() 
	{
		$email  = $this->input->post('email', true);
		$password = $this->input->post('password', true);
		$akses  = $this->input->post('akses', true); // Ambil akses dari input form

		$pengguna = $this->User_model->get_user_by_email($email);

		if ($pengguna) {
			if (password_verify($password, $pengguna->kata_sandi)) {
				$data = [
					'email'        => $pengguna->email,
					'akses'        => $pengguna->akses,
					'id_pengguna'  => $pengguna->id_pengguna
				];
				$this->session->set_userdata($data);

				// Redirect sesuai role
				switch ($pengguna->akses) {
					case 'admin':
						redirect('config/dashboard');
						break;
					case 'owner':
						redirect('config/dashboard');
						break;
					case 'kasir':
						redirect('config/dashboard');
						break;
					default:
						$this->session->set_flashdata('message', 
							'<div class="alert alert-danger alert-dismissible fade show" role="alert">
								Role tidak dikenali!
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>');
						redirect('auth/login' . ucfirst($akses)); // fallback
				}
			} else {
				$this->session->set_flashdata('message', 
					'<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Password salah!
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>');
				redirect('auth/login' . ucfirst($akses));
			}
		} else {
			$this->session->set_flashdata('message', 
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Email tidak terdaftar!
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');
			redirect('auth/login' . ucfirst($akses));
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
