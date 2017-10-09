<div class="panel panel-default panel-with-tabs" data-sortable-id="ui-unlimited-tabs-2">
    <div class="panel-heading p-0">
        <div class="panel-heading-btn m-r-10 m-t-10">
            <a href="#" class="btn btn-xs btn-icon btn-circle btn-inverse" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
        <!-- begin nav-tabs -->
        <div class="tab-overflow overflow-right overflow-left">
            <ul class="nav nav-tabs">
                <li class="prev-button"><a href="#" data-click="prev-tab" class="text-inverse"><i class="fa fa-arrow-left"></i></a></li>
                <li class="active"><a href="#harga-barang" data-toggle="tab">HARGA BARANG</a></li>
                <li class=""><a href="#kartu-stok" data-toggle="tab">KARTU STOK</a></li>
                <li class=""><a href="#expired-date" data-toggle="tab">EXPIRED DATE</a></li>
                <li class=""><a href="#jurnal" data-toggle="tab">BUKU BESAR</a></li>
                <li class="next-button"><a href="#" data-click="next-tab" class="text-inverse"><i class="fa fa-arrow-right"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <?=$this->apotek->message();?>
        <div class="tab-pane fade active in" id="harga-barang">
            <h3 class="m-t-10">Harga Barang</h3>
            <p>
                Menu ini digunakan untuk melihat laporan semua harga barang.
            </p>
<?php
$no = 1;
$total_stok = 0;
$total_hju = 0;
$total_hjd = 0;
$total_hjr = 0;
$harga_barang = $this->data_harga_barang->get();
?>
            <?php echo form_open('laporan/apotek/harga-barang/print', 'class="form-horizontal"');?>
                <table id="data-table" class="table table-responsive table-th-valign-middle table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">No</th>
                            <th rowspan="2">Nama Barang</th>
                            <th class="text-center" rowspan="2">HPP</th>
                            <th class="text-center" rowspan="2">STOK</th>
                            <th class="text-center" colspan="2">HJU</th>
                            <th class="text-center" colspan="2">HJD</th>
                            <th class="text-center" colspan="2">HJR</th>
                        </tr>
                        <tr>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php if ($harga_barang !== FALSE):?>
                        <?php foreach ($harga_barang as $items):?>
                        <?php
                        $dtbarang       = $this->master_barang->where($items->id_barang);
                        $stok           = $this->data_stok->where($items->id_barang);
                        $keuntungan_hju = $items->hju - $items->hpp; 
                        $persen_hju     = ceil((($keuntungan_hju / $items->hpp) * 100));
                        $keuntungan_hjd = $items->hjd - $items->hpp; 
                        $persen_hjd     = ceil((($keuntungan_hjd / $items->hpp) * 100));
                        $keuntungan_hjr = $items->hjr - $items->hpp; 
                        $persen_hjr     = ceil((($keuntungan_hjr / $items->hpp) * 100));
                        $total_hpp      = $items->hpp * $stok['sisa_stok'];
                        ?>
                        <tr>
                            <td class="text-center"><?=$no++;?></td>
                            <td><?=$dtbarang['nama_barang'];?></td>
                            <td><?=$this->apotek->rupiah($items->hpp);?></td>
                            <td><?=$stok['sisa_stok'].' / '.$dtbarang['satuan'];?></td>
                            <td>
                                <?= $this->apotek->rupiah($items->hju);?>
                            </td>
                            <td>
                                <?php $sub_hju = $items->hju * $stok['sisa_stok'];?>
                                <?=$this->apotek->rupiah($sub_hju);?>
                            </td>
                            <td>
                                <?=$this->apotek->rupiah($items->hjd);?>
                            </td>
                            <td>
                                <?php $sub_hjd = $items->hjd * $stok['sisa_stok'];?>
                                <?=$this->apotek->rupiah($sub_hjd);?>
                            </td>
                            <td>
                                <?=$this->apotek->rupiah($items->hjr);?>
                            </td>
                            <td>
                                <?php $sub_hjr = $items->hjr * $stok['sisa_stok'];?>
                                <?=$this->apotek->rupiah($sub_hjr);?>
                            </td>
                        </tr>
                        <?php
                        $total_stok += $stok['sisa_stok'];
                        $total_hju += $sub_hju;
                        $total_hjd += $sub_hjd;
                        $total_hjr += $sub_hjr;
                        ?>
                        <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th><?=$total_stok;?> Items</th>
                            <th>Total HJU</th>
                            <th><?=$this->apotek->rupiah($total_hju);?></th>
                            <th>Total HJD</th>
                            <th><?=$this->apotek->rupiah($total_hjd);?></th>
                            <th>Total HJR</th>
                            <th><?=$this->apotek->rupiah($total_hjr);?></th>
                        </tr>
                    </tfoot>
</table>
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success pull-right">Cetak</button>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
        <div class="tab-pane fade" id="kartu-stok">
            <h3 class="m-t-10">KARTU STOK</h3>
            <p>
                Menu ini untuk menampilkan Kartu Stok barang yang ada di apotek.
            </p>
            <?php echo form_open('laporan/apotek/kartu-stok/print', 'class="form-horizontal"');?>
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
                    <label class="control-label col-md-4">Nama Barang</label>
                    <div class="col-md-8">
                        <select name="barang" class="form-control selectpicker" data-live-search="true" data-style="btn-white">
                            <option selected="">-- Pilih nama barang --</option>
                            <?php $stok     = $this->db->get('tb_data_stok');?>
                            <?php if ($stok->num_rows() > 0):?>
                            <?php foreach ($stok->result() as $stok_items):?>
                            <?php $barang   = $this->master_barang->where($stok_items->id_barang);?>
                            <option value="<?=$barang['id'];?>"><?=$barang['nama_barang'];?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success pull-right">Cetak</button>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
        <div class="tab-pane fade" id="expired-date">
            <h3 class="m-t-10">Expired Date</h3>
            <p>
                Menu ini digunakan untuk menampilkan laporan barang expired
            </p>
            <?php echo form_open('laporan/apotek/expired/print', 'class="form-horizontal"');?>
                <div class="form-group">
                    <label class="col-md-4 control-label">Periode</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input class="form-control" name="start" placeholder="Tgl awal" type="text" id="kalender_start_2">
                            <span class="input-group-addon">s/d</span>
                            <input class="form-control" name="end" placeholder="Tgl akhir" type="text" id="kalender_end_2">
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
        <div class="tab-pane fade" id="jurnal">
            <h3 class="m-t-10">BUKU BESAR</h3>
            <p>
                Menu ini digunakan untuk menampilkan laporan buku besar apotek
            </p>
            <?php echo form_open('laporan/apotek/buku-besar/print', 'class="form-horizontal"');?>
                <div class="form-group">
                    <label class="col-md-4 control-label">Periode</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input class="form-control" name="start" placeholder="Tgl awal" type="text" id="kalender_start_3">
                            <span class="input-group-addon">s/d</span>
                            <input class="form-control" name="end" placeholder="Tgl akhir" type="text" id="kalender_end_3">
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
</div>