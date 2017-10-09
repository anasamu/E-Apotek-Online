<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Pemesanan Barang';
		$this->apotek->content('suplier/pesan_barang',$data);
	}
}
