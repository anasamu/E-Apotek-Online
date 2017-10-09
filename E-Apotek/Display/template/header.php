<?php

$user = $this->apotek->users();
?>

<div id="header" class="header navbar navbar-fixed-top navbar-inverse">
	<!-- begin container-fluid -->
	<div class="container-fluid">
	    <!-- begin mobile sidebar expand / collapse button -->
	    <div class="navbar-header">
	        <a href="<?php echo base_url();?>" class="navbar-brand"><span class="icon-i-health-services"></span> E-Apotek Online</a>
	        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	        </button>
	        <button type="button" class="navbar-toggle p-0 m-r-5" data-toggle="collapse" data-target="#top-navbar">
	            <span class="fa-stack fa-lg text-inverse">
	                <i class="fa fa-square-o fa-stack-2x m-t-2"></i>
	                <i class="fa fa-cog fa-stack-1x"></i>
	            </span>
	        </button>
	    </div>
	    <!-- end mobile sidebar expand / collapse button -->
	    
	    <!-- begin navbar-collapse -->
	    <div class="collapse navbar-collapse pull-left" id="top-navbar">
	        
	    </div>
	    <!-- end navbar-collapse -->
	    
	    <!-- begin header navigation right -->
	    <ul class="nav navbar-nav navbar-right">
	        <li class="dropdown navbar-user">
	            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
	                <img src="<?php echo base_url('assets/img/user/'.$user->foto);?>" alt="" /> 
	                <span class="hidden-xs"><?php echo $user->nama_lengkap;?></span> <b class="caret"></b>
	            </a>
	            <ul class="dropdown-menu animated fadeInLeft">
	                <li class="arrow"></li>
	                <li><a href="#keluar" data-toggle="modal"><i class="fa fa-power-off text-danger"></i> Keluar</a></li>
	            </ul>
	        </li>
	    </ul>
	    <!-- end header navigation right -->
	</div>
<!-- end container-fluid -->
</div>

<div class="modal" id="keluar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-warning"></i> Informasi!</h4>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin keluar dari sistem?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Batal</a>
                <a href="<?php echo base_url('logout');?>" class="btn btn-sm btn-danger">Keluar</a>
            </div>
        </div>
    </div>
</div>