<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_pengaturan_barang extends E_Apotek_Controller 
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
		$data['title'] 		= 'Pengaturan Barang';
		$this->apotek->content('pengaturan/barang',$data);
	}

	public function tambah_lokasi_barang()
	{
		$this->form_validation->set_rules('id_lokasi', 'Id_lokasi','trim|required');
		$this->form_validation->set_rules('lokasi', 'Lokasi','trim|required');
		$this->form_validation->set_rules('total', 'Total','trim|required');

		if ($this->form_validation->run())
		{
			$id_lokasi 	= $this->input->post('id_lokasi');
			$lokasi 	= strtoupper($this->input->post('lokasi'));
			$total 		= $this->input->post('total');

			$cek_lokasi = $this->db->where('nama_lokasi',$lokasi)
									->get('tb_lokasi_barang');
			if ($cek_lokasi->num_rows() > 0) 
			{
				$this->apotek->pesan_error('nama lokasi penyimpanan barang sudah ada. silahkan coba lagi!');
			}
			else
			{
				$data = array(	'id_lokasi' 		=> $id_lokasi,
								'nama_lokasi' 		=> $lokasi,
								'total_kapasitas' 	=> $total
							);
				$this->db->insert('tb_lokasi_barang',$data);
				$logs_menu 			= 'Pengaturan -> barang -> Tambah Data Lokasi';
				$logs_keterangan 	= 'Menambah data lokasi barang dengan nama lokasi : '.$lokasi;
				$this->apotek->log_user($logs_menu,$logs_keterangan);
				$this->apotek->pesan_sukses('data lokasi :'.$lokasi.' berhasil ditambahkan.');
			}
		}
		else
		{
			$this->apotek->pesan_error('gagal menambah lokasi penyimpanan barang. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}

	public function edit_lokasi_barang()
	{
		$this->form_validation->set_rules('id_lokasi', 'Id_lokasi','trim|required');
		$this->form_validation->set_rules('lokasi', 'Lokasi','trim|required');
		$this->form_validation->set_rules('total', 'Total','trim|required');

		if ($this->form_validation->run())
		{
			$id_lokasi 	= $this->input->post('id_lokasi');
			$lokasi 	= strtoupper($this->input->post('lokasi'));
			$total 		= $this->input->post('total');

			$cek_lokasi = $this->db->where('id_lokasi !=',$id_lokasi)
									->where('nama_lokasi',$lokasi)
									->get('tb_lokasi_barang');
			if ($cek_lokasi->num_rows() > 0) 
			{
				$this->apotek->pesan_error('nama lokasi penyimpanan barang sudah ada. silahkan coba lagi!');
			}
			else
			{
				$data = array(	
								'nama_lokasi' 		=> $lokasi,
								'total_kapasitas' 	=> $total
							);
				$this->db->where('id_lokasi',$id_lokasi)
						->update('tb_lokasi_barang',$data);
				$logs_menu 			= 'Pengaturan -> barang -> Edit Data Lokasi';
				$logs_keterangan 	= 'Mengubah data lokasi barang dengan ID lokasi : '.$id_lokasi;
				$this->apotek->log_user($logs_menu,$logs_keterangan);
				$this->apotek->pesan_sukses('data lokasi :'.$lokasi.' berhasil diubah.');
			}
		}
		else
		{
			$this->apotek->pesan_error('gagal mengubah data lokasi penyimpanan barang. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}

	public function hapus_lokasi_barang()
	{
		$this->form_validation->set_rules('id_lokasi', 'Id_lokasi','trim|required');

		if ($this->form_validation->run())
		{
			$this->db->where('id_lokasi',$this->input->post('id_lokasi'))
					->delete('tb_lokasi_barang');
			$logs_menu 			= 'Pengaturan -> barang -> Hapus Lokasi barang';
			$logs_keterangan 	= 'Menghapus data lokasi barang dengan ID Lokasi : '.$this->input->post('id_lokasi');
			$this->apotek->log_user($logs_menu,$logs_keterangan);
			$this->apotek->pesan_sukses('lokasi penyimpanan barang berhasil di hapus.');
		}
		else
		{
			$this->apotek->pesan_error('gagal menghapus lokasi penyimpanan barang. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}


	public function edit_jenis_obat()
	{
		$this->form_validation->set_rules('id_jenis_obat', 'Id_jenis_obat','trim|required');
		$this->form_validation->set_rules('jenis_obat', 'Jenis_obat','trim|required');
		$this->form_validation->set_rules('keterangan_jenis_obat', 'Keterangan_jenis_obat','trim|required');
	
		if ($this->form_validation->run())
		{
			$id_jenis_obat 		= $this->input->post('id_jenis_obat');
			$keterangan_obat 	= array('keterangan' => $this->input->post('keterangan_jenis_obat'));
			
			$this->db->where('id_jenis_obat',$id_jenis_obat)
						->update('tb_jenis_obat',$keterangan_obat);
			
			$logs_menu 			= 'Pengaturan -> Obat -> edit Jenis Obat';
			$logs_keterangan 	= 'Mengubah data Jenis Obat : '.$this->input->post('jenis_obat');
			
			$this->apotek->log_user($logs_menu,$logs_keterangan);
			$this->apotek->pesan_sukses('data jenis obat :'.$this->input->post('jenis_obat').' berhasil di ubah.');
		}
		else
		{
			$this->apotek->pesan_error('gagal melakukan perubahan pada jenis obat yang dipilih. silahkan coba lagi!');
		}
		
		$this->apotek->redirect();
	}

	public function tambah_kategori_obat()
	{
		$this->form_validation->set_rules('kategori_obat', 'Kategori_obat','trim|required');

		if ($this->form_validation->run())
		{
			$data_kategori = array('nama_kategori' => $this->input->post('kategori_obat'),
									'id_user' => $this->session->userdata('id_user'),
									'date' => date('Y-m-d H:m:s'));
			$this->db->insert('tb_kategori_obat',$data_kategori);
			
			$logs_menu 			= 'Pengaturan -> Obat -> Tambah Kategori Obat';
			$logs_keterangan 	= 'Menambah data Kategori Obat : '.$this->input->post('kategori_obat');
			$this->apotek->log_user($logs_menu,$logs_keterangan);

			$this->apotek->pesan_sukses('kategori obat : '.$this->input->post('kategori_obat').' berhasil di tambahkan.');
		}
		else
		{
			$this->apotek->pesan_error('gagal menambah Kategori Obat. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}

	public function edit_kategori_obat()
	{
		$this->form_validation->set_rules('id_kategori', 'Id_kategori','trim|required');
		$this->form_validation->set_rules('kategori_obat', 'Kategori_obat','trim|required');

		if ($this->form_validation->run())
		{
			$id_kategori 	= $this->input->post('id_kategori');
			$data_kategori 	= array('nama_kategori' => $this->input->post('kategori_obat'));

			$this->db->where('id_kategori',$id_kategori)
					->update('tb_kategori_obat',$data_kategori);

			$logs_menu 			= 'Pengaturan -> Obat -> edit Kategori Obat';
			$logs_keterangan 	= 'Mengubah data Kategori Obat : '.$this->input->post('kategori_obat');
			$this->apotek->log_user($logs_menu,$logs_keterangan);
			$this->apotek->pesan_sukses('kategori obat berhasil di Ubah.');
		}
		else
		{
			$this->apotek->pesan_error('gagal mengubah Kategori Obat. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}

	public function hapus_kategori_obat()
	{
		$this->form_validation->set_rules('id_kategori', 'Id_kategori','trim|required');
		$this->form_validation->set_rules('kategori_obat', 'Kategori_obat','trim|required');

		if ($this->form_validation->run())
		{
			$this->db->where('id_kategori',$this->input->post('id_kategori'))
					->where('nama_kategori',$this->input->post('kategori_obat'))
					->delete('tb_kategori_obat');
			$logs_menu 			= 'Pengaturan -> Obat -> Hapus Kategori Obat';
			$logs_keterangan 	= 'Menghapus data Kategori Obat : '.$this->input->post('kategori_obat');
			$this->apotek->log_user($logs_menu,$logs_keterangan);
			$this->apotek->pesan_sukses('kategori obat berhasil di hapus.');
		}
		else
		{
			$this->apotek->pesan_error('gagal menghapus Kategori Obat. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}


	public function tambah_satuan_obat()
	{
		$this->form_validation->set_rules('satuan_obat', 'Satuan_obat','trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		
		if ($this->form_validation->run())
		{
			$satuan_obat = array('nama_satuan_obat' => $this->input->post('satuan_obat'),
								'keterangan' 		=> $this->input->post('keterangan'),
								'id_users' 			=> $this->session->userdata('id_user'),
								'date' 				=> date('Y-m-d H:m:s'));
			$this->db->insert('tb_satuan_obat',$satuan_obat);

			$logs_menu 			= 'Pengaturan -> Obat -> Tambah Satuan Obat';
			$logs_keterangan 	= 'Menambah data Satuan Obat : '.$this->input->post('satuan_obat');
			
			$this->apotek->log_user($logs_menu,$logs_keterangan);
			$this->apotek->pesan_sukses('Satuan obat : '.$this->input->post('satuan_obat').' berhasil di tambahkan.');
		}
		else
		{
			$this->apotek->pesan_error('gagal menambah Satuan Obat. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}

	public function edit_satuan_obat()
	{
		$this->form_validation->set_rules('id_satuan', 'Id_satuan','trim|required');
		$this->form_validation->set_rules('satuan_obat', 'Satuan_obat','trim|required');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
		
		if ($this->form_validation->run())
		{
			$satuan_obat = array('nama_satuan_obat' => $this->input->post('satuan_obat'),
								'keterangan' 		=> $this->input->post('keterangan'),
								'id_users' 			=> $this->session->userdata('id_user'),
								);

			$this->db->where('id_satuan',$this->input->post('id_satuan'))
						->update('tb_satuan_obat',$satuan_obat);
			
			$logs_menu 			= 'Pengaturan -> Obat -> edit Satuan Obat';
			$logs_keterangan 	= 'Mengubah data Satuan Obat : '.$this->input->post('satuan_obat');
			$this->apotek->log_user($logs_menu,$logs_keterangan);

			$this->apotek->pesan_sukses('Satuan obat : '.$this->input->post('satuan_obat').' berhasil di ubah.');
		}
		else
		{
			$this->apotek->pesan_error('gagal mengubah Satuan Obat. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}

	public function hapus_satuan_obat()
	{
		$this->form_validation->set_rules('id_satuan', 'Id_satuan','trim|required');
		$this->form_validation->set_rules('satuan_obat', 'Satuan_obat','trim|required');
		
		if ($this->form_validation->run())
		{
			
			$this->db->where('id_satuan',$this->input->post('id_satuan'))
						->delete('tb_satuan_obat');

			$logs_menu 			= 'Pengaturan -> Obat -> Hapus Satuan Obat';
			$logs_keterangan 	= 'Menghapus data Satuan Obat : '.$this->input->post('satuan_obat');
			$this->apotek->log_user($logs_menu,$logs_keterangan);

			$this->apotek->pesan_sukses('Satuan obat : '.$this->input->post('satuan_obat').' berhasil di hapus.');
		}
		else
		{
			$this->apotek->pesan_error('gagal mengubah Satuan Obat. silahkan coba lagi!');
		}

		$this->apotek->redirect();
	}
}
