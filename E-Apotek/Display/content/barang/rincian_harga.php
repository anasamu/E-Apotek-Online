<?php
    $no         = 1;
	$total_stok = 0;
	$hpp 		= 0;
	$hju 		= 0;
	$hjd 		= 0;
	$hjr 		= 0;
	$barang 	= $this->data_harga_barang->get();
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Rincian Harga Barang</h4>
    </div>
    <div class="panel-body">
        <h5>Menu ini untuk menampilkan Rincian Harga penjualan barang untuk apotek.</h5>
        <p>Daftar barang yang ditampilkan hasil dari pembelian dari suplier.</p>
        <?php $this->apotek->message();?>
        <table id="data-table" class="table table-hover table-condensed table-th-valign-middle table-td-valign-middle  table-striped table-bordered">
        	<thead class="small">
        		<tr>
					<th colspan="4" class="text-center"><h5>Rincian Items Pembelian</h5></th>
					<th colspan="3" class="text-center"><h5>Rincian Items Penjualan</h5></th>
					<th rowspan="3" class="col-md-1 text-center"><h5>Action</h5></th>
				</tr>
				<tr>
					<th class="text-center">No</th>
					<th class="col-md-3">Nama Barang</th>
					<th class="text-center">STOK</th>
					<th class="text-center">HPP</th>
					<th class="text-center success">
                        (Harga Jual Umum)
                    </th>
					<th class="text-center warning">
                        (Harga Jual Dokter)
                    </th>
					<th class="text-center danger">
                        (Harga Jual Resep)
                    </th>
				</tr>
        	</thead>
        	<tbody>
        		<?php if ($barang !== FALSE):?>
        		<?php foreach ($barang as $items):?>
        		<?php
        		$dtbarang       = $this->master_barang->where($items->id_barang);
        		$stok 	        = $this->data_stok->where($items->id_barang);
                $keuntungan_hju = $items->hju - $items->hpp; 
                $persen_hju     = ceil((($keuntungan_hju / $items->hpp) * 100));
                $keuntungan_hjd = $items->hjd - $items->hpp; 
                $persen_hjd     = ceil((($keuntungan_hjd / $items->hpp) * 100));
        		$keuntungan_hjr = $items->hjr - $items->hpp; 
                $persen_hjr     = ceil((($keuntungan_hjr / $items->hpp) * 100));
        		?>
        		<tr>
        			<td><?php echo $no++;?></td>
        			<td>
                        <img class="pull-left" height="45px" width="45px" src="<?=$this->apotek->url('assets/img/obat/'.$dtbarang['foto']);?>"> 
                            <?php echo $dtbarang['nama_barang'];?>
                            <?php echo $this->apotek->get_label($items->id_barang);?>
                    </td>
        			<td class="text-center">
                        <?php echo $stok['sisa_stok'];?> / <?php echo $dtbarang['satuan'];?>
                    </td>
        			<td>
                        <?php echo $this->apotek->rupiah($items->hpp);?>
                    </td>
        			<td class="success semi-bold">
                        <?= $this->apotek->rupiah($items->hju);?>
                        <small>(<?=$persen_hju;?>%)</small>
                    </td>
        			<td class="warning semi-bold">
                        <?=$this->apotek->rupiah($items->hjd);?>
                        <small>(<?=$persen_hjd;?>%)</small>
                    </td>
        			<td class="danger semi-bold">
                        <?=$this->apotek->rupiah($items->hjr);?>
                        <small>(<?=$persen_hjr;?>%)</small>
                    </td>
        			<td>
                        <a href="#update-<?php echo $items->id_barang;?>" class="btn btn-success btn-sm" data-toggle="modal">Update</a>
                    </td>
        		</tr>
        		<?php endforeach;?>
                <?php else:?>
                <tr>
                    <td colspan="8">daftar barang masih kosong</td>
                </tr>
        		<?php endif;?>
        	</tbody>
        </table>
        <p class="text-left">
            <a href="#update-laba-penjualan" class="btn btn-success pull-right" data-toggle="modal">Laba Penjualan >></a>
            Perhatian :<br/>
            Nilai HPP (Harga Pokok Penjualan) digunakan untuk menentukan harga penjualan barang tsb.<br/>
            Harga Penjualan didapat dari Laba Penjualan
        </p>
    </div>
</div>



<div class="modal fade" id="update-laba-penjualan">
    <div class="modal-dialog">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Update Laba Penjualan</h4>
            </div>
            <div class="panel-body">
            <?php echo form_open('pengaturan/update/laba-penjualan','class="form-horizontal"  data-parsley-validate="true"');?>
                <div id="form2">
                    <div class="col-md-12 form-group">
                        <label class="col-md-6">Harga Jual Umum (HJU%) <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-6">
                            <input value="" required="" name="hju" type="number" class="form-control" placeholder="Persen Keuntungan HJU%"/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-6">Harga Jual Dokter (HJD%) <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-6">
                            <input value="" required="" name="hjd" type="number" class="form-control" placeholder="Persen Keuntungan HJD%"/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-6">Harga Jual Resep (HJR%) <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-6">
                            <input value="" required="" name="hjr" type="number" class="form-control" placeholder="Persen Keuntungan HJR%"/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input value="TRUE" name="update_harga" type="checkbox">
                                    Perbaharui Semua Harga Penjualan barang yang ada saat ini?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="small">
                            Perhatian : <br/>
                            Silahkan centang jika ingin memperbaharui semua harga penjualan dengan laba keuntungan baru.<br/>
                            Silahkan isi items tersebut berdasarkan nilai persen keuntungan.
                        </p>
                        <button type="submit" class="btn btn-success pull-right">Update</button>
                    </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<?php if ($barang !== FALSE):?>
<?php foreach ($barang as $items):?>
<?php $dtbarang  = $this->master_barang->where($items->id_barang);?>
<div class="modal fade" id="update-<?php echo $items->id_barang;?>">
    <div class="modal-dialog">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Ubah Harga Penjualan : <?php echo $dtbarang['nama_barang'];?></h4>
            </div>
            <div class="panel-body">
            <?php echo form_open('barang/rincian-harga/update','class="form-horizontal"  data-parsley-validate="true"');?>
                <div id="form2">
                    <div class="col-md-12 form-group">
                        <label class="col-md-4">ID Barang <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-8">
                            <input readonly="" value="<?=$items->id_barang;?>" required="" name="id_barang" type="text" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-4">Nama Barang <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-8">
                            <input value="<?=$dtbarang['nama_barang'];?>" readonly="" required="" name="nama_barang" type="text" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-4">HPP <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="hidden" name="hpp" value="<?=$items->hpp;?>">
                            <input value="<?=$this->apotek->rupiah($items->hpp);?>" readonly="" required="" name="nilai_hpp" type="text" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-4">Harga Jual Umum (HJU) <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-4">
                            <input value="<?=$items->hju;?>" required="" name="hju" type="number" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-4">Harga Jual Dokter (HJD) <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-4">
                            <input value="<?=$items->hjd;?>" required="" name="hjd" type="number" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label class="col-md-4">Harga Jual Resep (HJR) <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-4">
                            <input value="<?=$items->hjr;?>" required="" name="hjr" type="number" class="form-control" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-block">Update Harga Penjualan</button>
                        <p class="small">
                            Perhatian : Harap harga jual lebih dari Harga pokok penjualan (HPP)
                        </p>
                    </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php endif;?>