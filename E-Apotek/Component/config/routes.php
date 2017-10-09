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
| File routers.php
|
| Perhatian !
| Dilarang melakukan perubahan dalam file ini jika anda tidak mengerti
| dengan code2 yang ada. perubahan yg dilakukan dapat menyebabkan aplikasi
| tidak berjalan dengan semestinya.
| --------------------------------------------------------------------------
*/


$route['default_controller'] 		= 'dashboard';
$route['404_override'] 				= '';
$route['translate_uri_dashes'] 		= TRUE;

// link Data Master
// master user link
$route['master/user'] 						= 'master/Controllers_master_user';
$route['master/user/views/(:any)'] 			= 'master/Controllers_master_user/views/$1';
$route['master/user/tambah'] 				= 'master/Controllers_master_user/tambah';
$route['master/user/edit'] 					= 'master/Controllers_master_user/edit';
$route['master/user/delete'] 				= 'master/Controllers_master_user/delete';

//master barang link
$route['master/barang'] 					= 'master/Controllers_master_barang';
$route['master/barang/views/(:any)'] 		= 'master/Controllers_master_barang/views/$1';
$route['master/barang/tambah'] 				= 'master/Controllers_master_barang/tambah';
$route['master/barang/edit'] 				= 'master/Controllers_master_barang/edit';
$route['master/barang/delete']				= 'master/Controllers_master_barang/delete';

$route['master/suplier'] 					= 'master/Controllers_master_suplier';
$route['master/suplier/tambah'] 			= 'master/Controllers_master_suplier/tambah';
$route['master/suplier/edit'] 				= 'master/Controllers_master_suplier/edit';
$route['master/suplier/delete'] 			= 'master/Controllers_master_suplier/delete';
// Link Data Barang
$route['barang/rincian-harga'] 						= 'barang/Controllers_rincian_harga';
$route['barang/rincian-harga/update'] 				= 'barang/Controllers_rincian_harga/update';
$route['barang/rincian-barang'] 					= 'barang/Controllers_rincian_barang';
// Link Pembelian
$route['transaksi/pembelian'] 						= 'transaksi/Controllers_pembelian';
$route['transaksi/pembelian/proses']  				= 'transaksi/Controllers_pembelian/proses';
$route['transaksi/pembelian/proses-obat'] 			= 'transaksi/Controllers_pembelian/proses-obat';
$route['transaksi/pembelian/save'] 					= 'transaksi/Controllers_pembelian/save/$1';
$route['transaksi/pembelian/reset']  				= 'transaksi/Controllers_pembelian/reset';
$route['transaksi/pembelian/action-delete'] 		= 'transaksi/Controllers_pembelian/action-delete';
$route['transaksi/pembelian/print/(:any)'] 			= 'transaksi/Controllers_pembelian/print_faktur/$1';
$route['transaksi/pembelian/retur'] 				= 'transaksi/Controllers_pembelian/retur';
$route['transaksi/pembelian/retur/proses'] 			= 'transaksi/Controllers_pembelian/proses-retur';
$route['transaksi/pembelian/retur/proses-items'] 	= 'transaksi/Controllers_pembelian/proses-retur-items';
$route['transaksi/pembelian/retur/save'] 			= 'transaksi/Controllers_pembelian/retur-save';
$route['transaksi/pembelian/retur/reset'] 			= 'transaksi/Controllers_pembelian/retur-reset';

// Link Penjualan
$route['transaksi/penjualan'] 						= 'transaksi/Controllers_penjualan';
$route['transaksi/penjualan/proses'] 				= 'transaksi/Controllers_penjualan/proses';
$route['transaksi/penjualan/proses-obat'] 			= 'transaksi/Controllers_penjualan/proses-obat';
$route['transaksi/penjualan/save'] 					= 'transaksi/Controllers_penjualan/save';
$route['transaksi/penjualan/reset'] 				= 'transaksi/Controllers_penjualan/reset';
$route['transaksi/penjualan/action-delete'] 		= 'transaksi/Controllers_penjualan/action-delete';
$route['transaksi/penjualan/print/(:any)'] 			= 'transaksi/Controllers_penjualan/print_faktur/$1';
$route['transaksi/penjualan/retur'] 				= 'transaksi/Controllers_penjualan/retur';
$route['transaksi/penjualan/retur/proses'] 			= 'transaksi/Controllers_penjualan/proses-retur';
$route['transaksi/penjualan/retur/proses-items'] 	= 'transaksi/Controllers_penjualan/proses-retur-items';
$route['transaksi/penjualan/retur/save'] 			= 'transaksi/Controllers_penjualan/retur-save';
$route['transaksi/penjualan/retur/reset'] 			= 'transaksi/Controllers_penjualan/retur-reset';

