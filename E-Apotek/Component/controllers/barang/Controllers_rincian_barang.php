<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_rincian_barang extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Rincian Barang';
		$this->apotek->content('barang/rincian_barang',$data);
	}
}
