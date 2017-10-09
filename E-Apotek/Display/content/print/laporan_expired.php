<?php
$no 	= 1;
$debet 	= 0;
$kredit = 0;
$apotek = $this->apotek->e_apotek();
$saldo 	= $apotek->saldo_awal;
ob_start();
?>
<page backleft="10mm" backright="10mm" backtop="10mm" backbottom="15mm">
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
	LAPORAN BARANG EXPIRED DATE<br/>
	<small>Periode Laporan : <?=$tgl_transaksi;?></small>
	</h4>
</div>
<div class="divider"></div>
<div class="divider"></div>
<table style="width: 100%; border: solid 1px #5544DD" align="center" class="small">
	<thead>
		<tr>
			<th style="width:5%; border: solid 1px">No</th>
			<th style="width:10%; border: solid 1px">ID BELI</th>
			<th style="width:15%; border: solid 1px">Lokasi</th>
			<th style="width:30%; border: solid 1px">Nama Barang</th>
			<th style="width:10%; border: solid 1px">QTY</th>
			<th style="width:15%; border: solid 1px">Expired Date</th>
			<th style="width:15%; border: solid 1px">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($laporan as $items):?>
	<?php 
	$lokasi 		= $this->master_barang->lokasi_barang($items->id_lokasi);
	$barang 		= $this->master_barang->where($items->id_barang);
	$expired 		= date('d-m-Y',strtotime($items->expired_date));
	$tgl_sekarang 	= date('d-m-Y'); 
	if (strtotime($expired) < strtotime($tgl_sekarang)) 
	{
		$status = '<span class="text-danger">TELAH EXPIRED</span>';
	}
	else
	{
		$status = 'belum expired';
	}

	?>
		<tr>
			<td style="width:5%; border: solid 1px"><?=$no++;?></td>
			<td style="width:10%; border: solid 1px"><?=$items->id_beli;?></td>
			<td style="width:15%; border: solid 1px"><?=$lokasi->nama_lokasi;?></td>
			<td style="width:30%; border: solid 1px"><?=$barang['nama_barang'];?></td>
			<td style="width:10%; border: solid 1px"><?=$items->qty.' '.$barang['satuan'];?></td>
			<td style="width:15%; border: solid 1px"><?=$expired;?></td>
			<td style="width:15%; border: solid 1px"><?=$status;?></td>
		</tr>
	<?php endforeach?>
	</tbody>
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
$html2pdf->pdf->SetSubject('Laporan Expired Date');

// convert to PDF
$html2pdf->writeHTML($content);
$html2pdf->Output(date('Y-m-d').'-laporan-expired-date.pdf');