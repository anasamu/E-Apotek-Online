<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_master_suplier extends E_Apotek_Controller 
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
		$data['title'] 		= 'Master Suplier';
		$this->apotek->content('master/suplier/list',$data);
	}

	public function tambah()
	{
		$this->form_validation->set_rules('id_suplier', 'id_suplier','trim|required');
        $this->form_validation->set_rules('nama', 'Nama','trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat','trim|required');
		
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data suplier tidak dapat disimpan. Silahkan coba lagi');
            $this->apotek->redirect();
        }
        else
    	{
    		$query = $this->db->where('suplier',$this->input->post('suplier'))
    						->get('tb_suplier');

    		if ($query->num_rows() > 0) 
    		{
	            $this->apotek->pesan_error('nama suplier sudah ada. Silahkan coba lagi');
    	        $this->apotek->redirect();
    		}
    		else
    		{
				$data 	= array('id_suplier' 	=> $this->input->post('id_suplier'),
								'suplier'  		=> $this->input->post('nama'),
                                'alamat'        => $this->input->post('alamat'),
                                'no_telp'		=> $this->input->post('telp'),
                                'no_rek'		=> $this->input->post('no_rek'),
								'id_user' 		=> $this->apotek->users()->id_users,
                                );

    			$this->db->insert('tb_suplier',$data);
    			$this->apotek->set_label($this->input->post('id_suplier'),'new');
	            $this->apotek->pesan_sukses('suplier baru berhasil di tambahkan.');
                
                $logs_menu          = 'Data Master -> Master Suplier -> Tambah Data';
                $log = "Menambahkan Suplier baru dengan ID Suplier : ".$this->input->post('id_suplier');
                $this->apotek->log_user($logs_menu,$log);
    	        
                $this->apotek->redirect();
    		}
		}
	}

	public function edit()
	{
		$this->form_validation->set_rules('id_suplier', 'id_suplier','trim|required');
        $this->form_validation->set_rules('nama', 'Nama','trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat','trim|required');
		
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data suplier tidak dapat diubah. Silahkan coba lagi');
            $this->apotek->redirect();
        }
        else
    	{
    		$id_suplier = $this->input->post('id_suplier'); 
            
    		$data 	= array(
							'suplier'  		=> $this->input->post('nama'),
                            'alamat'        => $this->input->post('alamat'),
                            'no_telp'		=> $this->input->post('telp'),
                            'no_rek'		=> $this->input->post('no_rek'),
							'id_user_modif' => $this->apotek->users()->id_users,
                            );


    		$this->db->where('id_suplier',$id_suplier)
    				->update('tb_suplier',$data);
    		$this->apotek->pesan_sukses('Suplier dengan ID : '.$id_suplier.' berhasil di ubah.');
            $logs_menu  = 'Data Master -> Master Suplier -> Edit Data';
            $log        = "mengedit Suplier dengan ID Suplier : ". $id_suplier;
            $this->apotek->log_user($logs_menu,$log);
            $this->apotek->set_label($id_suplier,'Update');
    		$this->apotek->redirect();
    	}
	}

	public function delete()
	{
		$this->form_validation->set_rules('id_suplier', 'id_Suplier','trim|required');
        
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data Suplier tidak dapat dihapus. Silahkan coba lagi');
            $this->apotek->redirect();
        }
        else
    	{
    		$id_suplier  = $this->input->post('id_suplier');

    		$this->db->where('id_suplier',$id_suplier)
    				->delete('tb_suplier');

    		$this->apotek->pesan_sukses('Suplier dengan ID : '.$id_suplier.' berhasil di hapus.');
            $logs_menu  = 'Data Master -> Master Suplier -> Hapus Data';
            $log = "Menghapus Suplier dengan ID : ".$id_suplier;
            $this->apotek->log_user($logs_menu,$log);
    		$this->apotek->redirect();
    	}
	}

}