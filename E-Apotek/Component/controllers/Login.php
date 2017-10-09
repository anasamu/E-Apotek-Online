<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends E_Apotek_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->apotek->pesan_error('anda sedang login saat ini. menu login tidak tersedia.');
			$this->apotek->redirect();
		}
	}

	public function index()
	{
		$this->load->view('template/login');
	}

	public function proses()
	{
		$this->form_validation->set_rules('username', 'Username','trim|required');
        $this->form_validation->set_rules('password', 'Password','trim|required');
		$this->form_validation->set_rules('login_type', 'Login_type','trim|required');
		
		// cek validasi rule kalau berhasil 
		if ($this->form_validation->run())
        {
        	$username 	= $this->input->post('username',TRUE);
        	$password 	= $this->input->post('password',TRUE);
        	$type 		= $this->input->post('login_type',TRUE);
        	$login 		= $this->apotek->login($username,$password,$type);
			// jika login berhasil
			if ($login == TRUE) 
			{
				$menu 	= 'Sistem E-Apotek -> Login';
				$log 	= "Login Ke Sistem E-Apotek";
				$this->apotek->log_user($menu,$log);
				$this->apotek->redirect();
			}
			else
			{
				$this->apotek->pesan_error('Username atau password salah!');
        		$this->apotek->redirect();
			}
        }
        else
        {
        	$this->apotek->pesan_error('bidang tidak boleh kosong!');
        	$this->apotek->redirect();
        }
	}
}
