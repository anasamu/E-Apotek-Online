<?php
$qty            = 0;
$no             = 1;
$expired_date   = $this->data_pembelian->expired_date();
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Expired Date</h4>
    </div>
    <div class="panel-body">
        <h4>Menu ini digunakan untuk menampilkan daftar barang yang telah Expire Date.</h4>
        <p>Daftar barang yang telah expired date akan ditampilkan menurut ID Pembelian</p>
        <table id="data-table" class="table table-hover table-condensed table-th-valign-middle  table-td-valign-middle table-striped table-bordered">
        	<thead>
        		<tr>
                    <th rowspan="2" class="text-center">No</th>
                    <th colspan="5" class="text-center"><h5>Rincian Barang</h5></th>
                    <th rowspan="2" class="text-center">Expired Date</th>
        			<th rowspan="2" class="text-center">Action</th>
                </tr>
                <tr>
                    <th>Tgl Transaksi</th>
                    <th class="col-md-1 text-center">ID BELI</th>
                    <th>Nama Barang</th>
                    <th>Suplier</th>
                    <th>QTY</th>
        		</tr>
        	</thead>
            <tbody>
            <?php 
            
            if ($expired_date !== FALSE):

            
            foreach ($expired_date as $data):

                $barang         = $this->master_barang->where($data->id_barang);
                $suplier        = $this->master_suplier->where($data->id_suplier);
                $expired        = strtotime($data->expired_date);

            ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td>
                        <?=date('d-m-Y',strtotime($data->tgl_transaksi));?>
                    </td>
                    <td><?php echo $data->id_beli;?></td>
                    <td>
                        <img width="45px" height="45px" src="<?php $this->apotek->url('assets/img/obat/'.$barang['foto']);?>">
                        <?php echo $barang['nama_barang'];?>
                    </td>
                    <td>
                        <?=$suplier['suplier'];?>
                    </td>
                    <td>
                        <?=$data->qty;?>
                    </td>
                    <td class="semi-bold">
                        <?= $this->apotek->date($data->expired_date);?>
                    </td>
                    <td class="text-center"><input type="checkbox" name=""></td>
                </tr>
            <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="8">Belum ada items yang expired date</td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>
    </div>
</div>