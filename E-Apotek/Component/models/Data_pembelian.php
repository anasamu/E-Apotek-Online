<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pembelian extends CI_Model 
{

	public function expired_date()
	{
		$tgl_sekarang 	= date('Y-m-d');
		$query 			= $this->db->where('expired_date <=',$tgl_sekarang)->get('tb_cart_pembelian');

		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function group_barang()
	{
		$query = $this->db->group_by('id_barang')
							->select('id_barang')
							->get('tb_cart_pembelian');
		
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
							->get('tb_cart_pembelian');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function retur($id)
	{
		$query = $this->db->where('id_retur',$id)
						->where('jenis_retur','PEMBELIAN')
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
		$query = $this->db->get('tb_cart_pembelian');

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
		$query = $this->db->group_by($data)->get('tb_cart_pembelian');

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
							->get('tb_cart_pembelian');
		
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $faktur) 
			{
				$this->db->where('no_faktur',$faktur->no_faktur)
						->delete('tb_cart_pembelian');
			}
		}
	}

	public function where_faktur($no_faktur)
	{
		$query = $this->db->where('no_faktur',$no_faktur)
        					->get('tb_cart_pembelian');

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
							->get('tb_cart_pembelian');
		
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
							->get('tb_cart_pembelian');
		
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
							->get('tb_cart_pembelian');
		
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

	public function where_id_beli($id)
	{
		$query  = $this->db->where('id_beli',$id)
							->get('tb_cart_pembelian');
		
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
							'id_beli' 		=> '',
							'no_faktur' 	=> '',
							'id_suplier' 	=> '',
							'id_barang' 	=> '',
							'qty' 			=> 0, // Nilai interger
							'hpp' 			=> 0,
							'total_harga' 	=> 0,
							'id_user' 		=> '',
							'expired_date' 	=> '',
							'tgl_transaksi' => '',
							'payment' 		=> FALSE, // type boolean
							'date' 			=> '',
						);

			return $data;
		}
		else
		{
			$data = array(
							'id_beli' 		=> $items->id_beli,
							'no_faktur' 	=> $items->no_faktur,
							'id_suplier' 	=> $items->id_suplier,
							'id_barang' 	=> $items->id_barang,
							'qty' 			=> $items->qty, // Nilai interger
							'hpp' 			=> $items->hpp,
							'total_harga' 	=> $items->total_harga,
							'id_user' 		=> $items->id_user,
							'expired_date' 	=> $items->expired_date,
							'tgl_transaksi' => $items->tgl_transaksi,
							'payment' 		=> $items->payment, // type boolean
							'date' 			=> $items->date,
						);

			return $data;
		}
	}
}
