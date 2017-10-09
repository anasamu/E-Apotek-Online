<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tabel_apotek extends CI_Model 
{
	public function data_apotek()
	{
		$query = $this->db->get('tb_apotek');

		if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
	}
}
