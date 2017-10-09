<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends E_Apotek_Controller 
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

	public function proses_laba()
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
							$beli = $this->db->where('id_beli',$items->id_beli)
											->get('tb_cart_pembelian');
							
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
															'hju' 		=> ceil($hju),
															'hjd' 		=> ceil($hjd),
															'hjr'		=> ceil($hjr)
														);
										// proses ubah harga penjualan barang
										$this->db->where('id_beli',$items->id_beli)
												->update('tb_cart_pembelian',$update_harga); 
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
}
