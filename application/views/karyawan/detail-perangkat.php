<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-heading">
        <h1 class="page-title">Detail Perangkat: <?php echo $perangkat->nama_perangkat; ?></h1>
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
                                <img src="<?php echo base_url(); ?>./assets/img/perangkat/<?php echo $perangkat->foto; ?>" alt="Foto Perangkat" style="width: 100%; height: 100%; object-fit: cover; ">
                            </div>
                            <br>
                                <label class="font-bold"><?php echo $perangkat->nomer_seri; ?></label>
                            <div class="m-b-20 text-muted"><?php echo $perangkat->nama_perangkat; ?></div>
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
                                                <div class="col-sm-12 form-group">
                                                    <label class="font-bold">Nomer Inventaris Perangkat</label>
                                                    <p class="font-strong"><?php echo $perangkat->no_inventaris; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Nomer Seri Perangkat</label>
                                                    <p class="font-strong"><?php echo $perangkat->nomer_seri; ?></p>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Nama Perangkat</label>
                                                    <p class=""><?php echo $perangkat->nama_perangkat; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Pengguna Perangkat</label>
                                                    <p class=""><?php echo $perangkat->nama_user; ?></p>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Unit Kerja</label>
                                                    <p class=""><?php echo $perangkat->nama_departemen; ?></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Kategori Perangkat</label>
                                                    <p class=""><?php echo $perangkat->nama_kategori; ?></p>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Status Perangkat Sekarang</label>
                                                    <p class="">
                                                        <?php if ($perangkat->status_perangkat == 'PENGAJUAN'): ?>
                                                            <span class="badge badge-warning"><?php echo $perangkat->status_perangkat; ?></span>
                                                        <?php elseif ($perangkat->status_perangkat == 'PROSES'): ?>
                                                            <span class="badge badge-default"><?php echo $perangkat->status_perangkat; ?></span>
                                                        <?php elseif ($perangkat->status_perangkat == 'SELESAI'): ?>
                                                            <span class="badge badge-success"><?php echo $perangkat->status_perangkat; ?></span>
                                                        <?php elseif ($perangkat->status_perangkat == 'BERJALAN' || $perangkat->status_perangkat == 'DIPAKAI'): ?>
                                                            <span class="badge badge-success"><?php echo $perangkat->status_perangkat; ?></span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger"><?php echo $perangkat->status_perangkat; ?></span>
                                                        <?php endif; ?>
                                                    
                                                    </p>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <?php if (!empty($perangkat->ipaddress)): ?>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">IP Address Perangkat</label>
                                                    <p class=""><?php echo $perangkat->ipaddress; ?></p>
                                                </div>
                                                <?php endif; ?>
                                                <div class="col-sm-6 form-group">
                                                    <label class="font-bold">Tanggal Masuk Perangkat</label>
                                                    <p class=""><?php echo $perangkat->tanggal_masuk; ?></p>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label class="font-bold">Spesifikasi Perangkat</label>
                                                    <p class=""><?php echo $perangkat->spesifikasi; ?></p>
                                                </div>
                                            </div>

                                            <a href="<?= base_url()?>index.php/Karyawan/KelolaPerangkat" class="form-group">
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
                                        <?php foreach ($riwayat_perangkat as $ticket) : ?>
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
                                                <?php if (!empty($ticket->penanggung_jawab)): ?>
                                                    <?php echo $ticket->penanggung_jawab; ?>
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