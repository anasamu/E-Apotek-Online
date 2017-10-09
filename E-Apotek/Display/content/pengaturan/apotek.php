<?php
	
	echo $this->session->flashdata('message');
	$query = $this->db->get('tb_apotek');
	$apotek = $query->row();
?>
<div class="profile-container">
    <!-- begin profile-section -->
    <div class="profile-section">
        <!-- begin profile-right -->
        <div class="profile-right">
            <!-- begin profile-info -->
            <div class="profile-info">
                <!-- begin table -->
                <div class="table-responsive">
                    <table class="table table-profile">
                        <tbody>
                            <tr class="highlight">
                                <td colspan="2">
                                    <h4>Pengaturan E-Apotek Online</h4>
                                </td>
                            </tr>
                            <tr>
                                <td class="field">No SIPA</td>
                                <td><?php echo $apotek->no_sipa;?></td>
                            </tr>
                            <tr>
                                <td class="field">Nama Apotek</td>
                                <td><?php echo $apotek->nama_apotek;?></td>
                            </tr>
                            <tr>
                                <td class="field">Penanggung Jawab</td>
                                <td><?php echo $apotek->owner;?></td>
                            </tr>
                            <tr>
                                <td class="field">Metode HPP</td>
                                <td><?php echo $apotek->hpp;?></td>
                            </tr>
                            <tr>
                                <td class="field">Saldo Awal</td>
                                <td><?php echo $this->apotek->rupiah($apotek->saldo_awal);?></td>
                            </tr>
                            <tr>
                                <td class="field">Kota</td>
                                <td><?php echo $apotek->kota;?></td>
                            </tr>
                            <tr>
                                <td class="field">Alamat</td>
                                <td><?php echo nl2br($apotek->alamat);?></td>
                            </tr>
                            <tr>
                                <td class="field">Telp</td>
                                <td><?php echo $apotek->phone;?></td>
                            </tr>

                            <tr>
                                <td class="field">Fax</td>
                                <td><?php echo $apotek->fax;?></td>
                            </tr>
                            <tr>
                                <td class="field">Email</td>
                                <td><?php echo $apotek->email;?></td>
                            </tr>
                            <tr>
                                <td class="field">Slogan Struk</td>
                                <td><?php echo nl2br($apotek->slogan);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
                <p>
                    <a href="#update-data-apotek" class="btn btn-success pull-right" data-toggle="modal">Ubah Data</a>
                </p>
            </div>
            <!-- end profile-info -->
        </div>
        <p class="pull-left">
            Perhatian :<br/>
            Melakukan perubahan terhadap No. SIPA dan Nama Apotek akan menyebabkan Code License yang anda beli tidak valid.
        </p>
        <!-- end profile-right -->
    </div>
    <!-- end profile-section -->
</div>

<div class="modal" id="update-data-apotek">
    <div class="modal-dialog">
        <?php echo form_open('pengaturan/apotek/update', 'class="form-horizontal"');?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Data Apotek</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="id" value="<?php echo $apotek->id_apotek;?>">

                <div class="form-group">
                    <label class="col-md-3 control-label">No SIPA</label>
                    <div class="col-md-9">
                        <input name="no_sipa" required="" readonly="" value="<?php echo $apotek->no_sipa;?>" class="form-control" placeholder="no Surat ijin Apotek" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Nama Apotek</label>
                    <div class="col-md-9">
                        <input name="nama_apotek" required="" readonly="" value="<?php echo $apotek->nama_apotek;?>" class="form-control" placeholder="Masukan Nama Apotek" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Penanggung Jawab</label>
                    <div class="col-md-9">
                        <input name="pemilik" value="<?php echo $apotek->owner;?>" class="form-control" placeholder="Pemilik/Owner" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Metode HPP</label>
                    <div class="col-md-9">
                        <select name="hpp" class="form-control selectpicker" data-size="4" data-live-search="true" data-style="btn-white">
                            <option>-- Pilih Metode HPP --</option>
                            <option value="RATA-RATA">HPP : RATA-RATA</option>
                            <option value="PEMBELIAN TERTINGGI">HPP : HARGA PEMBELIAN TERTINGGI</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Saldo Awal Apotek</label>
                    <div class="col-md-9">
                        <input name="saldo_awal" value="<?php echo $apotek->saldo_awal;?>" class="form-control" placeholder="Saldo Awal Apotek" type="number">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Kota</label>
                    <div class="col-md-9">
                        <input name="kota" value="<?php echo $apotek->kota;?>" class="form-control" placeholder="Kota" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Alamat</label>
                    <div class="col-md-9">
                        <textarea rows="3" name="alamat" placeholder="Masukan Alamat Apotek" class="form-control"><?php echo $apotek->alamat;?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Telp</label>
                    <div class="col-md-9">
                        <input name="telp" value="<?php echo $apotek->phone;?>" class="form-control" placeholder="Masukan Nomor telp apotek" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Fax</label>
                    <div class="col-md-9">
                        <input name="fax" value="<?php echo $apotek->fax;?>" class="form-control" placeholder="Masukan fax apotek" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Email</label>
                    <div class="col-md-9">
                        <input name="email" value="<?php echo $apotek->email;?>" class="form-control" placeholder="Masukan Email apotek" type="text">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Slogan Struk</label>
                    <div class="col-md-9">
                        <textarea rows="3" name="slogan" placeholder="Masukan Slogan untuk struk Apotek" class="form-control"><?php echo $apotek->slogan;?></textarea>
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