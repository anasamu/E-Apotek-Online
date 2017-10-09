<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_barang extends E_Apotek_Controller 
{
	public function index()
	{
		$data['title'] 		= 'Stok Barang';
		$this->apotek->content('barang/stok_obat',$data);
	}

	public function update($id_barang)
	{
		if ($this->authentikasi->login() == TRUE) 
		{
			if ($this->data_stok->check_id($id_barang) == TRUE) 
			{
				$this->form_validation->set_rules('id_barang', 'Id_barang','trim|required');
				$this->form_validation->set_rules('stok', 'Stok','trim|required');

				if ($this->form_validation->run())
				{
					$master_barang 	= $this->master_barang->check_id($id_barang);
					if ($master_barang) 
					{
					 	$proses 		= array('stok_awal' => $this->input->post('stok',true));
						$this->data_stok->update_stok_awal($id_barang,$proses);
						$logs_menu 			= 'Obat -> Stok Obat -> update';
						$logs_keterangan 	= 'Melakukan perubahan stok obat dengan ID Obat : '.$id_barang;	
						$this->apotek->log_user($logs_menu,$logs_keterangan);
						$this->apotek->pesan_sukses('Stok barang dengan ID Barang : '. $id_barang.' berhasil diperbaharui');
						$this->apotek->set_label($id_barang,'Update');
					}
					else
					{
						$this->apotek->pesan_error('Stok barang tidak dapat diperbaharui! items pada master barang telah di hapus.');
					}
				}
				else
				{
					$this->apotek->pesan_error('Stok barang dengan ID Barang : '.$id_barang.' gagal diperbaharui');
				}
			}
		}

		$this->apotek->redirect();
	}

}
