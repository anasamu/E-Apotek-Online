<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_laporan_pembelian extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Laporan Pembelian';
		$this->apotek->content('laporan/pembelian',$data);
	}

	public function print_laporan()
	{
		$tgl_awal 			= date('Y-m-d',strtotime($this->input->post('start',TRUE)));
		$tgl_akhir 			= date('Y-m-d',strtotime($this->input->post('end',TRUE)));
		$jenis_transaksi 	= $this->input->post('jenis_transaksi',TRUE);
		$suplier 			= $this->input->post('suplier',TRUE);
		$user 				= $this->input->post('user',TRUE);

		if ($jenis_transaksi !== 'ALL') 
		{
			$this->db->where('jenis_transaksi',$jenis_transaksi);
		}

		if ($user !== 'ALL') 
		{
			$this->db->where('id_user',$user);
		}

		if ($suplier !== "ALL") 
		{
			$this->db->where('id_suplier',$suplier);
		}

		$this->db->where('tgl_transaksi >= ',$tgl_awal);
		$this->db->where('tgl_transaksi <=',$tgl_akhir);
		$this->db->group_by('no_faktur');
		$this->db->order_by('tgl_transaksi','ASC');
		$query = $this->db->get('tb_cart_pembelian');

		if ($query->num_rows() > 0) 
		{
			$data['tgl_transaksi'] 	 = $this->apotek->date($tgl_awal) .' s/d '.$this->apotek->date($tgl_akhir);
			$data['jenis_transaksi'] = $jenis_transaksi;
			$data['user'] 			 = $user;
			$data['laporan'] 		 = $query->result();
			$this->load->view('content/print/laporan_pembelian',$data);
		}
		else
		{
			$this->apotek->pesan_error('data transaksi kosong');

			$this->apotek->redirect();
		}
	}
}
