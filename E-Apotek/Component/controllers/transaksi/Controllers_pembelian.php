<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_pembelian extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Pembelian Barang';
		$this->apotek->content('transaksi/pembelian/menu_pembelian',$data);
	}

	public function save()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$transaksi = $this->session->userdata('cart_transaksi_pembelian');
			
			// cek jika session untuk no faktur pembelian ada
			if (!empty($transaksi['no_faktur'])) 
			{
				$this->form_validation->set_rules('no_faktur', 'no_faktur','trim|required');
				$this->form_validation->set_rules('jenis_transaksi', 'Jenis_transaksi','trim|required');
				$this->form_validation->set_rules('total_items', 'total_items','trim|required');
				$this->form_validation->set_rules('total_bayar', 'total_bayar','trim|required');
				
				if ($transaksi['jenis_transaksi'] === 'LUNAS') 
				{
					$this->form_validation->set_rules('dibayar', 'dibayar','trim|required');
				}
				elseif($transaksi['jenis_transaksi'] === 'HUTANG')
				{
					$this->form_validation->set_rules('hutang', 'Hutang','trim|required');
				}

				if ($this->form_validation->run())
				{
					// membuat variabel yang diperlukan untuk proses simpan
					$apotek 			= $this->apotek->e_apotek();
					$id_user 			= $this->session->userdata('id_user');
					$no_faktur 			= $transaksi['no_faktur'];
					$tgl_transaksi 		= date('Y-m-d', strtotime($transaksi['tgl_transaksi']));
					$jenis_transaksi 	= $transaksi['jenis_transaksi'];
					$total_items 		= $this->input->post('total_items',TRUE);
					$total_bayar 		= $this->input->post('total_bayar',TRUE);
					$tgl_sekarang 	 	= date('Y-m-d');
					$tgl_jatuh_tempo 	= date('Y-m-d',strtotime($this->input->post('hutang')));
					
					if ($transaksi['jenis_transaksi'] == 'TUNAI') 
					{
						$dibayar = $this->input->post('dibayar',TRUE);
					}
					else
					{
						$dibayar = 0;
					}

					$sisa_bayar = $dibayar - $total_bayar ;

					// proses 2
					// rule 2 transaksi penjualan
					// cek jika uang yg dibayar kurang dari total yang harus dibayar
					if ($transaksi['jenis_transaksi'] === 'TUNAI' AND $sisa_bayar < 0) 
					{
						$this->apotek->pesan_error('transaksi yang dibayar kurang dari total pembayaran');
					}
					elseif ($transaksi['jenis_transaksi'] === 'HUTANG' AND $tgl_sekarang > $tgl_jatuh_tempo) 
					{
						$this->apotek->pesan_error('tanggal jatuh tempo tidak boleh dibawah dari tanggal sekarang');
					}
					else
					{
						// proses 3
						// mengambil items yang akan dijual berdasarkan no faktur penjualan
						$jumlah_transaksi = 0;
						$faktur = $this->db->where('no_faktur',$no_faktur)
										->where('payment','FALSE')
										->where('id_user',$this->session->userdata('id_user'))
										->get('tb_cart_pembelian');

						if ($faktur->num_rows() > 0) 
						{
							foreach ($faktur->result() as $items) 
							{
								$jumlah_transaksi++;
								
								// proses perbaharui stok obat
								$stok = $this->db->where('id_barang',$items->id_barang)
												->get('tb_data_stok');
							
								// cek jika data barang sudah ada
								// jika ada maka akan memperbaharui stok barang yang lama
								if ($stok->num_rows() > 0) 
								{
									// jika data pembelian ada. update stok barang lama
									$this->stok_sekarang 	= $items->qty + $stok->row()->stok_masuk;
									$stok_masuk 			= array('stok_masuk' => $this->stok_sekarang);
									$this->db->where('id_barang',$items->id_barang)
											->update('tb_data_stok',$stok_masuk);
								}
								else
								{
									// jika data pembelian tidak ditemukan masukan stok barang yang baru dibeli
									$stok_masuk 	= array(
															'id_barang' => $items->id_barang,
															'stok_masuk' => $items->qty);
									$this->db->insert('tb_data_stok',$stok_masuk);
								}

								// proses menyimpan data kartu stok obat
								$nama_suplier 	= $this->master_suplier->where($items->id_suplier);

								$dtkartu_stok = array(
													'id_barang' 	=> $items->id_barang,
													'tgl_transaksi' => $items->tgl_transaksi,
													'no_faktur'		=> $items->no_faktur,
													'keterangan' 	=> 'Pembelian barang dari '.$nama_suplier->suplier,
													'masuk'			=> $items->qty,
													'keluar'		=> 0,
													'id_user' 		=> $items->id_user);

								$this->data_stok->kartu_stok($dtkartu_stok);

								// proses menentukan harga penjualan berdasarkan harga pokok penjualan dan keuntungan persen penjualan
								$harga_barang = $this->db->where('id_barang',$items->id_barang)
														->get('tb_harga_barang');

								if ($harga_barang->num_rows() > 0) 
								{

									if ($apotek->hpp == 'RATA-RATA') 
									{
										$stok_sekarang 		= $this->stok_sekarang - $items->qty;
										$a 					= $harga_barang->row()->hpp; 			// harga hpp lama
										$b 					= $stok_sekarang; 						// jumlah stok lama
										$c 					= $items->harga_pokok; 					// harga pokok baru
										$d 					= $items->qty; 							// jumlah stok baru
										$hpp 				= (($a*$b)+($c*$d))/($b+$d);
										// HPP = (( A x B) + ( C x D ) ) : ( B + D)
									}
									else
									{
										//$stok_sekarang 		= $this->stok_sekarang - $items->qty;
										$a 					= $harga_barang->row()->hpp; 			// harga hpp lama
										//$b 					= $stok_sekarang; 						// jumlah stok lama
										$c 					= $items->harga_pokok; 					// harga pokok baru
										//$d 					= $items->qty; 							// jumlah stok baru
										//$hpp 				= (($a*$b)+($c*$d))/($b+$d);
										//$laba 				= $this->apotek->laba($items->id_barang,$hpp);

										// HPP = (( A x B) + ( C x D ) ) : ( B + D)

										if ($a > $c) 
										{
											$hpp = $a;
										}
										else
										{
											$hpp = $c;
										}
									}

									$laba 				= $this->apotek->laba($items->id_barang,$hpp);

									$proses_harga = array(
															'hpp' 		=> $hpp,
															'hju' 		=> $laba['hju'],
															'hjd' 		=> $laba['hjd'],
															'hjr' 		=> $laba['hjr'],
														);

									$this->db->where('id_barang',$items->id_barang)
											->update('tb_harga_barang',$proses_harga); 
								}
								else
								{
									if ($apotek->hpp == 'RATA-RATA') 
									{
										$a 					= 0; 									// harga hpp lama
										$b 					= 0; 									// jumlah stok lama
										$c 					= $items->harga_pokok; 					// harga pokok baru
										$d 					= $items->qty; 							// jumlah stok baru
										$hpp 				= (($a*$b)+($c*$d))/($b+$d);
									}
									else
									{
										$hpp = $items->harga_pokok;
									}

									$laba 				= $this->apotek->laba($items->id_barang,$hpp);

									$proses_harga = array(	'id_barang' => $items->id_barang,
															'hpp' 		=> $hpp,
															'hju' 		=> $laba['hju'],
															'hjd' 		=> $laba['hjd'],
															'hjr' 		=> $laba['hjr'],
														);

									$this->db->insert('tb_harga_barang',$proses_harga); 
								}

								// cek struk penjualan berdasarkan no faktur jika sudah ada lewati proses.
								$struk_pembelian = $this->db->where('no_faktur',$no_faktur)
															->get('tb_struk');

								if ($struk_pembelian->num_rows() > 0) 
								{
									// lanjutkan proses jika no faktur pada tabel struk telah dibuat
									continue;
								}
								else
								{
									// proses menyimpan data struk dengan no faktur baru.
									$data_struk = array('no_faktur' 		=> $no_faktur,
														'total_items' 		=> $total_items,
														'total_harga' 		=> $total_bayar,
														'dibayar' 			=> $dibayar,
														'kembalian' 		=> $sisa_bayar,
														'jenis_struk' 		=> 'PEMBELIAN',
														'jenis_transaksi' 	=> $jenis_transaksi,
														'tgl_transaksi' 	=> $tgl_transaksi,
														'id_user' 			=> $id_user,
													);
									$this->db->insert('tb_struk',$data_struk);
								}

								if ($transaksi['jenis_transaksi'] === 'KONSINYASI') 
								{ 
									$data_konsinyasi = array(	'no_faktur' 	 => $no_faktur,
																'id_beli' 		 => $items->id_beli,
																'qty_dibayar' 	 => 0,
																'barang_dibayar' => 0,
																'total_qty' 	 => $items->qty,
																'harga_barang' 	 => $items->harga_pokok,
																'total_bayar' 	 => $items->total_harga,
																'status' 		 => 'BELUM LUNAS'
														);
									$this->db->insert('tb_data_konsinyasi',$data_konsinyasi);
								}
							}

							if ($transaksi['jenis_transaksi'] === 'HUTANG') 
							{
								$data_hutang = array('no_faktur' 	=> $no_faktur,
													'dibayar' 		=> 0,
													'total_bayar' 	=> $total_bayar,
													'status' 		=> 'BELUM LUNAS',
													'jatuh_tempo' 	=> date('Y-m-d',strtotime($this->input->post('hutang')))
												);
								$this->db->insert('tb_data_hutang',$data_hutang);
							}

							if ($transaksi['jenis_transaksi'] === 'TUNAI') 
							{
								// proses menyimpan data transaksi
								$transaksi = array(
													'tgl_transaksi'		=> $transaksi['tgl_transaksi'],
													'akun'				=> 'PEMBELIAN BARANG',
													'jenis' 			=> 'PENGELUARAN',
													'debet'				=> 0,
													'kredit'			=> $total_bayar,
													'keterangan' 		=> 'Melakukan pembelian barang dengan no faktur : '.$no_faktur,
													'id_user' 			=> $this->apotek->users()->id_users
												);
								$this->db->insert('tb_data_transaksi',$transaksi);

							}

							// proses menyimpan data pembelian
							$proses = array('payment' => 'TRUE');
							$this->db->where('no_faktur',$no_faktur)
										->where('id_user',$this->session->userdata('id_user'))
										->where('payment','FALSE')
										->update('tb_cart_pembelian',$proses);

							// membuat log user
							$logs_menu 			= 'Transaksi -> Pembelian -> Save';
							$logs_keterangan 	= 'Melakukan transaksi pembelian dengan jenis transaksi : '.$transaksi['jenis_transaksi'].' jumlah items pembelian '.$jumlah_transaksi.' dengan No Faktur: '.$no_faktur;	
							$this->apotek->log_user($logs_menu,$logs_keterangan);
							$this->apotek->pesan_sukses('transaksi dengan no faktur: '.$no_faktur .' berhasil simpan.');
							$this->apotek->set_label($no_faktur,'new',90);

							// menghapus session cart pembelian
							$this->session->unset_userdata('cart_transaksi_pembelian');
							// redirect ke nota pembelian
							$this->apotek->redirect();
						}
						else
						{
							$this->apotek->pesan_error('No.faktur tidak valid. transaksi dengan no faktur: '.$no_faktur .' tidak dapat diproses');
						}
					}
				}
				else
				{
					$this->apotek->pesan_error('silahkan coba lagi.');
				}
			}
			else
			{
				// link nomor faktur yang dumasukan tidak valid
				$this->apotek->pesan_error('No.faktur tidak valid. transaksi penjualan tidak dapat diproses');
			}
		}
		else
		{
			// redirect jika user belum login
			$this->apotek->pesan_error('Silahkan login untuk mengakses menu ini');
		}

		$this->apotek->redirect();
	}

	public function print_faktur($no_faktur)
	{
		// cek jika user telah login
		if ($this->authentikasi->login() == TRUE) 
		{
			$query = $this->db->where('no_faktur',$no_faktur)
							->get('tb_struk');
			if ($query->num_rows() > 0) 
			{
				// menampilkan struk transaksi pembayaran
				$data['no_faktur'] = $no_faktur;
				$this->load->view('content/print/laporan_struk_pembelian.php',$data);
			}
			else
			{
				$this->apotek->redirect('transaksi/pembelian/print/'.$no_faktur);
			}
		}
		else
		{
			// redirect jika belum login.
			$this->apotek->redirect();
		}
	}

	public function reset()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$transaksi 	 	= $this->session->userdata('cart_transaksi_pembelian');
			
			$this->db->where('no_faktur',$transaksi['no_faktur'])
						->where('payment','FALSE')	
						->delete('tb_cart_pembelian');
			$this->session->unset_userdata('cart_transaksi_pembelian');
		}
		
		$this->apotek->redirect();
	}

	public function action_delete()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('id_beli[]', 'Id_beli[]','trim|required');

			if ($this->form_validation->run())
			{
				$transaksi = $this->session->userdata('cart_transaksi_pembelian');
				foreach ($this->input->post('id_beli[]') as $id_beli) 
				{
					$this->db->where('id_beli',$id_beli)
							->where('no_faktur',$transaksi['no_faktur'])
							->where('id_user',$this->session->userdata('id_user'))
							->where('payment','FALSE')
							->delete('tb_cart_pembelian');
				}

				$this->apotek->pesan_sukses('items yang dipilih berhasil dihapus dalam keranjang transaksi pembelian');
			}
			else
			{
				$this->apotek->pesan_error('silahkan check items yang ingin dihapus dalam keranjang pembelian');
			}
		}

		$this->apotek->redirect();
	}

	public function proses()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('id_faktur', 'Id_faktur','trim|required');
			$this->form_validation->set_rules('tgl_pembelian', 'Tgl_pembelian','trim|required');
			$this->form_validation->set_rules('suplier', 'Suplier','trim|required');
			$this->form_validation->set_rules('jenis_transaksi', 'Jenis_transaksi','trim|required');

			if ($this->form_validation->run())
			{
				$tgl_sekarang 	= date('Y-m-d');
				$tgl_transaksi 	= date('Y-m-d',strtotime($this->input->post('tgl_pembelian')));
				$login_access 	= $this->session->userdata('access');

				if ($login_access == "KASIR") 
				{
					$waktu_sekarang 	= time();
					$batas_waktu 		= $waktu_sekarang - 24 * 7 * 60 * 60;
					$batas_transaksi 	= date('Y-m-d',$batas_waktu);

					if (strtotime($batas_transaksi) > strtotime($tgl_transaksi))
					{
						$this->apotek->pesan_error('transaksi tidak dapat di proses. kasir hanya bisa mencetak periode tgl transaksi penjualan dari : '. $this->apotek->date($batas_transaksi).' s/d '.$this->apotek->date($tgl_sekarang));
						return $this->apotek->redirect();
					}
				}

				if (strtotime($tgl_sekarang) < strtotime($tgl_transaksi))
				{
					$this->apotek->pesan_error('transaksi tidak dapat di proses. tgl transaksi tidak boleh lewat dari tanggal sekarang.');
				}
				else
				{
					$proses = array('no_faktur' 		=> $this->input->post('id_faktur'),
									'tgl_transaksi' 	=> $tgl_transaksi,
									'id_suplier' 		=> $this->input->post('suplier'),
									'jenis_transaksi' 	=> $this->input->post('jenis_transaksi')
									);

					$this->session->set_userdata('cart_transaksi_pembelian', $proses);
				}
			}
			else
			{
				$this->apotek->pesan_error('transaksi tidak dapat di proses. silahkan coba lagi');
			}
		}

		$this->apotek->redirect();
	}

	public function proses_obat()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('id_beli', 'Id_beli','trim|required');
			$this->form_validation->set_rules('nama_obat', 'Nama_obat','trim|required');
			$this->form_validation->set_rules('qty', 'Qty','trim|required');
			$this->form_validation->set_rules('lokasi', 'Lokasi','trim|required');
			$this->form_validation->set_rules('harga', 'Harga','trim|required');
			$this->form_validation->set_rules('expired_date', 'Expired_date','trim|required');
			
			if ($this->form_validation->run())
			{
				$tgl_sekarang 	= date('Y-m-d');
				$tgl_expired 	= date('Y-m-d',strtotime($this->input->post('expired_date')));
				$id_lokasi 		= $this->input->post('lokasi');
				$cek_lokasi 	= $this->db->where('id_lokasi',$id_lokasi)
											->get('tb_lokasi_barang');
				if ($cek_lokasi->num_rows() > 0) 
				{
					$lokasi 				= $cek_lokasi->row();
					$kapasitas_penyimpanan  = $lokasi->total_kapasitas;
				}
				else
				{
					$kapasitas_penyimpanan = 0;
				}

				$query_hitung_items_lokasi = $this->db->where('id_lokasi',$id_lokasi)
													->get('tb_cart_pembelian');
				$total_items_lokasi  = count($query_hitung_items_lokasi->result());

				if ($kapasitas_penyimpanan < $total_items_lokasi) 
				{
					$this->apotek->pesan_error('items tidak dapat dimasukan kedalam keranjang pembelian. lokasi penyimpanan yang dipilih sudah full. silahkan coba lagi dan gunakan lokasi penyimpanan yang lain.');
				}
				elseif (strtotime($tgl_sekarang) > strtotime($tgl_expired)) 
				{
					
					$this->apotek->pesan_error('items yang dipilih tidak layak dibeli items telah exprired. silahkan coba items lain.');
				}
				else
				{
					$transaksi 	 	= $this->session->userdata('cart_transaksi_pembelian');	
					$cek_barang 	= $this->db->where('no_faktur',$transaksi['no_faktur'])
												->where('id_barang',$this->input->post('nama_obat'))
												->get('tb_cart_pembelian');
					
					if ($cek_barang->num_rows() == 1) 
					{
						$this->apotek->pesan_error('items yang dipilih sudah ada dalam keranjang pembelian. silahkan coba lagi');
					}
					else
					{

						// proses perhitungan untuk menentukan harga penjualan berdasarkan hpp.
						$harga_beli 	= $this->input->post('harga');
						$qty 			= $this->input->post('qty');
						$harga_pokok 	= $harga_beli / $qty;
						
						if ($this->input->post('discount') === '') 
						{
							$disc 	   		= 0;
							$harga_discount = $qty * $harga_pokok;	
						}
						else
						{
							$disc 			 = $this->input->post('discount');
							$harga 			 = $qty * $harga_pokok;
							$harga_discount  = $harga - $disc / 100 * $harga;
						}

						if ($this->input->post('ppn') === '') 
						{
							$ppn 		= 0;
							$sub_total 	= $harga_discount;
						}
						else
						{
							$ppn 		= $this->input->post('ppn');
							$harga 		= $harga_discount;
							$sub_total  = $harga + $ppn / 100 * $harga;
						}

						// proses menyimpan data pembelian.
						$proses_obat 	= array(
												'no_faktur' 		=> $transaksi['no_faktur'],
												'id_suplier' 		=> $transaksi['id_suplier'],
												'tgl_transaksi' 	=> $transaksi['tgl_transaksi'],
												'jenis_transaksi'	=> $transaksi['jenis_transaksi'],
												'id_beli' 			=> $this->input->post('id_beli'),
												'id_barang' 		=> $this->input->post('nama_obat'),
												'id_lokasi' 		=> $this->input->post('lokasi'),
												'qty' 				=> $qty,
												'discount' 			=> $disc,
												'ppn' 				=> $ppn,
												'harga_pokok' 		=> $harga_pokok,
												'total_harga' 		=> $sub_total,
												'expired_date' 		=> $tgl_expired,
												'id_user' 			=> $this->session->userdata('id_user'),
												'payment' 			=> 'FALSE'
											);
						
						$this->apotek->set_label($this->input->post('id_beli'),'New');
						$this->db->insert('tb_cart_pembelian',$proses_obat);
						$this->apotek->pesan_sukses('items berhasil ditambahkan dalam keranjang pembelian');
					}
				}
			}
			else
			{
				$this->apotek->pesan_error('items tidak dapat di tambahkan ke keranjang pembelian. silahkan coba lagi');
			}
		}

		$this->apotek->redirect();
	}

	public function retur()
	{
		$data['title'] 		= 'Retur Pembelian Barang';
		$this->apotek->content('transaksi/pembelian/retur_pembelian',$data);
	}

	public function proses_retur()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('no_faktur', 'No_faktur','trim|required');
			$this->form_validation->set_rules('suplier', 'Suplier','trim|required');
			$this->form_validation->set_rules('tgl_retur', 'tgl_retur','trim|required');

			if ($this->form_validation->run())
			{
				$tgl_sekarang 	= date('Y-m-d');
				$tgl_transaksi 	= date('Y-m-d',strtotime($this->input->post('tgl_retur')));
				$login_access 	= $this->session->userdata('access');

				if ($login_access == "KASIR") 
				{
					$waktu_sekarang 	= time();
					$batas_waktu 		= $waktu_sekarang - 24 * 7 * 60 * 60;
					$batas_transaksi 	= date('Y-m-d',$batas_waktu);

					if (strtotime($batas_transaksi) > strtotime($tgl_transaksi))
					{
						$this->apotek->pesan_error('transaksi tidak dapat di proses. kasir hanya bisa mencetak periode tgl transaksi penjualan dari : '. $this->apotek->date($batas_transaksi).' s/d '.$this->apotek->date($tgl_sekarang));
						return $this->apotek->redirect();
					}
				}
				
				// cek tgl transaksi tidak melebihi tanggal hari ini.
				if (strtotime($tgl_sekarang) < strtotime($tgl_transaksi))
				{
					$this->apotek->pesan_error('transaksi tidak dapat di proses. tgl retur tidak boleh lewat dari tanggal sekarang.');
				}
				else
				{
					$cek_faktur = $this->db->where('no_faktur',$this->input->post('no_faktur'))
											->where('id_suplier',$this->input->post('suplier'))
											->where('payment','TRUE')
											->get('tb_cart_pembelian');

					if ($cek_faktur->num_rows() > 0) 
					{
						$faktur = $cek_faktur->row();

						if ($faktur->tgl_transaksi <= $tgl_transaksi) 
						{
							$proses = array(
										
										'no_retur' 				=> 'F-RB'.date('ymd-His-').$faktur->id_user,
										'no_faktur' 			=> $faktur->no_faktur,
										'tgl_transaksi' 		=> $faktur->tgl_transaksi,
										'tgl_retur' 			=> $tgl_transaksi,
										'id_user' 				=> $faktur->id_user,
										'id_suplier' 			=> $faktur->id_suplier,
										'jenis_transaksi' 		=> $faktur->jenis_transaksi,
										'jenis_retur' 			=> 'PEMBELIAN',
							);

							$this->session->set_userdata('cart_retur_pembelian', $proses);
						}
						else
						{
							$this->apotek->pesan_error('tgl retur tidak boleh dibawah dari tgl transaksi pembelian untuk no faktur tsb.<br/> tgl transaksi untuk no faktur : '.$faktur->no_faktur.' adalah '. date('d-m-Y',strtotime($faktur->tgl_transaksi)));
						}
					}
					else
					{
						$this->apotek->pesan_error('No faktur tidak cocok dengan nama suplier. silahkan masukan data dengan benar.');
					}
				}
			}
			else
			{
				$this->apotek->pesan_error('transaksi tidak dapat di proses. silahkan coba lagi');
			}
		}

		$this->apotek->redirect();
	}

	public function proses_retur_items()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('id_beli', 'Id_beli','trim|required');
			$this->form_validation->set_rules('id_barang', 'Id_barang','trim|required');
			$this->form_validation->set_rules('retur', 'Retur','trim|required');
			$this->form_validation->set_rules('qty', 'Qty','trim|required');

			if ($this->form_validation->run())
			{
				$transaksi 		= $this->session->userdata('cart_retur_pembelian');
				$qty 			= $this->input->post('qty');
				$id_barang 		= $this->input->post('id_barang');
				$id_retur 		= $this->input->post('id_beli');
				$jumlah_retur 	= $this->input->post('retur');
				$id_user 		= $this->apotek->users()->id_users;
				$jenis_retur 	= 'PEMBELIAN';
				$status 		= 'FALSE';
				$data 			= array(
											'faktur' 		=> $transaksi['no_faktur'],
											'no_retur' 		=> $transaksi['no_retur'],
											'id_retur' 		=> $id_retur,
											'id_barang'     => $id_barang,
											'jumlah_retur'	=> $jumlah_retur,
											'id_user' 		=> $id_user,
											'jenis_retur' 	=> $jenis_retur,
											'status' 		=> $status,
											'tgl_retur' 	=> $transaksi['tgl_retur'],
										);
				
				$cek_id 		= $this->db->where('no_retur',$transaksi['no_retur'])
											->where('id_retur',$id_retur)
											->get('tb_data_retur');
				
				$stok = $this->db->where('id_barang',$id_barang)->get('tb_data_stok');
				if ($stok->num_rows() > 0) 
				{
					$sisa_stok = $stok->row();
					$sisa_stok = $sisa_stok->stok_masuk - $sisa_stok->stok_keluar;
				}
				else
				{
					$sisa_stok = 0;
				}
				

				if ($sisa_stok < $jumlah_retur) 
				{
					$this->apotek->pesan_error('jumlah stok barang saat ini '.$sisa_stok.' jumlah retur tidak boleh lebih dari sisa stok');
				}
				elseif ($qty < $jumlah_retur) 
				{
					$this->apotek->pesan_error('retur tidak dapat di proses. jumlah retur tidak boleh lebih dari '.$qty.'. silahkan coba lagi');
				}
				elseif ($cek_id->num_rows() > 0) 
				{
					$stok = $this->db->where('id_barang',$id_barang)->get('tb_data_stok');
					$stok = $stok->row()->stok_masuk - $stok->row()->stok_masuk;

						$this->db->where('id_retur',$id_retur)
								->update('tb_data_retur',$data);
						$this->apotek->pesan_sukses('items berhasil diperbaharui dalam daftar retur.');
				}
				else
				{
					
					$this->db->insert('tb_data_retur',$data);
					$this->apotek->pesan_sukses('items berhasil ditambahkan dalam daftar retur.');
				}
			}
			else
			{
				$this->apotek->pesan_error('retur tidak dapat di proses. silahkan coba lagi');
			}
		}

		$this->apotek->redirect();
	}

	public function retur_save()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('no_retur', 'No_retur','trim|required');
			$this->form_validation->set_rules('total_retur', 'total_retur','trim|required');
			
			if ($this->form_validation->run())
			{
				$transaksi = $this->session->userdata('cart_retur_pembelian');
				if (!empty($transaksi['no_retur'])) 
				{
					$total = $this->input->post('total_retur');
					$user  = $this->apotek->users();
					$query = $this->db->where('no_retur',$transaksi['no_retur'])
										->where('status','FALSE')
										->where('jenis_retur','PEMBELIAN')
										->where('id_user',$user->id_users)
										->get('tb_data_retur');
					if ($query->num_rows() > 0)
					{
						foreach ($query->result() as $retur) 
						{
							$stok_barang = $this->db->where('id_barang',$retur->id_barang)
													->get('tb_data_stok');
							
							if ($stok_barang->num_rows() > 0) 
							{
								$barang 	 = $stok_barang->row();
								$stok_masuk  = $barang->stok_masuk - $retur->jumlah_retur;
								$update_stok = array('stok_masuk' => $stok_masuk);
								
								$this->db->where('id_barang',$barang->id_barang)
											->update('tb_data_stok',$update_stok);

								$dtkartu_stok = array(
													'id_barang' 	=> $barang->id_barang,
													'tgl_transaksi' => $transaksi['tgl_retur'],
													'no_faktur'		=> $transaksi['no_retur'],
													'keterangan' 	=> 'Retur Pembelian barang dengan no. faktur pembelian : '.$transaksi['no_faktur'],
													'masuk'			=> 0,
													'keluar'		=> $retur->jumlah_retur,
													'id_user' 		=> $retur->id_user
													);
								$this->data_stok->kartu_stok($dtkartu_stok);
							}
						}

						// proses menyimpan data transaksi
						$dt_transaksi = array(
										'tgl_transaksi'		=> $transaksi['tgl_retur'],
										'akun'				=> 'RETUR PEMBELIAN',
										'jenis' 			=> 'PEMASUKAN',
										'debet'				=> $total,
										'kredit'			=> 0,
										'keterangan' 		=> 'Melakukan retur pembelian barang dengan no retur : '.$transaksi['no_retur'],
										'id_user' 			=> $this->apotek->users()->id_users
									);

						$this->db->insert('tb_data_transaksi',$dt_transaksi);

						$data_retur = array('status' => 'TRUE');
						
						$this->db->where('no_retur', $transaksi['no_retur'])
								->where('id_user', $user->id_users)
								->where('status', 'FALSE')
								->where('jenis_retur','PEMBELIAN')
								->update('tb_data_retur',$data_retur);

						$logs_menu 			= 'Transaksi -> Retur Pembelian -> Save';
						$logs_keterangan 	= 'Melakukan transaksi Retur pembelian dengan dengan No. Retur : '.$transaksi['no_retur'];	
						$this->apotek->log_user($logs_menu,$logs_keterangan);

						$this->session->unset_userdata('cart_retur_pembelian');
						$this->apotek->pesan_sukses('transaksi retur pembelian berhasil disimpan.');
					}
					else
					{
						$this->apotek->pesan_error('retur tidak dapat di simpan. silahkan coba lagi');
					}
				}
				else
				{
					$this->apotek->pesan_error('retur tidak dapat di simpan. No retur tidak valid');
				}

			}
			else
			{
				$this->apotek->pesan_error('retur tidak dapat di simpan. silahkan coba lagi');
			}
		}
		
		$this->apotek->redirect();
	}

	public function retur_reset()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$user  = $this->apotek->users();
			$transaksi 	 	= $this->session->userdata('cart_retur_pembelian');
			$this->db->where('id_user',$user->id_users)
						->where('status','FALSE')	
						->where('jenis_retur','PEMBELIAN')
						->delete('tb_data_retur');
			$this->session->unset_userdata('cart_retur_pembelian');
		}
		
		$this->apotek->redirect();
	}
}
