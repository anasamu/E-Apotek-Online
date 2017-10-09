<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master_suplier extends CI_Model 
{

	public function get()
	{
		return $this->db->get('tb_suplier');
	}

	public function result()
	{
		$query = $this->db->get('tb_suplier');
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
		$query = $this->db->where('id_suplier',$id)
							->get('tb_suplier');
		
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function where($id)
	{
		$query  = $this->db->where('id_suplier',$id)
							->get('tb_suplier');
		
		if ($query->num_rows() > 0) 
		{
			$items = $query->row();
			return $items;
		}
		else
		{
			return false;
		}
	}

	protected function result_items($items = null)
	{
		if ($items == null) 
		{
			$data = array(	'id_suplier' 	=> 'items sudah dihapus',
							'suplier' 		=> '<span class="text-danger">Suplier sudah dihapus</span>',
							'alamat' 		=> 'items sudah dihapus',
							'no_telp' 		=> 'items sudah dihapus',
							'no_rek' 		=> 'items sudah dihapus',
							'id_user' 		=> 'items sudah dihapus',
							'id_user_modif' => 'items sudah dihapus',
							'date' 			=> 'items sudah dihapus'
						);
		}
		else
		{
			$data = array(	'id_suplier' 	=> $items->id_suplier,
							'suplier' 		=> $items->suplier,
							'alamat' 		=> $items->alamat,
							'no_telp' 		=> $items->no_telp,
							'no_rek' 		=> $items->no_rek,
							'id_user' 		=> $items->id_user,
							'id_user_modif' => $items->id_user_modif,
							'date' 			=> $items->date
			);
		}

		return $data;
	}
}