$route['transaksi/pembayaran/hutang'] 				= 'transaksi/Controllers_pembayaran/hutang';
$route['transaksi/pembayaran/hutang/proses'] 		= 'transaksi/Controllers_pembayaran/proses_hutang';

// Link Laporan penjualan
$route['laporan/penjualan'] 						= 'laporan/Controllers_laporan_penjualan';
$route['laporan/penjualan/print'] 					= 'laporan/Controllers_laporan_penjualan/print_laporan';

// Link Laporan Pembelian
$route['laporan/pembelian'] 						= 'laporan/Controllers_laporan_pembelian';
$route['laporan/pembelian/print'] 					= 'laporan/Controllers_laporan_pembelian/print_laporan';

// Link Laporan data apotek
$route['laporan/apotek'] 							= 'laporan/Controllers_laporan_barang';
$route['laporan/apotek/kartu-stok/print'] 			= 'laporan/Controllers_laporan_barang/kartu-stok';
$route['laporan/apotek/harga-barang/print'] 		= 'laporan/Controllers_laporan_barang/harga-barang';
$route['laporan/apotek/expired/print'] 				= 'laporan/Controllers_laporan_barang/expired';
$route['laporan/apotek/buku-besar/print'] 			= 'laporan/Controllers_laporan_barang/buku-besar';


$route['laporan/laba-rugi'] 						= 'laporan/Controllers_laporan_laba_rugi';
$route['laporan/laba-rugi/print'] 					= 'laporan/Controllers_laporan_laba_rugi/print_laporan';



$route['pengaturan/barang'] 					= 'pengaturan/Controllers_pengaturan_barang';
$route['pengaturan/lokasi/tambah'] 				= 'pengaturan/Controllers_pengaturan_barang/tambah_lokasi_barang';
$route['pengaturan/lokasi/edit'] 				= 'pengaturan/Controllers_pengaturan_barang/edit_lokasi_barang';
$route['pengaturan/lokasi/delete'] 				= 'pengaturan/Controllers_pengaturan_barang/hapus_lokasi_barang';

$route['pengaturan/obat/edit-jenis-obat'] 		= 'pengaturan/Controllers_pengaturan_barang/edit_jenis_obat';

$route['pengaturan/obat/tambah-kategori-obat'] 	= 'pengaturan/Controllers_pengaturan_barang/tambah_kategori_obat';
$route['pengaturan/obat/edit-kategori-obat'] 	= 'pengaturan/Controllers_pengaturan_barang/edit_kategori_obat';
$route['pengaturan/obat/hapus-kategori-obat'] 	= 'pengaturan/Controllers_pengaturan_barang/hapus_kategori_obat';

$route['pengaturan/barang/tambah-satuan-obat'] 	= 'pengaturan/Controllers_pengaturan_barang/tambah_satuan_obat';
$route['pengaturan/barang/edit-satuan-obat'] 	= 'pengaturan/Controllers_pengaturan_barang/edit_satuan_obat';
$route['pengaturan/barang/hapus-satuan-obat'] 	= 'pengaturan/Controllers_pengaturan_barang/hapus_satuan_obat';

$route['pengaturan/apotek'] 					= 'pengaturan/Controllers_pengaturan_apotek';
$route['pengaturan/apotek/update'] 				= 'pengaturan/Controllers_pengaturan_apotek/update';

$route['pengaturan/update/laba-penjualan'] 		= 'pengaturan/Controllers_pengaturan_apotek/update_laba_penjualan';
$route['pengaturan/backup'] 					= 'pengaturan/Controllers_pengaturan_apotek/database';
$route['pengaturan/configuration/backup'] 		= 'pengaturan/Controllers_pengaturan_apotek/config_backup';
$route['pengaturan/config/decrypt'] 			= 'pengaturan/Controllers_pengaturan_apotek/config_decrypt';

$route['pengaturan/database/backup'] 			= 'pengaturan/Controllers_pengaturan_apotek/database_backup';
$route['pengaturan/database/decrypt'] 			= 'pengaturan/Controllers_pengaturan_apotek/database_decrypt';

$route['logout'] 								= 'dashboard/logout';
