<div style="" class="panel panel-inverse" data-sortable-id="table-basic-7">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="#tambah" data-toggle="modal" class="btn btn-xs btn-success">Tambah Data</a>
        </div>
        <h4 class="panel-title">Daftar Suplier</h4>
    </div>
    <div class="panel-body">
    	<?= $this->apotek->message();?>
		<div class="table-responsive">
			<table id="data-table" class="table table-bordered table-condensed table-th-valign-middle table-hover table-striped">
				<thead>
					<tr class="">
						<th rowspan="2" class="text-center">#</th>
						<th rowspan="2" class="text-center">ID SUPLIER</th>
						<th rowspan="2" class="text-center">Nama Suplier</th>
						<th colspan="3" class="text-center">Informasi Suplier</th>
						<th rowspan="2" class="text-center">Date</th>
						<th rowspan="2" class="text-center">Action</th>
					</tr>
					<tr class="">
						<th>Alamat Lengkap</th>
						<th>No Telp</th>
						<th>No. Rekening</th>
					</tr>
				</thead>
				<tbody>
<?php 
	$dtsuplier = $this->db->get('tb_suplier');

	if ($dtsuplier->num_rows() > 0):
		$no = 1;
		foreach ($dtsuplier->result() as $suplier):
?>
					<tr>
						<td><?php echo $no++;?></td>
						<td class="text-center"><?php echo $suplier->id_suplier;?></td>
						<td>
							<?php echo $suplier->suplier;?>
							<?php $this->apotek->get_label($suplier->id_suplier);?>
						</td>
						<td>
							<address>
							<?php echo nl2br($suplier->alamat);?>
							</address>
						</td>
						<td><?php echo $suplier->no_telp;?></td>
						<td class="semi-bold"><?php echo $suplier->no_rek;?></td>
						<td><?php echo $this->apotek->date($suplier->date,false);?></td>
						<td>
							<div class="btn-group">
                                <a href="#" data-toggle="dropdown" class="btn btn-block btn-xs btn-success dropdown-toggle"><strong>Action <span class="caret"></span></strong></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#edit-<?php echo $suplier->id_suplier;?>" data-toggle="modal">Edit</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#hapus-<?php echo $suplier->id_suplier;?>" data-toggle="modal">Hapus</a></li>
                                </ul>
                            </div>
						</td>
					</tr>
<?php
		endforeach;
	else:
		echo "<tr><td colspan='8'> Data Suplier masih kosong!</td></tr>";
	endif;
?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="tambah">
    <div class="modal-dialog">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <h4 class="panel-title"><i class="fa fa-user"></i> Tambah Data Suplier</h4>
            </div>
            <?php echo form_open('master/suplier/tambah','data-parsley-validate="true"', 'class="form-horizontal"');?>
            <div class="panel-body">
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">ID Suplier <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="id_suplier" value="<?php echo $this->apotek->id_table('S-0','id_suplier','tb_suplier');?>" class="form-control" placeholder="" readonly="readonly" required="" type="text">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Nama Suplier <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="nama" class="form-control" placeholder="Masukan nama suplier" required="" type="text">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Alamat <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <textarea name="alamat" class="form-control" placeholder="Masukan alamat" required=""></textarea>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">No. Telp </label>
                    <div class="col-md-9">
                        <input name="telp" class="form-control" placeholder="Masukan No telp" type="number">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">No. Rekening </label>
                    <div class="col-md-9">
                        <input name="no_rek" class="form-control" placeholder="Masukan No rekening" type="text">
                    </div>
                </div>
                
                <div class="col-md-12 form-group">
	                <button type="submit" class="btn btn-sm btn-success btn-block">Simpan Data Suplier</button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<?php 
if ($dtsuplier->num_rows() > 0):
foreach ($dtsuplier->result() as $suplier):?>

<div class="modal" id="hapus-<?php echo $suplier->id_suplier;?>">
    <div class="modal-dialog">
        <?php echo form_open('master/suplier/delete', 'class="form-horizontal"');?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Delete Suplier</h4>
            </div>
            <div class="modal-body">
            <input type="hidden" name="id_suplier" value="<?php echo $suplier->id_suplier;?>">
            <p>Apakah anda yakin ingin menghapus suplier : <strong><?php echo $suplier->suplier;?></strong> ?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>

<div class="modal" id="edit-<?php echo $suplier->id_suplier;?>">
    <div class="modal-dialog">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <h4 class="panel-title"><i class="fa fa-user"></i> Edit Data Suplier</h4>
            </div>
            <?php echo form_open('master/suplier/edit','data-parsley-validate="true"', 'class="form-horizontal"');?>
            <div class="panel-body">
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">ID Suplier <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="id_suplier" value="<?php echo $suplier->id_suplier;?>" class="form-control" placeholder="" readonly="readonly" required="" type="text">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Nama Suplier <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input value="<?php echo $suplier->suplier;?>" name="nama" class="form-control" placeholder="Masukan nama suplier" required="" type="text">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Alamat <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <textarea name="alamat" class="form-control" placeholder="Masukan alamat" required=""><?php echo $suplier->alamat;?></textarea>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">No. Telp </label>
                    <div class="col-md-9">
                        <input name="telp" value="<?php echo $suplier->no_telp;?>" class="form-control" placeholder="Masukan No telp" type="number">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">No. Rekening </label>
                    <div class="col-md-9">
                        <input name="no_rek" value="<?php echo $suplier->no_rek;?>" class="form-control" placeholder="Masukan No rekening" type="text">
                    </div>
                </div>
                
                <div class="col-md-12 form-group">
	                <button type="submit" class="btn btn-sm btn-success btn-block">Ubah Data Suplier</button>
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