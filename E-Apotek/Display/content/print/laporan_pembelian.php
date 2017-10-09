<?php
$no = 0;
$no_barang = 1;
$total_transaksi = 0;
$total_penjualan = 0;
$total_qty = 0;
$apotek 	= $this->apotek->e_apotek();
ob_start();
?>
<page backleft="10mm" backright="10mm" backtop="10mm" backbottom="10mm">
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
	<?php echo $apotek->alamat;?>
</div>
<hr/>
<div class="text-center">
	<h4>
	LAPORAN PEMBELIAN BARANG<br/>
	<small>Periode Laporan : <?=$tgl_transaksi;?></small>
	</h4>
</div>
<?php foreach ($laporan as $pembelian):?>
<?php 
$no++;
if ($pembelian->id_suplier !== 'IMPORT') 
{
	$suplier = $this->db->where('id_suplier',$pembelian->id_suplier)->get('tb_suplier');
	$suplier = $suplier->row()->suplier;
}
else
{
	$suplier = 'IMPORT DATA';
}

$user = $this->db->where('id_users',$pembelian->id_user)->get('tb_users');
?>
<div class="divider"></div>
<div class="pull-left">
Tgl Transaksi : <?=$this->apotek->date($pembelian->tgl_transaksi);?><br/>
Suplier : <?=$suplier;?><br/>
Jenis Transaksi : <?=$pembelian->jenis_transaksi;?><br/>
Operator : <?=$user->row()->username;?><br/>
</div>
<div class="text-right">
No Faktur : <?=$pembelian->no_faktur;?>
</div>

<div class="divider"></div>
<?php
	$total_sub = 0;
	$items = $this->db->where('no_faktur',$pembelian->no_faktur)
					->get('tb_cart_pembelian');
?>
<table style="width: 100%; border: solid 1px #5544DD" align="center">
	<thead>
		<tr>
			<th style="width:5%; border: solid 1px ">No</th>
			<th style="width:30%; border: solid 1px ">Nama Barang</th>
			<th style="width:5%; border: solid 1px ">QTY</th>
			<th style="width:20%; border: solid 1px ">HARGA POKOK</th>
			<th style="width:5%; border: solid 1px ">Disc</th>
			<th style="width:5%; border: solid 1px ">PPN</th>
			<th style="width:15%; border: solid 1px ">SUB TOTAL</th>
			<th style="width:15%; border: solid 1px ">Exipired Date</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($items->num_rows() > 0):?>
		<?php foreach ($items->result() as $barang):?>
		<?php
			$nama_barang = $this->master_barang->where($barang->id_barang);
		?>
		<tr>
			<td style="width:5%; border: solid 1px"><?=$no_barang++;?></td>
			<td style="width:30%; border: solid 1px"><?=$nama_barang['nama_barang'];?></td>
			<td style="width:5%; border: solid 1px" align="center"><?=$barang->qty;?></td>
			<td style="width:20%; border: solid 1px"><?=$this->apotek->rupiah($barang->harga_pokok);?></td>
			<td style="width:5%; border: solid 1px" align="center"><?=$barang->discount;?>%</td>
			<td style="width:5%; border: solid 1px" align="center"><?=$barang->ppn;?>%</td>
			<td style="width:15%; border: solid 1px" align="center"><?=$this->apotek->rupiah($barang->total_harga);?></td>
			<td style="width:15%; border: solid 1px"><?=date('d-m-Y',strtotime($barang->expired_date));?></td>
		</tr>
		<?php 
		$total_penjualan++;
		$total_qty += $barang->qty;
		$total_sub += $barang->total_harga;
		$total_transaksi += $barang->total_harga;
		?>
		<?php endforeach;?>
		<?php $no_barang = 1;?>
		<?php endif;?>
	</tbody>
	<tfoot>
        <tr>
            <th colspan="6" style="border: solid 1px ">Total</th>
            <th style="border: solid 1px"><?=$this->apotek->rupiah($total_sub);?></th>
            <th style="border: solid 1px"></th>
        </tr>
    </tfoot>
</table>
<?php endforeach;?>
<hr/>
	<h4>
	Total Faktur Pembelian : <?=$no;?><br/>
	Total Items Pembelian : <?=$total_penjualan;?><br/>
	Total Barang Masuk : <?=$total_qty;?> Items<br/>
	Total Transaksi Pembelian : <?=$this->apotek->rupiah($total_transaksi);?> 
	</h4>
	<p class="text-right">
		<?=$apotek->kota.', '.$this->apotek->date(date('Y-m-d'));?><br/>
		Penanggung Jawab<br/>
		<div class="divider"></div>
		<div class="divider"></div>
		<div class="divider"></div>
		<div class="divider"></div>
		<div class="divider"></div>
		<?=$apotek->owner;?>
	</p>
</page>

<?php
$content 	= ob_get_clean();
$html2pdf 	= new $this->html2pdf('P', 'A4', 'en');
$html2pdf->setDefaultFont('times');
$html2pdf->pdf->SetCreator('Anas Amu');
$html2pdf->pdf->SetAuthor('E-Apotek Online');
$html2pdf->pdf->SetTitle('E-Apotek Online');
$html2pdf->pdf->SetSubject('Laporan Transaksi Penjualan');

// convert to PDF
$html2pdf->writeHTML($content);
$html2pdf->Output('laporan-penjualan'.'.pdf');