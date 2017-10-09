<?php

$apotek             = $this->apotek->e_apotek();
$debet              = 0;
$kredit             = 0;
$waktu_sekarang     = time();
$minggu_lalu        = $waktu_sekarang - 31 * 24 * 60 * 60;
$tgl_start          = date('Y-m-d',$minggu_lalu);
$tgl_end            = date('Y-m-d',$waktu_sekarang);
$transaksi          = $this->db->where('tgl_transaksi >=',$tgl_start)
                                ->where('tgl_transaksi <=',$tgl_end)
                                ->get('tb_data_transaksi');
if ($transaksi->num_rows() > 0) 
{
    foreach ($transaksi->result() as $items) 
    {
        $debet  += $items->debet;
        $kredit += $items->kredit;
    }
}

    $in     = $this->apotek->rupiah($debet);
    $out    = $this->apotek->rupiah($kredit);

    $debet1 = 0;
    $kredit2 = 0;
    $transaksi_lalu     = $minggu_lalu - 31 * 24 * 60 * 60;
    $tgl_start1         = date('Y-m-d',$transaksi_lalu);
    $tgl_end1           = date('Y-m-d',strtotime($tgl_start));
    $transaksi          = $this->db->where('tgl_transaksi >=',$tgl_start1)
                                    ->where('tgl_transaksi <=',$tgl_end1)
                                    ->get('tb_data_transaksi');
if ($transaksi->num_rows() > 0) 
{
    foreach ($transaksi->result() as $items) 
    {
        $debet1  += $items->debet;
        $kredit2 += $items->kredit;
    }
}
    
    if ($debet > 0) 
    {
        $hasil_debet    = $debet - $debet1;
        $persen_debet   = ceil((($hasil_debet / $debet) * 100));
    }
    else
    {
        $persen_debet = 0;
    }

    if ($kredit > 0) 
    {
        $hasil_kredit   = $kredit - $kredit2;
        $persen_kredit  = ceil((($hasil_kredit / $kredit) * 100));
    }
    else
    {
        $persen_kredit = 0;
    }
    
?>
<div class="col-md-4 col-sm-6">
    <div class="widget widget-stats bg-green">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
        <div class="stats-title">Total Uang Masuk dalam 31 Hari</div>
        <div class="stats-number"><?=$in;?></div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width:<?=$persen_debet;?>%;"></div>
        </div>
        <div class="stats-desc">
        Dibandingkan Bulan Lalu <?=$this->apotek->rupiah($debet1);?> (<?=$persen_debet;?>%)
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-6">
    <div class="widget widget-stats bg-green">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
        <div class="stats-title">Total Uang Keluar dalam 31 Hari</div>
        <div class="stats-number"><?=$out;?></div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width:<?=$persen_kredit;?>%;"></div>
        </div>
        <div class="stats-desc">
        Dibandingkan Bulan Lalu <?=$this->apotek->rupiah($kredit2);?> (<?=$persen_kredit;?>%)
        </div>
    </div>
</div>
<?php

$laba   = $debet - $kredit;
if ($laba > 0) 
{
    $persen_laba    = ceil((($laba / $debet) * 100));
    if ($persen_laba > 0) 
    {
        $items = 'Laba';
    }
    else
    {
        $items = 'Rugi';
    }
}
else
{
    $persen_laba = 0;
    $items = 'Laba';
}

$laba2           = $debet1 - $kredit2;
if ($laba2 > 0) 
{
    $persen_laba2    = ceil((($laba2 / $debet1) * 100));
    if ($persen_laba2 > 0) 
    {
        $items2 = 'Laba';
    }
    else
    {
        $items2 = 'Rugi';
    }
}
else
{
    $persen_laba2 = 0;
    $items2 = 'Laba';
}



?>
<div class="col-md-4 col-sm-6">
    <div class="widget widget-stats bg-green">
        <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
        <div class="stats-title">Keuntungan 31 Hari</div>
        <div class="stats-number"><?=$items;?> <?=$persen_laba;?>%</div>
        <div class="stats-progress progress">
            <div class="progress-bar" style="width:<?=$persen_laba;?>%;"></div>
        </div>
        <div class="stats-desc">
        Dibandingkan Keuntungan Bulan Lalu : <?=$items2;?> <?=$persen_laba2;?>%
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><?=$apotek->nama_apotek;?></h4>
        </div>
        <div class="panel-body">
            <h4>Selamat datang di E-Apotek Online.</h4>
            <hr/>
            <h4>Rincian Apotek</h4>
            <table>
                <tr>
                    <td>NO SIPA </td>
                    <td>: <strong><?=$apotek->no_sipa;?></strong></td>
                </tr>
                <tr>
                    <td>Nama Apotek </td>
                    <td>: <strong><?=$apotek->nama_apotek;?></strong></td>
                </tr>
                <tr>
                    <td>Penanggung Jawab </td>
                    <td>: <strong><?=$apotek->owner;?></td>
                </tr>
            </table>
            <hr/>
            <div class="note note-success">
                <h4>DEMO APLIKASI</h4>
                <p>Untuk percobaan DEMO aplikasi E-Apotek Online sampai dengan : <strong>20 September 2017</strong><br/>
                Jika masa percobaan telah habis, maka akan kembali ke installasi awal & semua data yg tersimpan akan dihapus secara otomatis.</p>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Riwayat Aktifitas Terakhir</h4>
        </div>
        <div class="panel-body">
        <p>Menampilkan Riwayat aktifitas selama 30 hari sebelumnya.</p>
<?php
    // menampilkan data dari tabel logs
    $user  = $this->apotek->users();
    $tgl_logs = date('Y-m-d H:i:s', strtotime($tgl_start));
    $items = $this->master_user->where($user->id_users);
    $query = $this->db->where('id_users',$items['id'])
                        ->where('date >=',$tgl_logs)
                        ->order_by('date','DESC')
                        ->get('tb_logs_user');
    $no = 1;
?>  
            <table id="data-table" class="table table-striped table-hover table-responsive table-bordered small">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Riwayat Aktifitas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($query->num_rows() > 0):?>
                    <?php foreach ($query->result() as $logs):?>
                    <tr>
                        <td><?php echo $no++;?></td>
                        <td><?php echo $logs->keterangan;?></td>
                    </tr>
                    <?php endforeach;?>
                    <?php else:?>
                    <tr>
                        <td colspan="4">Daftar Riwayat Aktifitas User masih kosong</td>
                    </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>