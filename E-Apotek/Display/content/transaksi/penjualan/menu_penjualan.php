<ul class="nav nav-tabs">
	<li class="active"><a href="#default-tab-1" data-toggle="tab">Form Penjualan Barang</a></li>
    <li><a href="#riwayat-transaksi" data-toggle="tab">Riwayat Transaksi Penjualan</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane fade active in" id="default-tab-1">
        <div class="container-fluid">
        <span class="pull-right fa-stack fa-4x text-muted">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-shopping-cart fa-stack-1x"></i>
        </span>
		<h3>Form Transaksi Penjualan</h3>
		<p>
			Menu ini digunakan untuk melakukan transaksi Penjualan barang/obat ke konsumen.
		</p>
        </div>
<?php 
$this->apotek->message();

//cek jika session cart transaksi tersedia
if (empty($this->session->userdata('cart_transaksi_penjualan'))):

// cek jika terdapat transaksi yg belum dikonfirmasi
?>

		<hr/>
			<h5>1.Rincian Transaksi Penjualan:</h5>
			<?php echo form_open('transaksi/penjualan/proses', 'class="form-horizontal" data-parsley-validate="true"');?>
		        <div id="form1">
		        	<div class="form-group">
		                <label class="col-md-3 control-label">No. Faktur <span class="semi-bold text-danger">*</span></label>
		                <div class="col-md-9">
		                    <input name="id_faktur" readonly="" required="" class="form-control" value="<?php echo 'F-J'.date('ymd-His').'-'.$this->session->userdata('id_user');?>" placeholder="No Faktur" type="text">
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="col-md-3 control-label">Tgl. Transaksi <span class="semi-bold text-danger">*</span></label>
		                <div class="col-md-9">
		                    <input name="tgl_transaksi" required="" type="text" id="kalender_penjualan" class="form-control" placeholder="tgl transaksi" value="<?php echo date('d-m-Y');?>" />
		                </div>
		            </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Transaksi <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="jenis_transaksi" required="" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white">
                                <option value="" selected>-- Pilih Salah Satu --</option>
                                <option value="UMUM">Harga Jual Umum</option>
                                <option value="DOKTER">Harga Jual Dokter</option>
                                <option value="RESEP">Harga Jual Resep</option>
                            </select>
                        </div>
                    </div>
                    <p class="bold pull-left">Keterangan : <br/>
                    Silahkan cek dengan benar form transaksi ini. agar tidak terjadi kesalahan dalam sistem E-Apotek.<br/>
                    <strong><span class="text-danger">*) Wajib di isi.</span></strong>
                    </p>
		            <div class="form-group">
		            	<div class="col-md-2  pull-right">
		            	<button type="submit" class="form-control btn btn-success">Proses</button>
		            	</div>
		            </div>
		        </div>
	    	<?php echo form_close();?>
<?php else:?>
        	<hr/>

<?php 
	$transaksi = $this->session->userdata('cart_transaksi_penjualan');
