<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="ibox bg-success color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php echo $jml_fixed ?>
                        </h2>
                        <div class="m-b-5">TOTAL REQUEST SELESAI</div><i
                            class="fa-solid fa-screwdriver-wrench widget-stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="ibox bg-warning color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php echo $jml_pending ?>
                        </h2>
                        <div class="m-b-5">TOTAL REQUEST PENGAJUAN</div><i
                            class="fa-solid fa-list-check widget-stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="ibox bg-danger color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php echo $jml_notfixed ?>
                        </h2>
                        <div class="m-b-5">TOTAL REQUEST RUSAK</div><i
                            class="fa-solid fa-circle-exclamation widget-stat-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="ibox bg-default color-black widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">
                            <?php echo $jml_pesan ?>
                        </h2>
                        <div class="m-b-5">PESAN LANGSUNG DILAYANI</div><i
                            class="fa fa-comments widget-stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">DAFTAR REQUEST</div>
                        <!-- <div>
                                    <a class="btn btn-info btn-sm" href="javascript:;">Buat Request</a>
                                </div> -->
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="tambah-request.html" class="dropdown-item">Buat Request</a>
                                <a href="kelola-request.html" class="dropdown-item">Lihat Semua Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Permasalahan</th>
                                    <th>Perangkat</th>
                                    <th>Status</th>
                                    <th width="91px">Tanggal Penyelesaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < min(5, count($tickets)); $i++): ?>
                                    <?php $ticket = $tickets[$i]; ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url()?>index.php/Teknisi/KelolaRequest/DetailRequest/<?=$ticket->request_id?>">
                                                <?php echo $ticket->request_id ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $ticket->deskripsi_permasalahan ?>
                                        </td>
                                        <td>
                                            <?php echo $ticket->nama_perangkat ?>
                                        </td>
                                        <td>
                                            <?php if ($ticket->status == 'PENGAJUAN'): ?>
                                                <span class="badge badge-warning"><?php echo $ticket->status; ?></span>
                                            <?php elseif ($ticket->status == 'SELESAI'): ?>
                                                <span class="badge badge-success"><?php echo $ticket->status; ?></span>
                                                <?php elseif ($ticket->status == 'PROSES'): ?>
                                                <span class="badge badge-default"><?php echo $ticket->status; ?></span>
                                            <?php elseif ($ticket->status == 'BERJALAN' || $ticket->status == 'DIPAKAI'): ?>
                                                <span class="badge badge-success"><?php echo $ticket->status; ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-danger"><?php echo $ticket->status; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo !empty($ticket->tanggal_ditangani) ? $ticket->tanggal_ditangani : "Belum Selesai"; ?>
                                        </td>
                                    </tr>
                                <?php endfor; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Daftar Live Chat</div>
                    </div>
                    <div class="ibox-body">
                        <ul class="media-list media-list-divider m-0">
                            <?php for ($i = 0; $i < min(4, count($list_chat)); $i++): ?>
                                <?php $item = $list_chat[$i]; ?>
                                <li class="media">
                                    <a class="media-img" href="javascript:;">
                                        <img src="<?php echo base_url(); ?>./assets/img/users/<?= $item->foto_user?>"
                                            width="50px;" />
                                    </a>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <a href="javascript:;">
                                                <?php echo $item->sender_nama ?>
                                            </a>
                                            <?php if ($item->status == 'open'): ?>
                                                <span class="font-16 float-right badge badge-warning"><?= strtoupper($item->status); ?></span>
                                            <?php elseif ($item->status == 'taken'): ?>
                                                <span class="font-16 float-right badge badge-success"><?= strtoupper($item->status); ?></span>
                                            <?php else: ?>
                                                <span class="font-16 float-right badge badge-danger"><?= strtoupper($item->status); ?></span>
                                            <?php endif; ?>

                                        </div>
                                        <div class="font-13">
                                            <?php if (!empty( $item->receiver_nama)):?>
                                                Oleh <?php echo $item->receiver_nama ?>
                                            <?php else: ?>
                                                <?php echo $item->nama_departemen ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <div class="ibox-footer text-center">
                        <a href="<?= base_url() ?>index.php/KelolaPesan">Lihat Semua Live Chat</a>
                    </div>
                </div>
            </div>
        </div>

    </div>