<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master_user extends CI_Model 
{

	public function where($id)
	{
		$query  = $this->db->where('id_users',$id)
							->get('tb_users');
		
		if ($query->num_rows() > 0) 
		{
			$items = $query->row();
			return $this->result_items($items);
		}
		else
		{
			return $this->result_items();
		}
	}

	protected function result_items($items = null)
	{
		if ($items == null) 
		{
			$data = array(	
							'id' 			=> 'items sudah dihapus',
							'username' 		=> '<span class="text-danger">items sudah dihapus</span>',
							'nama_lengkap' 	=> 'items sudah dihapus',
							'alamat' 		=> 'items sudah dihapus',
							'foto' 			=> 'items sudah dihapus',
							'date_create' 	=> 'items sudah dihapus',
							'type' 			=> 'items sudah dihapus'
						);

			return $data;
		}
		else
		{
			$data = array(	
							'id' 			=> $items->id_users,
							'username' 		=> $items->username,
							'nama_lengkap' 	=> $items->nama_lengkap,
							'alamat' 		=> $items->alamat,
							'foto' 			=> $items->foto,
							'date_create' 	=> $items->date_created,
							'type' 			=> $items->type
						);

			return $data;
		}
	}
}
