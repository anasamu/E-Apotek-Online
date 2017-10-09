<?php
$no 		= 1;
	$total 		= 0;
	$apotek 	= $this->apotek->e_apotek();
	$items 		= $this->db->where('no_faktur',$no_faktur)
					->get('tb_cart_penjualan');
	$user 		= $this->db->where('id_users',$items->row()->id_user)
							->get('tb_users');
	$struk 		= $this->db->where('no_faktur',$no_faktur)
					->get('tb_struk');
ob_start();
?>
<page backleft="5mm" backright="5mm" backtop="5mm" backbottom="5mm" >
<page_footer>
    <table style="width: 100%; border: solid 1px black; font-size: 65%;">
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
	<span style="font-size: 10pt%">
	<?php echo strtoupper($apotek->nama_apotek);?><br/>
	E-Apotek Online<br/>
	<?php echo $apotek->alamat;?>
	</span>
</div>
<hr/>
<div class="text-center">
	<h4>STRUK TRANSAKSI PENJUALAN</h4>
</div>
<div class="divider"></div>
<div align="left">
<table style="width: 100%; font-size: 75%;">
	<tr>
		<td>* No Faktur</td>
		<td> : <?php echo $no_faktur;?></td>
	</tr>
	<tr>
		<td>* Tgl Transaksi</td>
		<td> : <?php echo $this->apotek->date($items->row()->tgl_transaksi,false);?></td>
	</tr>
	<tr>
		<td>* Jenis Transaksi</td>
		<td> : <?php echo $items->row()->jenis_transaksi;?></td>
	</tr>
	<tr>
		<td>* Petugas</td>
		<td> : <?php echo $user->row()->nama_lengkap;?> / <?= $this->session->userdata('access');?></td>
	</tr>
</table>
</div>
<div class="divider"></div>

<table style="font-size: 75%; column-width: 100%; border: solid 1px #5544DD;" align="center">
			<thead>
				<tr>
					<th style="width:10%; border: solid 1px">No</th>
					<th style="width:30%; border: solid 1px">Items/Barang</th>
					<th style="width:10%; border: solid 1px">QTY</th>
					<th style="width:10%; border: solid 1px">DISC</th>
					<th style="width:20%; border: solid 1px">Harga</th>
					<th style="width:20%; border: solid 1px">Sub Total</th>
				</tr>
			</thead>
			<tbody>
<?php

	foreach ($items->result() as $items):
	$obat = $this->db->where('id_obat',$items->id_barang)
					->get('tb_data_obat');
?>
				<tr>
					<td class="small" style="width:10%; border: solid 1px"><?php echo $no++;?></td>
					<td class="small" style="width:30%; border: solid 1px"><?php echo $obat->row()->nama_obat;?></td>
					<td class="small" style="width:10%; border: solid 1px"><?php echo $items->qty;?></td>
					<td class="small" style="width:10%; border: solid 1px"><?php echo $items->discount;?>%</td>
					<td class="small" style="width:20%; border: solid 1px"><?php echo $this->apotek->rupiah($items->harga_jual);?></td>
					<td class="small" style="width:20%; border: solid 1px"><?php echo $this->apotek->rupiah($items->sub_total);?></td>
				</tr>
<?php
	endforeach;
?>
			</tbody>
</table>
<div class="divider"></div>	
<p class="small">
	Grand Total : <?= $this->apotek->rupiah($struk->row()->total_harga);?><br/>
	Dibayar : <?= $this->apotek->rupiah($struk->row()->dibayar);?><br/>
	Kembali : <?= $this->apotek->rupiah($struk->row()->kembalian);?>
</p>
<div class="divider"></div>	
<div align="center">
	<small><?= nl2br($apotek->slogan);?></small>
</div>
</page>

<?php
$content 	= ob_get_clean();
$html2pdf = new $this->html2pdf('P', 'A6', 'en', true, 'UTF-8');

$html2pdf->setDefaultFont('times');
$html2pdf->pdf->SetCreator('Anas Amu');
$html2pdf->pdf->SetAuthor('E-Apotek Online');
$html2pdf->pdf->SetTitle('E-Apotek Online');
$html2pdf->pdf->SetSubject('Transaksi Penjualan');
$html2pdf->pdf->IncludeJS("print(true);");

// convert to PDF
$html2pdf->writeHTML($content);
$html2pdf->Output($no_faktur.'.pdf');