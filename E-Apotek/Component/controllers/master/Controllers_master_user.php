<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Controllers_master_user extends E_Apotek_Controller 
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
		$data['title'] 		= 'Master User';
		$this->apotek->content('master/user/list',$data);
	}

    public function views($id = null)
    {
        $query = $this->db->where('id_users',$id)
                            ->get('tb_users');

        if($query->num_rows() > 0)
        {
            $data['title'] = 'Profil User';
            $data['items'] = $query->row();
            $this->apotek->content('master/user/views',$data);
        }
        else
        {
            $this->apotek->pesan_error('ID User tidak ditemukan. Silahkan coba lagi');
            redirect('master/user');
        }
    }

	public function tambah()
	{
		$this->form_validation->set_rules('id_user', 'Id_user','trim|required');
        $this->form_validation->set_rules('nama', 'Nama','trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat','trim|required');
		$this->form_validation->set_rules('username', 'Username','trim|required');
		$this->form_validation->set_rules('password', 'Password','trim|required');
		$this->form_validation->set_rules('trypassword', 'Trypassword','trim|required|matches[password]');
		$this->form_validation->set_rules('login_access', 'Login_access','trim|required');
		
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data user tidak dapat disimpan. Silahkan coba lagi');
            redirect('master/user');
        }
        else
    	{
    		$query = $this->db->where('username',$this->input->post('username'))
    						->get('tb_users');

    		if ($query->num_rows() > 0) 
    		{
	            $this->apotek->pesan_error('username sudah digunakan oleh user lain. Silahkan coba lagi');
    	        redirect('master/user');
    		}
    		else
    		{
                $file_name                  = mt_rand(1000,9999);
                $config['upload_path']      = './assets/img/user/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']         = '1024';
                $config['file_name']        = $file_name;
                $config['max_width']        = '1024';

                $this->upload->initialize($config);
                
                if (!$this->upload->do_upload('foto')) 
                {
                    $foto = 'default.jpg';
                }
                else
                {
                    $foto = $this->upload->data('file_name');
                }

                $private_key        = md5($this->encrypt->encode(rand(1000,9999)));
                $password_encrypt   = $this->apotek->pwd_in($this->input->post('password'),$private_key);

				$userdata = array('id_users' 	=> $this->input->post('id_user'),
								'nama_lengkap'  => $this->input->post('nama'),
                                'alamat'        => $this->input->post('alamat'),
                                'username'		=> $this->input->post('username'),
								'password' 		=> $password_encrypt,
                                'private_key'   => $private_key,
								'date_created' 	=> date('Y-m-d h:m:s'),
								'type'			=> $this->input->post('login_access'),
								'foto'			=> $foto);

    			$this->db->insert('tb_users',$userdata);
    			$this->apotek->set_label($this->input->post('id_user'),'new');
	            $this->apotek->pesan_sukses('User baru berhasil di tambahkan.');
                
                $logs_menu          = 'Data Master -> Master User -> Tambah Data User';
                $log = "Menambahkan User baru dengan ID User : ".$this->input->post('id_user');
                $this->apotek->log_user($logs_menu,$log);
    	        
                redirect('master/user');	
    		}
		}
	}

	public function edit()
	{
		$this->form_validation->set_rules('id_user', 'Id_user','trim|required');
        $this->form_validation->set_rules('nama', 'Nama','trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat','trim|required');
		$this->form_validation->set_rules('username', 'Username','trim|required');
		$this->form_validation->set_rules('login_access', 'Login_access','trim|required');
		
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data user tidak dapat diubah. Silahkan coba lagi');
            redirect('master/user');
        }
        else
    	{
            $file_name                  = mt_rand(1000,9999);
            $config['upload_path']      = './assets/img/user/';
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $config['max_size']         = '1024';
            $config['file_name']        = $file_name;
            $config['max_width']        = '1024';

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('foto')) 
            {
                $foto = $this->db->where('id_users',$this->input->post('id_user'))
                                ->get('tb_users');
                $foto = $foto->row()->foto;
            }
            else
            {
                $foto = $this->upload->data('file_name');
            }

    		$id_users = $this->input->post('id_user'); 

            $this->form_validation->set_rules('password', 'Password','trim|required');
            $this->form_validation->set_rules('trypassword', 'Trypassword','trim|required|matches[password]');
            
            if ($this->form_validation->run() == TRUE) 
            {
                $private_key = md5($this->encrypt->encode(rand(1000,9999)));
                $userdata = array(
                                'nama_lengkap'  => $this->input->post('nama'),
                                'alamat'        => $this->input->post('alamat'),
                                'foto'          => $foto,
                                'username'      => $this->input->post('username'),
                                'password'      => $this->apotek->pwd_in($this->input->post('password'),$private_key),
                                'private_key'   => $private_key,
                                'type'          => $this->input->post('login_access')
                            );
            }
            else
            {
                $userdata = array(

                                'nama_lengkap'  => $this->input->post('nama'),
                                'alamat'        => $this->input->post('alamat'),
                                'username'      => $this->input->post('username'),
                                'type'          => $this->input->post('login_access')
                            );
            }

    		$this->db->where('id_users',$id_users)
    				->update('tb_users',$userdata);
    		$this->apotek->pesan_sukses('User dengan ID : '.$id_users.' berhasil di ubah.');
            $logs_menu  = 'Data Master -> Master User -> edit Data User';
            $log        = "mengedit User dengan ID User : ". $this->input->post('id_user');
            $this->apotek->log_user($logs_menu,$log);
            $this->apotek->set_label($id_users,'Update');
    		$this->apotek->redirect();
    	}
	}

	public function delete()
	{
		$this->form_validation->set_rules('id_user', 'Id_user','trim|required');
        
        if (!$this->form_validation->run())
        {
            $this->apotek->pesan_error('Data user tidak dapat dihapus. Silahkan coba lagi');
            redirect('master/user');
        }
        else
    	{
    		$id_users     = $this->input->post('id_user');
    		if ($id_users == $this->session->userdata('id_user')) 
    		{
    			$this->apotek->pesan_error('Data user tidak dapat dihapus. anda sedang login menggunakan account ini.');
            	redirect('master/user');
    		}
    		else
    		{
	    		$this->db->where('id_users',$id_users)
	    				->delete('tb_users');
	    		$this->apotek->pesan_sukses('User dengan ID : '.$id_users.' berhasil di hapus.');
                $logs_menu  = 'Data Master -> Master User -> Hapus Data User';
                $log = "Menghapus User dengan ID User : ".$this->input->post('id_user');
                $this->apotek->log_user($logs_menu,$log);
	    		redirect('master/user');
    		}
    	}
	}
}
