<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expired_date extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Expired Date';
		$this->apotek->content('barang/expired_date',$data);
	}

}
