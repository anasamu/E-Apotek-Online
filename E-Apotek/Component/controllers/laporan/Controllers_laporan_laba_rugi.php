<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_laporan_laba_rugi extends E_Apotek_Controller 
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
		$data['title'] 		= 'Laporan Laba Rugi';
		$this->apotek->content('laporan/laba-rugi',$data);
	}

	public function print_laporan()
	{
		$tgl_awal 			= date('Y-m-d',strtotime($this->input->post('start',TRUE)));
		$tgl_akhir 			= date('Y-m-d',strtotime($this->input->post('end',TRUE)));

		$this->db->where('tgl_transaksi >= ',$tgl_awal);
		$this->db->where('tgl_transaksi <=',$tgl_akhir);
		$this->db->order_by('tgl_transaksi','ASC');
		$query = $this->db->get('tb_data_transaksi');

		if ($query->num_rows() > 0) 
		{
			$pemasukan = 0;
			$pengeluaran = 0;
			
			foreach ($query->result() as $items) 
			{
				$pemasukan += $items->debet;
				$pengeluaran += $items->kredit;
			}

			$data['tgl_transaksi'] 	 = $this->apotek->date($tgl_awal) .' s/d '.$this->apotek->date($tgl_akhir);
			$data['pemasukan'] 		 = $pemasukan;
			$data['pengeluaran'] 	 = $pengeluaran;
			$data['laporan'] 		 = $query;
			$this->load->view('content/print/laporan_laba_rugi',$data);
		}
		else
		{
			$this->apotek->pesan_error('periode yang dimasukan kosong.');
			$this->apotek->redirect();
		}
	}
}