?>

        <div class="col-md-8">
            <p><span class="semi-bold">2. Keranjang Penjualan Barang.</span><br/>Silahkan masukan daftar item yg akan di dijual dalam keranjang. dan klik konfirmasi untuk menyimpan proses transaksi penjualan.</p>
        </div>
        <div class="pull-right col-md-4">
            <div class="text-right">
                Tgl Transaksi : <?php echo $this->apotek->date($transaksi['tgl_transaksi'],false);?><br/>
                Jenis Transaksi : <?php echo $transaksi['jenis_transaksi'];?>
                <h5 class="semi-bold">No. Faktur : <?php echo $transaksi['no_faktur'];?></h5>
            </div>
        </div>
       	<?php echo form_open('transaksi/penjualan/action-delete');?>
       	<table class="table table-hover table-condensed table-th-valign-middle table-td-valign-middle table-striped table-bordered text-center">
        	<thead>
        		<tr>
        			<th class="col-md-1 text-center" rowspan="2">ID JUAL</th>
        			<th class="text-center" colspan="3">Rincian Barang</th>
        			<th class="text-center" colspan="3">Rincian Penjualan Barang</th>
        			<th rowspan="2" class="col-md-2 text-center">Sub Total</th>
        			<th rowspan="2" class="text-center">Action</th>
        		</tr>
        		<tr>
                    <th class="col-md-1 text-center">ID BELI</th>
                    <th class="col-md-2 text-center">LOKASI BARANG</th>
        			<th class="col-md-3">Nama Barang</th>
                    <th class="col-md-1 text-center">QTY</th>
        			<th class="col-md-1 text-center">HARGA JUAL</th>
                    <th class="col-md-1 text-center">Disc%</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?php
                $no         = 0;
    			$qty 		= 0;
    			$harga 		= 0;
    			$total 		= 0;
                $cart = $this->db->where('no_faktur',$transaksi['no_faktur'])
                                ->get('tb_cart_penjualan');

                if ($cart->num_rows() > 0):

        			foreach ($cart->result() as $cart_barang):
                    $dt_obat = $this->master_barang->where($cart_barang->id_barang)
        		?>
        		<tr>
        			<td class="small">
        				<?php 
                        if ($dt_obat !== FALSE) 
                        {
                            echo $cart_barang->id_jual;
                        }
                        else
                        {
                            echo "-";
                        }
                        ?>
        			</td>
                    <td class="small">
                        <?php 
                        if ($dt_obat !== FALSE) 
                        {
                            echo $cart_barang->id_beli;
                        }
                        else
                        {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td class="small">
                        <?php 
                        if ($dt_obat !== FALSE) 
                        {
                            $id_beli = $cart_barang->id_beli;
                            $query   = $this->db->where('id_beli',$id_beli)->get('tb_cart_pembelian');
                            $lokasi  = $this->db->where('id_lokasi',$query->row()->id_lokasi)->get('tb_lokasi_barang');
                            echo $lokasi->row()->nama_lokasi;
                        }
                        else
                        {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td class="text-left">
        				<?php 
        				if ($dt_obat == FALSE) 
    					{
    						echo "<span class='text-danger semi-bold'>Rincian tidak ditemukan. data obat telah dihapus.<br/><small>silahkan hapus items ini dari keranjang pembelian.</small></span>";
    					}
    					else
    					{
    						echo '<img src="'.base_url('assets/img/obat/'.$dt_obat['foto']).'" height="45px" width="45px"> ';
        					echo $dt_obat['nama_barang'];
    					}
        				?>
                    </td>
        			<td>
        				<?php 
        				if ($dt_obat !== FALSE) 
    					{
        					echo $cart_barang->qty.' / '.$dt_obat['satuan'];
        				}
        				else
        				{
        					echo "-";
        				}
        				?>
        			</td>
        			<td>
        				<?php 
        				if ($dt_obat !== FALSE) 
    					{
        					echo $this->apotek->rupiah($cart_barang->harga_jual);
        				}
        				else
        				{
        					echo "-";
        				}
        				?>
        			</td>
                    <td>
                        <?php 
                        if ($dt_obat !== FALSE) 
                        {
                            echo $cart_barang->discount.'%';
                        }
                        else
                        {
                            echo "-";
                        }
                        ?>
                    </td>
        			<td>
        				<?php 
        				if ($dt_obat !== FALSE) 
    					{
        					echo $this->apotek->rupiah($cart_barang->sub_total);
        				}
        				else
        				{
        					echo "-";
        				}
        				?>
        			</td>
        			<td>
        				<input type="checkbox" name="id_beli[]" value="<?php echo $cart_barang->id_jual;?>">
        			</td>

        		</tr>
        	<?php
        			$harga 	+= $cart_barang->harga_jual;
        			$qty 	+= $cart_barang->qty;
        			$total 	+= $cart_barang->sub_total;
                    $no++;
        			endforeach;
        		else:
        	?>
        		<tr>
        			<td colspan="9">Belum ada barang yang di tambahkan ke keranjang penjualan</td>
        		</tr>
        	<?php
        		endif;
        	?>
        	</tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="7"><h4>Grand Total</h4></th>
                    <th colspan="2"><h4><?=$this->apotek->rupiah($total);?></h4></th>
                </tr>
            </tfoot>
       	</table>
        <div class="row">
        	<div class="col-md-12">
		        <div class="pull-right">
		        	<button class="btn btn-white btn-icon btn-circle btn-lg"><i class="fa fa-trash text-danger"></i></button>
		        	<a href="#tambah_barang" class="btn btn-white btn-icon btn-circle btn-lg" data-toggle="modal"><i class="fa fa-plus text-success"></i></a>
				</div>
       		 	<p class="bold pull-left">Keterangan : <br/>
			        Sebelum melakukan konfirmasi pembayaran. Silahkan cek dengan benar form transaksi ini. agar tidak terjadi kesalahan dalam sistem E-Apotek.<br/>
                    Silahkan ambil barang yang akan dijual sesuai dengan lokasi Barang dan <strong>ID BELI</strong>.<br/> 
                    Barang yang akan dijual sudah di pilih dan diproses secara otomatis. sesuai metode yang disetting di aplikasi E-Apotek.<br/>
			        Jika nama barang tidak ditemukan dalam input box. silahkan cek data tsb di menu Data Barang.<br/>
                    Penyebab nama barang tidak ditemukan karena barang yg dicari belum pernah anda beli dari suplier, atau stok barang yang dicari telah habis.<br/>
			        <strong><span class="text-danger">*) Wajib di isi.</span></strong>
        		</p>
        	</div>
        </div>
        <?php echo form_close();?>
        <hr/>
       	<p class="text-right m-b-0">
			<a href="<?php $this->apotek->url('transaksi/penjualan/reset');?>" class="btn btn-white m-r-5">Reset Penjualan</a>
       		<?php
	    		if ($cart->num_rows() > 0)
	    		{
	    			if ($dt_obat !== FALSE) 
					{
    					echo '<a href="#konfirmasi" class="btn btn-primary" data-toggle="modal">Konfirmasi</a>';
    				}
	    		}	
    		?>
		</p>

        <div class="modal fade" id="konfirmasi">
            <div class="modal-dialog">
                <div data-init="true" class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Konfirmasi Penjualan</h4>
                    </div>
                    <div class="panel-body">
                    <?php echo form_open('transaksi/penjualan/save','class="form-horizontal"  data-parsley-validate="true"');?>
                    <p>
                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">No. Faktur  <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" readonly="" name="no_faktur" type="text" class="form-control" placeholder="total_items" value="<?php echo $transaksi['no_faktur'];?>"/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Jenis Transaksi  <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" readonly="" name="jenis_transaksi" type="text" class="form-control" placeholder="total_items" value="<?php echo $transaksi['jenis_transaksi'];?>"/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Total Items  <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" readonly="" name="total_items" type="text" class="form-control" placeholder="total_items" value="<?php echo $no;?>"/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Total Bayar  <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="hidden" name="total_bayar" value="<?=$total;?>">
                            <input required="" readonly="" name="total" type="text" class="form-control" placeholder="total_items" value="<?php echo $this->apotek->rupiah($total);?>"/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Dibayar  <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" name="dibayar" type="number" class="form-control" placeholder="Dibayar" value=""/>
                        </div>
                    </div>

                    Apakah anda yakin ingin menyimpan daftar item pembelian ini?<br/>
                    dengan mengklik simpan akan memperbaharui stok barang yang ada dalam sistem ini.</p>
                    <hr/>
                    <div class="pull-right">
                        <button type="submit" onclick="window.open('<?php $this->apotek->url('transaksi/penjualan/print/'.$transaksi['no_faktur']);?>', '_blank', 'width=800,height=600,scrollbars=no,menubar=no,status=no,resizable=no,screenx=0,screeny=0'); return true;"  class="btn btn-danger btn-sm">Simpan</button>
                    </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>

		<div class="modal fade" id="tambah_barang">
			<div class="modal-dialog">
				<div data-init="true" class="panel panel-success" data-sortable-id="ui-widget-11">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Tambah Barang ke keranjang Penjualan</h4>
                    </div>
                    <div class="panel-body">
                    <?php echo form_open('transaksi/penjualan/proses-obat','class="form-horizontal"  data-parsley-validate="true"');?>
                        <div id="form2">
                            <div class="col-md-12 form-group">
                                <label class="col-md-3 control-label">ID BELI <span class="semi-bold text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input required="" readonly="" name="id_beli" type="text" class="form-control" placeholder="ID Pembelian" value="<?php echo $this->apotek->id_table('J-00','id_beli','tb_cart_pembelian');?>"/>
                                </div>
                            </div>
				            <div class="col-md-12 form-group">
				                <label class="col-md-3 control-label">Nama Barang <span class="semi-bold text-danger">*</span></label>
				                <div class="col-md-9">
				                    <select required="" name="nama_obat" class="form-control selectpicker" data-live-search="true" data-style="btn-white">
				                        <option value="" selected>Silahkan pilih nama barang</option>
				                        <?php 

				                        	$obat = $this->db->get('tb_data_stok');

				                        	if ($obat->num_rows() > 0) 
				                        	{
				                        		foreach ($obat->result() as $dt_obat) 
				                        		{
                                                    $barang = $this->db->where('id_obat',$dt_obat->id_barang)
                                                                        ->get('tb_data_obat');
                                                    if ($barang->num_rows() > 0) 
                                                    {
				                        			 echo "<option value='".$barang->row()->id_obat."'>".$barang->row()->nama_obat."</option>";
                                                    }
				                        		}
				                        	}
				                        ?>
				                    </select>
				                </div>
				            </div>
				            
                            <div class="col-md-12 form-group">
				                <label class="col-md-3 control-label">QTY <span class="semi-bold text-danger">*</span></label>
				                <div class="col-md-9">
				                    <input name="qty" required="" type="number" class="form-control" placeholder="Jumlah Penjualan barang" value=""/>
				                </div>
				            </div>
				            
                            <div class="col-md-12 form-group">
				                <label class="col-md-3 control-label">Discount% </label>
				                <div class="col-md-9">
				                    <input name="discount" type="number" class="form-control" placeholder="Discount" value=""/>
				                </div>
				            </div>
				            
                            <div class="col-md-12 form-group">
				            	<div class="col-md-12">
				            		<button type="submit" class="btn btn-success btn-sm pull-right small">Tambah Barang</button>
				            	</div>
				            </div>

				        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
			</div>
		</div>
<?php endif;?>
	</div>
        <div class="tab-pane fade in" id="riwayat-transaksi">
    <h4>Riwayat Transaksi Penjualan</h4>
        <?php
            $no             = 1;
            $qty            = 0;
            $harga_pokok    = 0;
            $sub_total      = 0; 
            $barang         = $this->db->group_by('no_faktur')->order_by('date','desc')->get('tb_cart_penjualan');
        ?>

        <?php echo $this->session->userdata('message');?>
                <table id="data-table" class="table table-hover table-condensed table-th-valign-middle table-td-valign-middle table-bordered">
                    <thead class="small">
                        <tr>
                            <th class="col-md-1 text-center">No</th>
                            <th>Tgl Transaksi</th>
                            <th class="text-center">No. Faktur</th>
                            <th class="text-center">Jenis Transaksi</th>
                            <th class="text-center">Operator</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                    <?php if ($barang->num_rows () > 0):?>
                    <?php foreach ($barang->result() as $group):?>
                    <?php
                    $user     = $this->master_user->where($group->id_user);

                    if($group->jenis_transaksi === 'UMUM')
                    {
                        $label = '<span class="label label-inverse">UMUM</span>';
                    }
                    elseif ($group->jenis_transaksi === 'DOKTER') 
                    {
                        $label = '<span class="label label-danger">DOKTER</span>';
                    }
                    else
                    {
                         $label = '<span class="label label-warning">RESEP</span>';
                    }
                    ?>
                    <?php
                    $atts = array(
                            'width'       => 800,
                            'height'      => 600,
                            'scrollbars'  => 'no',
                            'status'      => 'no',
                            'resizable'   => 'no',
                            'screenx'     => 0,
                            'screeny'     => 0,
                            'window_name' => '_blank',
                            'class'       => 'btn btn-xs btn-success'
                    );

                    $link_print = anchor_popup('transaksi/penjualan/print/'.$group->no_faktur, '<i class="fa fa-print"></i> Print Struk', $atts);
                    ?>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?= date('d-m-Y',strtotime($group->tgl_transaksi));?></td>
                            <td>
                                <?=$group->no_faktur;?>
                            </td>
                            <td class="text-center"><?=$label;?></td>
                            <td class="text-center"><?=$user['nama_lengkap'];?></td>
                            <td class="text-center"><?=$link_print;?></td>
                        </tr>
                    <?php endforeach;?>
                    <?php else:?>
                        <tr>
                            <td colspan="6">Belum ada transaksi penjualan</td>
                        </tr>
                    <?php endif;?>
                    </tbody>
                </table>

    </div>

</div>