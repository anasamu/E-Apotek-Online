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
| File Database.php
|
| Perhatian !
| Dilarang melakukan perubahan dalam file ini jika anda tidak mengerti
| dengan code2 yang ada. perubahan yg dilakukan dapat menyebabkan aplikasi
| tidak berjalan dengan semestinya.
| --------------------------------------------------------------------------
*/

if (file_exists(ROOT_PATH.'Configuration/Configuration.php')) 
{
	require rtrim(ROOT_PATH.'Configuration/Configuration.php');

	$active_group = 'default';
	$query_builder = TRUE;

	$db['default'] = array(
		'dsn'	=> '',
		'hostname' => $db_hostname,
		'username' => $db_username,
		'password' => $db_password,
		'database' => $db_database,
		'dbdriver' => $db_driver,
		'dbprefix' => $db_prefix,
		'pconnect' => FALSE,
		'db_debug' => FALSE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => TRUE,
		'compress' => TRUE,
		'stricton' => FALSE,
		'failover' => array(),
		'save_queries' => TRUE
	);

	$db['connect'] = array(
		'dsn'	=> '',
		'hostname' => $db_hostname,
		'username' => $db_username,
		'password' => $db_password,
		'database' => '',
		'dbdriver' => $db_driver,
		'dbprefix' => $db_prefix,
		'pconnect' => FALSE,
		'db_debug' => FALSE,
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array(),
		'save_queries' => TRUE
	);


}
