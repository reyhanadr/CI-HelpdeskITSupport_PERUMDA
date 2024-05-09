<div class="content-wrapper">

    <!-- START PAGE CONTENT-->

    <div class="page-heading">

        <h1 class="page-title">Detail Data</h1>



    </div>

    <div class="page-content fade-in-up">

        <div class="row">

            <div class="col-lg-3 col-md-4">

                <div class="ibox">

                    <div class="ibox-body text-center">

                        <div class="m-t-20">

                            <div style="width: 230px; height: 230px; overflow: hidden; border-radius: 50%; ">

                                <img src="<?php echo base_url(); ?>./assets/img/users/<?= $detail['foto_user'] ?>" alt="User Foto" style="width: 100%; height: 100%; object-fit: cover; ">

                            </div>

                        </div>

                        <h5 class="font-strong m-b-10 m-t-10"><?= $detail['nama'] ?></h5>

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

                                        <form method="post"

                                            action="<?php echo site_url('Administator/Profil/updateDataUser'); ?>"

                                            enctype="multipart/form-data">

                                            <?php

                                            if ($this->session->flashdata('succes')) { ?>

                                            <div class="alert alert-success alert-dismissible fade show">

                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>

                                                <h6>

                                                <i class="icon fa fa-check"></i>

                                                Data Berhasil

                                                <strong>

                                                    <?= $this->session->flashdata('succes');   ?>

                                                </strong>

                                                </h6>

                                            </div>

                                            <?php } ?>

                                            <?php

                                            if ($this->session->flashdata('gagal')) { ?>

                                            <div class="alert alert-danger alert-dismissible fade show">

                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>

                                                <h6>

                                                <i class="icon fa  fa-times-circle"></i>

                                                <strong>

                                                    <?= $this->session->flashdata('gagal');   ?>

                                                </strong>

                                                </h6>

                                            </div>

                                            <?php } ?>

                                            <div class="row">

                                                <div class="col-sm-6 form-group">



                                                    <label>ID Teknisi</label>

                                                    <input class="form-control" type="text" placeholder="ID Karyawan"

                                                        value="<?= $detail['karyawan_id'] ?>" disabled>

                                                </div>

                                                <div class="col-sm-6 form-group">

                                                    <label>Nama Lengkap</label>

                                                    <input class="form-control" type="text" name="nama" id="nama"

                                                        placeholder="Nama Lengkap" value="<?= $detail['nama'] ?>" disabled>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6 form-group">

                                                    <label>Username</label>

                                                    <input class="form-control" type="text" name="username"

                                                        id="username" placeholder="Username"

                                                        value="<?= $detail['username'] ?>" disabled>

                                                </div>

                                                <div class="col-sm-6 form-group">

                                                    <label>Email</label>

                                                    <input class="form-control" type="email" name="email" id="email"

                                                        placeholder="Email address" value="<?= $detail['email'] ?>" disabled>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6 form-group">

                                                    <label>Departemen</label>

                                                    <input class="form-control" type="text" placeholder="Divisi"

                                                        value="<?= $detail['nama_kategori'] ?>" disabled>

                                                </div>

                                                <div class="col-sm-6 form-group">

                                                    <label>Status</label>

                                                    <input class="form-control" type="text" name="status" id="status"

                                                        placeholder="" value="<?= $detail['status'] ?>" disabled>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <?php if ($detail['status'] == 'Aktif') { ?>

                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#nonAktivasiModal">Non-Aktivasi</button>

                                                    <?php } else { ?>

                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#aktivasiModal">Aktivasi</button>

                                                    <?php } ?>

                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#resetPasswordModal">Reset Password</button>

                                                <a href="<?= base_url('index.php/Administator/KelolaTeknisi'); ?>" class="btn btn-default">Kembali</a>



                                            <!-- Modal Aktivasi -->

                                            <div class="modal fade" id="aktivasiModal" tabindex="-1" role="dialog" aria-labelledby="aktivasiModalLabel" aria-hidden="true">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="aktivasiModalLabel">Konfirmasi Aktivasi</h5>

                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                                <span aria-hidden="true">&times;</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">

                                                            Apakah Anda yakin ingin mengaktifkan karyawan ini?

                                                        </div>

                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                                                            <a href="<?= base_url('index.php/Administator/KelolaTeknisi/aktivasi/'.$detail['user_id']) ?>" class="btn btn-success">Ya, Aktifkan</a>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>



                                            <!-- Modal Non-Aktivasi -->

                                            <div class="modal fade" id="nonAktivasiModal" tabindex="-1" role="dialog" aria-labelledby="nonAktivasiModalLabel" aria-hidden="true">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="nonAktivasiModalLabel">Konfirmasi Non-Aktivasi</h5>

                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                                <span aria-hidden="true">&times;</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">

                                                            Apakah Anda yakin ingin menon-aktifkan karyawan ini?

                                                        </div>

                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                                                            <a href="<?= base_url('index.php/Administator/KelolaTeknisi/nonaktivasi/'.$detail['user_id']) ?>" class="btn btn-danger">Ya, Non-Aktifkan</a>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </form>

                                            <!-- Modal Konfirmasi Reset Password -->

                                            <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="resetPasswordModalLabel">Konfirmasi Reset Password</h5>

                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                                <span aria-hidden="true">&times;</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">

                                                            Apakah Anda yakin ingin mereset password karyawan ini?<br>

                                                            Masukan Password Admin untuk Konfirmasi:

                                                            <form class="form-horizontal"  method="POST" action="<?=base_url()?>index.php/Administator/KelolaTeknisi/konfirmasiResetPassword/<?= $detail['karyawan_id']?>">

                                                                <div class="form-group row">

                                                                    <div class="col-sm-10">

                                                                    <label class=" col-form-label">Password Admin:</label>

                                                                        <input class="form-control" type="text" name="username" hidden  value="<?= $this->session->userdata('username')?>">

                                                                        <input class="form-control" type="password" name="password" >

                                                                        <p id="error-message" style="color: red;"></p>

                                                                    </div>

                                                                </div>

                                                        </div>

                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                                                            <button class="btn btn-warning" type="submit">Ya, Reset Password</button>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                    </div>

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