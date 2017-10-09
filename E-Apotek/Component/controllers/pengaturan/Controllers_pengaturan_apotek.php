<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_pengaturan_apotek extends E_Apotek_Controller 
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
		$data['title'] 		= 'Pengaturan Apotek';
		$this->apotek->content('pengaturan/apotek',$data);
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Id','trim|required');
		$this->form_validation->set_rules('no_sipa', 'no_sipa','trim|required');
		$this->form_validation->set_rules('nama_apotek', 'Nama_apotek','trim|required');
		$this->form_validation->set_rules('pemilik', 'Pemilik','trim|required');
		$this->form_validation->set_rules('saldo_awal', 'saldo_awal','trim|required');
		$this->form_validation->set_rules('hpp', 'Hpp','trim|required');
		$this->form_validation->set_rules('slogan', 'Slogan','trim|required');

		if ($this->form_validation->run())
		{
			$data_apotek = array(	'nama_apotek' 	=> $this->input->post('nama_apotek'),
									'no_sipa' 		=> $this->input->post('no_sipa'),
									'saldo_awal' 	=> $this->input->post('saldo_awal'),
									'hpp'			=> $this->input->post('hpp'),
									'owner' 		=> $this->input->post('pemilik'),
									'kota' 			=> $this->input->post('kota'),
									'alamat'		=> $this->input->post('alamat'),
									'phone'			=> $this->input->post('telp'),
									'fax'			=> $this->input->post('fax'),
									'email'			=> $this->input->post('email'),
									'slogan' 		=> $this->input->post('slogan')
								);

			$this->db->where('id_apotek',$this->input->post('id'))
					->update('tb_apotek',$data_apotek);

			$this->apotek->log_user('Pengaturan -> Apotek -> edit Data Apotek','Mengubah pengaturan apotek');
			$this->apotek->pesan_sukses('Perubahan data apotek berhasil diubah!');
		}
		else
		{
			$this->apotek->pesan_error('Perubahan data apotek gagal diubah. silahkan coba lagi.');
		}

		redirect('pengaturan/apotek');
	}

	public function update_laba_penjualan()
	{
		if ($this->authentikasi->login()) 
		{
			$this->form_validation->set_rules('hju', 'Hju','trim|required');
			$this->form_validation->set_rules('hjd', 'Hjd','trim|required');
			$this->form_validation->set_rules('hjr', 'Hjr','trim|required');

			if ($this->form_validation->run())
			{
				$data = array(	'hju' => $this->input->post('hju',TRUE),
								'hjd' => $this->input->post('hjd',TRUE),
								'hjr' => $this->input->post('hjr',TRUE),
							);

				// pencarian jika pengaturan harga sudah ada atau tidak
				$harga_jual = $this->data_laba->check();
				
				if ($harga_jual === TRUE) 
				{
					$menu 	= 'Pengaturan -> Penjualan -> Proses Laba';
					$log 	= "Melakukan Perubahan Laba Penjualan";
					$this->apotek->log_user($menu,$log);
					$this->data_laba->update($data);
					$this->apotek->pesan_sukses('laba penjualan berhasil perbaharui.');
				}
				else
				{
					$menu 	= 'Pengaturan -> Penjualan -> Proses Laba';
					$log 	= "Menyimpan Laba Penjualan";
					$this->apotek->log_user($menu,$log);
					$this->data_laba->insert($data);
					$this->apotek->pesan_sukses('laba penjualan berhasil disimpan.');
				}

				if (!empty($this->input->post('update_harga'))) 
				{

					// proses mendapatkan data harga pokok barang 
					$harga 	= $this->db->get('tb_cart_pembelian');

					if ($harga->num_rows() > 0) 
					{
						// membuat variabel untuk menghitung jumlah barang yang akan diperbaharui
						$total_n = 0;
						$total_y = 0;

						foreach ($harga->result() as $items) 
						{
							// proses mendapatkan items pembelian dari tabel cart pembelian menurut if beli
							$beli = $this->db->where('id_barang',$items->id_barang)
											->get('tb_harga_barang');
							
							if ($beli->num_rows() > 0) 
							{
								// membuat variabel harga pokok penjualan
								$items_beli 	= $beli->row();
								$harga_pokok 	= $items_beli->hpp;
							}
							else
							{
								// jika harga pokok tidak ditemukan
								$harga_pokok 	= 0;
							}

								//proses perhitungan penjualan
								$hpp 			= $harga_pokok;
								$laba 			= $this->apotek->laba($items->id_barang,$hpp);
								$hju 			= $laba['hju'];
								$hjd 			= $laba['hjd'];
								$hjr 			= $laba['hjr'];

								if ($hpp >= $hju OR $hpp >= $hjd OR $hpp >= $hjr) 
								{
									$total_n++;
									continue;
								}
								else
								{
									$master_barang  = $this->master_barang->check_id($items->id_barang);

									if ($master_barang == TRUE) 
									{
										$total_y++;
										$update_harga 	= array(
															'hju' 		=> $hju,
															'hjd' 		=> $hjd,
															'hjr'		=> $hjr
														);
										// proses ubah harga penjualan barang
										$this->db->where('id_barang',$items->id_barang)
												->update('tb_harga_barang',$update_harga); 
									}
									else
									{
										$total_n++;
									}
								}

							$this->apotek->pesan_sukses('<br/>Harga penjualan barang yang berhasil diperbaharui : '.$total_y.' items<br/>'.
								'Harga penjualan barang yang gagal diperbaharui : '.$total_n.' items');
						}
						
						$menu 	= 'Data Obat -> Rincian Obat -> Proses Harga Obat';
						$log 	= "Melakukan Perubahan harga Penjualan pada semua items";
						$this->apotek->log_user($menu,$log);
					}
					else
					{
						$this->apotek->pesan_error('Perubahan untuk harga penjualan tidak dapat diperbaharui. items penjualan tidak ditemukan');
					}
				}
			}
			else
			{
				$this->apotek->pesan_error('perubahan laba penjualan gagal di update. silahkan coba lagi');
			}
		}

		$this->apotek->redirect();
	}

	public function database()
	{
		$data['title'] 		= 'Backup / Restore E-Apotek Online';
		$this->apotek->content('pengaturan/backup',$data);
	}

	public function database_backup()
	{
		if ($this->authentikasi->login()) 
		{
			$this->apotek->backup_db();
		}
	}

	public function config_backup()
	{
		if ($this->authentikasi->login()) 
		{
			$this->apotek->backup_config();
		}
	}

	public function config_decrypt()
	{
		if ($this->authentikasi->login()) 
		{
			$this->form_validation->set_rules('config_encrypt', 'config_encrypt','trim|required');

			if ($this->form_validation->run())
			{
				$encrypt = $this->input->post('config_encrypt');
				$this->apotek->restore_config($encrypt);
			}
			else
			{
				$this->apotek->pesan_error('ENCRYPT CONFIG FILE tidak valid');
			}
		}

		$this->apotek->redirect();
	}

	public function database_decrypt()
	{
		if ($this->authentikasi->login()) 
		{
			$this->form_validation->set_rules('db_encrypt', 'db_encrypt','trim|required');

			if ($this->form_validation->run())
			{
				$encrypt = $this->input->post('db_encrypt');
				
				$this->apotek->restore_db($encrypt);
			}
			else
			{
				$this->apotek->pesan_error('ENCRYPT DB FILE tidak valid');
			}
		}

		$this->apotek->redirect();
	}
}
