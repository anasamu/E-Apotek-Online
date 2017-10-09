<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_penjualan extends CI_Model 
{
	public function group_barang()
	{
		$query = $this->db->group_by('id_barang')
							->select('id_barang')
							->get('tb_cart_penjualan');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function group_faktur()
	{
		$query = $this->db->group_by('no_faktur')
							->select('no_faktur')
							->get('tb_cart_penjualan');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function retur($id_jual)
	{
		$query = $this->db->where('id_retur',$id_jual)
						->where('jenis_retur','PENJUALAN')
						->get('tb_data_retur');
		
		if ($query->num_rows() > 0) 
		{
			$retur 	= $query->row()->jumlah_retur;
		}
		else
		{
			$retur = 0;
		}

		return $retur;
	}

	public function get()
	{
		$query = $this->db->get('tb_cart_penjualan');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function group($data)
	{
		$query = $this->db->group_by($data)->get('tb_cart_penjualan');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function check_transaksi()
	{
		$query = $this->db->where('id_user',$this->session->userdata('id_user'))
							->where('payment','FALSE')
							->group_by('no_faktur')
							->get('tb_cart_penjualan');
		
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $faktur) 
			{
				$this->db->where('no_faktur',$faktur->no_faktur)
						->delete('tb_cart_penjualan');
			}
		}
	}

	public function where_faktur($no_faktur)
	{
		$query = $this->db->where('no_faktur',$no_faktur)
        					->get('tb_cart_penjualan');

        if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}

	public function check_id_barang($id)
	{
		$query = $this->db->where('id_barang',$id)
							->get('tb_cart_penjualan');
		
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_id_beli($id)
	{
		$query = $this->db->where('id_beli',$id)
							->get('tb_cart_penjualan');
		
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function where_id_barang($id)
	{
		$query  = $this->db->where('id_barang',$id)
							->get('tb_cart_penjualan');
		
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

	public function where_id_jual($id)
	{
		$query  = $this->db->where('id_beli',$id)
							->get('tb_cart_penjualan');
		
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
							'id_jual' 			=> '',
							'id_beli' 			=> '',
							'no_faktur' 		=> '',
							'id_barang' 		=> '',
							'qty' 				=> 0, // Nilai interger
							'harga_jual' 		=> 0,
							'discount'	 		=> 0,
							'sub_total'	 		=> 0,
							'tgl_transaksi' 	=> '',
							'jenis_transaksi' 	=> '',
							'payment' 			=> FALSE, // type boolean
							'id_user' 			=> '',
							'date' 				=> '',
						);

			return $data;
		}
		else
		{
			$data = array(
							'id_jual' 			=> $items->id_jual,
							'id_beli' 			=> $items->id_beli,
							'no_faktur' 		=> $items->no_faktur,
							'id_barang' 		=> $items->id_barang,
							'qty' 				=> $items->qty, // Nilai interger
							'harga_jual' 		=> $items->harga_jual,
							'discount' 			=> $items->discount,
							'sub_total'		 	=> $items->sub_total,
							'tgl_transaksi' 	=> $items->tgl_transaksi,
							'jenis_transaksi' 	=> $items->jenis_transaksi,
							'payment' 			=> $items->payment, // type boolean
							'id_user' 			=> $items->id_user,
							'date' 				=> $items->date,
						);

			return $data;
		}
	}
}
