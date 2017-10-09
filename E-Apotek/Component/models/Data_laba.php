<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_laba extends CI_Model 
{
	public function get()
	{
		$laba = $this->db->get('tb_harga_penjualan');
		
		if ($laba->num_rows() == 1) 
		{
			$laba 	= $laba->row();
			$array 	= array('hju' => $laba->hju,
							'hjd' => $laba->hjd,
							'hjr' => $laba->hjr
						);
		}
		else
		{
			$array 	= array('hju' => 0,
							'hjd' => 0,
							'hjr' => 0
						);
		}

		return $array;
	}

	public function update($data)
	{
		return $this->db->update('tb_harga_penjualan',$data);
	}

	public function insert($data)
	{
		return $this->db->insert('tb_harga_penjualan',$data);
	}

	public function check()
	{
		$query = $this->db->get('tb_harga_penjualan');

		if ($query->num_rows() == 1) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
