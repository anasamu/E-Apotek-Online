
<div class="col-md-12">
	<?php echo $this->session->flashdata('message');?>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#lokasi" data-toggle="tab">Lokasi Barang</a></li>
		<li class=""><a href="#default-tab-1" data-toggle="tab">Jenis Obat</a></li>
		<li class=""><a href="#default-tab-2" data-toggle="tab">Kategori Obat</a></li>
		<li class=""><a href="#default-tab-3" data-toggle="tab">Satuan Obat</a></li>
	</ul>
	<div class="tab-content">

<!#-- Data Lokasi Obat ->
		
	<div class="tab-pane fade active in" id="lokasi">
		<h4>
			Dibawah ini merupakan daftar nama lokasi penyimpanan barang.
		</h4>
		<p>
		Lokasi barang digunakan untuk memudahkan pencarian barang saat barang tersebut dibutuhkan. menu ini biasanya digunakan untuk petugas gudang untuk menyortir barang.<br/>
		Harap tandai lokasi penyimpanan tersebut berdasarkan ID LOKASI atau nama lokasi.
		</p>
		<div id="jstree-default">
            <ul>
            	<?php 
            		$dtlokasi = $this->db->order_by('nama_lokasi','ASC')->get('tb_lokasi_barang');

            		if ($dtlokasi->num_rows() > 0):
            		foreach ($dtlokasi->result() as $lokasi):

            		$isi = $this->db->where('id_lokasi',$lokasi->id_lokasi)
            						->get('tb_cart_pembelian');
            		if ($isi->num_rows() > 0):
            		$total_items = count($isi->result());
            	?>
                    <li>
                        <?= $lokasi->id_lokasi.' ('.$lokasi->nama_lokasi.') - '.$total_items.' items';?>
                        <ul>  
                        	<li data-jstree='{ "icon" : "fa fa-pencil fa-lg text-success" }'><a href="#edit-lokasi-<?=$lokasi->id_lokasi;?>"  data-toggle="modal"> Ubah Nama Lokasi</a></li>
                        	<?php foreach ($isi->result() as $items):?>
                        	<?php $barang = $this->master_barang->where($items->id_barang);?>
                            <li data-jstree='{"opened":false}' >
                                <?= $items->id_beli;?>
                                <ul>
                                    <li data-jstree='{"disabled":true, "icon" : "fa fa-circle-o text-primary"}' > <?= $barang['nama_barang'];?> (<?=$items->qty;?> <?=$barang['satuan'];?>)</li>
                                </ul>
                            </li>
                        	<?php endforeach;?>
						</ul>
                    </li>
                	<?php else:?>
                	<li> <?= $lokasi->id_lokasi.' ('.$lokasi->nama_lokasi.')';?> <span class="text-danger">(Kosong)</span>
                		<ul>
                			<li data-jstree='{ "icon" : "fa fa-pencil fa-lg text-success" }'><a href="#edit-lokasi-<?=$lokasi->id_lokasi;?>" data-toggle="modal">  Ubah Nama Lokasi</a></li>
                        	<li data-jstree='{ "icon" : "fa fa-trash-o fa-lg text-danger" }'><a href="#hapus-lokasi-<?=$lokasi->id_lokasi;?>" data-toggle="modal">  Hapus Nama Lokasi</a></li>
                		</ul>
                	</li>
                	<?php endif;?>
        			<?php endforeach;?>
            		<?php endif;?>
            </ul>
        </div>
        <div class="text-left">Perhatian! nama lokasi yang sudah terdapat items barang tidak dapat dihapus.</div>
        <p class="text-right">
        	<a href="#tambah-lokasi" data-toggle="modal" class="btn btn-success">Tambah</a>
        </p>
        <div class="divider"></div>
	</div>

	<div class="modal" id="tambah-lokasi">
	    <div class="modal-dialog">
	        <div class="panel panel-success">
	            <div class="panel-heading">
	                <div class="panel-heading-btn">
	                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal">
	                        <i class="fa fa-times"></i>
	                    </a>
	                </div>
	                <h4 class="panel-title"> Tambah Data Lokasi Penyimpanan Barang</h4>
	            </div>
	            <?php echo form_open('pengaturan/lokasi/tambah','data-parsley-validate="true"', 'class="form-horizontal"');?>
	            <div class="panel-body">
	                <div class="col-md-12 form-group">
	                    <label class="col-md-3 control-label">ID LOKASI <span class="semi-bold text-danger">*</span></label>
	                    <div class="col-md-9">
	                        <input name="id_lokasi" value="<?php echo $this->apotek->id_table('LB-00','id_lokasi','tb_lokasi_barang');?>" class="form-control" placeholder="" readonly="readonly" required="" type="text">
	                    </div>
	                </div>
	                <div class="col-md-12 form-group">
	                    <label class="col-md-3 control-label">Nama Lokasi <span class="semi-bold text-danger">*</span></label>
	                    <div class="col-md-9">
	                        <input name="lokasi" class="form-control" placeholder="Masukan nama lokasi penyimpanan barang" required="" type="text">
	                    </div>
	                </div>
	                <div class="col-md-12 form-group">
	                    <label class="col-md-3 control-label">Jumlah Penyimpanan <span class="semi-bold text-danger">*</span></label>
	                     <div class="col-md-9">
	                        <input name="total" class="form-control" placeholder="Jumlah maksimal barang yang disimpan" required="" type="number">
	                    </div>
	                </div>                
	                <div class="col-md-12 form-group">
		                <button type="submit" class="btn btn-sm btn-success btn-block">Simpan Data</button>
	                </div>
	            </div>
	            <?php echo form_close();?>
	        </div>
	    </div>
	</div>

	<?php
		
	if ($dtlokasi->num_rows() > 0):
	    foreach ($dtlokasi->result() as $lokasi):?>
		<div class="modal" id="hapus-lokasi-<?php echo $lokasi->id_lokasi;?>">
	    <div class="modal-dialog">
	        <?php echo form_open('pengaturan/lokasi/delete', 'class="form-horizontal"');?>
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title"><i class="fa fa-trash-o"></i> Delete Lokasi Penyimpanan Barang</h4>
	            </div>
	            <div class="modal-body">
	            <input type="hidden" name="id_lokasi" value="<?php echo $lokasi->id_lokasi;?>">
	            <p>Apakah anda yakin ingin menghapus lokasi penyimpanan <strong><?php echo $lokasi->nama_lokasi;?></strong> ?</p>
	            </div>
	            <div class="modal-footer">
	                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
	                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
	            </div>
	        </div>
	        <?php echo form_close();?>
	    </div>
	</div>


	<div class="modal" id="edit-lokasi-<?=$lokasi->id_lokasi;?>">
	    <div class="modal-dialog">
	        <div class="panel panel-success">
	            <div class="panel-heading">
	                <div class="panel-heading-btn">
	                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal">
	                        <i class="fa fa-times"></i>
	                    </a>
	                </div>
	                <h4 class="panel-title"> Ubah Data Lokasi Penyimpanan Barang</h4>
	            </div>
	            <?php echo form_open('pengaturan/lokasi/edit','data-parsley-validate="true"', 'class="form-horizontal"');?>
	            <div class="panel-body">
	                <div class="col-md-12 form-group">
	                    <label class="col-md-3 control-label">ID LOKASI <span class="semi-bold text-danger">*</span></label>
	                    <div class="col-md-9">
	                        <input name="id_lokasi" value="<?=$lokasi->id_lokasi;?>" class="form-control" placeholder="" readonly="readonly" required="" type="text">
	                    </div>
	                </div>
	                <div class="col-md-12 form-group">
	                    <label class="col-md-3 control-label">Nama Lokasi <span class="semi-bold text-danger">*</span></label>
	                    <div class="col-md-9">
	                        <input name="lokasi" value="<?=$lokasi->nama_lokasi;?>" class="form-control" placeholder="Masukan nama lokasi penyimpanan barang" required="" type="text">
	                    </div>
	                </div>
	                <div class="col-md-12 form-group">
	                    <label class="col-md-3 control-label">Jumlah Penyimpanan <span class="semi-bold text-danger">*</span></label>
	                     <div class="col-md-9">
	                        <input name="total" value="<?=$lokasi->total_kapasitas;?>" class="form-control" placeholder="Jumlah maksimal barang yang disimpan" required="" type="number">
	                    </div>
	                </div>                
	                <div class="col-md-12 form-group">
		                <button type="submit" class="btn btn-sm btn-success btn-block">Ubah Data Lokasi Penyimpanan</button>
	                </div>
	            </div>
	            <?php echo form_close();?>
	        </div>
	    </div>
	</div>
	<?php    
		endforeach;
	endif;
	?>
