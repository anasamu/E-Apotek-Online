<?php defined('BASEPATH') OR exit('No direct script access allowed');

class E_Apotek_Controller extends CI_Controller 
{
    public function __construct()
    {
            parent::__construct();
            return $this->load_files();
    }

    public function load_files()
    {
        if (!file_exists('index.php')) 
        {
            echo "file index.php tidak ditemukan.";
            exit;
        }
        elseif (!file_exists('.htaccess')) 
        {
            echo "file .htaccess tidak ditemukan.";
            exit;
        }
        elseif (!file_exists(ROOT_PATH.'E_Apotek.php')) 
        {
            echo "file E_Apotek.php tidak ditemukan.";
            exit;
        }
        elseif (!file_exists(ROOT_PATH.'Boostrap.php')) 
        {
            echo "file Boostrap.php tidak ditemukan.";
            exit;
        }
        elseif (!file_exists(APPPATH.'libraries/Apotek.php')) 
        {
            echo "file Libraries Apotek.php tidak ditemukan.";
            exit;
        }
        else
        {
            return $this->get_files();
        }
    }

    public function get_files()
    {
        if (file_exists(ROOT_PATH.'Configuration/Configuration.php')) 
        {
            $register = $this->config->item('file');

            $file[] =  bin2hex(md5_file('index.php'));
            $file[] =  bin2hex(md5_file('.htaccess'));
            $file[] =  bin2hex(md5_file(ROOT_PATH.'E_Apotek.php'));
            $file[] =  bin2hex(md5_file(ROOT_PATH.'Boostrap.php'));
            $file[] =  bin2hex(md5_file(APPPATH.'libraries/Apotek.php'));
            $file[] =  bin2hex(md5_file(APPPATH.'core/E_Apotek_Controller.php'));
            $file[] =  bin2hex(md5_file(APPPATH.'config/file_register.php'));
            $file[] =  bin2hex(md5_file(APPPATH.'config/config.php'));
            $file[] =  bin2hex(md5_file(VIEWPATH.'template/index.php'));
            $file[] =  $register[9];
            return $this->check_files($file);
        }
    }

    public function check_files($file)
    {
        $register = $this->config->item('file');
        $scanning = $file;

        if (file_exists(ROOT_PATH.'Configuration/Configuration.php')) 
        {
            if ($this->apotek->check_configuration() == FALSE) 
            {
               redirect();
            }

            for ($i=0; $i < count($register); $i++) 
            { 
                if($this->encrypt->hash($register[$i]) !== $this->encrypt->hash($scanning[$i]))
                {
                   // echo "Kesalahan! Struktur file Aplikasi E-Apotek Online telah dirubah, aplikasi tidak dapat dilanjutkan!<br/> silahkan restore file Configuration.php atau install ulang aplikasi E-Apotek Online anda.<br/>";
                    //exit;
                }
                
            }
        }
    }
}
