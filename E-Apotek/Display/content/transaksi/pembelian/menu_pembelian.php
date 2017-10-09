<ul class="nav nav-tabs">
	<li class="active"><a href="#default-tab-1" data-toggle="tab">Form Pembelian Barang</a></li>
    <li><a href="#riwayat-transaksi" data-toggle="tab">Riwayat Transaksi Pembelian</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane fade active in" id="default-tab-1">
        <div class="container-fluid">
        <span class="pull-right fa-stack fa-4x text-muted">
            <i class="fa fa-square-o fa-stack-2x"></i>
            <i class="fa fa-shopping-cart fa-stack-1x"></i>
        </span>
		<h3>Form Transaksi Pembelian Barang/Obat dari suplier</h3>
		<p>
			Menu ini digunakan untuk melakukan transaksi pembelian barang/obat dari suplier.
		</p>
        </div>
<?php 
$this->apotek->message();

//cek jika session cart transaksi tersedia
if (empty($this->session->userdata('cart_transaksi_pembelian'))):

// cek jika terdapat transaksi yg belum dikonfirmasi
$this->data_pembelian->check_transaksi();?>
		<hr/>
			<h5>1.Rincian Transaksi Pembelian:</h5>
			<?php echo form_open('transaksi/pembelian/proses', 'class="form-horizontal" data-parsley-validate="true"');?>
		        <div id="form1">
		        	<div class="form-group">
		                <label class="col-md-3 control-label">No. Faktur <span class="semi-bold text-danger">*</span></label>
		                <div class="col-md-9">
		                    <input name="id_faktur" required="" class="form-control" value="" placeholder="No Faktur Pembelian" type="text">
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="col-md-3 control-label">Tgl. Transaksi <span class="semi-bold text-danger">*</span></label>
		                <div class="col-md-9">
		                    <input name="tgl_pembelian" required="" type="text" id="kalender_pembelian" class="form-control" placeholder="tgl transaksi" value="<?php echo date('d-m-Y');?>" />
		                </div>
		            </div>
		            <div class="form-group">
		                <label class="col-md-3 control-label">Nama Suplier <span class="semi-bold text-danger">*</span></label>
		                <div class="col-md-9">
		                    <select name="suplier" required="" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white">
		                        <option value="" selected>-- Pilih Salah Satu --</option>
		                        <?php 

		                        	$suplier = $this->master_suplier->get();

		                        	if ($suplier->num_rows() > 0) 
		                        	{
		                        		foreach ($suplier->result() as $dt_suplier) 
		                        		{
		                        			echo "<option value='".$dt_suplier->id_suplier."'>".$dt_suplier->suplier."</option>";
		                        		}
		                        	}
		                        ?>
		                    </select>
		                </div>
		            </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Transaksi Pembelian <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="jenis_transaksi" required="" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white">
                                <option value="" selected>-- Pilih Salah Satu --</option>
                                <option value="TUNAI">CASH TUNAI</option>
                                <option value="HUTANG">HUTANG</option>
                            </select>
                        </div>
                    </div>
                    <p class="bold pull-left">Keterangan : <br/>
                    Silahkan cek dengan benar form transaksi ini. agar tidak terjadi kesalahan dalam sistem E-Apotek.<br/>
                    Jika nama suplier tidak ditemukan dalam input box. silahkan login sebagai administrator dan tambahkan data tsb di menu Data Master. <br/>
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
	$transaksi = $this->session->userdata('cart_transaksi_pembelian');
    $suplier   = $this->master_suplier->where($transaksi['id_suplier']);
