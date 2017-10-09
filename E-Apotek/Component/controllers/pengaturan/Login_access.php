<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_access extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Pengaturan Login Access';
		$this->apotek->content('pengaturan/login_access',$data);
	}
}