<!#-- End Data lokasi barang ->
		
<!#-- Data Jenis Obat -->
		<div class="tab-pane fade" id="default-tab-1">
			<h4>
				Dibawah ini merupakan daftar jenis obat yang disediakan oleh E-Apotek.
			</h4>
			<?php
				$jenis_obat = $this->db->get('tb_jenis_obat');
				$no = 1;
			?>
			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th class="text-center"></th>
						<th>Jenis Obat</th>
						<th>Keterangan</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($jenis_obat->num_rows() > 0):?>
					<?php foreach ($jenis_obat->result() as $items):?>
					<tr>
						<td>
							<div class="navbar-user">
							<img height="50px" class="img img-circle" src="<?php echo base_url('assets/img/product/'.$items->icon);?>">
							</div>
						</td>
						<td>		
							<?php echo $items->nama_jenis_obat;?>
						</td>
						<td><?php echo nl2br($items->keterangan);?></td>
						<td>
					        <a href="#edit-jenis-obat-<?php echo $items->id_jenis_obat;?>" class="btn btn-xs btn-success" data-toggle="modal">Edit</a>
                    	</td>
					</tr>
					<?php endforeach;?>
					<?php else:?>
					<tr>
						<td colspan="4">Jenis Obat Masih Kosong.</td>
					</tr>
					<?php endif;?>
				</tbody>	
			</table>
		</div>

		<?php foreach ($jenis_obat->result() as $items):?>
			<div class="modal" id="edit-jenis-obat-<?php echo $items->id_jenis_obat;?>">
			    <div class="modal-dialog">
			        <?php echo form_open('pengaturan/obat/edit-jenis-obat', 'class="form-horizontal"');?>
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			                <h4 class="modal-title"> Edit Jenis Obat</h4>
			            </div>
			            <div class="modal-body">
			                    <div class="form-group">
			                        <label class="col-md-3 control-label">Jenis Obat</label>
			                        <div class="col-md-9">
			                        	<input type="hidden" name="id_jenis_obat" value="<?php echo $items->id_jenis_obat;?>">
			                            <input name="jenis_obat" value="<?php echo $items->nama_jenis_obat;?>" class="form-control" placeholder="" readonly="readonly" type="text">
			                        </div>
			                    </div>
			                    <div class="form-group">
			                        <label class="col-md-3 control-label">Keterangan</label>
			                        <div class="col-md-9">
			                            <textarea rows="8" name="keterangan_jenis_obat" class="form-control"><?php echo $items->keterangan;?></textarea>
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
		<?php endforeach;?>
