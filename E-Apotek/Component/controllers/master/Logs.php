<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends E_Apotek_Controller 
{
	public function delete()
	{
		$this->form_validation->set_rules('id_users', 'Id_users','trim|required');		
		$this->form_validation->set_rules('id_logs[]', 'Id_logs[]','trim|required');		
        
        if (!$this->form_validation->run())
        {
        	$this->apotek->pesan_error('tidak dapat menghapus Logs. Silahkan coba lagi');
        }
        else
        {
        	$id_logs = $this->input->post('id_logs');
        	
        	if (is_array($id_logs)) 
        	{
        		foreach ($id_logs as $items) 
        		{
        			$this->db->where('id_logs',$items)
        						->where('id_users',$this->input->post('id_users'))
        						->delete('tb_logs_user');
        			$this->apotek->pesan_sukses('Riwayat Aktifitas berhasil dihapus!');
        		}
        	}
                
                $log = "Menghapus Riwayat Aktifitas untuk ID User : ".$this->input->post('id_users');
                $this->apotek->log_user($log);
        }

        redirect('master/user/views/'.$this->input->post('id_users'));
	}
}