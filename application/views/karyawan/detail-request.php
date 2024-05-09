<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-heading">
        <h1 class="page-title">Perbaikan Perangkat dengan Nomer Request: <?php echo $supportticket->request_id; ?></h1>
        <ol class="breadcrumb"> 
            <li class="breadcrumb-item font-strong"></li>     
        </ol>

    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        <div class="m-t-20">
                            <div style="width: 230px; height: 230px; overflow: hidden; ">
                                <img src="<?php echo base_url(); ?>./assets/img/request/<?php echo $supportticket->foto; ?>" alt="User Foto" style="width: 100%; height: 100%; object-fit: cover; ">
                            </div>
                                <label class="font-bold mt-4">Status Perangkat</label>
                            <div class="m-b-20 text-muted">
                            <?php if ($supportticket->status == 'PENGAJUAN'): ?>
                                 <span class="badge badge-warning"><?php echo $supportticket->status; ?></span>
                              <?php elseif ($supportticket->status == 'PROSES'): ?>
                                 <span class="badge badge-default"><?php echo $supportticket->status; ?></span>
                              <?php elseif ($supportticket->status == 'SELESAI'): ?>
                                 <span class="badge badge-success"><?php echo $supportticket->status; ?></span>
                              <?php elseif ($supportticket->status == 'BERJALAN' || $supportticket->status == 'DIPAKAI'): ?>
                                 <span class="badge badge-success"><?php echo $supportticket->status; ?></span>
                              <?php else: ?>
                                 <span class="badge badge-danger"><?php echo $supportticket->status; ?></span>
                              <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-1">
                                <div class="row">
                                    <div class="col-md-12" style="border-right: 1px solid #eee;">
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Nomer Seri Perangkat</label>
                                                    <p class="font-strong"><?php echo $supportticket->nomer_seri; ?></p>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Nama Perangkat</label>
                                                    <p class=""><?php echo $supportticket->nama_perangkat; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Pengguna Perangkat</label>
                                                    <p class=""><?php echo $supportticket->nama_user; ?></p>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Unit Kerja</label>
                                                    <p class=""><?php echo $supportticket->nama_departemen; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Tanggal Request Dibuat</label>
                                                    <p class=""><?php echo $supportticket->tanggal_dibuat; ?></p>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Tanggal Ditangani</label>
                                                    <p class=""><?php echo !empty($supportticket->tanggal_ditangani) ? $supportticket->tanggal_ditangani : "Belum Selesai / Sedang DiTangani"; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Skala Prioritas</label>
                                                    <p class=""><?php echo $supportticket->prioritas; ?></p>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Penanggung Jawab Perbaikan</label>
                                                    <p class=""><?php echo !empty($supportticket->penanggung_jawab) ? $supportticket->penanggung_jawab : "Belum Selesai / Sedang DiTangani"; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Penanggung Jawab Perbaikan</label>
                                                    <p class=""><?php echo !empty($supportticket->penanggung_jawab) ? $supportticket->penanggung_jawab : "Belum Selesai / Sedang DiTangani"; ?></p>
                                                </div>
                                            </div>
                                            <?php if (!empty($supportticket->ipaddress)): ?>
                                            <div class="form-group">
                                                <label class="font-bold">IP Address Perangkat</label>
                                                <p class=""><?php echo $supportticket->ipaddress; ?></p>
                                            </div>
                                            <?php endif; ?>

                                            <a href="<?= base_url()?>index.php/Karyawan/KelolaRequest" class="form-group">
                                                <button class="btn btn-default" type="submit">Back</button>
                                            </a>
                                    </div>
                                </div>
                                <h4 class="text-info m-b-20 m-t-20"><i class="fa-solid fa-clock-rotate-left"></i>
                                    Riwayat Pengajuan Request Permasalahan
                                </h4>
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Request ID</th>
                                            <th>Deskripsi Masalah</th>
                                            <th>Catatan Perbaikan</th>
                                            <th width="91px">Tanggal Pengajuan</th>
                                            <th>Status</th>
                                            <th width="91px">Tanggal Penyelesaian</th>
                                            <th width="91px">Penanggung Jawab</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($riwayat as $ticket) : ?>
                                        <tr>
                                            <td><?php echo $ticket->request_id; ?></td>
                                            <td><?php echo $ticket->deskripsi_permasalahan; ?></td>
                                            <td><?php echo $ticket->catatan; ?></td>
                                            <td><?php echo $ticket->tanggal_dibuat; ?></td>
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
                                            <td><?php echo !empty($ticket->tanggal_ditangani) ? $ticket->tanggal_ditangani : "Belum Selesai"; ?></td>
                                            <td>
                                                <?php if (!empty($ticket->penanggung_jawab_perbaikan)): ?>
                                                    <?php echo $ticket->nama_penanggung_jawab; ?>
                                                <?php else: ?>
                                                    Sedang Proses Pengajuan/perbaikan
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .profile-social a {
            font-size: 16px;
            margin: 0 10px;
            color: #999;
        }

        .profile-social a:hover {
            color: #485b6f;
        }

        .profile-stat-count {
            font-size: 22px
        }
        </style>
    </div>