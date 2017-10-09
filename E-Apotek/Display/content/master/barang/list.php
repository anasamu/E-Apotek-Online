<div style="" data-init="true" class="panel panel-inverse" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <h4 class="panel-title">Master Barang/Obat</h4>
    </div>
    <div class="panel-body">
		<?php echo $this->apotek->message();?>
		<div class="panel-group" id="accordion">
			<div class="panel overflow-hidden">
				<div class="panel-heading">
					<h3 class="panel-title">
						<a class="accordion-toggle accordion-toggle-styled collapsed btn" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
						    <i class="fa fa-plus-circle pull-right"></i> 
							<h4>Form Tambah Data Master Barang</h4>
						</a>
					</h3>
				</div>
				<div id="collapseOne" class="panel-collapse collapse">
					<?php echo form_open_multipart('master/barang/tambah', 'data-parsley-validate="true" class="form-horizontal"');?>
					<div class="col-md-6">
						<div class="panel-body">
							<h4>DATA BARANG</h4><hr/>
			                <div class="form-group">
			                    <label class="col-md-3 control-label">ID Barang<span class="semi-bold text-danger">*</span></label>
			                    <div class="col-md-9">
			                        <input name="id_obat" required="" class="form-control" value="<?php echo $this->apotek->id_table('MB-0','id_obat','tb_data_obat');?>" placeholder="Id obat" readonly="readonly" type="text">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <label class="col-md-3 control-label">Nama Barang<span class="semi-bold text-danger">*</span></label>
			                    <div class="col-md-9">
			                        <input name="nama_obat" required="" class="form-control" placeholder="Masukan nama barang" type="text">
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-3 control-label">Gambar Produk</label>
			                    <div class="col-md-9">
			                        <input type="file" name="gambar_obat">
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-3 control-label">Jenis Barang<span class="semi-bold text-danger">*</span></label>
			                    <div class="col-md-9">
			                    	<select name="jenis_obat" required="" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white">
			                            <option value="">-- Silahkan Pilih Jenis Barang --</option>
			                        <?php
			                        	$jenis = $this->db->get('tb_jenis_obat');

			                        if ($jenis->num_rows() > 0):

			                        foreach ($jenis->result() as $items):?>
			                                <option value="<?php echo $items->id_jenis_obat;?>"><?=$items->nama_jenis_obat;?></option>
			                    	<?php 
			                    	endforeach;
			                    	endif;?>
			                    	</select>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-3 control-label">Satuan Barang<span class="semi-bold text-danger">*</span></label>
			                    <div class="col-md-9">
			                        <select name="satuan_obat" required="" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white">
			                            <option value="">-- Silahkan Pilih Satuan Barang --</option>
			                        <?php
			                        	$kategori = $this->db->get('tb_satuan_obat');

			                        if ($kategori->num_rows() > 0):

			                        foreach ($kategori->result() as $items):?>
			                            <option value="<?php echo $items->id_satuan;?>"><?php echo $items->nama_satuan_obat;?></option>
			                        <?php 
			                    	endforeach;
			                    	endif;?>
			                        </select>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-3 control-label">Kategori<span class="semi-bold text-danger">*</span></label>
			                    <div class="col-md-9">
			                        <select required="" name="kategori_obat" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white" >
			                            <option value="">-- Silahkan Pilih Kategori Barang --</option>
			                        <?php
			                        	$kategori = $this->db->get('tb_kategori_obat');

			                        if ($kategori->num_rows() > 0):

			                        foreach ($kategori->result() as $items):?>
			                            <option value="<?php echo $items->id_kategori;?>"><?php echo $items->nama_kategori;?></option>
			                        <?php 
			                    	endforeach;
			                    	endif;?>
			                        </select>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label class="col-md-3 control-label">Keterangan</label>
			                    <div class="col-md-9">
			                    	<textarea name="keterangan_obat" placeholder="Masukan Keterangan obat untuk memudahkan pencarian data obat" class="form-control" rows="8"></textarea>
			                    </div>
			                </div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel-body">
							<h4>IMPORT BARANG</h4><hr/>
							<p>Menu import digunakan untuk memasukan data barang yang belum tersimpan kedalam sistem E-Apotek.</p>
							<div class="form-group">
			                    <label class="col-md-3 control-label">Tgl Pembelian</label>
			                    <div class="col-md-9">
			                        <input type="text" name="tgl_pembelian" class="form-control" id="kalender_pembelian" placeholder="Tgl Pembelian">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <label class="col-md-3 control-label">STOK Barang</label>
			                    <div class="col-md-9">
			                        <input name="stok_barang" class="form-control" placeholder="Jumlah STOK barang" type="number">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <label class="col-md-3 control-label">Harga Beli</label>
			                    <div class="col-md-9">
			                        <input name="harga_beli" class="form-control" placeholder="Harga Pembelian" type="number">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <label class="col-md-3 control-label">Tgl Expired</label>
			                    <div class="col-md-9">
			                        <input name="expired_date" class="form-control" id="kalender_expired" placeholder="Tgl Expired barang" type="text">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <label class="col-md-3 control-label">Lokasi Penyimpanan</label>
			                    <div class="col-md-9">
			                        <select name="lokasi_penyimpanan" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white" >
			                            <option value="">-- Silahkan Pilih Lokasi Penyimpanan Barang --</option>
			                        <?php 
            						$dtlokasi = $this->db->order_by('nama_lokasi','ASC')->get('tb_lokasi_barang');
            						if ($dtlokasi->num_rows() > 0):
            							foreach ($dtlokasi->result() as $lokasi):?>
			                            <option value="<?php echo $lokasi->id_lokasi;?>"><?php echo $lokasi->nama_lokasi;?></option>
			                        <?php 
			                    	endforeach;
			                    	endif;?>
			                        </select>
			                    </div>
			                </div>
						</div>
					</div>
					<div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-success pull-right">Tambah Data</button>
                    </div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>

		<hr/>
		<h5>Menampilkan Daftar Master Barang/obat</h5>
    	<p>Sebelum melakukan transaksi Barang/obat yang baru. silahkan input data Barang/obat terlebih dahulu.</p>
    	<table class="table table-responsive table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th class="row row-space-0">ID BARANG</th>
					<th colspan="2" class="text-center">Gambar Produk/ Nama Barang</th>
					<th>Satuan Barang</th>
					<th>Jenis</th>
					<th>Kategori</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$dt_obat = $this->db->order_by('date','DESC')->get('tb_data_obat');
				?>

				<?php if ($dt_obat->num_rows() > 0):?>
				<?php foreach ($dt_obat->result() as $items):?>
				<tr>
					<td><?php echo $items->id_obat;?></td>
					<td align="center">
						<img height="50px" width="50px" src="<?php echo base_url('assets/img/obat/'.$items->foto);?>">
					</td>
					<td><?php echo $items->nama_obat;?></td>
					<?php
						$satuan = $this->db->where('id_satuan',$items->id_satuan)
												->get('tb_satuan_obat');
						if ($satuan->num_rows() > 0) 
						{
							echo "<td>".$satuan->row()->nama_satuan_obat."</td>";
						}
						else
						{
							echo "<td>-</td>";
						}

						$Jenis = $this->db->where('id_jenis_obat',$items->id_jenis)
												->get('tb_jenis_obat');
						if ($Jenis->num_rows() > 0) 
						{
							echo "<td> 
										<div class='navbar-user'>
											<img src='".base_url('assets/img/product/'.$Jenis->row()->icon)."' height='50px' class='img img-circle'/>"
											.$Jenis->row()->nama_jenis_obat.
										"</div>
								</td>";
						}
						else
						{
							echo "<td>-</td>";
						}

						$Kategori = $this->db->where('id_kategori',$items->id_kategori)
											->get('tb_kategori_obat');
						
						if ($Kategori->num_rows() > 0) 
						{
							echo "<td>".$Kategori->row()->nama_kategori."</td>";
						}
						else
						{
							echo "<td>-</td>";
						}
					?>
					
					<td>
						<div class="btn-group">
		                    <a href="#" data-toggle="dropdown" class="btn btn-block btn-xs btn-success dropdown-toggle"><strong>Action <span class="caret"></span></strong></a>
		                    <ul class="dropdown-menu">
		                        <li><a href="<?php echo base_url('master/barang/views/'.$items->id_obat);?>">Views</a></li>
		                        <li><a href="#edit-<?php echo $items->id_obat;?>" data-toggle="modal">Edit</a></li>
		                        <li class="divider"></li>
		                        <li><a href="#hapus-<?php echo $items->id_obat;?>" data-toggle="modal">Hapus</a></li>
		                    </ul>
		                </div>
					</td>
				</tr>
				<?php endforeach;?>
				<?php else:?>
				<tr>
					<td colspan="7">Data Obat Masih Kosong</td>
				</tr>
				<?php endif;?>
			</tbody>
		</table>
    </div>
