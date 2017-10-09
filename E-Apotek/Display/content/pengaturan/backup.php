<div class="col-md-12 ui-sortable">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Backup/ Restore menu</h4>
        </div>
        <div class="panel-body">
            <h4>Menu ini digunakan untuk melakukan backup/ restore aplikasi anda.</h4>
            <?=$this->apotek->message();?>
            <hr/>
            <p>1. Backup Configuration File</p>
            <p>Untuk melakukan backup file konfigurasi silahkan klik <a href="<?=$this->apotek->url('pengaturan/configuration/backup');?>">disini</a>.</p>
            <hr/>
            <p>2. Restore Configuration File</p>
            <p>
                Silahkan Copy text ENCRYPT CONFIG FILE yang ekstensi file *.amu dan paste dibawah ini.<br/>
            </p>
            <?= form_open('pengaturan/config/decrypt','class="form-horizontal"');?>
            <div class="form-group">
                <label class="col-md-3 control-label">ENCRYPT CONFIG FILE</label>
                <div class="col-md-9">
                    <textarea name="config_encrypt" class="form-control" placeholder="ENCRYPT CONFIG FILE" rows="5"></textarea>
                </div>
            </div>
            <p class="text-right">
                <button type="submit" class="btn btn-success">Decrypt</button>
            </p>
            <?= form_close();?>
            <hr/>
            <p>3. Backup Database</p>
            <p>Untuk melakukan backup database silahkan klik <a href="<?=$this->apotek->url('pengaturan/database/backup');?>">disini</a>.</p>
            <hr/>
            <p>4. Restore Database</p>
            <p>
            	Silahkan Copy text ENCRYPT DB FILE yang ekstensi file *.amu dan paste dibawah ini.<br/>
            </p>
            <hr/>
            <?= form_open('pengaturan/database/decrypt','class="form-horizontal"');?>
            <div class="form-group">
                <label class="col-md-3 control-label">ENCRYPT DB FILE</label>
                <div class="col-md-9">
                    <textarea name="db_encrypt" class="form-control" placeholder="ENCRYPT DB FILE" rows="5"></textarea>
                </div>
            </div>
            <p class="text-right">
	            <button type="submit" class="btn btn-success">Decrypt</button>
	        </p>
	        <?= form_close();?>
        </div>
    </div>
</div>