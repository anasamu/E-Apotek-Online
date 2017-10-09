<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_penjualan extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Penjualan Barang';
		$this->apotek->content('transaksi/penjualan/menu_penjualan',$data);
	}

	public function proses()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('id_faktur', 'Id_faktur','trim|required');
			$this->form_validation->set_rules('tgl_transaksi', 'tgl_transaksi','trim|required');
			$this->form_validation->set_rules('jenis_transaksi', 'Jenis_transaksi','trim|required');

			if ($this->form_validation->run())
			{
				$tgl_sekarang 	= date('Y-m-d');
				$tgl_transaksi 	= date('Y-m-d',strtotime($this->input->post('tgl_transaksi')));
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
					$this->apotek->pesan_error('transaksi tidak dapat di proses. tgl transaksi tidak boleh lewat dari tanggal sekarang.');
				}
				else
				{
					// menghapus transaksi sebelumnya yang belum di save
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

					$proses = array(
										$this->input->post('id_faktur') => $this->input->post('id_faktur'),
										'no_faktur' 					=> $this->input->post('id_faktur'),
										'tgl_transaksi' 				=> $tgl_transaksi,
										'jenis_transaksi' 				=> $this->input->post('jenis_transaksi')
									);

					$this->session->set_userdata('cart_transaksi_penjualan', $proses);
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
			
			if ($this->form_validation->run())
			{
				$id_barang 		= $this->input->post('nama_obat',TRUE);
				$transaksi 	 	= $this->session->userdata('cart_transaksi_penjualan');
				$cek_barang 	= $this->db->where('no_faktur',$transaksi['no_faktur'])
											->where('id_barang',$id_barang)
											->get('tb_cart_penjualan');
				$cek_stok 		= $this->db->where('id_barang',$id_barang)
											->get('tb_data_stok');
				$pembelian_barang = $this->db->where('id_barang',$id_barang)
											->where('tgl_transaksi <=',$transaksi['tgl_transaksi'])
											->get('tb_cart_pembelian');

				if ($pembelian_barang->num_rows() > 0) 
				{
					if ($cek_stok->num_rows() > 0) 
					{
						$stok 			= $cek_stok->row();
						$stok_awal 		= $stok->stok_awal;
						$stok_masuk 	= $stok->stok_masuk;
						$stok_keluar 	= $stok->stok_keluar;
						$sisa_stok 		= $stok_awal + $stok_masuk - $stok_keluar;

						if ($sisa_stok === 0) 
						{
							$this->apotek->pesan_error('items tidak dapat diproses. stok barang saat ini '.$sisa_stok.'. stok habis');
						}
						elseif ($sisa_stok < $this->input->post('qty')) 
						{
							$this->apotek->pesan_error('items tidak dapat dimasukan dalam keranjang penjualan. sisa stok barang saat ini '.$sisa_stok);
						}
						else
						{
							if ($cek_barang->num_rows() == 1) 
							{
								$this->apotek->pesan_error('items yang dipilih sudah ada dalam keranjang penjualan. silahkan coba lagi');
							}
							else
							{
								// mencari nilai harga jual
								$harga_jual 	= $this->db->where('id_barang',$id_barang)
															->get('tb_harga_barang');	
								if ($harga_jual->num_rows() > 0) 
								{
									$id_jual 	= $this->input->post('id_beli');
									$qty 		= $this->input->post('qty');
									$query 		= $harga_jual->row();

									if ($transaksi['jenis_transaksi'] === 'UMUM') 
									{
									 	$harga_pokok = $query->hju;
									}
									elseif($transaksi['jenis_transaksi'] === 'DOKTER')
									{
										$harga_pokok = $query->hjd;
									}
									else
									{
										$harga_pokok = $query->hjr;
									}

									if ($this->input->post('discount') === '') 
									{
										$disc 	   = 0;
										$sub_total = $qty * $harga_pokok;	
									}
									else
									{
										$disc 		= $this->input->post('discount');
										$harga 		= $qty * $harga_pokok;
										$sub_total  = $harga - $disc / 100 * $harga;
									}

									// rumus fifo step 1
									// mencari kata kunci id barang dan sorting tanggal transaksi secara ascending dari tabel pembelian
									// hasil akan berbentuk array
									// teknik ini untuk mencari nilai id beli dengan tanggal pembelian awal
									$fifo1 = $this->db->where('id_barang',$id_barang)
													->order_by('tgl_transaksi','ASC')
													->select('id_beli')
													->select('qty')
													->get('tb_cart_pembelian');
									
									foreach ($fifo1->result() as $dtfifo1) 
									{
										// rumus fifo step 2
										// mencari nilai id beli dengan tgl transaksi awal berdasarkan id barang yang didapatkan
										// hasil akan berbntuk array untuk mengambil id beli yang di dapatkan.
										$fifo2 = $this->db->where('id_beli',$dtfifo1->id_beli)
															->select('id_beli')
															->select('qty')
															->order_by('tgl_transaksi','ASC')
															->get('tb_cart_penjualan');
										if ($fifo2->num_rows() > 0) 
										{
											$total_penjualan_fifo = 0;
											
											foreach ($fifo2->result() as $dtfifo2) 
											{
												$total_penjualan_fifo += $dtfifo2->qty;
												// rumus fifo 3
												// menghitung jumlah barang yang dibeli berdasarkan id beli pada tabel transaksi penjualan.
												// jika jumlah barang yang dibeli masih dibawah atau sama dengan dari items pembelian barang utk tgl transaksi saat ini maka buat variabel id beli tsb.
												// jika tidak break proses perulangan untuk fifo3 dan lanjutkan perulangan fifo2
											}

											if ($total_penjualan_fifo <= $dtfifo1->qty) 
											{
												$id_beli = $dtfifo1->id_beli;
												break;
											}
										}
										else
										{
											$id_beli = $dtfifo1->id_beli;
										}
									}


									// proses menyimpan data penjualan.
									$proses_obat 	= array(

															'id_jual' 			=> $id_jual,
															'id_beli' 			=> $id_beli,
															'no_faktur' 		=> $transaksi['no_faktur'],
															'id_barang' 		=> $id_barang,
															'qty' 				=> $qty,
															'harga_jual' 		=> $harga_pokok,
															'discount' 			=> $disc,
															'sub_total' 		=> $sub_total,
															'tgl_transaksi' 	=> $transaksi['tgl_transaksi'],
															'jenis_transaksi'	=> $transaksi['jenis_transaksi'],
															'payment' 			=> 'FALSE',
															'id_user' 			=> $this->session->userdata('id_user'),
														);
									
									$this->apotek->set_label($this->input->post('id_beli'),'New');
									$this->db->insert('tb_cart_penjualan',$proses_obat);
									$this->apotek->pesan_sukses('items berhasil ditambahkan dalam keranjang penjualan');
								}
							}
						}
					}
				}
				else
				{
					$this->apotek->pesan_error('items tidak dapat ditambahkan. tgl transaksi untuk pembelian barang ini tidak ditemukan.<br/> kemungkinan barang yang dipilih belum di beli untuk tgl transaksi saat ini.');
				}
			}
			else
			{
				$this->apotek->pesan_error('items tidak dapat di tambahkan ke keranjang penjualan. silahkan coba lagi');
			}
		}

		$this->apotek->redirect();
	}

	public function save()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$transaksi = $this->session->userdata('cart_transaksi_penjualan');
			
			// Proses 1
			// rule 1 transaksi penjualan
			// cek jika session untuk no faktur penjualan ada
			if (!empty($transaksi['no_faktur']) AND $transaksi['no_faktur'] === $transaksi[$transaksi['no_faktur']]) 
			{
				$this->form_validation->set_rules('no_faktur', 'no_faktur','trim|required');
				$this->form_validation->set_rules('jenis_transaksi', 'Jenis_transaksi','trim|required');
				$this->form_validation->set_rules('total_items', 'total_items','trim|required');
				$this->form_validation->set_rules('total_bayar', 'total_bayar','trim|required');
				$this->form_validation->set_rules('dibayar', 'dibayar','trim|required');
				
				if ($this->form_validation->run())
				{
					// membuat variabel yang diperlukan untuk proses simpan
					$id_user 			= $this->session->userdata('id_user');
					$no_faktur 			= $transaksi['no_faktur'];
					$tgl_transaksi 		= date('Y-m-d', strtotime($transaksi['tgl_transaksi']));
					$jenis_transaksi 	= $transaksi['jenis_transaksi'];
					$total_items 		= $this->input->post('total_items',TRUE);
					$total_bayar 		= $this->input->post('total_bayar',TRUE);
					$dibayar 			= $this->input->post('dibayar',TRUE);
					$sisa_bayar 		= $dibayar - $total_bayar ;

					// proses 2
					// rule 2 transaksi penjualan
					// cek jika uang yg dibayar kurang dari total yang harus dibayar
					if ($sisa_bayar < 0) 
					{
						$this->apotek->pesan_error('transaksi yang dibayar kurang dari total pembayaran');
					}
					else
					{
						// proses 3
						// mengambil items yang akan dijual berdasarkan no faktur penjualan
						$jumlah_transaksi = 0;
						$items_penjualan = $this->db->where('no_faktur',$no_faktur)
													->where('payment', "FALSE")
													->where('id_user',$id_user)
													->get('tb_cart_penjualan');
						
						if ($items_penjualan->num_rows() > 0) 
						{
							foreach ($items_penjualan->result() as $penjualan) 
							{
								// proses 4
								// mencari nilai sisa stok barang berdasarkan items yang dipilih.
								$jumlah_transaksi++;
								$stok_barang = $this->db->where('id_barang',$penjualan->id_barang)
														->get('tb_data_stok');
								
								if ($stok_barang->num_rows() > 0) 
								{
									$stok 			= $stok_barang->row();
									$stok_awal 		= $stok->stok_awal;
									$stok_masuk 	= $stok->stok_masuk;
									$stok_keluar 	= $stok->stok_keluar;
									$sisa_stok 		= $stok_awal + $stok_masuk - $stok_keluar;

									// proses 5
									// rule 3 mencari nilai sisa stok yang telah habis
									if ($sisa_stok <= 0) 
									{
										$this->apotek->pesan_error('stok dari id barang '.$penjualan->id_barang.' telah habis');
									}
									else
									{
										$dtkartu_stok = array(
															'id_barang' 	=> $penjualan->id_barang,
															'tgl_transaksi' => $penjualan->tgl_transaksi,
															'no_faktur'		=> $penjualan->no_faktur,
															'keterangan' 	=> 'Penjualan barang dengan jenis transaksi penjualan '.$jenis_transaksi,
															'masuk'			=> 0,
															'keluar'		=> $penjualan->qty,
															'id_user' 		=> $penjualan->id_user
														);
										$this->data_stok->kartu_stok($dtkartu_stok);
										// proses 6
										// menambahkan nilai stok keluar berdasarkan jumlah items yang dijual
										$total_stok_keluar 	= $stok->stok_keluar + $penjualan->qty;
										$stok_items 		= array('stok_keluar' => $total_stok_keluar);
										$this->db->where('id_barang',$penjualan->id_barang)
												->update('tb_data_stok',$stok_items);

										// proses 7
										// cek struk penjualan berdasarkan no faktur jika sudah ada lewati proses.
										$struk_penjualan = $this->db->where('no_faktur',$no_faktur)
																	->get('tb_struk');

										if ($struk_penjualan->num_rows() > 0) 
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
																'jenis_struk' 		=> 'PENJUALAN',
																'jenis_transaksi' 	=> $jenis_transaksi,
																'tgl_transaksi' 	=> $tgl_transaksi,
																'id_user' 			=> $id_user,
															);

											$this->db->insert('tb_struk',$data_struk);
										}
									}
								}
							}

							// proses menyimpan data transaksi
							$transaksi = array(
												'tgl_transaksi'		=> $transaksi['tgl_transaksi'],
												'akun'				=> 'PENJUALAN BARANG',
												'jenis' 			=> 'PEMASUKAN',
												'debet'				=> $total_bayar,
												'kredit'			=> 0,
												'keterangan' 		=> 'Melakukan penjualan barang dengan no. faktur : '.$no_faktur,
												'id_user' 			=> $this->apotek->users()->id_users
											);

							$this->db->insert('tb_data_transaksi',$transaksi);
								
							// proses 8
							// mengubah status penjualan berdasarkan no faktur
							$proses = array('payment' => 'TRUE');
							$this->db->where('no_faktur',$no_faktur)
									->where('id_user',$this->session->userdata('id_user'))
									->where('payment','FALSE')
									->update('tb_cart_penjualan',$proses);


							// membuat log user
							$logs_menu 			= 'Transaksi -> Penjualan -> Save';
							$logs_keterangan 	= 'Melakukan transaksi penjualan dengan jumlah items penjualan '.$jumlah_transaksi.' dengan No Faktur: '.$no_faktur;	
							$this->apotek->log_user($logs_menu,$logs_keterangan);
							$this->apotek->pesan_sukses('transaksi penjualan dengan no faktur: '.$no_faktur .' berhasil simpan.');
							$this->apotek->set_label($no_faktur,'new',90);
							// menghapus session cart pembelian
							$this->session->unset_userdata('cart_transaksi_penjualan');
							// redirect ke nota penjualan
							$this->apotek->redirect();
						 	
						}
						else
						{
							$this->apotek->pesan_error('No. faktur tidak ditemukan. transaksi penjualan tidak dapat di proses');
						}
					}
				}
				else
				{
					$this->apotek->pesan_error('silahkan coba lagi.');
					$this->apotek->redirect();
				}
			}
			else
			{
				// link nomor faktur yang dumasukan tidak valid
				$this->apotek->pesan_error('No.faktur tidak valid. transaksi penjualan tidak dapat diproses');
			}
			
			$this->apotek->redirect();
		}
		else
		{
			// redirect jika user belum login
			$this->apotek->redirect();
		}
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
				$this->load->view('content/print/laporan_struk_penjualan.php',$data);
			}
			else
			{
				$this->apotek->redirect('transaksi/penjualan/print/'.$no_faktur);
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
			$transaksi 	 	= $this->session->userdata('cart_transaksi_penjualan');
			
			$this->db->where('no_faktur',$transaksi['no_faktur'])
						->where('payment','FALSE')	
						->delete('tb_cart_penjualan');
			$this->session->unset_userdata('cart_transaksi_penjualan');
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
				$transaksi = $this->session->userdata('cart_transaksi_penjualan');
				foreach ($this->input->post('id_beli[]') as $id_beli) 
				{
					$this->db->where('id_jual',$id_beli)
							->where('no_faktur',$transaksi['no_faktur'])
							->where('id_user',$this->session->userdata('id_user'))
							->where('payment','FALSE')
							->delete('tb_cart_penjualan');
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

	public function retur()
	{
		$data['title'] 		= 'Retur Penjualan Barang';
		$this->apotek->content('transaksi/penjualan/retur_penjualan',$data);
	}

	public function proses_retur()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('no_faktur', 'No_faktur','trim|required');
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
											->where('payment','TRUE')
											->get('tb_cart_penjualan');

					if ($cek_faktur->num_rows() > 0) 
					{

						$faktur = $cek_faktur->row();

						if ($faktur->tgl_transaksi <= $tgl_transaksi) 
						{
							$proses = array(
										
										'no_retur' 				=> 'F-RJ'.date('ymd-His-').$faktur->id_user,
										'no_faktur' 			=> $faktur->no_faktur,
										'tgl_transaksi' 		=> $faktur->tgl_transaksi,
										'tgl_retur' 			=> $tgl_transaksi,
										'id_user' 				=> $faktur->id_user,
										'jenis_transaksi' 		=> $faktur->jenis_transaksi,
										'jenis_retur' 			=> 'PENJUALAN',
							);

							$this->session->set_userdata('cart_retur_penjualan', $proses);
						}
						else
						{
							$this->apotek->pesan_error('tgl retur tidak boleh dibawah dari tgl transaksi penjualan untuk no faktur tsb.<br/> tgl transaksi untuk no faktur : '.$faktur->no_faktur.' adalah '. date('d-m-Y',strtotime($faktur->tgl_transaksi)));
						}
					}
					else
					{
						$this->apotek->pesan_error('No faktur tidak valid. no faktur tidak ditemukan dalam sistem.');
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
			$this->form_validation->set_rules('id_jual', 'Id_jual','trim|required');
			$this->form_validation->set_rules('id_barang', 'Id_barang','trim|required');
			$this->form_validation->set_rules('retur', 'Retur','trim|required');
			$this->form_validation->set_rules('qty', 'Qty','trim|required');

			if ($this->form_validation->run())
			{
				$transaksi 		= $this->session->userdata('cart_retur_penjualan');
				$qty 			= $this->input->post('qty');
				$id_barang 		= $this->input->post('id_barang');
				$id_retur 		= $this->input->post('id_jual');
				$jumlah_retur 	= $this->input->post('retur');
				$id_user 		= $this->apotek->users()->id_users;
				$jenis_retur 	= 'PENJUALAN';
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
				$transaksi = $this->session->userdata('cart_retur_penjualan');
				if (!empty($transaksi['no_retur'])) 
				{
					$total = $this->input->post('total_retur');
					$user  = $this->apotek->users();
					$query = $this->db->where('no_retur',$transaksi['no_retur'])
										->where('status','FALSE')
										->where('jenis_retur','PENJUALAN')
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
								$stok_keluar = $barang->stok_keluar - $retur->jumlah_retur;
								$update_stok = array('stok_keluar' => $stok_keluar);
								
								$this->db->where('id_barang',$barang->id_barang)
											->update('tb_data_stok',$update_stok);

								$dtkartu_stok = array(
													'id_barang' 	=> $barang->id_barang,
													'tgl_transaksi' => $transaksi['tgl_retur'],
													'no_faktur'		=> $transaksi['no_retur'],
													'keterangan' 	=> 'Retur Penjualan barang dengan dengan no. faktur Penjualan : '.$transaksi['no_faktur'],
													'masuk'			=> $retur->jumlah_retur,
													'keluar'		=> 0,
													'id_user' 		=> $retur->id_user
													);
								$this->data_stok->kartu_stok($dtkartu_stok);
							}
						}

						// proses menyimpan data transaksi
						$dt_transaksi = array(
										'tgl_transaksi'		=> $transaksi['tgl_retur'],
										'akun'				=> 'RETUR PENJUALAN',
										'jenis' 			=> 'PENGELUARAN',
										'debet'				=> 0,
										'kredit'			=> $total,
										'keterangan' 		=> 'Melakukan retur penjualan barang dengan no retur : '.$transaksi['no_retur'],
										'id_user' 			=> $this->apotek->users()->id_users
									);

						$this->db->insert('tb_data_transaksi',$dt_transaksi);

						$data_retur = array('status' => 'TRUE');
						$this->db->where('no_retur',$transaksi['no_retur'])
								->where('jenis_retur','PENJUALAN')
								->where('id_user',$user->id_users)
								->where('status','FALSE')
								->update('tb_data_retur',$data_retur);
						$logs_menu 			= 'Transaksi -> Retur Penjualan -> Save';
						$logs_keterangan 	= 'Melakukan transaksi Retur penjualan dengan dengan No. Retur : '.$transaksi['no_retur'];	
						$this->apotek->log_user($logs_menu,$logs_keterangan);
						$this->session->unset_userdata('cart_retur_penjualan');
						$this->apotek->pesan_sukses('transaksi retur penjualan berhasil disimpan.');
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
			$transaksi 	 	= $this->session->userdata('cart_retur_penjualan');
			$this->db->where('id_user',$user->id_users)
						->where('status','FALSE')	
						->where('jenis_retur','PENJUALAN')
						->delete('tb_data_retur');
			$this->session->unset_userdata('cart_retur_penjualan');
		}
		
		$this->apotek->redirect();
	}
}
