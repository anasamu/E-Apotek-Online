<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_stok extends CI_Model 
{
	public function stok_masuk($id_barang)
	{
		$query = $this->db->where('id_barang',$id_barang)
						->select('stok_masuk')
						->get('tb_data_stok');
		
		if ($query->num_rows() > 0) 
		{
			return $query->row()->stok_masuk;
		}
		else
		{
			return 0;
		}
	}

	public function stok_keluar($id_barang)
	{
		$query = $this->db->where('id_barang',$id_barang)
						->select('stok_keluar')
						->get('tb_data_stok');
		
		if ($query->num_rows() > 0) 
		{
			return $query->row()->stok_keluar;
		}
		else
		{
			return 0;
		}
	}

	public function get_kartu_stok($tgl_min,$tgl_max,$id_barang)
	{
		$this->db->where('id_barang',$id_barang);
		$this->db->where('tgl_transaksi >= ',$tgl_min);
		$this->db->where('tgl_transaksi <=',$tgl_max);
		$this->db->order_by('tgl_transaksi','ASC');
		$query = $this->db->get('tb_kartu_stok');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function kartu_stok($data)
	{
		return $this->db->insert('tb_kartu_stok',$data);
	}


	public function get()
	{
		$query = $this->db->get('tb_data_stok');

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
							->get('tb_data_stok');
		
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function update_stok_awal($id,$data)
	{
		return $this->db->where('id_barang',$id)
						->update('tb_data_stok',$data);
	}

	public function where($id)
	{
		$query  = $this->db->where('id_barang',$id)
							->get('tb_data_stok');
		
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
			$data = array(	'id_barang' 	=> '<span class="text-danger">items sudah dihapus</span>',
							'stok_awal' 	=> '<span class="text-danger">items sudah dihapus</span>',
							'stok_masuk' 	=> '<span class="text-danger">items sudah dihapus</span>',
							'stok_keluar' 	=> '<span class="text-danger">items sudah dihapus</span>',
							'sisa_stok' 	=> '<span class="text-danger">items sudah dihapus</span>',
							'date' 			=> '<span class="text-danger">items sudah dihapus</span>',
						);

			return $data;
		}
		else
		{
			$total = $items->stok_awal + $items->stok_masuk - $items->stok_keluar;

			if ($total <= 0) 
			{
				$total = '<span class="semi-bold text-danger">'.$total.'</span>';
			}

			$data = array(	'id_barang' 	=> $items->id_barang,
							'stok_awal' 	=> $items->stok_awal,
							'stok_masuk' 	=> $items->stok_masuk,
							'stok_keluar' 	=> $items->stok_keluar,
							'sisa_stok' 	=> $total,
							'date' 			=> $items->date
						);

			return $data;
		}
	}
}
