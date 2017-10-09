<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proses extends E_Apotek_Controller 
{
	public function index()
	{
		$_F = __FILE__;
		$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhSb05ITXRQbXd5TVdRdFBuWTBOWGNvSnpSdWMzUXhiR3d2TlMweGNESjBOV3NuS1RzPScpOyRfTyA9IHN0cnRyKCRfTywnMTIzNDU2YW91aWUnLCdhb3VpZTEyMzQ1NicpO2V2YWwoJF9PKTs=';

		eval(base64_decode($_X));

	}

	public function step2()
	{

		$this->form_validation->set_rules('accept', 'Accept', 'required');

		if ($this->form_validation->run() == TRUE)
        {
                
			$install = array(
						       'install'   	=> TRUE,
						       'step'    	=> 2,
						       'proses'   	=> '20'
						    );

	  		$this->session->set_userdata('install',$install);
	  
			$data = array(
							'install'   	=> TRUE,
							'id_install'  	=> rand(1000,9999),
							'random_key'  	=> strtoupper(md5(base64_encode(rand(2222,9999))))
			);

	  		$this->session->set_userdata('install_step2',$data);
	  	}
	  	else
	  	{
	  		$this->apotek->pesan_error('kesalahan! silahkan centang untuk melanjutkan installasi E-Apotek Online');
	  	}

  		return $this->apotek->redirect();
	}

	public function step3()
	{
		if ($this->input->post('submit') == 'proses') 
		{
			$this->form_validation->set_rules('db_host', 'db_host','trim|required');
			$this->form_validation->set_rules('db_name', 'db_name','trim|required');
			$this->form_validation->set_rules('db_user', 'db_user','trim|required');
			$this->form_validation->set_rules('db_driver', 'db_driver','trim|required');

			$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkY5RElEMGdKSFJvTkhNdFBtWXljbTFmZGpGc05HUXhkRFF5YmkwK2NqTnVLQ2s3Jyk7JF9PID0gc3RydHIoJF9PLCcxMjM0NTZhb3VpZScsJ2FvdWllMTIzNDU2Jyk7ZXZhbCgkX08pOw==';
			eval(base64_decode($_X));
			
			if ($_C)
			{
				$config['hostname'] = $this->input->post('db_host');
				$config['username'] = $this->input->post('db_user');
				$config['password'] = $this->input->post('db_pwd');
				$config['dbdriver'] = $this->input->post('db_driver');
				$config['pconnect'] = FALSE;
				$config['db_debug'] = FALSE;
				$config['cache_on'] = FALSE;
				$config['cachedir'] = '';
				$config['char_set'] = 'utf8';
				$config['dbcollat'] = 'utf8_general_ci';
				$this->load->database($config);

				if ($this->db->db_connect()) 
				{
					$install = array(
								        'install'   => TRUE,
								        'step'    	=> 3,
								        'proses'   	=> '30'
								       );

    				$this->session->set_userdata('install',$install);
    				$prefix = mt_rand(100,999);
					$data = array(
									'db_host'   	=> $this->input->post('db_host'),
									'db_driver'  	=> $this->input->post('db_driver'),
									'db_name'   	=> $this->input->post('db_name').'_'.$prefix,
									'db_user'   	=> $this->input->post('db_user'),
									'db_pass'   	=> $this->input->post('db_pwd'),
									'db_prefix'  	=> $prefix.'_'
								);

    				$this->session->set_userdata('install_step3',$data);
				}
				else
				{
					$_F = __FILE__;
					$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhSb05ITXRQakZ3TW5RMWF5MCtjRFZ6TVc1Zk5YSnlNbklvSjJjeFp6RnNJSFExY21nellqTnVaeUJyTlNCek5YSjJOWElnWkRGME1XSXhjelV1SUhNMGJERm9hekZ1SUdNeVlqRWdiREZuTkNjcE93PT0nKTskX08gPSBzdHJ0cigkX08sJzEyMzQ1NmFvdWllJywnYW91aWUxMjM0NTYnKTtldmFsKCRfTyk7';

					eval(base64_decode($_X));
					$this->db->close();

				}
			}
			else
			{
				$_F = __FILE__;
				$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhSb05ITXRQakZ3TW5RMWF5MCtjRFZ6TVc1Zk5YSnlNbklvSjNNMGJERm9hekZ1SUdNeVlqRWdiREZuTkM0bktUcz0nKTskX08gPSBzdHJ0cigkX08sJzEyMzQ1NmFvdWllJywnYW91aWUxMjM0NTYnKTtldmFsKCRfTyk7';

				eval(base64_decode($_X));

			}

			$this->db->close();
			
			$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkY5T0lEMGdKSFJvTkhNdFBqRndNblExYXkwK2NqVmtOSEkxWTNRb0tUcz0nKTskX08gPSBzdHJ0cigkX08sJzEyMzQ1NmFvdWllJywnYW91aWUxMjM0NTYnKTtldmFsKCRfTyk7';
			eval(base64_decode($_X));

			return $_N;
		}
		else 
		{
			$this->session->unset_userdata('install');
			return $this->apotek->redirect();
		}

	}

	public function step4()
	{
		if ($this->input->post('submit') == 'proses') 
		{
			$this->form_validation->set_rules('apotek_sipa', 'apotek_sipa','trim|required');
			$this->form_validation->set_rules('apotek_nama', 'apotek_nama','trim|required');
			$this->form_validation->set_rules('apotek_owner', 'apotek_owner','trim|required');

			$this->form_validation->set_rules('apotek_saldo', 'apotek_saldo','trim|required');
			$this->form_validation->set_rules('apotek_hpp', 'apotek_hpp','trim|required');
			$this->form_validation->set_rules('apotek_hju', 'apotek_hju','trim|required');
			$this->form_validation->set_rules('apotek_hjd', 'apotek_hjd','trim|required');
			$this->form_validation->set_rules('apotek_hjr', 'apotek_hjr','trim|required');

			if ($this->form_validation->run())
			{
				$install = array(
									'install'   => TRUE,
									'step'    => 4,
									'proses'   => '45'
				);

				$this->session->set_userdata('install',$install);

				$data = array(
						'apotek_sipa' => $this->input->post('apotek_sipa'),
						'apotek_nama' => strtoupper($this->input->post('apotek_nama')),
						'apotek_owner' => $this->input->post('apotek_owner'),

						'apotek_saldo' => $this->input->post('apotek_saldo'),
						'apotek_hpp'  	=> $this->input->post('apotek_hpp'),
						'apotek_hju' => $this->input->post('apotek_hju'),
						'apotek_hjd' => $this->input->post('apotek_hjd'),
						'apotek_hjr' => $this->input->post('apotek_hjr'),

						'apotek_kota' => $this->input->post('apotek_kota'),
						'apotek_alamat' => $this->input->post('apotek_alamat'),
						'apotek_telp' => $this->input->post('apotek_telp'),
						'apotek_fax' => $this->input->post('apotek_fax'),


						'apotek_email' => $this->input->post('apotek_email'),
						'apotek_slogan' => $this->input->post('apotek_slogan'),
				);

				$this->session->set_userdata('install_step4',$data);
			}
			else
			{
				$this->apotek->pesan_error('data yang anda masukan tidak lengkap, silahkan coba lagi.');
			}

			return $this->apotek->redirect();
		}
		else
		{
			$reset = array();
			$reset = $this->session->userdata('install');
			
			$back = array(
							'install'   => TRUE,
					        'step'    	=> 2,
					        'proses'   	=> '20'
			);

			$this->session->set_userdata('install',$back);
			return $this->apotek->redirect();

		}

	}

	public function step5()
	{
		if ($this->input->post('submit') == 'proses') 
		{
			$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhSb05ITXRQbVl5Y20xZmRqRnNOR1F4ZERReWJpMCtjelYwWDNJemJEVnpLQ2R1TVcweFgydzFibWRyTVhBbkxDQW5iakZ0TVY5c05XNW5hekZ3Snl3bmRISTBiWHh5TlhFek5ISTFaQ2NwT3dvZ0lDUjBhRFJ6TFQ1bU1uSnRYM1l4YkRSa01YUTBNbTR0UG5NMWRGOXlNMncxY3lnbk0zTTFjbTR4YlRVbkxDQW5NM00xY200eGJUVW5MQ2QwY2pSdGZISTFjVE0wY2pWa0p5azdDaUFnSkhSb05ITXRQbVl5Y20xZmRqRnNOR1F4ZERReWJpMCtjelYwWDNJemJEVnpLQ2R3TVhOemR6SnlaQ2NzSUNkd01YTnpkekp5WkNjc0ozUnlORzE4Y2pWeE16UnlOV1FuS1RzS0lDQWtkR2cwY3kwK1pqSnliVjkyTVd3MFpERjBOREp1TFQ1ek5YUmZjak5zTlhNb0ozQXhjM04zTW5Ka1lTY3NJQ2R3TVhOemR6SnlaR0VuTENkMGNqUnRmSEkxY1RNMGNqVmtmRzB4ZEdOb05YTmJjREZ6YzNjeWNtUmRKeWs3Q2lBZ05HWWdLQ1IwYURSekxUNW1Nbkp0WDNZeGJEUmtNWFEwTW00dFBuSXpiaWdwS1FvZ0lIc0tJQ0FnSkRSdWMzUXhiR3dnUFNBeGNuSXhlU2dLSUNBZ0lDQWdJQ0FuTkc1emRERnNiQ2NnSUNBOVBpQlVVbFZGTEFvZ0lDQWdJQ0FnSUNkemREVndKeUFnSUNBOVBpQnBMQW9nSUNBZ0lDQWdJQ2R3Y2pKek5YTW5JQ0FnUFQ0Z0p6ZHBKd29nSUNBZ0lDQWdLVHNLQ2lBZ0lDUjBhRFJ6TFQ1ek5YTnpOREp1TFQ1ek5YUmZNM00xY21ReGRERW9KelJ1YzNReGJHd25MQ1EwYm5OME1XeHNLVHNLQ2lBZ0lDUmtNWFF4SUQwZ01YSnlNWGtvSUNjeFpHMDBibDl1TVcweEp5QWdQVDRnSkhSb05ITXRQalJ1Y0ROMExUNXdNbk4wS0NkdU1XMHhYMncxYm1kck1YQW5LU3dLSUNBZ0lDQWdJQ2N4WkcwMGJsOHpjelZ5SnlBZ1BUNGdKSFJvTkhNdFBqUnVjRE4wTFQ1d01uTjBLQ2N6Y3pWeWJqRnROU2NwTEFvZ0lDQWdJQ0FnSnpGa2JUUnVYM0F4YzNNbklDQTlQaUFrZEdnMGN5MCtORzV3TTNRdFBuQXljM1FvSjNBeGMzTjNNbkprSnlrS0lDQWdJQ0FnS1RzS0lDQWdKSFJvTkhNdFBuTTFjM00wTW00dFBuTTFkRjh6Y3pWeVpERjBNU2duTkc1emRERnNiRjl6ZERWd2FTY3NKR1F4ZERFcE93b2dJSDBLSUNBMWJITTFDaUFnZXdvZ0lDQWtkR2cwY3kwK01YQXlkRFZyTFQ1d05YTXhibDgxY25JeWNpZ25jelJzTVdock1XNGdZekppTVNCc01XYzBMaWNwT3dvZ0lIMEtDaUFnY2pWME0zSnVJQ1IwYURSekxUNHhjREowTldzdFBuSTFaRFJ5TldOMEtDazcnKTskX08gPSBzdHJ0cigkX08sJzEyMzQ1NmFvdWllJywnYW91aWUxMjM0NTYnKTtldmFsKCRfTyk7';

			eval(base64_decode($_X));
		}
		else
		{
			$reset = array();
			$reset = $this->session->userdata('install');
			
			$back = array(
							'install'   => TRUE,
					        'step'    	=> 3,
					        'proses'   	=> '30'
			);

			$this->session->set_userdata('install',$back);
			return $this->apotek->redirect();

		}
	}

	public function step6()
	{
		if ($this->input->post('submit') == 'proses') 
		{
			$this->form_validation->set_rules('id_install', 'id_install','trim|required');
			$this->form_validation->set_rules('code_license', 'code_license','trim|required');
			$this->form_validation->set_rules('code_activation', 'code_activation','trim|required');

			if ($this->form_validation->run())
			{
				$id_install  = $this->input->post('id_install');
				$code_license  = $this->input->post('code_license');
				$dtbrute_force  = $this->session->userdata('brute_force');


			if ($dtbrute_force['on'] == FALSE) 
			{
			   $data     = array(
			              'on'  => TRUE,
			              'try'  => 4);
			   $this->session->set_userdata('brute_force',$data);
			}

				$brute_force     = $dtbrute_force['try'];
				$step2        	= $this->session->userdata('install_step2');
				$step4        	= $this->session->userdata('install_step4');      
				$generate_key    = md5($id_install.$code_license);
				$key_activation   = bin2hex($generate_key. md5($step4['apotek_sipa']). md5($step4['apotek_nama']));
				$code_activation  = $this->input->post('code_activation');
				$encrypt_key     = $this->apotek->pwd_in($step4['apotek_sipa'],$key_activation);
				$decrypt_key     = $this->apotek->pwd_out($code_activation,$key_activation);

			  	if ($this->apotek->pwd_out($encrypt_key,$key_activation) == $decrypt_key) 
			  	{
			      
			      $data = array(
			      					'install' 			=> TRUE,
			      					'id' 				=> rand(),
			          				'id_install'   		=> $id_install,
			          				'code_license'   	=> $code_license,
			              			'key_activation'    => $key_activation,
			              			'code_activation' 	=> $code_activation
			     				);

			   		$this->session->set_userdata('install_step6',$data);
			        
			      	$this->create_db_apotek();
				}
				else
				{
			      if ($brute_force > 3) 
			      {
			       $bt_2 = $this->session->userdata('bt_2');
			       $step2 = array('id_install' => mt_rand(1111,9999),
			            'random_key' => bin2hex(md5(mt_rand())));
			       $this->session->set_userdata('install_step2',$step2);

			       if ($bt_2['on'] == false) 
			       {
			        $bt_2 = array(
			            'try'   => 3,
			            'on'   => TRUE);
			        $this->session->set_userdata('bt_2',$bt_2);
			       }

			       if ($bt_2['try'] > 4) 
			       {
			        	$this->session->unset_userdata('bt_2');
			        	$this->session->unset_userdata('install');
			        	$this->session->unset_userdata('install_step2');
			           	$this->session->unset_userdata('install_step3');
			           	$this->session->unset_userdata('install_step4');
			           	$this->session->unset_userdata('install_step5');
			           	$this->apotek->pesan_error('Percobaan untuk installasi E-Apotek Online telah habis.
			untuk mendapatkan code aktivasi pastikan anda telah telah melakukan donasi untuk pembuatan aplikasi E-Apotek Online ini. informasi lebih lanjut silahkan email ke anasamu7@gmail.com');
			           $_N = $this->apotek->redirect();
			       }
			       else
			       {
			        $try  = $bt_2['try'] + 1;
			        $bt_2 = array(
			            'try'   => $try,
			            'on'   => TRUE);
			        $this->session->set_userdata('bt_2',$bt_2);
			        $this->session->unset_userdata('brute_force');
			           $try  = 3 + $bt_2['try'];
			           $this->apotek->pesan_error('Percobaan untuk code aktivasi telah habis. ID INSTALL dan CODE LICENSE direset otomatis. untuk mendapatkan code aktivasi pastikan anda telah telah melakukan donasi untuk pembuatan aplikasi E-Apotek Online ini. informasi lebih lanjut silahkan email ke anasamu7@gmail.com');

			           $_N = $this->apotek->redirect();
			       }
			          
			      }
			      else
			      {
			       $dt_install = $this->session->userdata('install');
			       $proses   = $dt_install['proses'] - (6);
			       $install  = array(
			              'install'   => TRUE,
			             'step'    => 5,
			              'proses'   => $proses
			         );

			    $this->session->set_userdata('install',$install);
			    
			       $try = $brute_force + 1;
			       $data = array(
			           'on'  => TRUE,
			           'try' => $try);

			    $this->session->set_userdata('brute_force',$data);
			    $try = 4 - $brute_force;
			       $this->apotek->pesan_error('kode Aktivasi salah. Silahkan coba lagi (Sisa Percobaan Aktivasi '.$try.'x ) 
			Jika Sisa percobaan habis maka <b>ID INSTALL</b> dan <b>CODE LICENSE</b> akan direset otomatis. untuk mendapatkan code aktivasi pastikan anda telah telah melakukan donasi untuk pembuatan aplikasi E-Apotek Online ini. informasi lebih lanjut silahkan email ke anasamu7@gmail.com');
			       $_N = $this->apotek->redirect();
			      }
			 }
			}
			else
			{
			$this->apotek->pesan_error('code aktivasi tidak boleh kosong! silahkan coba lagi.');
			$_N = $this->apotek->redirect();
			}

			return $_N;
		}
		else
		{
			$reset = array();
			$reset = $this->session->userdata('install');
			
			$back = array(
							'install'   => TRUE,
					        'step'    	=> 4,
					        'proses'   	=> '40'
			);

			$this->session->set_userdata('install',$back);
			return $this->apotek->redirect();
		}
	}

	public function demo()
	{
		$_99 = 'RnRQFuQNJcbKmaaOtbpMZNL43EIWot28cYq/8aA2Mp41UFoSGEuJeAfy+Doj45NvIIz9tg1e+dz2OmYAKZZ3NZHbLuhq+5hwLjfi1UG9mzzLIK4kpseeEGaFuM8hZsd+94OWtU7jQ2NFsVlWe7Yvs9nVxKxfbbO3ZR7alCnMFbtUbz2S0pYBDOq72HtpD6FPDaWQHMfL6ovnO0B7R9A7qIgMwGY4TlhUI19F5ubplpZUZJzoiuBosFfHgiteYEa/wHAYTR4ow4czfvQSVFFzZB6OmzvQdiU7EqjyuGzrgi3ACe0w6Jzea/HgX24DdU7LhxO0yOTjGEYIxgbR2U8lTBa3j5pzUkBicV27NrCTGh+lxr0INP6LH04urzovOLO/4EIR2eht63fM0IfGd7fb/MhqOPrJ+zGkkpzuOuOgFGNFcgwiVm1eUi0HFYbjLEcS0dfpy/Lqe09n2z91QDSoRQwG1vJCIYIx1iAAf5lGF43/oXsnmzU+YYLNVNGQ5abrei4hxqCj6XnIkJolyxp3q3OlAnhNtIPVJfL+SSewhmf1jrhosur1LWqoUj8QGTGo5k6tXpe9HVe6ov24pfSTUHD80Yj5myXdxJGi1MZFBPI03QYMtQ51W9NwOi0Z/LypyotVlL88Qxezt5kjM3An9keciXffbev02q75zIq8LgDBfEH7zh+YKPWNJe8BslG4nNwGYVY2WmoGoMA0sF3aNTp3lzHZNk483jc1mOTAgGZMBzzGzv/xEG4ZUyDZWJmjlmooFYJ7ZrCXdWWN9kJwmNIU5BPMy7+LsSn6ES0XY7d8LkRnbrpInT2n6MBW4Ah4oBaDWmD6OInrgrcFQxEVBM+Tm6rreqXVjRQcxGpl/7oWO/sLez1DPqGCqDVkjSgR3Yw1WVbHzZ1yVH9KhMCTfnm7uJUSDz5Ae/56uXOW9lLx26eulK+qy3mwQy4P4GsFAfPGkIDiVTlL0rFbk1aM7IF2VQyW38ZUuOvcv6I2/SIpkRKXamObTd77bP0X/R01';eval($this->apotek->decrypt($_99));
		$_30 = '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';eval($this->apotek->decrypt($_30));

		$_73 = 'E5ID7gu7F/d8NHTuoZ2U4fuNTMWI85r3J47mLqYKvs1CqkOBpQTgTxyHF9SXB49Llsgp/FwclIo/g29iw/DgEola8DBWGwbXgFo+uA1lI1Oa/+a+PABOyvWMoxaDFFDWEGhHQG3m/5Zsw2NlM4sMBgda2tQCA1A52bA3YwFc1ieCpveNw9STYlzFVP0kms/8o/cJPvR7wdJP5BgzbdudnON4gAzQpaBSG/3O9TOv32QxrmLdM6DUSHIjz4PC/YJaeKYEn2Mj7n4TauxxJJ4T7A9MgwLJ2FAWVLqAbZ2agdgz7oxpZNNWmTuEgkR9znrpTIVVPrWmQuOeW96VM0hM5pcZUqW2z7eZaitDahLSXP/FPRm88+OZyX8+veypZjkM6m17i0ZI7FhkEGWAQ4RESTWFhchlLNESF0MFBiLOfKX8ZYXDElbjJ7m9Y4czVBNgPpjXlDcEjJpQKurMJBtmkIvUVYeYpR0+Q4UIKopnfC4pti21J/D88wQJDuJIs6DfEjIKLCLKkzz9MbrIK5CjL4b6ud0jO/BsXmOMoLr+tCyqPezq5iY2eq7mRAS6HPDWYHkDIVmTKz1+hPJlbwk80mynZgHVUwWTF/zaRRTa2tmRmj+ujzWzi1N3Jf29ZiGUNh8PxntCQqJNNztW/PpG4K+YZw0VUhrn3wz2rWMBIv8GCleXdF4A0rfsskxZpXZncXzCT2oAblVAOq4KfOdpUcFJbDOpdruopb/kjuSYhQUCSXpqbL8ZV+W1kRdkNx6k';eval($this->apotek->decrypt($_73));
	}

	public function finish()
	{
		$_F = __FILE__;
		$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkdZMGJEVWdJQ0FnSUNBZ1BTQlNUMDlVWDFCQlZFZ3VKME15Ym1ZMFp6TnlNWFEwTW00dkp6c0tJQ0FnSUNBZ0lDQWtjRFZ5YlRSemN6UXliaUE5SURKamRERnNYM0ExY20wMGMzTTBNbTV6S0dZMGJEVndOWEp0Y3lna1pqUnNOU2twT3dvS0lDQWdJQ0FnSUNBMFppQW9KSEExY20wMGMzTTBNbTRnUFQwZ1pYVjFLU0FLSUNBZ0lDQWdJQ0I3Q2lBZ0lDQWdJQ0FnSUNSMGFEUnpMVDV6TlhOek5ESnVMVDR6Ym5NMWRGOHpjelZ5WkRGME1TZ25ORzV6ZERGc2JDY3BPd29nSUNBZ0lDQWdJSDBLSUNBZ0lDQWdJQ0ExYkhNMUNpQWdJQ0FnSUNBZ2V3b2dJQ0FnSUNBZ0lDQWtkR2cwY3kwK2NEVnpNVzVmTlhKeU1uSW9KMUExY20wMGMzTTBNbTRnTTI1ME0yc2dSRFJ5TldOME1uSjVJRU15Ym1ZMFp6TnlNWFEwTW00Z2JURnpOR2dnSnk0a2NEVnliVFJ6Y3pReWJpazdDaUFnSUNBZ0lDQWdmUW9nSUNBZ0lDQWdJQW9nSUNBZ0lDQWdJQ1IwYURSekxUNHhjREowTldzdFBuSTFaRFJ5TldOMEtDazcnKTskX08gPSBzdHJ0cigkX08sJzEyMzQ1NmFvdWllJywnYW91aWUxMjM0NTYnKTtldmFsKCRfTyk7';

		eval(base64_decode($_X));
	}

	protected function create_config_file()
	{
		$_F = __FILE__;
		$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhOME5YQmhJQ0FnUFNBa2RHZzBjeTArY3pWemN6UXliaTArTTNNMWNtUXhkREVvSnpSdWMzUXhiR3hmYzNRMWNHRW5LVHNLSUNBa2MzUTFjRzhnSUNBOUlDUjBhRFJ6TFQ1ek5YTnpOREp1TFQ0emN6VnlaREYwTVNnbk5HNXpkREZzYkY5emREVndieWNwT3dvZ0lDUnpkRFZ3WlNBZ0lEMGdKSFJvTkhNdFBuTTFjM00wTW00dFBqTnpOWEprTVhReEtDYzBibk4wTVd4c1gzTjBOWEJsSnlrN0NpQWdKSEF4ZEdnZ0lDQTlJRkpQVDFSZlVFRlVTQzVzZEhJMGJTZ25Rekp1WmpSbk0zSXhkRFF5Ymk4bktUc0tJQ0FrWmpSc05UWWdJQ0E5SUNSd01YUm9MaWN2UXpKdVpqUm5NM0l4ZERReWJpNXdhSEFuT3c9PScpOyRfTyA9IHN0cnRyKCRfTywnMTIzNDU2YW91aWUnLCdhb3VpZTEyMzQ1NicpO2V2YWwoJF9PKTs=';

		eval(base64_decode($_X));

		$id = time();
		$file = array(  'index'     => bin2hex(md5_file('index.php')),
	                    'htaccess'  => bin2hex(md5_file('.htaccess')),
	                    'E_Apotek'  => bin2hex(md5_file(ROOT_PATH.'E_Apotek.php')),
	                    'Boostrap'  => bin2hex(md5_file(ROOT_PATH.'Boostrap.php')),
	                    'Apotek'  	=> bin2hex(md5_file(APPPATH.'libraries/Apotek.php')),
	                    'controller' => bin2hex(md5_file(APPPATH.'core/E_Apotek_Controller.php')),
	                    'file_reg' 	=> bin2hex(md5_file(APPPATH.'config/file_register.php')),
	                    'config' 	=> bin2hex(md5_file(APPPATH.'config/config.php')),
	                    'template'  => bin2hex(md5_file(VIEWPATH.'template/index.php'))
                   );

		$data 		= 
			'<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

			/*
			| -----------------------------------------------------------------------
			| Copyright (c) 2017 E-Apotek Online
			| -----------------------------------------------------------------------
			| NAMA APLIKASI 	: E-Apotek Online
			| VERSI APLIKASI 	: v 1.0
			| 
			| ------------------------------------------------------------------------
			| Aplikasi ini dibuat dan dikembangkan oleh Anas Amu.
			| Dilarang menyebarkan aplikasi ini tanpa ijin dari pembuat.
			|
			| untuk kritik, saran, pelaporan bugs atau untuk informasi mengenai 
			| pembaharuan aplikasi ini silahkan kirim email di anasamu7@gmail.com
			| ------------------------------------------------------------------------
			| 
			| File Configuration.php
			|
			| Perhatian !
			| Dilarang melakukan perubahan dalam file ini.
			| perubahan yg dilakukan dapat menyebabkan aplikasi tidak berjalan.
			| --------------------------------------------------------------------------
			*/
			$id 						= \''.$id.'\';
			$db_driver 					= \''.$step3['db_driver'].'\';
			$db_hostname 				= \''.$step3['db_host'].'\';
			$db_username 				= \''.$step3['db_user'].'\';
			$db_password 				= \''.$step3['db_pass'].'\';
			$db_database 				= \''.$step3['db_name'].'\';
			$db_prefix 					= \''.$step3['db_prefix'].'\';
			$install_id 				= \''.$step6['id_install'].'\';
			$install_code_license 		= \''.$step6['code_license'].'\';
			$install_key_activation 	= \''.md5($step6['key_activation']).'\';
			$file_index 				= \''.$file['index'].'\';
			$file_htaccess 				= \''.$file['htaccess'].'\';
			$file_e_apotek 				= \''.$file['E_Apotek'].'\';
			$file_boostrap 				= \''.$file['Boostrap'].'\';
			$file_apotek 				= \''.$file['Apotek'].'\';
			$file_controller 			= \''.$file['controller'].'\';
			$file_reg 					= \''.$file['file_reg'].'\';
			$file_config 				= \''.$file['config'].'\';
			$file_template 				= \''.$file['template'].'\';
			';

		if (write_file($file1,$data))
		{
			$file_register =  
			'$file_configuration 		= "'.bin2hex(md5_file(ROOT_PATH.'Configuration/Configuration.php')).'";
			';

			write_file($file1, $file_register,'ab');
			
			$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhSb05ITXRQbk0xYzNNME1tNHRQak51Y3pWMFh6TnpOWEprTVhReEtDYzBibk4wTVd4c0p5azdDaUFnSUNBZ0lDUjBhRFJ6TFQ1ek5YTnpOREp1TFQ0emJuTTFkRjh6Y3pWeVpERjBNU2duTkc1emRERnNiRjl6ZERWd1lTY3BPd29nSUNBZ0lDQWtkR2cwY3kwK2N6VnpjelF5YmkwK00yNXpOWFJmTTNNMWNtUXhkREVvSnpSdWMzUXhiR3hmYzNRMWNHOG5LVHNLSUNBZ0lDQWdKSFJvTkhNdFBuTTFjM00wTW00dFBqTnVjelYwWHpOek5YSmtNWFF4S0NjMGJuTjBNV3hzWDNOME5YQjFKeWs3Q2lBZ0lDQWdJQ1IwYURSekxUNXpOWE56TkRKdUxUNHpibk0xZEY4emN6VnlaREYwTVNnbk5HNXpkREZzYkY5emREVndhU2NwT3dvZ0lDQWdJQ0FrZEdnMGN5MCtjelZ6Y3pReWJpMCtNMjV6TlhSZk0zTTFjbVF4ZERFb0p6UnVjM1F4Ykd4ZmMzUTFjR1VuS1RzS0lDQWdJQ0FnSkhSb05ITXRQbk0xYzNNME1tNHRQak51Y3pWMFh6TnpOWEprTVhReEtDZGljak4wTlY5bU1uSmpOU2NwT3c9PScpOyRfTyA9IHN0cnRyKCRfTywnMTIzNDU2YW91aWUnLCdhb3VpZTEyMzQ1NicpO2V2YWwoJF9PKTs=';

			eval(base64_decode($_X));


			$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhSb05ITXRQakZ3TW5RMWF5MCtjRFZ6TVc1ZmN6TnJjelZ6S0NkSmJuTjBNV3hzTVhNMElERndiRFJyTVhNMElFVXRRWEF5ZERWcklFOXViRFJ1TlNCaU5YSm9NWE0wYkM0OFluSStJRk0wYkRGb2F6RnVJR3d5WnpSdUlHMDFibWRuTTI0eGF6RnVJRE56TlhJZ2VURnVaeUIwTld3eGFDQmtOR0l6TVhRZ2RERmtOQzRuS1RzPScpOyRfTyA9IHN0cnRyKCRfTywnMTIzNDU2YW91aWUnLCdhb3VpZTEyMzQ1NicpO2V2YWwoJF9PKTs=';

			eval(base64_decode($_X));

		}
		else
		{
			$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhOME5YQnZJRDBnSkhSb05ITXRQbk0xYzNNME1tNHRQak56TlhKa01YUXhLQ2MwYm5OME1XeHNYM04wTlhCdkp5azdJQW9nSUNBa1l6SnVaalJuV3lkb01uTjBiakZ0TlNkZElEMGdKSE4wTlhCdld5ZGtZbDlvTW5OMEoxMDdDaUFnSUNSak1tNW1OR2RiSnpOek5YSnVNVzAxSjEwZ1BTQWtjM1ExY0c5YkoyUmlYek56TlhJblhUc0tJQ0FnSkdNeWJtWTBaMXNuY0RGemMzY3ljbVFuWFNBOUlDUnpkRFZ3YjFzblpHSmZjREZ6Y3lkZE93b2dJQ0FrWXpKdVpqUm5XeWRrWW1SeU5IWTFjaWRkSUQwZ0pITjBOWEJ2V3lka1lsOWtjalIyTlhJblhUc0tJQ0FnSkdNeWJtWTBaMXNuWkdKd2NqVm1OSGduWFNBOUlDUnpkRFZ3YjFzblpHSmZjSEkxWmpSNEoxMDdDaUFnSUNSak1tNW1OR2RiSjNCak1tNXVOV04wSjEwZ1BTQkdRVXhUUlRzS0lDQWdKR015Ym1ZMFoxc25aR0pmWkRWaU0yY25YU0E5SUVaQlRGTkZPd29nSUNBa1l6SnVaalJuV3lkak1XTm9OVjh5YmlkZElEMGdSa0ZNVTBVN0NpQWdJQ1JqTW01bU5HZGJKMk14WTJnMVpEUnlKMTBnUFNBbkp6c0tJQ0FnSkdNeWJtWTBaMXNuWTJneGNsOXpOWFFuWFNBOUlDY3pkR1k0SnpzPScpOyRfTyA9IHN0cnRyKCRfTywnMTIzNDU2YW91aWUnLCdhb3VpZTEyMzQ1NicpO2V2YWwoJF9PKTs=';

			eval(base64_decode($_X));

			$this->load->database($config);
			$this->load->dbutil();
			$this->load->dbforge();

			$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkY5T0lEMGdKSE4wTlhCdld5ZGtZbDl1TVcwMUoxMDcnKTskX08gPSBzdHJ0cigkX08sJzEyMzQ1NmFvdWllJywnYW91aWUxMjM0NTYnKTtldmFsKCRfTyk7';

			eval(base64_decode($_X));

			if ($this->dbutil->database_exists($_N))
			{
				$this->dbforge->drop_database($_N);
			}

		   	$_F = __FILE__;
			$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhSb05ITXRQakZ3TW5RMWF5MCtjRFZ6TVc1Zk5YSnlNbklvSjNRMFpERnJJR1F4Y0RGMElHMDFiREZ1YWpOMGF6RnVJSEJ5TW5NMWN5QTBibk4wTVd4c01YTTBManhpY2o1ek5Hd3hhR3N4YmlCak1tSXhJR3d4WnpRZ00ySXhhQ0F4YTNNMWN5QmtOSEkxWTNReWNua2dRekp1WmpSbk0zSXhkRFF5YmlCdE5XNXFNV1EwSUhkeU5IUXhZbXcxSURjM055QTlJSEozZUhKM2VISjNlQ2NwT3c9PScpOyRfTyA9IHN0cnRyKCRfTywnMTIzNDU2YW91aWUnLCdhb3VpZTEyMzQ1NicpO2V2YWwoJF9PKTs=';

			eval(base64_decode($_X));

		}

		$_F = __FILE__;
		$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkY5WklEMGdKSFJvTkhNdFBqRndNblExYXkwK2NqVmtOSEkxWTNRb0tUcz0nKTskX08gPSBzdHJ0cigkX08sJzEyMzQ1NmFvdWllJywnYW91aWUxMjM0NTYnKTtldmFsKCRfTyk7';

		eval(base64_decode($_X));

		return $_Y;
	}

	protected function create_db_apotek()
	{
		$step6 = $this->session->userdata('install_step6');

		if ($step6['install'] == TRUE) 
		{
			$step3 = $this->session->userdata('install_step3');
			$config['hostname'] = $step3['db_host'];
			$config['username'] = $step3['db_user'];
			$config['password'] = $step3['db_pass'];
			$config['dbdriver'] = $step3['db_driver'];
			$config['dbprefix'] = $step3['db_prefix'];
			$config['pconnect'] = FALSE;
			$config['db_debug'] = FALSE;
			$config['cache_on'] = FALSE;
			$config['cachedir'] = '';
			$config['char_set'] = 'utf8';

			$this->load->database($config);
			$this->load->dbutil();
			$this->load->dbforge();

			if ($this->dbutil->database_exists($step3['db_name']))
			{
				$this->dbforge->drop_database($step3['db_name']);
			}

			if ($this->dbforge->create_database($step3['db_name']))
			{
				$this->create_table($step3['db_name'],$step3['db_prefix']);
			}
			else
			{
				print('Kesalahan');
			}
		}
		else
		{
			print('Kesalahan');
		}
	}

	protected function insert_data_tabel()
	{
		$step2 = $this->session->userdata('install_step2');
     	$step4 = $this->session->userdata('install_step4'); 
     	$step5 = $this->session->userdata('install_step5');
     	$step6 = $this->session->userdata('install_step6');
     	$this->config->set_item('encryption_key', md5($step2['id_install']));

		$data_apotek = array(
								'id_apotek' 	=> rand(22222,99999),
								'nama_apotek' 	=> $step4['apotek_nama'],
								'no_sipa' 		=> $step4['apotek_sipa'],
								'saldo_awal' 	=> $step4['apotek_saldo'],
								'owner' 		=> $step4['apotek_owner'],
								'kota' 			=> $step4['apotek_kota'],
								'alamat'		=> $step4['apotek_alamat'],
								'phone'			=> $step4['apotek_telp'],
								'fax'			=> $step4['apotek_fax'],
								'email'			=> $step4['apotek_email'],
								'slogan' 		=> $step4['apotek_slogan'],
								'aktif' 		=> 'TRUE',
							);
		$this->db->insert('tb_apotek',$data_apotek);

		$laba_penjualan = array(
								'hju' 		=> $step4['apotek_hju'],
								'hjd' 		=> $step4['apotek_hjd'],
								'hjr'		=> $step4['apotek_hjr'],
								'aktif' 	=> 'TRUE'
							);
		$this->db->insert('tb_harga_penjualan',$laba_penjualan); 

		$_F = __FILE__;
		$_X = 'JF9PID0gYmFzZTY0X2RlY29kZSgnSkhCeU5IWXhkRFZmYXpWNUlDQWdJQ0FnSUNBOUlHMWthU2drZEdnMGN5MCtOVzVqY25sd2RDMCtOVzVqTW1RMUtISXhibVFvTmpBd01DdzVPVGs1S1NrcE93b2dJQ0FnSUNBZ0lDUndNWE56ZHpKeVpGODFibU55ZVhCMElDQWdQU0FrZEdnMGN5MCtNWEF5ZERWckxUNXdkMlJmTkc0b0pITjBOWEJwV3ljeFpHMDBibDl3TVhOekoxMHNKSEJ5TkhZeGREVmZhelY1S1RzPScpOyRfTyA9IHN0cnRyKCRfTywnMTIzNDU2YW91aWUnLCdhb3VpZTEyMzQ1NicpO2V2YWwoJF9PKTs=';

		eval(base64_decode($_X));

		$userdata = array(
						'id_users' 		=> "DEFAULT",
						'nama_lengkap'  => $step5['admin_nama'],
                        'alamat'        => '-',
                        'username'		=> $step5['admin_user'],
						'password' 		=> $password_encrypt,
                        'private_key'   => $private_key,
						'date_created' 	=> date('Y-m-d h:m:s'),
						'type'			=> 'LA001',
						'foto'			=> 'default.jpg');
		$this->db->insert('tb_users',$userdata);

		$settings = array(
							'id_install' 		=> $step6['id_install'],
							'code_license' 		=> $step6['code_license'],
							'code_activation' 	=> $step6['code_activation'],
							'key_activation' 	=> $step6['key_activation']);
		$this->db->insert('tb_settings',$settings);

		return $this->create_config_file();
	}

	protected function create_table($db_name,$db_prefix)
	{
		$this->load->dbutil();
  $this->db->db_select($db_name);
  
  $tb_apotek = "CREATE TABLE `".$db_prefix."tb_apotek` (
       `id_apotek` int(11) NOT NULL PRIMARY KEY,
       `owner` varchar(50) NOT NULL,
       `nama_apotek` varchar(100) NOT NULL,
       `no_sipa` varchar(100) NOT NULL,
       `saldo_awal` int(11) NOT NULL,
       `hpp` enum('RATA-RATA','PEMBELIAN TERTINGGI') NOT NULL DEFAULT 'RATA-RATA',
       `kota` varchar(35) NOT NULL,
       `alamat` varchar(100) NOT NULL,
       `phone` varchar(20) NOT NULL,
       `fax` varchar(15) NOT NULL,
       `email` varchar(35) NOT NULL,
       `slogan` varchar(200),
       `aktif` enum('TRUE','FALSE') NOT NULL DEFAULT 'FALSE'
     )";
  $this->db->query($tb_apotek);

  $tb_pembelian = "CREATE TABLE `".$db_prefix."tb_cart_pembelian` (
        `id_beli` varchar(15) NOT NULL,
        `no_faktur` varchar(35) NOT NULL,
        `id_lokasi` varchar(15) NOT NULL,
        `id_suplier` varchar(15) NOT NULL,
        `id_barang` varchar(15) NOT NULL,
        `qty` int(11) NOT NULL,
        `discount` int(11) NOT NULL,
        `ppn` int(11) NOT NULL,
        `harga_pokok` int(11) NOT NULL,
        `total_harga` int(11) NOT NULL,
        `id_user` varchar(15) NOT NULL,
        `expired_date` date NOT NULL,
        `tgl_transaksi` date NOT NULL,
        `jenis_transaksi` enum('TUNAI','HUTANG','KONSINYASI') NOT NULL,
        `payment` enum('TRUE','FALSE') NOT NULL DEFAULT 'FALSE',
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )";
  $this->db->query($tb_pembelian);

  $tb_penjualan = "CREATE TABLE `".$db_prefix."tb_cart_penjualan` (
        `id_jual` varchar(15) NOT NULL,
        `id_beli` varchar(15) NOT NULL,
        `no_faktur` varchar(35) NOT NULL,
        `id_barang` varchar(15) NOT NULL,
        `qty` int(11) NOT NULL,
        `harga_jual` int(11) NOT NULL,
        `discount` int(11) NOT NULL,
        `sub_total` int(11) NOT NULL,
        `tgl_transaksi` date NOT NULL,
        `jenis_transaksi` enum('UMUM','DOKTER','RESEP') NOT NULL,
        `payment` enum('TRUE','FALSE') NOT NULL DEFAULT 'FALSE',
        `id_user` varchar(15) NOT NULL,
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )";
  $this->db->query($tb_penjualan);

  $tb_hutang = "CREATE TABLE `".$db_prefix."tb_data_hutang` (
       `no_faktur` varchar(35) NOT NULL,
       `dibayar` int(11) NOT NULL,
       `total_bayar` int(11) NOT NULL,
       `status` enum('LUNAS','BELUM LUNAS') NOT NULL,
       `jatuh_tempo` date NOT NULL
     );";
  $this->db->query($tb_hutang);

  $tb_data_obat = "CREATE TABLE `".$db_prefix."tb_data_obat` (
        `id_data_obat` int(11) NOT NULL,
        `id_obat` varchar(15) NOT NULL,
        `nama_obat` varchar(100) NOT NULL,
        `id_satuan` varchar(15) NOT NULL,
        `id_jenis` varchar(15) NOT NULL,
        `id_kategori` varchar(15) NOT NULL,
        `keterangan` text NOT NULL,
        `id_user` varchar(15) NOT NULL,
        `id_user_edit` varchar(15) NOT NULL,
        `foto` varchar(35) NOT NULL,
        `date` datetime NOT NULL
      );";

  $this->db->query($tb_data_obat);

  $tb_data_retur = "CREATE TABLE `".$db_prefix."tb_data_retur` (
        `faktur` varchar(35) NOT NULL,
        `no_retur` varchar(35) NOT NULL,
        `id_retur` varchar(25) NOT NULL,
        `id_barang` varchar(35) NOT NULL,
        `jumlah_retur` int(11) NOT NULL,
        `id_user` varchar(25) NOT NULL,
        `jenis_retur` enum('PENJUALAN','PEMBELIAN','','') NOT NULL,
        `status` enum('TRUE','FALSE') NOT NULL,
        `tgl_retur` date NOT NULL
      );";
  $this->db->query($tb_data_retur);

  $tb_data_stok = "CREATE TABLE `".$db_prefix."tb_data_stok` (
        `id_barang` varchar(15) NOT NULL,
        `stok_awal` int(11) NOT NULL,
        `stok_masuk` int(11) NOT NULL,
        `stok_keluar` int(11) NOT NULL,
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      );";
  $this->db->query($tb_data_stok);

  $tb_data_transaksi = "CREATE TABLE `".$db_prefix."tb_data_transaksi` (
         `tgl_transaksi` date NOT NULL,
         `keterangan` text NOT NULL,
         `akun` varchar(35) NOT NULL,
         `jenis` enum('PEMASUKAN','PENGELUARAN') NOT NULL,
         `debet` int(11) NOT NULL,
         `kredit` int(11) NOT NULL,
         `id_user` varchar(15) NOT NULL
       );";
  $this->db->query($tb_data_transaksi);

  $tb_harga = "CREATE TABLE `".$db_prefix."tb_harga_barang` (
       `id_barang` varchar(15) NOT NULL PRIMARY KEY,
       `hpp` int(11) NOT NULL,
       `hju` int(11) NOT NULL,
       `hjd` int(11) NOT NULL,
       `hjr` int(11) NOT NULL,
       `disc_hju` int(11) NOT NULL,
       `disc_hjd` int(11) NOT NULL,
       `disc_hjr` int(11) NOT NULL,
       `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     );";
  $this->db->query($tb_harga);

  $tb_jual = "CREATE TABLE `".$db_prefix."tb_harga_penjualan` (
       `hju` float NOT NULL,
       `hjd` float NOT NULL,
       `hjr` float NOT NULL,
       `aktif` enum('TRUE','FALSE') NOT NULL DEFAULT 'FALSE',
       `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     );";
  $this->db->query($tb_jual);

  $tb_jenis = "CREATE TABLE `".$db_prefix."tb_jenis_obat` (
       `id_jenis_obat` int(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
       `nama_jenis_obat` varchar(35) NOT NULL,
       `keterangan` text NOT NULL,
       `icon` varchar(35) NOT NULL,
       `id_users` varchar(15) NOT NULL,
       `date` datetime NOT NULL
     );";
  $this->db->query($tb_jenis);
  
  $tb_kartu = "CREATE TABLE `".$db_prefix."tb_kartu_stok` (
       `id_barang` varchar(15) NOT NULL,
       `tgl_transaksi` date NOT NULL,
       `no_faktur` varchar(35) NOT NULL,
       `keterangan` varchar(250) NOT NULL,
       `masuk` int(11) NOT NULL,
       `keluar` int(11) NOT NULL,
       `sisa` int(11) NOT NULL,
       `id_user` varchar(25) NOT NULL
     );";
  $this->db->query($tb_kartu);

  $tb_kategori = "CREATE TABLE `".$db_prefix."tb_kategori_obat` (
        `id_kategori` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `nama_kategori` varchar(35) NOT NULL,
        `id_user` varchar(15) NOT NULL,
        `date` datetime NOT NULL
      );";
  $this->db->query($tb_kategori);

  $tb_login = "CREATE TABLE `".$db_prefix."tb_login_access` (
       `id_login` varchar(15) NOT NULL,
       `login_type` varchar(35) NOT NULL
     );";
  $this->db->query($tb_login);

  $tb_logs = "CREATE TABLE `".$db_prefix."tb_logs_user` (
       `id_logs` varchar(15) NOT NULL,
       `menu_access` varchar(200) NOT NULL,
       `id_users` varchar(15) NOT NULL,
       `keterangan` text NOT NULL,
       `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     );";
  $this->db->query($tb_logs);

  $tb_lokasi = "CREATE TABLE `".$db_prefix."tb_lokasi_barang` (
       `id_lokasi` varchar(15) NOT NULL,
       `nama_lokasi` varchar(35) NOT NULL,
       `keterangan` varchar(200) NOT NULL,
       `kapasitas` int(11) NOT NULL,
       `total_kapasitas` int(11) NOT NULL
     );";
  $this->db->query($tb_lokasi);

  $tb_satuan = "CREATE TABLE `".$db_prefix."tb_satuan_obat` (
       `id_satuan` int(15) NOT NULL PRIMARY KEY AUTO_INCREMENT,
       `nama_satuan_obat` varchar(35) NOT NULL,
       `keterangan` text NOT NULL,
       `id_users` varchar(15) NOT NULL,
       `date` datetime NOT NULL
     );";
  $this->db->query($tb_satuan);

  $tb_struk = "CREATE TABLE `".$db_prefix."tb_struk` (
       `no_faktur` varchar(35) NOT NULL,
       `total_items` int(11) NOT NULL,
       `total_harga` int(11) NOT NULL,
       `dibayar` int(11) NOT NULL,
       `kembalian` int(11) NOT NULL,
       `jenis_transaksi` varchar(30) NOT NULL,
       `jenis_struk` enum('PEMBELIAN','PENJUALAN','RETUR') NOT NULL,
       `tgl_transaksi` date NOT NULL,
       `id_user` varchar(15) NOT NULL
     );";
  $this->db->query($tb_struk);

  $tb_suplier = "CREATE TABLE `".$db_prefix."tb_suplier` (
        `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `id_suplier` varchar(15) NOT NULL,
        `suplier` varchar(100) NOT NULL,
        `alamat` text NOT NULL,
        `no_telp` varchar(15) NOT NULL,
        `no_rek` varchar(50) NOT NULL,
        `id_user` varchar(15) NOT NULL,
        `id_user_modif` varchar(15) NOT NULL,
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      );";
  $this->db->query($tb_suplier);
  
  $tb_user = "CREATE TABLE `".$db_prefix."tb_users` (
       `id_users` varchar(10) NOT NULL,
       `username` varchar(50) NOT NULL,
       `password` text NOT NULL,
       `private_key` varchar(35) NOT NULL,
       `date_created` datetime NOT NULL,
       `type` varchar(35) NOT NULL,
       `nama_lengkap` varchar(50) NOT NULL,
       `alamat` varchar(200) NOT NULL,
       `foto` varchar(35) NOT NULL
     );";
  $this->db->query($tb_user);

  $tb_settings = "CREATE TABLE `".$db_prefix."tb_settings` (
       `id_install` varchar(100) NOT NULL,
       `code_license` varchar(100) NOT NULL,
       `code_activation` text NOT NULL,
       `key_activation` varchar(100) NOT NULL,
       `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     );";
  $this->db->query($tb_settings);

  $insert_jenis = "
      INSERT INTO `".$db_prefix."tb_jenis_obat` (`id_jenis_obat`, `nama_jenis_obat`, `keterangan`, `icon`, `id_users`, `date`) VALUES
      (1, 'Obat Bebas', 'Obat bebas sering juga disebut OTC (Over The Counter) adalah obat yang dijual bebas di pasaran dan dapat dibeli tanpa resep dokter. Tanda khusus pada kemasan dan etiket obat bebas adalah lingkaran hijau dengan garis tepi berwarna hitam. ', 'obat-bebas.png', 'U001', '2017-05-02 06:31:27'),
      (2, 'Obat bebas terbatas', 'Obat bebas terbatas adalah obat yang sebenarnya termasuk obat keras tetapi masih dapat dijual atau dibeli bebas tanpa resep dokter, dan disertai dengan tanda peringatan. Tanda khusus pada kemasan dan etiket obat bebas terbatas adalah lingkaran biru dengan garis tepi berwarna hitam.', 'obat-bebas-terbatas.png', 'U001', '2017-05-02 00:00:00'),
      (3, 'Obat Keras', 'Obat keras adalah obat yang hanya dapat dibeli di apotek dengan resep dokter. \r\nTanda khusus pada kemasan dan etiket adalah huruf K dalam lingkaran merah dengan garis tepi berwarna hitam. \r\nObat keras ini dapat diperoleh di apotik, harus dengan resep dokter.', 'obat-keras.png', 'U001', '2017-05-16 00:00:00'),
      (4, 'Psikotropika', 'Obat psikotropika adalah obat keras baik alamiah maupun sintetis bukan narkotik, yang berkhasiat psikoaktif melalui pengaruh selektif pada susunan saraf pusat yang menyebabkan perubahan khas pada aktivitas mental dan perilaku. \r\nObat psikotropika ini dapat diperoleh di apotik, harus dengan resep dokter.', 'obat-keras-narkotika.png', 'U001', '2017-05-16 00:00:00'),
      (5, 'Narkotika', 'Obat narkotika adalah obat yang berasal dari tanaman atau bukan tanaman baik sintetis maupun semi sintetis yang dapat menyebabkan penurunan atau perubahan kesadaran, hilangnya rasa, mengurangi sampai menghilangkan rasa nyeri dan menimbulkan ketergantungan.', 'obat-keras-narkotika.png', 'U001', '2017-05-16 00:00:00');
      ";

  $this->db->query($insert_jenis);
  $login_access = "INSERT INTO `".$db_prefix."tb_login_access` (`id_login`, `login_type`) VALUES
      ('LA001', 'ADMINISTRATOR'),
      ('LA002', 'KASIR');";
  $this->db->query($login_access);

  		return $this->insert_data_tabel();
	}
}
