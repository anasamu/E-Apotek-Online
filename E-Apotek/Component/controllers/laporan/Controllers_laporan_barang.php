<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_laporan_barang extends E_Apotek_Controller 
{
	public function __construct()
    {
        parent::__construct();
        
        if ($this->session->userdata('access') !== 'ADMINISTRATOR') 
        {
            $this->apotek->pesan_error('anda tidak punya akses ke menu ini.');
            $this->apotek->redirect();
        }
    }
    
	public function index()
	{
		$data['title'] 		= 'Laporan Apotek';
		$this->apotek->content('laporan/barang',$data);
	}

	public function kartu_stok()
	{
		$tgl_awal 			= date('Y-m-d',strtotime($this->input->post('start',TRUE)));
		$tgl_akhir 			= date('Y-m-d',strtotime($this->input->post('end',TRUE)));
		$id_barang 			= $this->input->post('barang',TRUE);
		$kartu_stok 		= $this->data_stok->get_kartu_stok($tgl_awal,$tgl_akhir,$id_barang);

		if ($kartu_stok !== FALSE) 
		{
			$data['tgl_transaksi'] 	 = $this->apotek->date($tgl_awal) .' s/d '.$this->apotek->date($tgl_akhir);
			$data['id_barang'] 		 = $id_barang;
			$data['kartu_stok'] 	 = $kartu_stok;
			$this->load->view('content/print/laporan_kartu_stok',$data);
		}
		else
		{
			$this->apotek->pesan_error('data kartu stok untuk periode yang dipilih tidak ditemukan.');
			$this->apotek->redirect();
		}
	}

	public function harga_barang()
	{
		$barang 		= $this->input->post('barang',TRUE);
		$harga_barang 	= $this->data_harga_barang->get();
		
		if($harga_barang !== FALSE) 
		{
			$data['harga_barang'] = $harga_barang;
			$this->load->view('content/print/laporan_harga_barang',$data);
		}
		else
		{
			$this->apotek->pesan_error('data harga barang tidak ditemukan.');
			$this->apotek->redirect();
		}
	}

	public function buku_besar()
	{
		$tgl_awal 			= date('Y-m-d',strtotime($this->input->post('start',TRUE)));
		$tgl_akhir 			= date('Y-m-d',strtotime($this->input->post('end',TRUE)));

		$transaksi 			= $this->db->where('tgl_transaksi >=', $tgl_awal)
										->where('tgl_transaksi <=', $tgl_akhir)
										->get('tb_data_transaksi');

		if ($transaksi->num_rows() > 0) 
		{
			$data['tgl_transaksi'] 	= $this->apotek->date($tgl_awal) .' s/d '.$this->apotek->date($tgl_akhir);
			$data['laporan'] 	 	= $transaksi->result();
			$this->load->view('content/print/laporan_buku_besar',$data);
		}
		else
		{
			$this->apotek->pesan_error('data buku besar untuk periode yang dipilih tidak ditemukan.');
			$this->apotek->redirect();
		}
	}

	public function expired()
	{
		$tgl_awal 			= date('Y-m-d',strtotime($this->input->post('start',TRUE)));
		$tgl_akhir 			= date('Y-m-d',strtotime($this->input->post('end',TRUE)));

		$transaksi 			= $this->db->where('tgl_transaksi >=', $tgl_awal)
										->where('tgl_transaksi <=', $tgl_akhir)
										->where('payment','TRUE')
										->get('tb_cart_pembelian');

		if ($transaksi->num_rows() > 0) 
		{
			$data['tgl_transaksi'] 	= $this->apotek->date($tgl_awal) .' s/d '.$this->apotek->date($tgl_akhir);
			$data['laporan'] 	 	= $transaksi->result();
			$this->load->view('content/print/laporan_expired',$data);
		}
		else
		{
			$this->apotek->pesan_error('data buku besar untuk periode yang dipilih tidak ditemukan.');
			$this->apotek->redirect();
		}
	}
}
