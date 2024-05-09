<div class="content-wrapper">
   <!-- START PAGE CONTENT-->
   <div class="page-heading">
      <h1 class="page-title">Kelola Request</h1>
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?= base_url('Karyawan/Home'); ?>"><i class="la la-home font-20"></i></a>
         </li>
      </ol>
   </div>
   <div class="page-content fade-in-up">
      <div class="ibox">
         <div class="ibox-head">
            <div class="ibox-title">Data Request</div>
            <a href="<?= base_url()?>index.php/Karyawan/KelolaRequest/tampilTambahRequest">
            <button class="btn btn-primary" type="submit">Buat Request</button>
            </a>
         </div>
         <div class="ibox">
            <?php if ($this->session->flashdata('success')): ?>
               <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
               <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <div class="ibox-body">
               <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                  <thead class="thead-default">
                     <tr>
                        <th class="text-center">ID Request</th>
                        <th class="text-center">Nama Perangkat</th>
                        <th class="text-center">Perbaikan Oleh</th>
                        <th class="text-center">Unit Kerja</th>
                        <th class="text-center">Tanggal Pelaporan</th>
                        <th class="text-center">Deskripsi Masalah</th>
                        <th class="text-center">Prioritas</th>
                        <th class="text-center">Gambar Kerusakan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Penyelesaian</th>
                        <th class="text-center">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($tickets as $ticket) : ?>
                        <tr class="text-center">
                           <td><?php echo $ticket->request_id; ?></td>
                           <td><?php echo $ticket->nama_perangkat; ?></td>
                           <td>
                              <?php
                              if (!empty($ticket->nama_penanggung_jawab)) {
                                 echo $ticket->nama_penanggung_jawab;
                              } else {
                                 echo "Belum Ada";
                              }
                              ?>
                           </td>
                           <td><?php echo $ticket->nama_departemen ; ?></td>
                           <td><?php echo $ticket->tanggal_dibuat; ?></td>
                           <td><?php echo strlen($ticket->deskripsi_permasalahan) > 30 ? substr($ticket->deskripsi_permasalahan, 0, 20) . '...' : $ticket->deskripsi_permasalahan; ?></td>
                           <td><?php echo $ticket->prioritas; ?></td>
                           <td><img src="<?php echo base_url(); ?>/assets/img/request/<?php echo $ticket->foto?>" width="45px">
                           </td>
                           <td>
                              <?php if ($ticket->status == 'PENGAJUAN'): ?>
                                 <span class="badge badge-warning"><?php echo $ticket->status; ?></span>
                              <?php elseif ($ticket->status == 'PROSES'): ?>
                                 <span class="badge badge-default"><?php echo $ticket->status; ?></span>
                              <?php elseif ($ticket->status == 'SELESAI'): ?>
                                 <span class="badge badge-success"><?php echo $ticket->status; ?></span>
                              <?php elseif ($ticket->status == 'BERJALAN' || $ticket->status == 'DIPAKAI'): ?>
                                 <span class="badge badge-success"><?php echo $ticket->status; ?></span>
                              <?php else: ?>
                                 <span class="badge badge-danger"><?php echo $ticket->status; ?></span>
                              <?php endif; ?>
                           </td>
                           <td>
                              <?php
                              if (empty($ticket->tanggal_ditangani) && $ticket->status === 'DIBATALKAN') {
                                 echo 'Request Dibatalkan';
                              } elseif (empty($ticket->tanggal_ditangani)) {
                                 echo 'Belum Selesai / Sedang DiTangani';
                              } else {
                                 echo $ticket->tanggal_ditangani;
                              }
                              ?>
                           </td>


                           <td>
                              <div class="d-flex justify-content-center">
                                 <!-- Menggunakan flexbox untuk tata letak sejajar horizontal -->
                                 <?php if ($ticket->status == 'SELESAI'): ?>
                                    <a href="<?php echo base_url('index.php/Karyawan/KelolaRequest/setStatusToBerjalan/'.$ticket->request_id); ?>" class="mr-2">
                                       <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Perangkat Telah Berjalan Sepenuhnya">
                                             <i class="fa-solid fa-check-to-slot font-14"></i>
                                       </button>
                                    </a>
                                 <?php elseif ($ticket->status == 'PENGAJUAN'): ?>
                                    <a href="<?php echo base_url('index.php/Karyawan/KelolaRequest/tampilEditRequest/'.$ticket->request_id); ?>" class="mr-2">
                                       <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Edit">
                                             <i class="fa fa-pencil font-14"></i>
                                       </button>
                                    </a>
                                    <div class="mr-2">
                                       <button 
                                          class="btn btn-default btn-xs btnBatalRequest" 
                                          data-toggle="modal"
                                          data-target="#batalRequest" 
                                          data-original-title="Batalkan Request" 
                                          data-requestid="<?= $ticket->request_id ?>"
                                          data-namaperangkat="<?= $ticket->nama_perangkat ?>
                                       ">
                                          <i class="fa-solid fa-rectangle-xmark font-14"></i>
                                       </button>
                                    </div>
                                 <?php endif; ?>

                                 <?php if ($ticket->status === 'BERJALAN' || $ticket->status === 'DIPAKAI'): ?>
                                    <!-- <a href="<?php echo base_url('index.php/Karyawan/KelolaRequest/BatalkanRequest/' . $ticket->request_id); ?>" class="mr-2">
                                       <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Batalkan Request">
                                             <i class="fa-solid fa-rectangle-xmark font-14"></i>
                                       </button>
                                    </a> -->
                                 <?php endif; ?>

                                 <a href="<?php echo base_url('index.php/Karyawan/KelolaRequest/DetailRequest/' . $ticket->request_id); ?>" class="mr-2">
                                    <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Detail Permasalahan">
                                    <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                 </a>


                              </div>
                           </td>

                        </tr>
                        <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
       <!-- Modal Batal Request -->
       <div class="modal fade" id="batalRequest" tabindex="-1" role="dialog" aria-labelledby="hapusPerangkatLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusPerangkatLabel">Konfirmasi Batal Request?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin membatalkan Request dengan ID Request "<span id="id_request_modal"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <a id="hapus_perangkat_button" class="btn btn-danger" href="">Ya, Batalkan Request</a>
                </div>
            </div>
        </div>
   <!-- END PAGE CONTENT-->
</div>