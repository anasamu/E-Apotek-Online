<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_hutang extends CI_Model 
{
	public function get()
	{
		$query 		= $this->db->where('jenis_transaksi','HUTANG')->where('payment','TRUE')->order_by('tgl_transaksi')->group_by('no_faktur')->get('tb_cart_pembelian');
		$no_items 	= 0;
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
}