?>

        <div class="col-md-8">
            <p><span class="semi-bold">2. Keranjang Pembelian Barang.</span><br/>Silahkan masukan daftar item yg akan dibeli dalam keranjang. dan klik konfirmasi untuk menyimpan proses transaksi pembelian.</p>
        </div>
        <div class="pull-right col-md-4">
            <div class="text-right">
                Tgl Transaksi : <?php echo $this->apotek->date($transaksi['tgl_transaksi'],false);?><br/>
                Nama Suplier : <?php echo $suplier->suplier;?><br/>
                Jenis Transaksi ; <?php echo $transaksi['jenis_transaksi'];?>
                <h5 class="semi-bold">No. Faktur : <?php echo $transaksi['no_faktur'];?></h5>
            </div>
        </div>
       	<?php echo form_open('transaksi/pembelian/action-delete');?>
       	<table class="table table-hover table-condensed table-th-valign-middle table-td-valign-middle table-striped table-bordered">
        	<thead>
        		<tr>
        			<th class="text-center" colspan="4">Rincian Barang</th>
        			<th class="text-center" colspan="4">Rincian Pembelian Barang</th>
        			<th rowspan="2" class="text-center">Sub Total</th>
        			<th rowspan="2" class="text-center">Action</th>
        		</tr>
        		<tr>
                    <th class="col-md-2 text-center">Expired Date</th>
                    <th class="col-md-1 text-center">ID BELI</th>
                    <th class="col-md-2 text-center">LOKASI</th>
                    <th class="col-md-4 text-center">NAMA BARANG</th>
                    <th class="col-md-2 text-center">QTY</th>
        			<th class="col-md-1 text-center">Harga POKOK</th>
                    <th class="col-md-1 text-center">Disc</th>
                    <th class="col-md-1 text-center">PPN</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?php
                $no         = 0;
    			$qty 		= 0;
    			$harga 		= 0;
    			$total 		= 0;
                $cart = $this->db->where('no_faktur',$transaksi['no_faktur'])
                                ->order_by('date','DESC')
                                ->get('tb_cart_pembelian');

                if ($cart->num_rows() > 0):

        			foreach ($cart->result() as $cart_barang):
                    $dt_obat = $this->master_barang->where($cart_barang->id_barang);
                    $lokasi  = $this->db->where('id_lokasi',$cart_barang->id_lokasi)
                                        ->get('tb_lokasi_barang');
        		?>
        		<tr>
                    <td>
                        <?php 
                        if ($dt_obat !==  FALSE) 
                        {
                            echo date('d-m-Y',strtotime($cart_barang->expired_date));
                        }
                        else
                        {
                            echo "-";
                        }
                        ?>
                    </td>
        			<td class="small">
        				<?php 
                        if ($dt_obat !==  FALSE) 
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
                        if ($lokasi->num_rows() == 0) 
                        {
                            echo "<span class='text-danger semi-bold'>Rincian tidak ditemukan. data obat telah dihapus.<br/><small>silahkan hapus items ini dari keranjang pembelian.</small></span>";
                        }
                        else
                        {
                            echo $lokasi->row()->nama_lokasi;
                        }
                        ?>
                    </td>
                    <td>
        				<?php 
        				if ($dt_obat !==  FALSE) 
    					{
                            echo '<img class="img pull-left" src="'.base_url('assets/img/obat/'.$dt_obat['foto']).'" height="45px" width="45px"> '. $dt_obat['nama_barang'];
                        }
                        else
                        {
                            echo "<span class='text-danger semi-bold'>Rincian tidak ditemukan. data obat telah dihapus.<br/><small>silahkan hapus items ini dari keranjang pembelian.</small></span>";
    					}
        				?>
                    </td>
        			<td>
        				<?php 
        				if ($dt_obat !==  FALSE) 
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
        				if ($dt_obat !==  FALSE) 
    					{
        					echo $this->apotek->rupiah($cart_barang->harga_pokok);
        				}
        				else
        				{
        					echo "-";
        				}
        				?>
        			</td>
                    <td>
                        <?php 
                        if ($dt_obat !==  FALSE) 
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
                        if ($dt_obat !==  FALSE) 
                        {
                            echo $cart_barang->ppn.'%';
                        }
                        else
                        {
                            echo "-";
                        }
                        ?>
                    </td>
        			<td>
        				<?php 
        				if ($dt_obat !==  FALSE) 
    					{
        					echo $this->apotek->rupiah($cart_barang->total_harga);
        				}
        				else
        				{
        					echo "-";
        				}
        				?>
        			</td>
        			<td class="text-center">
        				<input type="checkbox" name="id_beli[]" value="<?php echo $cart_barang->id_beli;?>">
        			</td>

        		</tr>
        	<?php
        			$harga 	+= $cart_barang->harga_pokok;
        			$qty 	+= $cart_barang->qty;
        			$total 	+= $cart_barang->total_harga;
                    $no++;
        			endforeach;
        		else:
        	?>
        		<tr>
        			<td colspan="10">Belum ada barang yang di tambahkan ke keranjang pembelian</td>
        		</tr>
        	<?php
        		endif;
        	?>
        	</tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="8"><h4>Grand Total</h4></th>
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
                    Tandai barang yang akan anda terima dari suplier sesuai dengan <strong>ID BELI</strong> untuk barang tersebut dan simpan sesuai lokasi barang tsb.<br/>
			        Jika nama barang tidak ditemukan dalam input box. silahkan login sebagai administrator dan tambahkan data tsb di menu Data Master. <br/>
			        <strong><span class="text-danger">*) Wajib di isi.</span></strong>
        		</p>
        	</div>
        </div>
        <?php echo form_close();?>
        <hr/>
       	<p class="text-right m-b-0">
			<a href="<?php $this->apotek->url('transaksi/pembelian/reset');?>" class="btn btn-white m-r-5">Reset Pembelian</a>
       		<?php
	    		if ($cart->num_rows() > 0)
	    		{
	    			if ($dt_obat !==  FALSE) 
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
                        <h4 class="panel-title">Konfirmasi Pembelian anda</h4>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('transaksi/pembelian/save','class="form-horizontal"  data-parsley-validate="true"');?>
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
                        <?php if ($transaksi['jenis_transaksi'] === 'TUNAI'):?>
                        <div class="col-md-12 form-group">
                            <label class="col-md-3 control-label">Dibayar  <span class="semi-bold text-danger">*</span></label>
                            <div class="col-md-9">
                                <input required="" name="dibayar" type="number" class="form-control" placeholder="Dibayar" value=""/>
                            </div>
                        </div>
                        <?php endif;?>
                        <?php if ($transaksi['jenis_transaksi'] === 'HUTANG'):?>
                        <div class="col-md-12 form-group">
                            <label class="col-md-3 control-label">Tgl Jatuh Tempo  <span class="semi-bold text-danger">*</span></label>
                            <div class="col-md-9">
                                <input required="" name="hutang" type="text" id="kalender_pembelian" class="form-control" placeholder="Tgl Pembayaran Hutang" value=""/>
                            </div>
                        </div>
                        <?php endif;?>

                        Apakah anda yakin ingin menyimpan daftar item pembelian ini?<br/>
                        dengan mengklik simpan akan memperbaharui stok barang yang ada dalam sistem ini.</p>
                        <hr/>
                        <div class="pull-right">
                            <button type="submit" onclick="window.open('<?php $this->apotek->url('transaksi/pembelian/print/'.$transaksi['no_faktur']);?>', '_blank', 'width=800,height=600,scrollbars=no,menubar=no,status=no,resizable=no,screenx=0,screeny=0'); return true;" class="btn btn-danger btn-sm">Simpan</button>
                        </div>
                        <?php echo form_close();?>
                    </div>
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
                        <h4 class="panel-title">Tambah Barang ke keranjang Pembelian</h4>
                    </div>
                    <div class="panel-body">
                    <?php echo form_open('transaksi/pembelian/proses-obat','class="form-horizontal"  data-parsley-validate="true"');?>
                        <div id="form2">
                            <div class="col-md-12 form-group">
                                <label class="col-md-3 control-label">ID BELI <span class="semi-bold text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input required="" readonly="" name="id_beli" type="text" class="form-control" placeholder="ID Pembelian" value="<?php echo $this->apotek->id_table('B-00','id_beli','tb_cart_pembelian');?>"/>
                                </div>
                            </div>
				            <div class="col-md-12 form-group">
				                <label class="col-md-3 control-label">Nama Barang <span class="semi-bold text-danger">*</span></label>
				                <div class="col-md-9">
				                    <select required="" name="nama_obat" class="form-control selectpicker" data-live-search="true" data-style="btn-white">
				                        <option value="" selected>Silahkan pilih nama obat</option>
				                        <?php 

				                        	$obat = $this->db->get('tb_data_obat');

				                        	if ($obat->num_rows() > 0) 
				                        	{
				                        		foreach ($obat->result() as $dt_obat) 
				                        		{
				                        			echo "<option value='".$dt_obat->id_obat."'>".$dt_obat->nama_obat."</option>";
				                        		}
				                        	}
				                        ?>
				                    </select>
				                </div>
				            </div>

				            <div class="col-md-12 form-group">
				                <label class="col-md-3 control-label">Harga Beli <span class="semi-bold text-danger">*</span></label>
				                <div class="col-md-9">
				                    <input required="" name="harga" type="number" class="form-control" placeholder="Harga Pembelian" value=""/>
				                </div>
				            </div>
				            
                            <div class="col-md-12 form-group">
				                <label class="col-md-3 control-label">QTY <span class="semi-bold text-danger">*</span></label>
				                <div class="col-md-9">
				                    <input name="qty" required="" type="number" class="form-control" placeholder="jumlah Satuan Pembelian" value=""/>
				                </div>
				            </div>
				            
                            <div class="col-md-12 form-group">
				                <label class="col-md-3 control-label">Expired Date <span class="semi-bold text-danger">*</span></label>
				                <div class="col-md-9">
				                    <input name="expired_date" required="" type="text" id="kalender_expired" class="form-control" placeholder="Tgl Kadaluarsa" value=""/>
				                </div>
				            </div>
                            <div class="col-md-12 form-group">
                                <label class="col-md-3 control-label">Lokasi Barang <span class="semi-bold text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select required="" name="lokasi" class="form-control selectpicker" data-live-search="true" data-style="btn-white">
                                        <option value="" selected>Tempat penyimpanan barang</option>
                                        <?php 

                                            $lokasi = $this->db->order_by('nama_lokasi','ASC')->get('tb_lokasi_barang');

                                            if ($lokasi->num_rows() > 0) 
                                            {
                                                foreach ($lokasi->result() as $lokasi_barang) 
                                                {
                                                    echo "<option value='".$lokasi_barang->id_lokasi."'>".$lokasi_barang->nama_lokasi."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="col-md-3 control-label">Discount</label>
                                <div class="col-md-9">
                                    <input name="discount" type="number" class="form-control" placeholder="Discount Pembelian" value=""/>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="col-md-3 control-label">PPN </label>
                                <div class="col-md-9">
                                    <input name="ppn" type="number" class="form-control" placeholder="Pajak" value=""/>
                                </div>
                            </div>
				            
                            <div class="col-md-12 form-group">
                                <div class="col-md-10">
                                    <p class="small">
                                        Keterangan :<br/> 
                                        - masukan discount pembelian jika terdapat discount pembelian untuk barang tsb.<br/>
                                        - masukan PPN jika pembelian terdapat pajak pembelian.
                                    </p>
                                </div>
                                <div class="col-md-2">
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
    <h4>Riwayat Transaksi Pembelian</h4>
        <?php
            $no             = 1;
            $qty            = 0;
            $harga_pokok    = 0;
            $sub_total      = 0; 
            $barang         = $this->db->where('payment','TRUE')->group_by('no_faktur')->order_by('date','desc')->get('tb_cart_pembelian');
        ?>

        <?php echo $this->session->userdata('message');?>
                <table id="data-table" class="table table-hover table-condensed table-th-valign-middle table-td-valign-middle table-bordered">
                    <thead class="small">
                        <tr>
                            <th class="col-md-1 text-center">No</th>
                            <th>Tgl Transaksi</th>
                            <th class="text-center">No. Faktur</th>
                            <th class="text-center">Suplier</th>
                            <th class="text-center">Jenis Transaksi</th>
                            <th class="text-center">Operator</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                    <?php if ($barang->num_rows () > 0):?>
                        <?php foreach ($barang->result() as $group):?>
                            <?php
                            $suplier  = $this->master_suplier->where($group->id_suplier);
                            $user     = $this->master_user->where($group->id_user);
                            if ($suplier !== FALSE) 
                            {
                                if($group->jenis_transaksi === 'HUTANG')
                            {
                                $label = '<span class="label label-danger">HUTANG</span>';
                            }
                            elseif ($group->jenis_transaksi === 'TUNAI') 
                            {
                                $label = '<span class="label label-inverse">TUNAI</span>';
                            }
                            else
                            {
                                 $label = '<span class="label label-warning">KONSINYASI</span>';
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

                            $link_print = anchor_popup('transaksi/pembelian/print/'.$group->no_faktur, '<i class="fa fa-print"></i> Print Struk', $atts);
                            ?>
                                <tr>
                                    <td><?=$no++;?></td>
                                    <td><?= date('d-m-Y',strtotime($group->tgl_transaksi));?></td>
                                    <td>
                                        <?=$group->no_faktur;?>
                                    </td>
                                    <td><?=$suplier->suplier;?></td>
                                    <td class="text-center"><?=$label;?></td>
                                    <td class="text-center"><?=$user['nama_lengkap'];?></td>
                                    <td class="text-center"><?=$link_print;?></td>
                                </tr>
                                <?php 
                                    $qty = 0;
                                    $harga_pokok = 0;
                                    $sub_total = 0;
                            }
                            
                         endforeach;?>
                    <?php else:?>
                        <tr>
                            <td colspan="7">Belum ada transaksi pembelian</td>
                        </tr>
                    <?php endif;?>
                    </tbody>
                </table>

    </div>
</div>