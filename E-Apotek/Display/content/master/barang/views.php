<?php
$id_obat  = $this->uri->segment(4);
$query    = $this->db->where('id_obat',$id_obat)
                    ->get('tb_data_obat');
if ($query->num_rows() > 0)
{
    $obat = $query->row();
}
else
{
    $obat = '';
}

 ?>

<!-- begin profile-container -->
      <div class="profile-container">
          <!-- begin profile-section -->
          <div class="profile-section">
              <!-- begin profile-left -->
              <div class="profile-left">
                  <!-- begin profile-image -->
                  <div class="profile-image">
                      <img src="<?php echo base_url('assets/img/obat/'.$obat->foto);?> " />
                      <i class="fa fa-user hide"></i>
                  </div>
                  <!-- end profile-image -->
                  <!-- begin profile-highlight -->
                    <?php

                      $Jenis = $this->db->where('id_jenis_obat',$obat->id_jenis)
                                  ->get('tb_jenis_obat');
                      if ($Jenis->num_rows() > 0)
                      {
                        echo "
                              <div class='navbar-user'>
                                <img src='".base_url('assets/img/product/'.$Jenis->row()->icon)."' height='50px' class='img img-circle'/><strong>"
                                .$Jenis->row()->nama_jenis_obat.
                              "</strong></div>";
                      }
                      else
                      {
                        echo "Jenis obat tidak ditemukan";
                      }?>
                  <!-- end profile-highlight -->
              </div>
              <!-- end profile-left -->
              <!-- begin profile-right -->
              <div class="profile-right">
                  <!-- begin profile-info -->
                  <div class="profile-info">
                      <!-- begin table -->
                      <div class="table-responsive">
                          <table class="table table-profile">
                              <tbody>
                                  <tr class="highlight">
                                      <td colspan="2"><h4>Informasi Obat :</h4></td>
                                  </tr>
                                  <tr class="divider">
                                      <td colspan="2"></td>
                                  </tr>
                                  <tr>
                                      <td class="field">ID OBAT</td>
                                      <td><?php echo $obat->id_obat;?></td>
                                  </tr>
                                  <tr>
                                      <td class="field">NAMA OBAT</td>
                                      <td><?php echo $obat->nama_obat;?></td>
                                  </tr>
                                  <tr>
                                	<td class="field">SATUAN OBAT</td>
                                  <?php
                                  $satuan = $this->db->where('id_satuan',$obat->id_satuan)
                                              ->get('tb_satuan_obat');
                                  if ($satuan->num_rows() > 0) 
                                  {
                                    echo "<td>".$satuan->row()->nama_satuan_obat."</td>";
                                  }
                                  else
                                  {
                                    echo "<td>-</td>";
                                  }
                                  ?>
                                  </tr>
                                  <tr>
                                      <td class="field">KATEGORI</td>
                                <?php

                                $Kategori = $this->db->where('id_kategori',$obat->id_kategori)
                                										->get('tb_kategori_obat');
                                					
                  								if ($Kategori->num_rows() > 0) 
                  								{
                  									echo "<td>".$Kategori->row()->nama_kategori."</td>";
                  								}
                  								else
                  								{
                  									echo "<td>-</td>";
                  								}?>
                                  </tr>

                                  <tr>
                                      <td class="field">DATE CREATE</td>
                                      <td><?php echo $this->apotek->date($obat->date,FALSE);?></td>
                                  </tr>
                                  <tr>
                                      <td class="field">USER CREATE</td>
                                      <td><?php echo $obat->id_user;?></td>
                                  </tr>
                                  <tr>
                                      <td class="field">KETERANGAN</td>
                                      <td><?php echo nl2br($obat->keterangan); ?></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                      <!-- end table -->
                  </div>
                  <!-- end profile-info -->
              </div>
              <a href="<?php echo base_url('master/barang');?>" class="btn btn-white">Kembali</a>
              <!-- end profile-right -->
          </div>
          <!-- end profile-section -->
      </div>
<!-- end profile-container -->
