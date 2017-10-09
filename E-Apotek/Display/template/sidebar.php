  <?php

$user           = $this->apotek->users();
$login_access   = $this->db->where('id_login',$user->type)
                        ->get('tb_login_access');
?>

 <div id="sidebar" class="sidebar">

    <!-- begin sidebar user -->
    <ul class="nav">
        <li class="nav-profile">
            <img class="img-rounded img-responsive" src="<?php echo base_url('assets/img/user/'.$user->foto);?>" alt="User Profile"/>
            <div class="info text-center">
                <div class="divider"></div>
                <?php echo $user->nama_lengkap;?>
                <small><?php echo $login_access->row()->login_type;?></small>
            </div>
        </li>
    </ul>
    <!-- end sidebar user -->    
            
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="320px">
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li>
                <a href="<?php $this->apotek->url();?>dashboard">
                    <i class="fa fa-laptop"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if ($this->session->userdata('access') === 'ADMINISTRATOR'):?>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-suitcase"></i>
                    <span>Data Master</span> 
                </a>
                <ul class="sub-menu">
                    <li><a href="<?php $this->apotek->url();?>master/user">Master User</a></li>
                    <li><a href="<?php $this->apotek->url();?>master/barang">Master Barang</a></li>
                    <li><a href="<?php $this->apotek->url();?>master/suplier">Master Suplier</a></li>
                </ul>
            </li>
            <?php endif;?>
            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file-o"></i>
                    <span>Data Barang</span> 
                </a>
                <ul class="sub-menu">
                    <li><a href="<?php $this->apotek->url();?>barang/rincian-harga">Harga Barang</a></li>
                    <li><a href="<?php $this->apotek->url();?>barang/stok-barang">Stok Barang</a></li>
                    <li><a href="<?php $this->apotek->url();?>barang/expired-date">Expired Date</a></li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-shopping-cart"></i> 
                    <span>Transaksi</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?php $this->apotek->url();?>transaksi/penjualan">Penjualan</a></li>
                    <li><a href="<?php $this->apotek->url();?>transaksi/pembelian">Pembelian</a></li>
                    <li><a href="<?php $this->apotek->url();?>transaksi/penjualan/retur">Retur Penjualan</a></li>
                    <li><a href="<?php $this->apotek->url();?>transaksi/pembelian/retur">Retur Pembelian</a></li>
                    <li class="has-sub">
                        <a href="#">
                            <b class="caret pull-right"></b>
                            Pembayaran
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?php $this->apotek->url();?>transaksi/pembayaran/hutang">Hutang</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="has-sub">
                <a href="#">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-book"></i> 
                    <span>Laporan</span>
                </a>
                <ul class="sub-menu">
                    <?php if ($this->session->userdata('access') === 'ADMINISTRATOR'):?>
                    <li><a href="<?php $this->apotek->url();?>laporan/apotek">Apotek</a></li>
                    <?php endif;?>
                    <li><a href="<?php $this->apotek->url();?>laporan/penjualan">Penjualan</a></li>
                    <li><a href="<?php $this->apotek->url();?>laporan/pembelian">Pembelian</a></li>
                    <?php if ($this->session->userdata('access') === 'ADMINISTRATOR'):?>
                    <li><a href="<?php $this->apotek->url();?>laporan/laba-rugi">Laba/Rugi</a></li>
                    <?php endif;?>
                </ul>
            </li>

            <?php if ($this->session->userdata('access') === 'ADMINISTRATOR'):?>
            <li class="has-sub">
                <a href="#">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-cogs"></i>
                    <span>Pengaturan</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?php $this->apotek->url();?>pengaturan/apotek">Pengaturan Apotek</a></li>
                    <li><a href="<?php $this->apotek->url();?>pengaturan/barang">Pengaturan barang</a></li>
                    <li><a href="<?php $this->apotek->url();?>pengaturan/backup">Pengaturan Backup</a></li>
                </ul>
            </li>
            <?php endif;?>
            <!-- begin sidebar minify button -->
            <li><a href="#" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->

</div>
<div class="sidebar-bg"></div>
