<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proses_harga extends E_Apotek_Controller 
{
	public function index()
	{
		$this->form_validation->set_rules('id_beli', 'Id_beli','trim|required');
		$this->form_validation->set_rules('id_barang', 'Id_barang','trim|required');
		$this->form_validation->set_rules('hpp', 'Hpp','trim|required');
		$this->form_validation->set_rules('hju', 'Hju','trim|required');
		$this->form_validation->set_rules('hjd', 'Hjd','trim|required');
		$this->form_validation->set_rules('hjr', 'Hjr','trim|required');
		$this->form_validation->set_rules('disc_hju', 'Disc_hju','trim|required');
		$this->form_validation->set_rules('disc_hjd', 'Disc_hjd','trim|required');
		$this->form_validation->set_rules('disc_hjr', 'Disc_hjr','trim|required');

		if ($this->form_validation->run())
		{
			$id_barang 		= $this->input->post('id_barang',TRUE);
			$master_barang 	= $this->master_barang->check_id($id_barang);
			if ($master_barang == TRUE) 
			{
				$id_beli 	= $this->input->post('id_beli',TRUE);
				$hpp 		= $this->input->post('hpp',TRUE);
				$hju 		= $this->input->post('hju',TRUE);
				$hjd 		= $this->input->post('hjd',TRUE);
				$hjr 		= $this->input->post('hjr',TRUE);

				if ($hpp > $hju OR $hpp > $hjd OR $hpp > $hjr) 
				{
					$this->apotek->pesan_error('Harga penjualan tidak dapat diperbaharui. harga Penjualan yang di masukan lebih rendah dari Harga Pokok Penjualan');
				}
				else
				{
					$proses_data 	= array('hju' 		=> $hju, 
											'hjd' 		=> $hjd,
											'hjr' 		=> $hjr,
											'disc_hju' 	=> $this->input->post('disc_hju',TRUE),
											'disc_hjd' 	=> $this->input->post('disc_hjd',TRUE),
											'disc_hjr' 	=> $this->input->post('disc_hjr',TRUE),   
									);
					$this->db->where('id_beli',$id_beli)
							->update('tb_cart_pembelian',$proses_data);
					$menu 	= 'Data Obat -> Rincian Obat -> Ubah Harga';
					$log 	= "Mengubah Perubahan Harga Penjualan dengan ID Beli: ".$this->input->post('id_beli');
					$this->apotek->log_user($menu,$log);
					$this->apotek->set_label($id_beli,'Update');
					$this->apotek->pesan_sukses('Harga penjualan berhasil diperbaharui.');
				}
			}
			else
			{
				$this->apotek->pesan_error('Harga penjualan tidak dapat diperbaharui items pada master barang telah di hapus.');
			}
		}
		else
		{
			$this->apotek->pesan_error('Harga penjualan tidak dapat diperbaharui.');
		}

		$this->apotek->redirect();
	}
}
