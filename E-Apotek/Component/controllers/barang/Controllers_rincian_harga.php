<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_rincian_harga extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Rincian Harga Barang';
		$this->apotek->content('barang/rincian_harga',$data);
	}

	public function update()
	{
		if ($this->session->userdata('access') !== 'ADMINISTRATOR') 
        {
            $this->apotek->pesan_error('anda tidak punya akses ke menu ini.');
            return $this->apotek->redirect();
        }

		$this->form_validation->set_rules('id_barang', 'Id_barang','trim|required');
		$this->form_validation->set_rules('hpp', 'Hpp','trim|required');
		$this->form_validation->set_rules('hju', 'Hju','trim|required');
		$this->form_validation->set_rules('hjd', 'Hjd','trim|required');
		$this->form_validation->set_rules('hjr', 'Hjr','trim|required');

		if ($this->form_validation->run())
		{
			$id_barang 		= $this->input->post('id_barang',TRUE);
			$master_barang 	= $this->master_barang->check_id($id_barang);

			if ($master_barang == TRUE) 
			{
				$id_barang 	= $this->input->post('id_barang',TRUE);
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
											'hjr' 		=> $hjr   
											);
					$this->db->where('id_barang',$id_barang)
							->update('tb_harga_barang',$proses_data);
					$menu 	= 'Data Barang -> Rincian Harga -> Update';
					$log 	= "Mengubah Perubahan Harga Penjualan dengan ID Barang: ".$this->input->post('id_barang');
					$this->apotek->log_user($menu,$log);
					$this->apotek->set_label($id_barang,'Update');
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
