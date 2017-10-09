<div class="col-md-12">
        <?php echo $this->session->flashdata('message');?>
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="#tambah" class="btn btn-xs btn-success" data-toggle="modal">Tambah User</a>
                </div>
                <h4 class="panel-title"><i class="fa fa-users"></i> Daftar User Apotek</h4>
            </div>
            
            <div class="panel-body">
                
                <table id="data-table" class="table table-striped table-hover table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>ID USER</th>
                            <th>USERNAME</th>
                            <th>LOGIN ACCESS</th>
                            <th>TGL DAFTAR</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query      = $this->db->get('tb_users');
                        $tb_user    = $query->result();
                        ?>

                        <?php foreach ($tb_user as $items):?>
                        <tr>
                            <td><?php echo $items->id_users;?></td>
                            <td>
                                <span class="navbar-user">
                                    <img src="<?php echo base_url('assets/img/user/'.$items->foto);?>" class="img img-circle">
                                    <?php echo $items->username;?>
                                    <?php $this->apotek->get_label($items->id_users);?>
                                </span>
                            </td>

                            <?php
                                    $query = $this->db->where('id_login',$items->type)
                                                        ->get('tb_login_access');
                                    $type = strtoupper($query->row()->login_type);
                            ?>
                            <td class="text-center"><b><?php echo $type;?></b></td>

                            <td><?php echo $this->apotek->date($items->date_created,false);?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="#" data-toggle="dropdown" class="btn btn-block btn-xs btn-success dropdown-toggle"><strong>Action <span class="caret"></span></strong></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo base_url('master/user/views/'.$items->id_users);?>">Views</a></li>
                                        <li><a href="#edit-<?php echo $items->id_users;?>" data-toggle="modal">Edit</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#hapus-<?php echo $items->id_users;?>" data-toggle="modal">Hapus</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end panel -->
</div>

<!-- modal menu -->
<div class="modal" id="tambah">
    <div class="modal-dialog">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="#" class="btn btn-xs btn-icon btn-circle btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <h4 class="panel-title"><i class="fa fa-user"></i> Tambah Data User</h4>
            </div>
            <?php echo form_open_multipart('master/user/tambah','data-parsley-validate="true"', 'class="form-horizontal"');?>
            <div class="panel-body">
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">ID User <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="id_user" value="<?php echo $this->apotek->id_table('U00','id_users','tb_users');?>" class="form-control" placeholder="" readonly="readonly" required="" type="text">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Nama Lengkap <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="nama" class="form-control" placeholder="Masukan nama lengkap" required="" type="text">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Alamat <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <textarea name="alamat" class="form-control" placeholder="Masukan alamat" required=""></textarea>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Username <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="username" class="form-control" placeholder="Masukan Username" required="" type="text">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Password <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="password" class="form-control" placeholder="Masukan Password" required="" type="password">
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Ulangi Password <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <input name="trypassword" class="form-control" placeholder="Ulangi Password" required="" type="password">
                    </div>
                </div>
                
                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Foto</label>
                    <div class="col-md-9">
                        <input type="file" name="foto">
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <label class="col-md-3 control-label">Login Access <span class="semi-bold text-danger">*</span></label>
                    <div class="col-md-9">
                        <select required="" name="login_access" class="form-control">
                            <option value="">Pilih Login Access User</option>
                            <?php
                                
                                $query = $this->db->get('tb_login_access');

                                if ($query->num_rows() > 0)
                                {
                                    foreach ($query->result() as $items) 
                                    {
                                        echo "<option value=\"$items->id_login\">$items->login_type</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12 form-group">
                <button type="submit" class="btn btn-sm btn-success btn-block">Simpan Data User</button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>


<?php foreach ($tb_user as $items):?>

<div class="modal" id="hapus-<?php echo $items->id_users;?>">
    <div class="modal-dialog">
        <?php echo form_open('master/user/delete', 'class="form-horizontal"');?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Delete User</h4>
            </div>
            <div class="modal-body">
            <input type="hidden" name="id_user" value="<?php echo $items->id_users;?>">
            <p>Apakah anda yakin ingin menghapus user dengan ID : <strong><?php echo $items->id_users;?></strong> ?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>

<div class="modal" id="edit-<?php echo $items->id_users;?>">
    <div class="modal-dialog">
        <?php echo form_open_multipart('master/user/edit', 'class="form-horizontal"');?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Edit User</h4>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">ID User</label>
                        <div class="col-md-9">
                            <input name="id_user" value="<?php echo $items->id_users;?>" class="form-control" placeholder="" readonly="readonly" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Nama Lengkap <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <input name="nama" value="<?php echo $items->nama_lengkap;?>" class="form-control" placeholder="Masukan nama lengkap" required="" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Alamat <span class="semi-bold text-danger">*</span></label>
                        <div class="col-md-9">
                            <textarea name="alamat" class="form-control" placeholder="Masukan alamat" required=""><?php echo $items->alamat;?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Username</label>
                        <div class="col-md-9">
                            <input value="<?php echo $items->username;?>" name="username" class="form-control" placeholder="Masukan Username" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Password</label>
                        <div class="col-md-9">
                            <input name="password" class="form-control" placeholder="Masukan Password baru" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Ulangi Password</label>
                        <div class="col-md-9">
                            <input name="trypassword" class="form-control" placeholder="Ulangi Password baru" type="password">
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="col-md-3 control-label">Foto</label>
                        <div class="col-md-9">
                            <input type="file" name="foto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Login Access</label>
                        <div class="col-md-9">
                            <select name="login_access" class="form-control">
                                <?php
                                    $query = $this->db->where('id_login',$items->type)
                                                            ->get('tb_login_access');
                                    $id_type    = $query->row()->id_login;
                                    $type       = strtoupper($query->row()->login_type);
                                ?>

                                <option value="<?php echo $id_type;?>"><?php echo $type;?></option>
                                <?php
                                    
                                    $query = $this->db->get('tb_login_access');

                                    if ($query->num_rows() > 0)
                                    {
                                        foreach ($query->result() as $items) 
                                        {   
                                            if ($items->id_login == $id_type) 
                                            {
                                                continue;
                                            }

                                            echo "<option value=\"$items->id_login\">$items->login_type</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-sm btn-success">Ubah</button>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>

<?php endforeach;?>