<?php
$no = 0;
$no_barang = 1;
$total_transaksi = 0;
$total_penjualan = 0;
$total_qty = 0;
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
	<h4>
	LAPORAN KARTU STOK<br/>
	<small>Periode Laporan : <?=$tgl_transaksi;?></small>
	</h4>
</div>
<div class="divider"></div>
<div class="pull-left">
<?php $barang = $this->master_barang->where($id_barang);?>
ID BARANG : <?=$barang['id'];?><br/>
NAMA BARANG : <?=$barang['nama_barang'];?><br/>
</div>
<div class="divider"></div>
<table style="width: 100%; border: solid 1px #5544DD">
	<thead>
		<tr>
			<th style="width:5%; border: solid 1px">No</th>
			<th style="width:11%; border: solid 1px">Tanggal</th>
			<th style="width:23%; border: solid 1px">No Faktur</th>
			<th style="width:23%; border: solid 1px">Keterangan</th>
			<th style="width:9%; border: solid 1px" class="text-center small">STOK MASUK</th>
			<th style="width:9%; border: solid 1px" class="text-center small">STOK KELUAR</th>
			<th style="width:8%; border: solid 1px" class="text-center small">SISA STOK</th>
			<th style="width:10%; border: solid 1px" class="text-center">Operator</th>
		</tr>
	</thead>
	<tbody>
<?php
	$no = 1;
	$sisa = 0;
	$total_masuk = 0;
	$total_keluar = 0;
	$total = 0;	
?>
	<?php if ($kartu_stok !== FALSE) :?>
	<?php foreach ($kartu_stok as $items):?>
	<?php 
		$user = $this->master_user->where($items->id_user);
		$sisa = $sisa + $items->masuk - $items->keluar;
	?>
		<tr>
			<td class="text-center small" style="width:5%;  border: solid 1px">
				<?=$no++;?>
			</td>		
			<td class="text-center small" style="width:11%; border: solid 1px">
				<?= date('d-m-Y',strtotime($items->tgl_transaksi));?>
			</td>
			<td class="small" style="width:23%; border: solid 1px">
				<?=$items->no_faktur;?>
			</td>
			<td class="small" style="width:23%; border: solid 1px">
				<?=$items->keterangan;?>
			</td>
			<td class="text-center small" style="width:9%; border: solid 1px">
				<?=$items->masuk;?>
			</td>
			<td class="text-center small" style="width:9%; border: solid 1px">
				<?=$items->keluar;?>
			</td>
			<td class="text-center small" style="width:8%; border: solid 1px">
				<?=$sisa;?>
			</td>
			<td class="text-center small" style="width:12%; border: solid 1px">
				<?=$user['nama_lengkap'];?>
			</td>
		</tr>
	<?php
		$total_masuk 	+= $items->masuk;
		$total_keluar 	+= $items->keluar;
		$total 			= $total_masuk - $total_keluar;
	?>
	<?php endforeach;?>
	<?php endif;?>
	</tbody>
	<tfoot>
		<tr>
			<th class="small" style="border: solid 1px" colspan="4">
				TOTAL KARTU STOK : <?=$barang['nama_barang'];?>
			</th>
			<th class="text-center small" style="border: solid 1px"><?=$total_masuk;?></th>
			<th class="text-center small" style="border: solid 1px"><?=$total_keluar;?></th>
			<th class="text-center small" style="border: solid 1px"><?=$total;?></th>
			<th style="border: solid 1px"></th>
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
$html2pdf 	= new $this->html2pdf('P', 'A4', 'en');
$html2pdf->setDefaultFont('times');
$html2pdf->pdf->SetCreator('Anas Amu');
$html2pdf->pdf->SetAuthor('E-Apotek Online');
$html2pdf->pdf->SetTitle('E-Apotek Online');
$html2pdf->pdf->SetSubject('Laporan KARTU STOK');

// convert to PDF
$html2pdf->writeHTML($content);
$html2pdf->Output(date('Y-m-d').'-laporan-kartu-stok-'.$id_barang.'.pdf');