<!#-- End Data Jenis Obat -->

<!#-- Data Kategori Obat -->
		<div class="tab-pane fade" id="default-tab-2">
			<?php
				$kategori_obat = $this->db->get('tb_kategori_obat');
				$no = 1;
			?>

			<table id="data-table" class="table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th class="col-md-1">No</th>
						<th>Kategori Obat</th>
						<th class="col-md-1">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($kategori_obat->num_rows() > 0):?>
					<?php foreach ($kategori_obat->result() as $items):?>
					<tr>
						<td><?php echo $no++;?></td>
						<td><?php echo $items->nama_kategori;?></td>
						<td>
							<div class="btn-group">
	                            <a href="#" data-toggle="dropdown" class="btn btn-block btn-xs btn-success dropdown-toggle"><strong>Action <span class="caret"></span></strong></a>
	                            <ul class="dropdown-menu">
	                                <li><a href="#edit-kategori-<?php echo $items->id_kategori;?>" data-toggle="modal">Edit</a></li>
	                                <li class="divider"></li>
	                                <li><a href="#hapus-kategori-<?php echo $items->id_kategori;?>" data-toggle="modal">Hapus</a></li>
	                            </ul>
	                        </div>
						</td>
					</tr>
					<?php endforeach;?>
					<?php else:?>
					<tr>
						<td colspan="3">Kategori Obat masih kosong.</td>
					</tr>
					<?php endif;?>
				</tbody>	
			</table>
			<p>
				<a href="#tambah-kategori-obat" class="btn btn-success" data-toggle="modal">Tambah Data</a>
			</p>
		</div>

		<div class="modal" id="tambah-kategori-obat">
		    <div class="modal-dialog">
		        <?php echo form_open('pengaturan/obat/tambah-kategori-obat', 'class="form-horizontal"');?>
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                <h4 class="modal-title">Tambah Kategori Obat</h4>
		            </div>
		            <div class="modal-body">
	                    <div class="form-group">
	                        <label class="col-md-3 control-label">Kategori Obat</label>
	                        <div class="col-md-9">
	                            <input name="kategori_obat" value="" class="form-control" placeholder="Masukan Kategori Obat" type="text">
	                        </div>
	                    </div>
		            </div>
		            <div class="modal-footer">
		                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
		                <button type="submit" class="btn btn-sm btn-success">Tambah</button>
		            </div>
		        </div>
		        <?php echo form_close();?>
		    </div>
		</div>

		<?php foreach ($kategori_obat->result() as $items):?>
		<div class="modal" id="edit-kategori-<?php echo $items->id_kategori;?>">
		    <div class="modal-dialog">
		        <?php echo form_open('pengaturan/obat/edit-kategori-obat', 'class="form-horizontal"');?>
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                <h4 class="modal-title">Edit Kategori Obat</h4>
		            </div>
		            <div class="modal-body">
	                    <div class="form-group">
	                        <label class="col-md-3 control-label">Kategori Obat</label>
	                        <div class="col-md-9">
	                        	<input type="hidden" name="id_kategori" value="<?php echo $items->id_kategori;?>">
	                            <input name="kategori_obat" value="<?php echo $items->nama_kategori;?>" class="form-control" placeholder="Masukan Kategori Obat" type="text">
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
		<div class="modal" id="hapus-kategori-<?php echo $items->id_kategori;?>">
		    <div class="modal-dialog">
		        <?php echo form_open('pengaturan/obat/hapus-kategori-obat', 'class="form-horizontal"');?>
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                <h4 class="modal-title">Perhatian!</h4>
		            </div>
		            <div class="modal-body">
		            	<input type="hidden" name="id_kategori" value="<?php echo $items->id_kategori;?>">
		            	<input type="hidden" name="kategori_obat" value="<?php echo $items->nama_kategori;?>">
	                    <p>Apakah anda yakin ingin menghapus kategori : <strong><?php echo $items->nama_kategori;?></strong> ?</p>
		            </div>
		            <div class="modal-footer">
		                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
		                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
		            </div>
		        </div>
		        <?php echo form_close();?>
		    </div>
		</div>
		<?php endforeach;?>
