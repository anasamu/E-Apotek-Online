<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_master_barang extends E_Apotek_Controller 
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
		$data['title'] 		= 'Master Barang';
		$this->apotek->content('master/barang/list',$data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('id_obat', 'Id_obat','trim|required');
		$this->form_validation->set_rules('nama_obat', 'Nama_obat','trim|required');
		$this->form_validation->set_rules('jenis_obat', 'Jenis_obat','trim|required');
		$this->form_validation->set_rules('satuan_obat', 'Satuan_obat','trim|required');
		$this->form_validation->set_rules('kategori_obat', 'Kategori_obat','trim|required');
		
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data obat tidak dapat disimpan. Silahkan coba lagi');
        }
        else
    	{
    		$nama_obat 	= strtoupper($this->input->post('nama_obat'));
    		$dt_obat 	= $this->db->where('nama_obat',$nama_obat)
    								->get('tb_data_obat');
    		
    		if ($dt_obat->num_rows() > 0) 
    		{    			
				$this->apotek->pesan_error('Data Obat tidak dapat disimpan. nama obat sudah ada.');
				redirect('master/barang');
    		}
    		else
    		{
    			$file_name                  = mt_rand(1000,9999);
    			$config['upload_path'] 		= './assets/img/obat/';
				$config['allowed_types'] 	= 'gif|jpg|png';
				$config['max_size']			= '1024';
				$config['file_name'] 		= $file_name;
				$config['max_width'] 		= '1024';
				$config['max_height'] 		= '768';

				$this->upload->initialize($config);
				
				if (!$this->upload->do_upload('gambar_obat')) 
				{
					$foto = 'default.jpg';
					$this->apotek->pesan_sukses('Data berhasil disimpan');
				}
				else
				{
			    	$foto = $this->upload->data('file_name');
					$this->apotek->pesan_sukses('data obat berhasil ditambahkan');
				}

				$data_obat 	= array('id_obat' 			=> $this->input->post('id_obat'),
								'nama_obat'				=> strtoupper($this->input->post('nama_obat')),
								'id_satuan' 			=> $this->input->post('satuan_obat'),
								'id_jenis'				=> $this->input->post('jenis_obat'),
								'id_kategori' 			=> $this->input->post('kategori_obat'),
								'keterangan' 			=> $this->input->post('keterangan_obat'),
								'id_user' 				=> $this->session->userdata('id_user'),
								'foto'					=> $foto,
								'date'					=> date('Y-m-d H:m:s')
							);
				$logs_menu 			= 'Data Master -> Master Obat -> Tambah Data Obat';
				$logs_keterangan 	= 'Menambahkan data obat dengan ID obat : '. $this->input->post('id_obat');

				$this->apotek->log_user($logs_menu,$logs_keterangan);
		    	
		    	$this->db->insert('tb_data_obat',$data_obat);

		    	$this->form_validation->set_rules('tgl_pembelian', 'Tgl_pembelian','trim|required');
				$this->form_validation->set_rules('stok_barang', 'Stok_barang','trim|required');
				$this->form_validation->set_rules('harga_beli', 'harga_beli','trim|required');
				$this->form_validation->set_rules('expired_date', 'Expired_date','trim|required');
				$this->form_validation->set_rules('lokasi_penyimpanan', 'Lokasi_penyimpanan','trim|required');
				if ($this->form_validation->run())
		        {
		        	$id_obat 		= $data_obat['id_obat'];
		        	$faktur 		= 'IMPORT-'.mt_rand();
		        	$suplier 		= 'IMPORT';
		        	$tgl_transaksi 	= date('Y-m-d',strtotime($this->input->post('tgl_pembelian')));
		        	$transaksi 		= 'TUNAI';
		        	$id_beli 		= 'IMPORT-'.mt_rand();
		        	$harga_pokok 	= $this->input->post('harga_beli') / $this->input->post('stok_barang');
		        	$tgl_expired 	= date('Y-m-d', strtotime($this->input->post('expired_date')));
		        	$qty 			= $this->input->post('stok_barang');
		        	$apotek 		= $this->apotek->e_apotek();
		        	$proses_obat 	= array(
												'no_faktur' 		=> $faktur,
												'id_suplier' 		=> $suplier,
												'tgl_transaksi' 	=> $tgl_transaksi,
												'jenis_transaksi'	=> $transaksi,
												'id_beli' 			=> $id_beli,
												'id_barang' 		=> $id_obat,
												'id_lokasi' 		=> $this->input->post('lokasi_penyimpanan'),
												'qty' 				=> $qty,
												'discount' 			=> 0,
												'ppn' 				=> 0,
												'harga_pokok' 		=> $harga_pokok,
												'total_harga' 		=> $this->input->post('harga_beli'),
												'expired_date' 		=> $tgl_expired,
												'id_user' 			=> $this->session->userdata('id_user'),
												'payment' 			=> 'TRUE'
											);
						
					$this->apotek->set_label($this->input->post('id_beli'),'New');
					$this->db->insert('tb_cart_pembelian',$proses_obat);

					$stok_masuk 	= array(
											'id_barang' => $id_obat,
											'stok_awal' => $qty);
					$this->db->insert('tb_data_stok',$stok_masuk);

					$dtkartu_stok = array(
											'id_barang' 	=> $id_obat,
											'tgl_transaksi' => $tgl_transaksi,
											'no_faktur'		=> $faktur,
											'keterangan' 	=> 'IMPORT Pembelian barang dari DATA MASTER',
											'masuk'			=> $qty,
											'keluar'		=> 0,
											'id_user' 		=> $this->session->userdata('id_user'));

					$this->data_stok->kartu_stok($dtkartu_stok);
					
					if ($apotek->hpp == 'RATA-RATA') 
					{
						$a 					= 0; 									// harga hpp lama
						$b 					= 0; 									// jumlah stok lama
						$c 					= $harga_pokok; 					// harga pokok baru
						$d 					= $qty; 							// jumlah stok baru
						$hpp 				= (($a*$b)+($c*$d))/($b+$d);
					}
					else
					{
						$hpp = $harga_pokok;
					}

					$laba 				= $this->apotek->laba($id_obat,$hpp);

					$proses_harga = array(	'id_barang' => $id_obat,
											'hpp' 		=> $hpp,
											'hju' 		=> $laba['hju'],
											'hjd' 		=> $laba['hjd'],
											'hjr' 		=> $laba['hjr'],
										);

					$this->db->insert('tb_harga_barang',$proses_harga);
		        }
    		}	
    	}

    	redirect('master/barang');
	}

	public function views($id)
	{
		$query = $this->db->where('id_obat',$id)
						->get('tb_data_obat');

		if ($query->num_rows() > 0) 
		{
			$data['title'] 		= 'Master Obat';
			$this->apotek->content('master/barang/views',$data);
		}
	}

	public function edit()
	{
		$this->form_validation->set_rules('id_obat', 'Id_obat','trim|required');
		$this->form_validation->set_rules('nama_obat', 'Nama_obat','trim|required');
		$this->form_validation->set_rules('jenis_obat', 'Jenis_obat','trim|required');
		$this->form_validation->set_rules('satuan_obat', 'Satuan_obat','trim|required');
		$this->form_validation->set_rules('kategori_obat', 'Kategori_obat','trim|required');
		
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data obat tidak dapat diubah. Silahkan coba lagi');
        }
        else
    	{
			$file_name                  = mt_rand(1000,9999);
			$config['upload_path'] 		= './assets/img/obat/';
			$config['allowed_types'] 	= 'gif|jpg|png';
			$config['max_size']			= '1024';
			$config['file_name'] 		= $file_name;
			$config['max_width'] 		= '1024';
			$config['max_height'] 		= '768';

			$this->upload->initialize($config);

    		if (!$this->upload->do_upload('gambar_obat')) 
			{
				$data_obat 	= array(
							'nama_obat'				=> strtoupper($this->input->post('nama_obat')),
							'id_satuan' 			=> $this->input->post('satuan_obat'),
							'id_jenis'				=> $this->input->post('jenis_obat'),
							'id_kategori' 			=> $this->input->post('kategori_obat'),
							'keterangan' 			=> $this->input->post('keterangan_obat'),
							'id_user_edit' 			=> $this->session->userdata('id_user')
						);
		    	$this->db->where('id_obat',$this->input->post('id_obat'))
		    			->update('tb_data_obat',$data_obat);	
			}
			else
			{

				$data_obat2 	= array(
								'nama_obat'				=> $this->input->post('nama_obat'),
								'id_satuan' 			=> $this->input->post('satuan_obat'),
								'id_jenis'				=> $this->input->post('jenis_obat'),
								'id_kategori' 			=> $this->input->post('kategori_obat'),
								'keterangan' 			=> $this->input->post('keterangan_obat'),
								'id_user_edit' 			=> $this->session->userdata('id_user'),
								'foto'					=> $this->upload->data('file_name')
							);
				$this->db->where('id_obat',$this->input->post('id_obat'))
		    			->update('tb_data_obat',$data_obat2);	
			}


				$logs_menu 			= 'Data Master -> Master Obat -> edit Data Obat';
				$logs_keterangan 	= 'Mengubah data obat dengan ID obat : '. $this->input->post('id_obat');

				$this->apotek->log_user($logs_menu,$logs_keterangan);
				$this->apotek->pesan_sukses('data obat dengan ID Obat : '.$this->input->post('id_obat').' berhasil diubah');
    	}

    	redirect('master/barang');
	}

	public function delete()
	{
		$this->form_validation->set_rules('id_obat', 'Id_obat','trim|required');
		
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data obat tidak dapat dihapus. Silahkan coba lagi');
        }
        else
    	{
    		$this->db->where('id_obat',$this->input->post('id_obat'))
    				->delete('tb_data_obat');

    		$logs_menu 			= 'Data Master -> Master Obat -> Hapus Data Obat';
			$logs_keterangan 	= 'Menghapus data obat dengan ID obat : '. $this->input->post('id_obat');

			$this->apotek->log_user($logs_menu,$logs_keterangan);

    		$this->apotek->pesan_sukses('ID obat : '.$this->input->post('id_obat').' berhasil dihapus.');
    	}

    	redirect('master/barang');
	}
}
