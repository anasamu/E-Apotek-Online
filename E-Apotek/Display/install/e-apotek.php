<?php
	$install = $this->session->userdata('install');
	$license = read_file(VIEWPATH.'install/license.txt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Install E-Apotek Online</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="E-Apotek Online | Aplikasi Pengelola Apotek" name="description" />
	<meta content="Anas Amu" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="<?= $this->apotek->url();?><?= $this->apotek->url();?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?= $this->apotek->url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?= $this->apotek->url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?= $this->apotek->url();?>assets/css/animate.min.css" rel="stylesheet" />
	<link href="<?= $this->apotek->url();?>assets/css/style.min.css" rel="stylesheet" />
	<link href="<?= $this->apotek->url();?>assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?= $this->apotek->url();?>assets/css/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?= $this->apotek->url();?>assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body class="boxed-layout">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="#" class="navbar-brand">E-Apotek Online <small>v 1.0</small></a>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin page-header -->
			<h1 class="page-header">Install E-Apotek Online v 1.0</h1>
			<!-- end page-header -->
			
			<div class="row">
			    <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <?php if($install['install'] == TRUE):?>
                            <div class="progress progress-striped progress-sm active pull-right m-t-5">
				                <div class="progress-bar progress-bar-success" style="width: <?=$install['proses'];?>%"><?=$install['proses'];?>%</div>
				            </div>
				            <?php endif;?>
                            <h4 class="panel-title">E-Apotek Online V 1.0</h4>
                        </div>
                        <div class="panel-body">
                            
                            <?=$this->apotek->message();?>

                        	<?php if($install['install'] !== TRUE):?>
                        	<?php $this->session->sess_destroy();?>
                            <h5>1. Informasi &amp; Persyaratan Installasi</h5>
                            <div data-scrollbar="true" data-height="320px">
	                            <pre>
	                            	<?=$license;?>
	                            </pre>
                            </div>
	                        <?= form_open('install/proses/step2');?>
                            <div class="form-group">
	                        <input type="checkbox" name="accept" class="" value="true">
                            <label class="control-label">Untuk melanjutkan Installasi silahkan centang dan klik Accept untuk melakukan installasi E-Apotek Online.</label>
	                        </div>
	                        <p class="pull-right">
	                        	<button type="submit" class="btn btn-success">Accept</button>
	                        </p>
	                        <?= form_close();?>
	                    	<?php endif;?>

	                    	<?php if($this->session->userdata('install_step2') AND $install['step'] == 2):?>
	                    	<h5>2. Pembuatan Database</h5>
	                    	<hr/>
	                    	<?= form_open('install/proses/step3', 'class="form-horizontal"');?>
	                    	<div class="row">
	                    		<div class="col-md-6">
			                    	<div class="form-group">
		                                <label class="col-md-6 control-label">Hostname</label>
		                                <div class="col-md-6">
		                                    <input name="db_host" class="form-control" placeholder="Hostname Database" type="text" value="localhost">
		                                </div>
		                            </div>
			                    	<div class="form-group">
		                                <label class="col-md-6 control-label">Nama Database</label>
		                                <div class="col-md-6">
		                                    <input name="db_name" class="form-control" placeholder="Nama Database" type="text">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Username Database</label>
		                                <div class="col-md-6">
		                                    <input name="db_user" class="form-control" placeholder="Usernama Database" type="text">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Password Database</label>
		                                <div class="col-md-6">
		                                    <input name="db_pwd" class="form-control" placeholder="Password Database" type="Password">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Database Driver</label>
		                                <div class="col-md-6">
		                                    <input name="db_driver" readonly="readonly" class="form-control" placeholder="Database Driver" type="text" value="mysqli">
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <p class="text-right">
		                    	<button type="submit" name="submit" value="reset" class="btn btn-danger">Reset</button>
		                    	<button type="submit" name="submit" value="proses" class="btn btn-success">Proses</button>
		                    </p>
	                    	<?= form_close();?>
	                    	<?php endif;?>


	                    	<?php if($this->session->userdata('install_step3') AND $install['step'] == 3):?>
	                    	<h5>3. Informasi Apotek</h5>
	                    	<hr/>
	                    	<?= form_open('install/proses/step4', 'class="form-horizontal"');?>
	                    	<div class="row">
	                    		<div class="col-md-6">
			                    	
			                    	<div class="form-group">
		                                <label class="col-md-6 control-label">No. SIPA *</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_sipa" class="form-control" placeholder="No Surat Ijin Apotek" type="text">
		                                </div>
		                            </div>
		                            
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Nama Apotek *</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_nama" class="form-control" placeholder="Nama Apotek" type="text">
		                                </div>
		                            </div>
		                            
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Penanggung Jawab Apotek *</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_owner" class="form-control" placeholder="Penanggung jawab Apotek" type="text">
		                                </div>
		                            </div>
		                            <hr/>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Saldo Awal Apotek *</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_saldo" class="form-control" placeholder="Saldo Awal Apotek" type="number">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Metode HPP *</label>
		                                <div class="col-md-6">
		                                    <select name="apotek_hpp" class="form-control">
		                                    	<option>-- Pilih Metode HPP --</option>
		                                    	<option value="RATA-RATA">HPP : RATA-RATA</option>
		                                    	<option value="PEMBELIAN TERTINGGI">HPP : HARGA PEMBELIAN TERTINGGI</option>
		                                    </select>
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Laba Harga Jual UMUM *</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_hju" class="form-control" placeholder="Laba HJU %" type="number">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Laba Harga Jual DOKTER *</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_hjd" class="form-control" placeholder="Laba HJD %" type="number">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Laba Harga Jual RESEP *</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_hjr" class="form-control" placeholder="Laba HJR %" type="number">
		                                </div>
		                            </div>
		                            <hr/>

		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Kota</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_kota" class="form-control" placeholder="Kota" type="text">
		                                </div>
		                            </div>

		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Alamat</label>
		                                <div class="col-md-6">
		                                    <textarea name="apotek_alamat" class="form-control" placeholder="Alamat"></textarea>
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">No. Telp</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_telp" class="form-control" placeholder="Telp" type="text">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Fax</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_fax" class="form-control" placeholder="fax" type="text">
		                                </div>
		                            </div>
		                            <hr/>

		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Email</label>
		                                <div class="col-md-6">
		                                    <input name="apotek_email" class="form-control" placeholder="email" type="text">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Slogan Struk</label>
		                                <div class="col-md-6">
		                                   <textarea name="apotek_slogan" class="form-control" placeholder="Slogan Struk"></textarea>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <p>
                            	Perhatian : <br/>
                            	No.SIPA dan Nama Apotek tidak dapat diubah setelah anda selesai melakukan installasi E-Apotek Online, silahkan isi dengan benar form ini.<br/>
                            	<small class="text-danger">*) Wajib diisi.</small> 
                            </p>
		                    <p class="text-right">
		                    	<button type="submit" name="submit" value="reset" class="btn btn-danger">Kembali</button>
		                    	<button type="submit" name="submit" value="proses" class="btn btn-success">Proses</button>
		                    </p>
	                    	<?= form_close();?>
	                    	<?php endif;?>


	                    	<?php if($this->session->userdata('install_step4') AND $install['step'] == 4):?>
	                    	<h5>4. Informasi Login Administrator</h5>
	                    	<hr/>
	                    	<?= form_open('install/proses/step5', 'class="form-horizontal"');?>
	                    	<div class="row">
	                    		<div class="col-md-6">
			                    	<div class="form-group">
		                                <label class="col-md-6 control-label">Nama Lengkap</label>
		                                <div class="col-md-6">
		                                    <input name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" type="text">
		                                </div>
		                            </div>
			                    	<div class="form-group">
		                                <label class="col-md-6 control-label">Username</label>
		                                <div class="col-md-6">
		                                    <input name="username" class="form-control" placeholder="Username" type="text">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Password</label>
		                                <div class="col-md-6">
		                                    <input name="password" class="form-control" placeholder="Password" type="password">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-6 control-label">Ulangi Password</label>
		                                <div class="col-md-6">
		                                    <input name="password2" class="form-control" placeholder="Ulangi Password" type="Password">
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <p class="text-right">
		                    	<button type="submit" name="submit" value="reset" class="btn btn-danger">Kembali</button>
		                    	<button type="submit" name="submit" value="proses" class="btn btn-success">Proses</button>
		                    </p>
	                    	<?= form_close();?>
	                    	<?php endif;?>

	                    	<?php if($this->session->userdata('install_step5') AND $install['step'] == 5):?>
	                    	<?php

	                    		$step2 = $this->session->userdata('install_step2');
	                    		$step4 = $this->session->userdata('install_step4');
	                    	?>
	                    	<h5>4. Informasi Code License</h5>
	                    	<hr/>
	                    	<?= form_open('install/proses/step6', 'class="form-horizontal"');?>
	                    	<div class="row">
	                    		<div class="col-md-6">
	                    			<div class="form-group">
		                                <label class="col-md-4 control-label">NO. SIPA</label>
		                                <div class="col-md-8">
		                                    <input name="no_sipa" readonly="" class="form-control" placeholder="ID INSTALL" type="text" value="<?=$step4['apotek_sipa'];?>">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-4 control-label">NAMA APOTEK</label>
		                                <div class="col-md-8">
		                                    <input name="apotek" readonly="" class="form-control" placeholder="ID INSTALL" type="text" value="<?=$step4['apotek_nama'];?>">
		                                </div>
		                            </div>
			                    	<div class="form-group">
		                                <label class="col-md-4 control-label">ID INSTALL</label>
		                                <div class="col-md-8">
		                                    <input name="id_install" class="form-control" placeholder="ID INSTALL" type="text" value="<?=$step2['id_install'];?>">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-4 control-label">CODE LICENSE</label>
		                                <div class="col-md-8">
		                                    <input name="code_license" class="form-control" placeholder="CODE LICENSE" type="text" value="<?=$step2['random_key'];?>">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label class="col-md-4 control-label">CODE AKTIVASI</label>
		                                <div class="col-md-8">
		                                    <textarea name="code_activation" class="form-control" placeholder="CODE AKTIVASI"></textarea>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <p>Keterangan : <br/>
		                    Jika anda mempunyai ID INSTALL dan CODE LICENSE yang sebelumnya silahkan masukan data tsb dan masukan code aktivasi sesuai data sebelumnya.<br/>
		                    untuk percobaan DEMO aplikasi ini silahkan <a href="<?=$this->apotek->url('install/proses/demo');?>">klik disini.</a> untuk mengunduh code license demo.</p>
		                    <p class="text-right">
		                    	<button type="submit" name="submit" value="reset" class="btn btn-danger">Kembali</button>
		                    	<button type="submit" name="submit" value="proses" class="btn btn-success">Aktivasi</button>
		                    </p>
	                    	<?= form_close();?>
	                    	<?php endif;?>

	                    	<?php if($install['step'] == 6 ):?>
	                    	<h4>Terimakasih sudah membeli aplikasi E-Apotek Online.</h4>
	                    	<p>Silahkan ubah directory Configuration menjadi 644 (drw-r--r--) untuk menyelesaikan proses installasi.<br/> jika telah melakukan perubahan directory Configuration silahkan klik <a href="<?=$this->apotek->url('install/proses/finish');?>">disini</a>.</p>
	                    	<?php endif;?>
                        </div>
                    </div>
			    </div>
			</div>
		</div>
		<!-- end #content -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?= $this->apotek->url();?>assets/plugins/jquery/jquery.min.js"></script>
	<script src="<?= $this->apotek->url();?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?= $this->apotek->url();?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?= $this->apotek->url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?= $this->apotek->url();?>assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?= $this->apotek->url();?>assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?= $this->apotek->url();?>assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?= $this->apotek->url();?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?= $this->apotek->url();?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?= $this->apotek->url();?>assets/js/apps.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
</html>
