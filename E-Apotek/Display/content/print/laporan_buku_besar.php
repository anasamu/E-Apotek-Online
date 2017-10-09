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
	LAPORAN BUKU BESAR<br/>
	<small>Periode Laporan : <?=$tgl_transaksi;?></small>
	</h4>
</div>
<div class="divider"></div>
<div class="divider"></div>
<table style="width: 100%; border: solid 1px #5544DD" align="center" class="small">
	<thead>
		<tr>
			<th style="width:5%; border: solid 1px">No</th>
			<th style="width:12%; border: solid 1px">Tgl Transaksi</th>
			<th style="width:23%; border: solid 1px">Keterangan</th>
			<th style="width:15%; border: solid 1px">Operator</th>
			<th style="width:15%; border: solid 1px">Debet</th>
			<th style="width:15%; border: solid 1px">Kredit</th>
			<th style="width:15%; border: solid 1px">Saldo</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th style="border: solid 1px" colspan="6">Saldo Awal Apotek</th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($apotek->saldo_awal);?></th>
		</tr>
	<?php foreach ($laporan as $items):?>
	<?php 
	$user 	= $this->master_user->where($items->id_user);
	$saldo 	= $saldo + $items->debet - $items->kredit; 
	?>
		<tr>
			<td style="width:5%; border: solid 1px"><?=$no++;?></td>
			<td style="width:12%; border: solid 1px"><?=date('d-m-Y',strtotime($items->tgl_transaksi));?></td>
			<td style="width:23%; border: solid 1px"><?=$items->keterangan;?></td>
			<td style="width:15%; border: solid 1px"><?=$user['nama_lengkap'];?></td>
			<td style="width:15%; border: solid 1px"><?=$this->apotek->rupiah($items->debet);?></td>
			<td style="width:15%; border: solid 1px"><?=$this->apotek->rupiah($items->kredit);?></td>
			<td style="width:15%; border: solid 1px"><?=$this->apotek->rupiah($saldo);?></td>
		</tr>
	<?php 
		$debet += $items->debet;
		$kredit += $items->kredit;
	?>
	<?php endforeach?>
	<tfoot>
		<tr>
			<th colspan="4" style="border: solid 1px">Total Transaksi</th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($debet);?></th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($kredit);?></th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($saldo);?></th>
		</tr>
	</tfoot>
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
$html2pdf 	= new $this->html2pdf('L', 'F4', 'en');
$html2pdf->setDefaultFont('times');
$html2pdf->pdf->SetCreator('Anas Amu');
$html2pdf->pdf->SetAuthor('E-Apotek Online');
$html2pdf->pdf->SetTitle('E-Apotek Online');
$html2pdf->pdf->SetSubject('Laporan LABA RUGI');

// convert to PDF
$html2pdf->writeHTML($content);
$html2pdf->Output(date('Y-m-d').'-laporan-laba-rugi.pdf');