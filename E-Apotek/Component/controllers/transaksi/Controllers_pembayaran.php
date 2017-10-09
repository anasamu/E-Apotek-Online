<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_pembayaran extends E_Apotek_Controller 
{
	public function hutang()
	{
		$data['title'] 		= 'Pembayaran Hutang';
		$this->apotek->content('transaksi/pembayaran/hutang',$data);
	}

	public function proses_hutang()
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			$this->form_validation->set_rules('no_faktur', 'no_faktur','trim|required');
			$this->form_validation->set_rules('total', 'total','trim|required');
			$this->form_validation->set_rules('sisa', 'sisa','trim|required');
			$this->form_validation->set_rules('status', 'status','trim|required');
			$this->form_validation->set_rules('dibayar', 'dibayar','trim|required');

			if ($this->form_validation->run())
			{
				$no_faktur 	= $this->input->post('no_faktur');
				$total 		= $this->input->post('total');
				$sisa 		= $this->input->post('sisa');
				$status 	= $this->input->post('status');
				$_dibayar 	= $this->input->post('dibayar');

				if ($status === 'LUNAS' OR $sisa === 0) 
				{
					$this->apotek->pesan_error('proses pembayaran hutang tidak dapat diproses. no faktur yang dipilih sudah lunas.');
				}
				else
				{
					if ($_dibayar > $total) 
					{
						$this->apotek->pesan_error('proses pembayaran hutang tidak dapat diproses. jumlah yang dibayar tidak boleh lebih dari total pembelian');
					}
					else
					{
						$cek = $this->db->where('no_faktur',$no_faktur)
											->get('tb_data_hutang');
						if ($cek->num_rows() > 0) 
						{
							$sisa_sebelumnya 	= $cek->row()->total_bayar - $cek->row()->dibayar;
							$sisa_bayar 		= $sisa_sebelumnya - $_dibayar;
							$dibayar 			= $cek->row()->dibayar + $_dibayar;
						}

						if ($sisa_bayar < 0) 
						{
							$this->apotek->pesan_error('proses pembayaran hutang tidak dapat diproses. sisa pembayaran melebihi total pembelian silahkan coba lagi');
						}
						
						if ($sisa_bayar == 0) 
						{
							// proses pembayaran lunas
							$this->apotek->pesan_sukses('proses pembayaran hutang berhasil disimpan. dengan status bayar LUNAS');
							$data_hutang = array('dibayar' => $dibayar,
												'status' 	=> 'LUNAS');
							$status_hutang = 'LUNAS';
						}
						elseif($dibayar < $total)
						{
							$sisa = $total - $dibayar;
							$sisa = $this->apotek->rupiah($sisa);
							$status_hutang = 'BELUM LUNAS';
							$this->apotek->pesan_sukses('proses pembayaran hutang berhasil disimpan. dengan sisa hutang '.$sisa);
							$data_hutang = array('dibayar' => $dibayar,
												'status' 	=> 'BELUM LUNAS');
						}

						if (isset($data_hutang)) 
						{
							$this->db->where('no_faktur',$no_faktur)
								->update('tb_data_hutang',$data_hutang);
							// proses menyimpan data transaksi
							$keterangan = 'Melakukan Pembayaran hutang dengan No Faktur : '.$no_faktur;
							$dt_transaksi = array(
											'tgl_transaksi'		=> date('Y-m-d'),
											'keterangan' 		=> $keterangan,
											'akun'				=> 'PEMBAYARAN HUTANG',
											'jenis' 			=> 'PENGELUARAN',
											'debet'				=> 0,
											'kredit'			=> $_dibayar,
											'id_user' 			=> $this->apotek->users()->id_users
										);

							$this->db->insert('tb_data_transaksi',$dt_transaksi);
							$logs_menu 			= 'Transaksi -> Pembayaran -> Hutang';
							$logs_keterangan 	= 'Melakukan transaksi pembayaran hutang dengan dengan No. faktur : '.$no_faktur;
							$this->apotek->log_user($logs_menu,$logs_keterangan);
						}

					}
				}
			}
			else
			{
				$this->apotek->pesan_error('proses pembayaran hutang tidak dapat diproses. silahkan coba lagi');
			}
		}
		else
		{
			$this->apotek->pesan_error('silahkan login untuk mengakses menu ini');
		}

		$this->apotek->redirect();
	}
}
