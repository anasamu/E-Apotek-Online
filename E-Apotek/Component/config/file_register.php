<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
| File file_register.php
|
| Perhatian !
| Dilarang melakukan perubahan dalam file ini.
| perubahan yg dilakukan dapat menyebabkan aplikasi tidak berjalan.
| --------------------------------------------------------------------------
*/

if (file_exists(ROOT_PATH.'Configuration/Configuration.php')) 
{
	require ROOT_PATH.'Configuration/Configuration.php';

	$config['file'][] 		= $file_index;
	$config['file'][] 		= $file_htaccess;
	$config['file'][]		= $file_e_apotek;
	$config['file'][]		= $file_boostrap;
	$config['file'][]		= $file_apotek;
	$config['file'][]		= $file_controller;
	$config['file'][]		= $file_reg;
	$config['file'][]		= $file_config;
	$config['file'][] 		= $file_template;
	$config['file'][]		= $file_configuration;
}
else
{
	$config['file'][] 		= '';
	$config['file'][] 		= '';
	$config['file'][]		= '';
	$config['file'][]		= '';
	$config['file'][]		= '';
	$config['file'][]		= '';
	$config['file'][]		= '';
	$config['file'][]		= '';
	$config['file'][]		= '';
	$config['file'][]		= '';
}
