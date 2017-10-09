<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Master_barang extends CI_Model 
{
	public function get()
	{
		return $this->db->get('tb_data_obat');
	}

	public function check_id($id)
	{
		$query = $this->db->where('id_obat',$id)
							->get('tb_data_obat');
		
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
		$query  = $this->db->where('id_obat',$id)
							->get('tb_data_obat');
		
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

	public function lokasi_barang($id_lokasi)
	{
		$query = $this->db->where('id_lokasi',$id_lokasi)
							->get('tb_lokasi_barang');

		if ($query->num_rows() > 0) 
		{
			return $query->row();
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
			$data = array(	'id' 			=> 'items sudah dihapus',
							'nama_barang' 	=> '<span class="text-danger">items sudah dihapus</span>',
							'id_satuan' 	=> 'items sudah dihapus',
							'id_jenis' 		=> 'items sudah dihapus',
							'id_kategori' 	=> 'items sudah dihapus',
							'keterangan' 	=> 'items sudah dihapus',
							'foto' 			=> 'default.jpg'
						);

			return $data;
		}
		else
		{
			$satuan = $this->db->where('id_satuan',$items->id_satuan)
								->get('tb_satuan_obat');
			if ($satuan->num_rows() > 0) 
			{
				$satuan = $satuan->row()->nama_satuan_obat;
			}
			else
			{
				$satuan = '-';
			}
							
			$data = array(	'id' 			=> $items->id_obat,
							'nama_barang' 	=> $items->nama_obat,
							'satuan' 		=> $satuan,
							'id_jenis' 		=> $items->id_jenis,
							'id_kategori' 	=> $items->id_kategori,
							'keterangan' 	=> $items->keterangan,
							'foto' 			=> $items->foto,
						);

			return $data;
		}
	}
}
