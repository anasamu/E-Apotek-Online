<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_harga_barang extends CI_Model 
{

	public function get()
	{
		$query = $this->db->get('tb_harga_barang');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function check_id($id)
	{
		$query = $this->db->where('id_barang',$id)
							->get('tb_harga_barang');
		
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function where_row($id)
	{
		$query  = $this->db->where('id_barang',$id)
							->get('tb_harga_barang');
		
		if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
}
