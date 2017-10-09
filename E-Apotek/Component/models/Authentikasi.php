<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Authentikasi extends CI_Model 
{
	public function login()
	{
		if ($this->session->userdata('logged_in') == TRUE) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
