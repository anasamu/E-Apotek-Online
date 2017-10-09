<div data-init="true" class="panel panel-inverse" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <h4 class="panel-title">Stok Barang</h4>
    </div>
    <div class="panel-body">
        <h4>Menu ini untuk menampilkan daftar stok barang yang ada dalam apotek anda.</h4>
        <?php $this->apotek->message();?>
        <table id="data-table" class="table table-hover table-condensed table-th-valign-middle table-td-valign-middle table-striped table-bordered">
        	<thead>
        		<tr>
        			<th rowspan="2" class="col-md-1 text-center">No</th>
        			<th colspan="2" class="text-center"><h5>RINCIAN BARANG</h5></th>
        			<th colspan="4" class="text-center"><h5>RINCIAN STOK BARANG</h5></th>
        		</tr>
        		<tr>
        			<th class="text-center col-md-1">ID BARANG</th>
                    <th class="col-md-4">Nama Barang</th>
                    <th class="text-center">STOK AWAL</th>
        			<th class="text-center">STOK MASUK</th>
        			<th class="text-center">STOK KELUAR</th>
        			<th class="text-center">SISA STOK</th>
        		</tr>
        	</thead>
        	<tbody>
            <?php $no = 1;?>
            <?php if (!$this->data_pembelian->group_barang() == FALSE):?>
            <?php foreach ($this->data_pembelian->group_barang() as $items):?>
            <?php 
                $stok           = $this->data_stok->where($items->id_barang);
                $stok_awal      = $stok['stok_awal'];
                $stok_masuk     = $stok['stok_masuk'];
                $stok_keluar    = $stok['stok_keluar'];
                $sisa_stok      = $stok['sisa_stok'];
                $master_barang  = $this->master_barang->where($items->id_barang);
            ?>
        		<tr>            
                    <td class="text-center">
                        <?=$no++;?>
                    </td>
                    <td>
                        <?php echo $items->id_barang;?>
                    </td>
                    <td>
                        <img class="img" height="45px" width="45px" src="<?php $this->apotek->url('assets/img/obat/'.$master_barang['foto']);?>">
                        <?php echo $master_barang['nama_barang'];?>
                        <?php echo $this->apotek->get_label($items->id_barang);?>
                    </td>
                    <td class="col-md-1 text-center">
                        <?=$stok_masuk;?>
                    </td>
        			<td class="col-md-1 text-center">
                        <?=$stok_masuk;?>
                    </td>
        			<td class="col-md-1 text-center">
                        <?=$stok_keluar;?>
                    </td>
        			<td class="col-md-1 text-center">
                        <?=$sisa_stok?>
                    </td>
        		</tr>
            <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="8">Stok barang masih kosong</td>
                </tr>
            <?php endif;?>
        	</tbody>
        </table>
        <p>
        Keterangan : <br/>
        SISA STOK merupakan hasil dari sisa barang yang ada dalam apotek.<br/> 
        hasil dari sisa stok didapat dari <small><code><strong>STOK MASUK - STOK KELUAR = SISA STOK</strong></code></small><br/>
        Untuk informasi kartu stok silahkan cek di menu laporan > apotek > kartu stok
        </p>
    </div>
</div>