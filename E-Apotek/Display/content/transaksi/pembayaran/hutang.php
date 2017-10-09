<div data-init="true" class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Daftar Transaksi Hutang</h4>
    </div>
    <div class="panel-body">
        <?=$this->apotek->message();?>
        <h5>Menu ini digunakan untuk menampilkan daftar pembelian dengan jenis transaksi HUTANG.</h5>
        <table id="data-table" class="table table-bordered table-striped table-hover table-condensed table-responsive table-th-valign-middle">
        	<thead>
        		<tr>
        			<th rowspan="2" class="text-center">No</th>
        			<th rowspan="2" class="text-center">Tgl Transaksi</th>
        			<th colspan="3"><h5>Rincian Pembelian</h5></th>
        			<th colspan="4"><h5>Rincian Hutang</h5></th>
        			<th rowspan="2">Actions</th>
        		</tr>
        		<tr>
        			<th class="col-md-2">No. Faktur</th>
        			<th>Suplier</th>
        			<th>Total Pembelian</th>

        			<th>Dibayar</th>
        			<th>Sisa Bayar</th>
        			<th>Status</th>
        			<th>Tgl Jatuh Tempo</th>
        		</tr>
        	</thead>
        	<tbody class="small">
        	<?php
        			$no     	= 1; 
        			$dthutang 	= $this->data_hutang->get(); 
			?>
        	<?php if ($dthutang !== FALSE):?>
        	<?php foreach ($dthutang as $items):?>
        	<?php
        	$data_hutang 	= $this->db->where('no_faktur',$items->no_faktur)->get('tb_data_hutang');
			$hutang 		= $data_hutang->row();
			$sisa_bayar 	= $hutang->total_bayar - $hutang->dibayar;
			$suplier 	 	= $this->master_suplier->where($items->id_suplier);
			?>
        		<tr>
        			<td><?=$no++;?></td>
        			<td><?=date('d-m-Y', strtotime($items->tgl_transaksi));?></td>
        			<td><?=$items->no_faktur;?></td>
        			<td><?=$suplier->suplier;?></td>
        			<td><?=$this->apotek->rupiah($hutang->total_bayar);?></td>
        			<td><?=$this->apotek->rupiah($hutang->dibayar);?></td>
        			<td><?=$this->apotek->rupiah($sisa_bayar);?></td>
        			<td><?=$hutang->status;?></td>
        			<td><?=date('d-m-Y', strtotime($hutang->jatuh_tempo));?></td>
        			<td><a href="#bayar-<?=$items->no_faktur;?>" class="btn btn-success btn-sm" data-toggle="modal">Bayar</a></td>
        		</tr>
        	<?php endforeach;?>
        	<?php else:?>
        		<tr>
        			<td colspan="11">Data hutang tidak ditemukan</td>
        		</tr>
        	<?php endif;?>
        	</tbody>
        </table>
    </div>
</div>

<?php if ($dthutang !== FALSE):?>
<?php foreach ($dthutang as $items):?>
<?php
$data_hutang 	= $this->db->where('no_faktur',$items->no_faktur)->get('tb_data_hutang');
$hutang 		= $data_hutang->row();
$sisa_bayar 	= $hutang->total_bayar - $hutang->dibayar;
$suplier 	 	= $this->master_suplier->where($items->id_suplier);
?>
<div class="modal" id="bayar-<?=$items->no_faktur;?>">
	<div class="modal-dialog">
		<div data-init="true" class="panel panel-danger" data-sortable-id="ui-widget-13">
		    <div class="panel-heading">
		        <div class="panel-heading-btn">
		            <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></a>
		        </div>
		        <h4 class="panel-title">Form Pembayaran Hutang</h4>
		    </div>
		    <div class="panel-body">
		        <?php echo form_open('transaksi/pembayaran/hutang/proses','class="form-horizontal"  data-parsley-validate="true"');?>
                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">No. Faktur <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                        	<input type="hidden" name="total" value="<?=$hutang->total_bayar;?>">
                        	<input type="hidden" name="sisa" value="<?=$sisa_bayar;?>">
                        	<input type="hidden" name="status" value="<?=$hutang->status;?>">
                            <input required="" readonly="" name="no_faktur" type="text" class="form-control" placeholder="total_items" value="<?=$items->no_faktur;?>"/>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Suplier <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" readonly="" name="suplier" type="text" class="form-control" value="<?=$suplier->suplier;?>"/>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Total Pembelian <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" disabled="" name="" type="text" class="form-control" value="<?=$this->apotek->rupiah($hutang->total_bayar);?>"/>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Sisa Bayar <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" disabled="" name="" type="text" class="form-control" value="<?=$this->apotek->rupiah($sisa_bayar);?>"/>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Status <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" disabled="" name="" type="text" class="form-control" value="<?=$hutang->status;?>"/>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Dibayar <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input required="" name="dibayar" type="number" class="form-control" placeholder="Jumlah Uang pembayaran"/>
                        </div>
                    </div>

                    <div class="pull-right">
                        <button type="submit" class="btn btn-danger btn-sm">Bayar</button>
                    </div>
                <?php echo form_close();?>
		    </div>
		</div>
	</div>
</div>
<?php endforeach;?>
<?php endif;?>