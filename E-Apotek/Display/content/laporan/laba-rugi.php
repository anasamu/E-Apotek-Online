<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Laporan Laba Rugi</h4>
    </div>
    <div class="panel-body">
        <h4>Menu ini digunakan untuk melihat laporan laba rugi berdasarkan periode</h4>
        <?php echo $this->apotek->message();?>
        <hr/>
        <?php echo form_open('laporan/laba-rugi/print', 'class="form-horizontal"');?>
        <div class="form-group">
            <label class="col-md-4 control-label">Periode</label>
            <div class="col-md-8">
                <div class="input-group">
                    <input class="form-control" name="start" placeholder="Tgl awal" type="text" id="kalender_start">
                    <span class="input-group-addon">s/d</span>
                    <input class="form-control" name="end" placeholder="Tgl akhir" type="text" id="kalender_end">
                </div>
            </div>
        </div>

		<div class="form-group">
			<div class="col-md-12">
				<button type="submit" class="btn btn-success pull-right">Cetak</button>
			</div>
		</div>

		<?php echo form_close();?>
	</div>
</div>