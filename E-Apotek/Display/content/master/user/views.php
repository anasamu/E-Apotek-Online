<?php 
	echo $this->session->flashdata('message');
	// menampilkan data dari tabel login access
	$items = $this->master_user->where($this->uri->segment(4));
	$query = $this->db->where('id_login',$items['type'])
						->get('tb_login_access');
	$login_type = $query->row()->login_type;
?>
<div class="col-md-12">
	<ul class="nav nav-tabs">
		<li class="active"><a aria-expanded="true" href="#default-tab-1" data-toggle="tab">Profil User</a></li>
		<li class=""><a aria-expanded="false" href="#default-tab-2" data-toggle="tab">Riwayat Aktifitas</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade active in" id="default-tab-1">
			<div class="row">
				<div class="col-md-6">
					<table class="table">
						<tr>
							<td rowspan="7">
								<img height="200px" class="img" src="<?php echo base_url('assets/img/user/'.$items["foto"]);?>">
							</td>
						</tr>
						<tr>
							<th>ID USER</th>
							<td><strong><?php echo $items['id'];?></strong></td>
						</tr>
						<tr>
							<th>Username</th>
							<td><strong><?php echo $items['username'];?></strong></td>
						</tr>
						<tr>
							<th>Login Access</th>
							<td><strong><?php echo $login_type;?></strong></td>
						</tr>
						<tr>
							<th>Nama Lengkap</th>
							<td><strong><?php echo $items['nama_lengkap'];?></strong></td>
						</tr>
						<tr>
							<th>Alamat</th>
							<td><strong><?php echo $items['alamat'];?></strong></td>
						</tr>
					</table>
				</div>
			</div>
			<p class="text-right">
				<a href="<?php echo base_url('master/user');?>" class="btn btn-white m-r-5">Kembali</a>
			</p>
		</div>

		<div class="tab-pane fade" id="default-tab-2">
		<?php
			// menampilkan data dari tabel logs
			$query = $this->db->where('id_users',$items['id'])
								->order_by('date','DESC')
								->get('tb_logs_user');
			$no = 1;
		?>	
			<?php echo form_open('master/logs/delete');?>
			<input type="hidden" name="id_users" value="<?php echo $items['id'];?>">
			<table id="data-table" class="table table-striped table-hover table-responsive table-bordered">
				<thead>
					<tr>
						<th>NO</th>
						<th>Menu Akses</th>
						<th>Riwayat Aktifitas</th>
						<th>Logs Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($query->num_rows() > 0):?>
					<?php foreach ($query->result() as $logs):?>
					<tr>
						<td><?php echo $no++;?></td>
						<td><?php echo $logs->menu_access;?></td>
						<td><?php echo $logs->keterangan;?></td>
						<td><?php echo $this->apotek->date($logs->date,TRUE);?></td>
					</tr>
					<?php endforeach;?>
					<?php else:?>
					<tr>
						<td colspan="4">Daftar Riwayat Aktifitas User masih kosong</td>
					</tr>
					<?php endif;?>
				</tbody>
			</table>
			<p class="text-right">
				<a href="<?php echo base_url('master/user');?>" class="btn btn-white m-r-5">Kembali</a>
			</p>
			<?php echo form_close();?>
		</div>
	</div>
</div>