<!#-- End Data Kategori Obat -->

<!#-- Data Satuan Obat -->

	<div class="tab-pane fade" id="default-tab-3">
		<?php
			$satuan_obat = $this->db->get('tb_satuan_obat');
			$no = 1;
		?>
		<table id="data-table" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Satuan Obat</th>
					<th>Keterangan</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($satuan_obat->num_rows() > 0):?>
				<?php foreach ($satuan_obat->result() as $items):?>
				<tr>
					<td><?php echo $no++;?></td>
					<td><?php echo $items->nama_satuan_obat;?></td>
					<td><?php echo nl2br($items->keterangan);?></td>
					<td>
						<div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-block btn-xs btn-success dropdown-toggle"><strong>Action <span class="caret"></span></strong></a>
                            <ul class="dropdown-menu">
                                <li><a href="#edit-satuan-obat-<?php echo $items->id_satuan;?>" data-toggle="modal">Edit</a></li>
                                <li class="divider"></li>
                                <li><a href="#hapus-satuan-obat-<?php echo $items->id_satuan;?>" data-toggle="modal">Hapus</a></li>
                            </ul>
                        </div>
					</td>
				</tr>
				<?php endforeach;?>
				<?php else:?>
				<tr>
					<td colspan="4">Satuan Obat masih kosong.</td>
				</tr>
				<?php endif;?>
			</tbody>	
		</table>
		<p>
			<a href="#tambah-satuan-obat" data-toggle="modal" class="btn btn-success">Tambah Data</a>
		</p>
		<div class="modal" id="tambah-satuan-obat">
		    <div class="modal-dialog">
		        <?php echo form_open('pengaturan/barang/tambah-satuan-obat', 'class="form-horizontal"');?>
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                <h4 class="modal-title">Tambah Satuan Obat</h4>
		            </div>
		            <div class="modal-body">
		                <div class="form-group">
		                    <label class="col-md-3 control-label">Satuan Obat</label>
		                    <div class="col-md-9">
		                        <input name="satuan_obat" value="" class="form-control" placeholder="Masukan Nama Satuan Obat" type="text">
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-3 control-label">Keterangan</label>
		                    <div class="col-md-9">
		                        <textarea rows="8" name="keterangan" placeholder="Masukan Keterangan" class="form-control"></textarea>
		                    </div>
		                </div>

		            </div>
		            <div class="modal-footer">
		                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
		                <button type="submit" class="btn btn-sm btn-success">Tambah</button>
		            </div>
		        </div>
		        <?php echo form_close();?>
		    </div>
		</div>

		<?php foreach ($satuan_obat->result() as $items):?>
			<div class="modal" id="edit-satuan-obat-<?php echo $items->id_satuan;?>">
			    <div class="modal-dialog">
			        <?php echo form_open('pengaturan/barang/edit-satuan-obat', 'class="form-horizontal"');?>
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			                <h4 class="modal-title">Edit Satuan Obat</h4>
			            </div>
			            <div class="modal-body">
			            	<input type="hidden" name="id_satuan" value="<?php echo $items->id_satuan;?>">
			                <div class="form-group">
			                    <label class="col-md-3 control-label">Satuan Obat</label>
			                    <div class="col-md-9">
			                        <input name="satuan_obat" value="<?php echo $items->nama_satuan_obat;?>" class="form-control" placeholder="Masukan Nama Satuan Obat" type="text">
			                    </div>
			                </div>
			                <div class="form-group">
			                    <label class="col-md-3 control-label">Keterangan</label>
			                    <div class="col-md-9">
			                        <textarea rows="8" name="keterangan" placeholder="Masukan Keterangan" class="form-control"><?php echo nl2br($items->keterangan);?></textarea>
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

			<div class="modal" id="hapus-satuan-obat-<?php echo $items->id_satuan;?>">
			    <div class="modal-dialog">
			        <?php echo form_open('pengaturan/barang/hapus-satuan-obat', 'class="form-horizontal"');?>
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			                <h4 class="modal-title">Informasi!</h4>
			            </div>
			            <div class="modal-body">
			            	<input type="hidden" name="id_satuan" value="<?php echo $items->id_satuan;?>">
			            	<input type="hidden" name="satuan_obat" value="<?php echo $items->nama_satuan_obat;?>">
			                <p>
			                Apakah anda yakin ingin menghapus satuan obat : <strong><?php echo $items->nama_satuan_obat;?></strong> ?
			                </p>
			            </div>
			            <div class="modal-footer">
			                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
			                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
			            </div>
			        </div>
			        <?php echo form_close();?>
			    </div>
			</div>
		<?php endforeach;?>
	</div>
<!#-- End Data Satuan Obat -->

	</div>
</div>
