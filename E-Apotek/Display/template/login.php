<?php 
$apotek         = $this->apotek->e_apotek();
$login_type     = $this->db->get('tb_login_access');
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8" />
	<title>Login <?php echo $apotek->nama_apotek;?> | E-Apotek Online</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <link href="<?php $this->apotek->url();?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="<?php $this->apotek->url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php $this->apotek->url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="<?php $this->apotek->url();?>assets/css/animate.min.css" rel="stylesheet"/>
    <link href="<?php $this->apotek->url();?>assets/css/style.min.css" rel="stylesheet"/>
    <link href="<?php $this->apotek->url();?>assets/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="<?php $this->apotek->url();?>assets/css/wfmi-style.css" rel="stylesheet"/>
    <link href="<?php $this->apotek->url();?>assets/css/theme/default.css" rel="stylesheet" id="theme"/>
    <link href="<?php $this->apotek->url();?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="<?php $this->apotek->url();?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"/>

</head>

<body class="pace-top bg-white">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
	    <!-- begin login -->
        <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image">
                    <img src="<?php $this->apotek->url();?>assets/img/login-bg/background.jpg" data-id="login-cover-image" alt="" />
                </div>
                <div class="news-caption">
                    <h4 class="caption-title text-success"><span class="icon-i-health-services"></span> <?php echo $apotek->nama_apotek;?></h4>
                    <address>
                        <i class="fa fa-compass"></i> Alamat : <?php echo $apotek->alamat;?><br/>
                        <i class="fa fa-phone-square"></i> Telepon : <?php echo $apotek->phone;?><br/>
                        <i class="fa fa-envelope"></i> Email : <?php echo $apotek->email;?><br/>
                    </address>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header highlight">
                    <div class="brand text-success">
                        <span class="icon-i-health-services"></span> E-Apotek Online
                        <small class="text-success">Sistem Informasi <?php echo $apotek->nama_apotek;?></small>
                    </div>
                    <div class="icon text-success">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                	<h4>Login Sistem</h4>
                    <?php echo $this->session->flashdata('message');
                    echo form_open('login/proses','data-parsley-validate="true"');?>
                        <div class="form-group m-b-15">
                            <input name="username" id="username" type="text" class="form-control input-lg" placeholder="Username" required />
                        </div>
                        <div class="form-group m-b-15">
                            <input name="password" id="password" type="password" class="form-control input-lg" placeholder="Password" required />
                        </div>
                        <div class="form-group m-b-15">
                                <select name="login_type" class="form-control input-lg selectpicker" data-size="4" data-live-search="true" data-style="btn-white" required="required">
                                    <option value="">Tipe Login</option>
                                    <?php foreach ($login_type->result() as $items):?>
                                    <option value="<?php echo $items->id_login;?>"><?php echo $items->login_type;?></option>
                                    <?php endforeach;?>
                                </select>
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-info btn-block btn-lg">Login</button>
                        </div>
                    <?php echo form_close();?>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->
        
	</div>
	<!-- end page container -->
	
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php $this->apotek->url();?>assets/plugins/pace/pace.min.js"></script>
    <script src="<?php $this->apotek->url();?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php $this->apotek->url();?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="<?php $this->apotek->url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="<?php $this->apotek->url();?>assets/crossbrowserjs/html5shiv.js"></script>
        <script src="<?php $this->apotek->url();?>assets/crossbrowserjs/respond.min.js"></script>
        <script src="<?php $this->apotek->url();?>assets/crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?php $this->apotek->url();?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php $this->apotek->url();?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->
    
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php $this->apotek->url();?>assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="<?php $this->apotek->url();?>assets/js/apps.min.js"></script>
    <script src="<?php $this->apotek->url();?>assets/plugins/parsley/dist/parsley.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
</html>
