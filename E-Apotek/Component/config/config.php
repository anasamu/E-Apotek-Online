<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -----------------------------------------------------------------------
| Copyright (c) 2017 E-Apotek Online
| -----------------------------------------------------------------------
| NAMA APLIKASI 	: E-Apotek Online
| VERSI APLIKASI 	: v 1.0
| 
| ------------------------------------------------------------------------
| Aplikasi E-Apotek Online merupakan sistem informasi untuk usaha apotek
| yang dibuat dan didesain sedemikian rupa untuk memanajemen semua data
| yang ada dalam apotek agar terstruktur secara teratur. dan mendapatkan
| data laporan penjualan, pembelian, stok barang dll. secara cepat, dan
| mudah.
| ------------------------------------------------------------------------
| Aplikasi ini dibuat dan dikembangkan oleh Anas Amu.
| Dilarang menyebarkan aplikasi ini tanpa ijin dari pembuat.
|
| untuk kritik, saran, pelaporan bugs atau mendapatkan info mengenai 
| pembaharuan aplikasi ini silahkan email di anasamu7@gmail.com
| ------------------------------------------------------------------------
| 
| File Config.php
|
| Perhatian !
| Dilarang melakukan perubahan dalam file ini.
| perubahan yg dilakukan dapat menyebabkan aplikasi tidak berjalan.
| --------------------------------------------------------------------------
*/


$config['base_url'] 					= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url']						.= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] 					.= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$config['index_page'] 					= '';
$config['uri_protocol']					= 'REQUEST_URI';
$config['url_suffix'] 					= '';
$config['language']						= 'english';
$config['charset'] 						= 'UTF-8';
$config['enable_hooks'] 				= FALSE;
$config['subclass_prefix'] 				= 'E_Apotek_';
$config['composer_autoload'] 			= FALSE;
$config['permitted_uri_chars'] 			= 'a-z 0-9~%.:_\-=';
$config['enable_query_strings'] 		= FALSE;
$config['controller_trigger'] 			= 'c';
$config['function_trigger'] 			= 'm';
$config['directory_trigger'] 			= 'd';
$config['allow_get_array'] 				= TRUE;
$config['log_threshold'] 				= 0;
$config['log_path'] 					= '';
$config['log_file_extension'] 			= '';
$config['log_file_permissions'] 		= 0644;
$config['log_date_format'] 				= 'Y-m-d H:i:s';
$config['error_views_path'] 			= APPPATH.'errors/';
$config['cache_path'] 					= '';
$config['cache_query_string'] 			= FALSE;

if (file_exists(ROOT_PATH.'Configuration/Configuration.php')) 
{
	require ROOT_PATH.'Configuration/Configuration.php';
	$config['encryption_key'] = md5($install_id);
}

$config['sess_driver'] 					= 'files';
$config['sess_cookie_name'] 			= 'e-apotek';
$config['sess_expiration'] 				= 3200;
$config['sess_save_path'] 				= NULL;
$config['sess_match_ip'] 				= TRUE;
$config['sess_time_to_update'] 			= 300;
$config['sess_regenerate_destroy'] 		= TRUE;
$config['cookie_prefix']				= '';
$config['cookie_domain']				= '';
$config['cookie_path']					= '/';
$config['cookie_secure']				= FALSE;
$config['cookie_httponly'] 				= FALSE;
$config['standardize_newlines'] 		= TRUE;
$config['global_xss_filtering'] 		= TRUE;
$config['csrf_protection'] 				= TRUE;
$config['csrf_token_name'] 				= 'token_apotek';
$config['csrf_cookie_name'] 			= 'cookie_apotek';
$config['csrf_expire'] 					= 7200;
$config['csrf_regenerate'] 				= TRUE;
$config['csrf_exclude_uris']	 		= array();
$config['compress_output'] 				= TRUE;
$config['time_reference'] 				= 'now';
$config['rewrite_short_tags'] 			= FALSE;
$config['proxy_ips']	 				= '';
