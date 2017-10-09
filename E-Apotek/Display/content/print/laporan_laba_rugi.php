<?php
$no 	= 1;
$debet 	= 0;
$kredit = 0;
$apotek 	= $this->apotek->e_apotek();
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
	LAPORAN LABA RUGI<br/>
	<small>Periode Laporan : <?=$tgl_transaksi;?></small>
	</h4>
</div>
<div class="divider"></div>
<div class="divider"></div>
<table style="width: 100%; border: solid 1px #5544DD" align="center">
	<thead>
		<tr>
			<th style="width:5%; border: solid 1px ">No</th>
			<th style="width:15%; border: solid 1px ">Tgl Transaksi</th>
			<th style="width:30%; border: solid 1px ">Nama Akun</th>
			<th style="width:20%; border: solid 1px ">Jenis</th>
			<th style="width:15%; border: solid 1px ">Debet</th>
			<th style="width:15%; border: solid 1px ">Kredit</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($laporan->result() as $items):?>
		<tr>
			<td style="width:5%; border: solid 1px"><?=$no++;?></td>
			<td style="width:15%; border: solid 1px"><?=date('d-m-Y',strtotime($items->tgl_transaksi));?></td>
			<td style="width:30%; border: solid 1px"><?=$items->akun;?></td>
			<td style="width:20%; border: solid 1px"><?=$items->jenis;?></td>
			<td style="width:15%; border: solid 1px"><?=$this->apotek->rupiah($items->debet);?></td>
			<td style="width:15%; border: solid 1px"><?=$this->apotek->rupiah($items->kredit);?></td>
		</tr>
	<?php 
		$debet += $items->debet;
		$kredit += $items->kredit;
		$laba_rugi = $debet - $kredit;
		$persen_laba_rugi = (($laba_rugi / $kredit) * 100);
	?>
	<?php endforeach?>
	<tfoot>
		<tr>
			<th colspan="4" style="border: solid 1px">Total Transaksi</th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($debet);?></th>
			<th style="border: solid 1px"><?=$this->apotek->rupiah($kredit);?></th>
		</tr>
	</tfoot>
	</tbody>
</table>
<div class="divider"></div>
<h4>Laporan Laba Rugi : <?=$this->apotek->rupiah($laba_rugi);?> (<?=  floor($persen_laba_rugi);?> %)</h4>
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
$html2pdf->pdf->SetSubject('Laporan LABA RUGI');

// convert to PDF
$html2pdf->writeHTML($content);
$html2pdf->Output(date('Y-m-d').'-laporan-laba-rugi.pdf');