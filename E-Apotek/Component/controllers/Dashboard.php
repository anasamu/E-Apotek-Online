<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Menu Dashboard';
		$this->apotek->content('dashboard',$data);
	}

	public function logout()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$menu 	= 'Sistem E-Apotek -> Logout';
			$log 	= "Logout Ke Sistem E-Apotek";
			$this->apotek->log_user($menu,$log);
			$this->session->sess_destroy();
		}
		
		redirect();
	}
}
