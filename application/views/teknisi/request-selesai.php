<div class="content-wrapper">
   <!-- START PAGE CONTENT-->
   <div class="page-heading">
      <h1 class="page-title">Request Yang Telah Selesai</h1>
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?= base_url('Teknisi/Home'); ?>"><i class="la la-home font-20"></i></a>
         </li>
      </ol>
   </div>
   <div class="page-content fade-in-up">
      <div class="ibox">
         <div class="ibox-head">
            <div class="ibox-title">Data Request Yang Telah Selesai</div>

         </div>
         <div class="ibox">
            <?php if ($this->session->flashdata('success')): ?>
               <div class="alert alert-success">
                  <?php echo $this->session->flashdata('success'); ?>
               </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
               <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('error'); ?>
               </div>
            <?php endif; ?>
            <div class="ibox-body">
               <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0"
                  width="100%">
                  <thead class="thead-default">
                     <tr>
                        <th class="text-center">ID Request</th>
                        <th class="text-center">Nama Perangkat</th>
                        <th class="text-center">Pemilik Perangkat</th>
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
                     <?php foreach ($tickets as $ticket): ?>
                        <tr class="text-center">
                           <td>
                              <?php echo $ticket->request_id; ?>
                           </td>
                           <td>
                              <?php echo $ticket->nama_perangkat; ?>
                           </td>
                           <td>
                              <?php echo $ticket->nama; ?>
                           </td>
                           <td>
                              <?php echo $ticket->nama_departemen; ?>
                           </td>
                           <td>
                              <?php echo $ticket->tanggal_dibuat; ?>
                           </td>
                           <td>
                              <?php echo strlen($ticket->deskripsi_permasalahan) > 30 ? substr($ticket->deskripsi_permasalahan, 0, 20) . '...' : $ticket->deskripsi_permasalahan; ?>
                           </td>

                           <td>
                              <?php echo $ticket->prioritas; ?>
                           </td>
                           <td><img src="<?php echo base_url(); ?>/assets/img/request/<?php echo $ticket->foto ?>"
                                 width="45px">
                           </td>
                           <td>
                              <?php if ($ticket->status == 'PENGAJUAN'): ?>
                                 <span class="badge badge-warning">
                                    <?php echo $ticket->status; ?>
                                 </span>
                              <?php elseif ($ticket->status == 'PROSES'): ?>
                                 <span class="badge badge-default">
                                    <?php echo $ticket->status; ?>
                                 </span>
                              <?php elseif ($ticket->status == 'SELESAI'): ?>
                                 <span class="badge badge-success">
                                    <?php echo $ticket->status; ?>
                                 </span>
                              <?php elseif ($ticket->status == 'BERJALAN' || $ticket->status == 'DIPAKAI'): ?>
                                 <span class="badge badge-success">
                                    <?php echo $ticket->status; ?>
                                 </span>
                              <?php elseif ($ticket->status == 'RUSAK'): ?>
                                 <span class="badge badge-danger">
                                    <?php echo $ticket->status; ?>
                                 </span>
                              <?php endif; ?>
                           </td>
                           <td>
                              <?php echo !empty($ticket->tanggal_ditangani) ? $ticket->tanggal_ditangani : "Belum Selesai / Sedang Diproses"; ?>
                           </td>

                           <td>
                              <div class="d-flex justify-content-center">
                                 <!-- Menggunakan flexbox untuk tata letak sejajar horizontal -->
                                 <?php if ($ticket->status == 'PENGAJUAN'): ?>
                                    <a href="<?php echo base_url('index.php/Teknisi/KelolaRequest/setStatusToProses/' . $ticket->request_id); ?>" class="mr-2">
                                       <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Ubah Status ke PROSES">
                                             <i class="fa-solid fa-hourglass-start font-14"></i>
                                       </button>
                                    </a>
                                 <?php elseif ($ticket->status == 'PROSES'): ?>
                                    <a href="<?php echo base_url('index.php/Teknisi/KelolaRequest/setStatusToTampil/' . $ticket->request_id); ?>" class="mr-2">
                                       <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Tinjau Permasalahan Perangkat">
                                             <i class="fa-solid fa-check-to-slot font-14"></i>
                                       </button>
                                    </a>
                                 <?php endif; ?>
                                 <a href="<?php echo base_url('index.php/Teknisi/KelolaRequest/DetailRequest/' . $ticket->request_id); ?>" class="mr-2">
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
   <!-- END PAGE CONTENT-->