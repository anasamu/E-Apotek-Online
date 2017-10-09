<?php
$no = 1;
$total_stok = 0;
$total_hju = 0;
$total_hjd = 0;
$total_hjr = 0;
$apotek 	= $this->apotek->e_apotek();
ob_start();
?>
<page backleft="10mm" backright="10mm" backtop="10mm" backbottom="15mm" >
<page_footer>
    <table style="width: 100%; border: solid 1px black;">
        <tr>
            <td style="text-align: left; width: 50%">
            	E-Apotek Online - <?php echo strtoupper($apotek->nama_apotek);?><br/>
            	<small>Dicetak Oleh : <?=$this->apotek->users()->nama_lengkap;?> / Tgl Cetak <?=date('d-m-Y');?></small>
            </td>
            <td style="text-align: right; width: 50%">page [[page_cu]]/[[page_nb]]</td>
        </tr>
    </table>
</page_footer>
<link type="text/css" href="./assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<div class="text-center">
	<span style="font-size: 15pt">
	<?php echo strtoupper($apotek->nama_apotek);?><br/>
	</span>
	E-Apotek Online<br/>
	<?= $apotek->alamat;?>
</div>
<hr/>
<div class="text-center">
	<h4>LAPORAN HARGA BARANG</h4>
</div>
<div class="divider"></div>
<div class="divider"></div>
<table style="width: 100%; border: solid 1px #5544DD" class="">
	<thead>
		<tr>
			<th style="width:5%; border: solid 1px" class="text-center" rowspan="2">No</th>
			<th style="width:23%; border: solid 1px" rowspan="2">Nama Barang</th>
			<th style="width:7%; border: solid 1px" class="text-center" rowspan="2">HPP</th>
			<th style="width:8%; border: solid 1px" class="text-center" rowspan="2">STOK MASUK</th>
			<th style="width:10%; border: solid 1px" class="text-center" colspan="2">HJU</th>
			<th style="width:10%; border: solid 1px" class="text-center" colspan="2">HJD</th>
			<th style="width:10%; border: solid 1px" class="text-center" colspan="2">HJR</th>
		</tr>
		<tr>
			<th style="border: solid 1px" class="text-center">Harga</th>
			<th style="border: solid 1px" class="text-center">Total</th>
			<th style="border: solid 1px" class="text-center">Harga</th>
			<th style="border: solid 1px" class="text-center">Total</th>
			<th style="border: solid 1px" class="text-center">Harga</th>
			<th style="border: solid 1px" class="text-center">Total</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($harga_barang !== FALSE):?>
		<?php foreach ($harga_barang as $items):?>
		<?php
		$dtbarang       = $this->master_barang->where($items->id_barang);
		$stok 	        = $this->data_stok->where($items->id_barang);
        $keuntungan_hju = $items->hju - $items->hpp; 
        $persen_hju     = ceil((($keuntungan_hju / $items->hpp) * 100));
        $keuntungan_hjd = $items->hjd - $items->hpp; 
        $persen_hjd     = ceil((($keuntungan_hjd / $items->hpp) * 100));
		$keuntungan_hjr = $items->hjr - $items->hpp; 
        $persen_hjr     = ceil((($keuntungan_hjr / $items->hpp) * 100));
        $total_hpp 		= $items->hpp * $stok['stok_masuk'];
		?>
		<tr>
			<td style="width:5%; border: solid 1px" class="text-center"><?=$no++;?></td>
			<td style="width:23%; border: solid 1px"><?=$dtbarang['nama_barang'];?></td>
			<td style="width:7%; border: solid 1px"><?=$this->apotek->rupiah($items->hpp);?></td>
			<td style="width:8%; border: solid 1px"><?=$stok['stok_masuk'].' / '.$dtbarang['satuan'];?></td>
			<td style="width:10%; border: solid 1px">
				<?= $this->apotek->rupiah($items->hju);?>
				<small>- (<?=$persen_hju;?>%)</small>
            </td>
            <td style="width:9%; border: solid 1px">
            	<?php $sub_hju = $items->hju * $stok['stok_masuk'];?>
            	<?=$this->apotek->rupiah($sub_hju);?>
            </td>
			<td style="width:10%; border: solid 1px">
				<?=$this->apotek->rupiah($items->hjd);?>
				<small>- (<?=$persen_hjd;?>%)</small>
			</td>
			<td style="width:9%; border: solid 1px">
				<?php $sub_hjd = $items->hjd * $stok['stok_masuk'];?>
            	<?=$this->apotek->rupiah($sub_hjd);?>
            </td>
			<td style="width:10%; border: solid 1px">
				<?=$this->apotek->rupiah($items->hjr);?>
				<small>- (<?=$persen_hjr;?>%)</small>
			</td>
			<td style="width:9%; border: solid 1px">
				<?php $sub_hjr = $items->hjr * $stok['stok_masuk'];?>
            	<?=$this->apotek->rupiah($sub_hjr);?>
            </td>
		</tr>
		<?php
		$total_stok += $stok['stok_masuk'];
		$total_hju += $sub_hju;
		$total_hjd += $sub_hjd;
		$total_hjr += $sub_hjr;
		?>
		<?php endforeach;?>
        <?php endif;?>
	</tbody>
	<tfoot>
		<tr>
			<th style="border: solid 1px" colspan="3">Total</th>
			<th style="border: solid 1px"><?=$total_stok;?> Items</th>
			<th style="border: solid 1px">Total HJU</th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($total_hju);?></th>
			<th style="border: solid 1px">Total HJD</th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($total_hjd);?></th>
			<th style="border: solid 1px">Total HJR</th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($total_hjr);?></th>
		</tr>
	</tfoot>
</table>

<div class="divider"></div>
<div class="divider"></div>
<div class="divider"></div>

<table>
	<tr>
		<td class="text-right">
			<span a><?=$apotek->kota.', '.$this->apotek->date(date('Y-m-d'));?></span>
		</td>
	</tr>
	<tr>
		<td class="text-right">
			Penanggung Jawab
		</td>
	</tr>
	<tr>
		<td class="text-center">
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="divider"></div>
		</td>
	</tr>
	<tr>
		<td class="text-right"><?=$apotek->owner;?></td>
	</tr>
</table>
</page>
<?php
$content 	= ob_get_clean();
$html2pdf 	= new $this->html2pdf('L', 'F4', 'en');
$html2pdf->setDefaultFont('times');
$html2pdf->pdf->SetCreator('Anas Amu');
$html2pdf->pdf->SetAuthor('E-Apotek Online');
$html2pdf->pdf->SetTitle('E-Apotek Online');
$html2pdf->pdf->SetSubject('Laporan KARTU STOK');

// convert to PDF
$html2pdf->writeHTML($content);
$html2pdf->Output(date('Y-m-d').'-laporan-harga-barang.pdf');