</div>
<?php 
if ($dt_obat->num_rows() > 0):
foreach ($dt_obat->result() as $obat):?>
<div class="modal" id="hapus-<?php echo $obat->id_obat;?>">
    <div class="modal-dialog">
        <?php echo form_open('master/barang/delete', 'class="form-horizontal"');?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Delete Obat</h4>
            </div>
            <div class="modal-body">
            <input type="hidden" name="id_obat" value="<?php echo $obat->id_obat;?>">
            <p>Apakah anda yakin ingin menghapus data obat dengan ID : <strong><?php echo $obat->id_obat;?></strong> ?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>

<div class="modal" id="edit-<?php echo $obat->id_obat;?>">
    <div class="modal-dialog">
        <?php echo form_open_multipart('master/barang/edit', 'class="form-horizontal"');?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Edit Obat</h4>
            </div>
            <div class="modal-body" data-scrollbar="true" data-height="350px">
	            
	            	<div class="form-group">
	                    <label class="col-md-3 control-label">ID OBAT *</label>
	                    <div class="col-md-9">
	                        <input name="id_obat" class="form-control" value="<?php echo $obat->id_obat;?>" placeholder="Id obat" readonly="readonly" type="text">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-3 control-label">Nama Obat *</label>
	                    <div class="col-md-9">
	                        <input name="nama_obat" value="<?php echo $obat->nama_obat;?>" class="form-control" placeholder="Masukan nama obat" type="text">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">Gambar Obat</label>
	                    <div class="col-md-9">
	                        <input type="file" name="gambar_obat">
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">Jenis Obat *</label>
	                    <div class="col-md-9">
	                        <?php
	                        	$jenis = $this->db->get('tb_jenis_obat');

	                        if ($jenis->num_rows() > 0):

	                        foreach ($jenis->result() as $jenis):?>
	                        
	                        <div class="radio">
	                            <label>
	                            	<?php if ($obat->id_jenis == $jenis->id_jenis_obat):?>
	                                <input name="jenis_obat" checked="" value="<?php echo $jenis->id_jenis_obat;?>" type="radio">
	                                <?php echo $jenis->nama_jenis_obat;?>
	                            	<?php else:?>
	                            	<input name="jenis_obat" value="<?php echo $jenis->id_jenis_obat;?>" type="radio">
	                                <?php echo $jenis->nama_jenis_obat;?>
	                            	<?php endif;?>
	                            </label>
	                        </div>

	                    	<?php 
	                    	endforeach;
	                    	endif;?>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">Satuan Obat *</label>
	                    <div class="col-md-9">
	                        <select name="satuan_obat" class="form-control">
	                        <?php
	                        	$satuan_obat = $this->db->where('id_satuan',$obat->id_satuan)
	                        							->get('tb_satuan_obat');?>
	                        <option value="<?php echo $satuan_obat->row()->id_satuan;?>"><?php echo $satuan_obat->row()->nama_satuan_obat;?></option>
	                        <?php	

	                        $satuan = $this->db->get('tb_satuan_obat');
	                        if ($satuan->num_rows() > 0):
		                        foreach ($satuan->result() as $satuan):
		                        	
		                        	if ($obat->id_satuan == $satuan->id_satuan)
		                        	{
		                        		continue;
		                        	}
		                        	?>
		                        	<option value="<?php echo $satuan->id_satuan;?>"><?php echo $satuan->nama_satuan_obat;?></option>
		                        <?php
		                    	endforeach;
	                    	endif;?>
	                        </select>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">Kategori Obat *</label>
	                    <div class="col-md-9">
	                        <select name="kategori_obat" class="form-control">
	                        <?php
	                        	$kategori = $this->db->where('id_kategori',$obat->id_kategori)
	                        							->get('tb_kategori_obat');?>
	                        <option value="<?php echo $kategori->row()->id_kategori;?>"><?php echo $kategori->row()->nama_kategori;?></option>
	                        <?php	

	                        $kategori = $this->db->get('tb_kategori_obat');
	                        if ($kategori->num_rows() > 0):
		                        foreach ($kategori->result() as $kategori):
		                        	
		                        	if ($obat->id_kategori == $kategori->id_kategori)
		                        	{
		                        		continue;
		                        	}
		                        	?>
		                        	<option value="<?php echo $kategori->id_kategori;?>"><?php echo $kategori->nama_kategori;?></option>
		                        <?php
		                    	endforeach;
	                    	endif;?>
	                        </select>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">Keterangan Obat</label>
	                    <div class="col-md-9">
	                    	<textarea name="keterangan_obat" placeholder="Masukan Keterangan obat untuk memudahkan pencarian data obat" class="form-control" rows="8"><?php echo $obat->keterangan;?></textarea>
	                    </div>
	                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-sm btn-success">Update</button>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>
<?php 
endforeach;
endif;
?>