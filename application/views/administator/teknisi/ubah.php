

        <div class="content-wrapper">

            <!-- START PAGE CONTENT-->

        <div class="page-heading">

                <h1 class="page-title">Form Edit Data Teknisi</h1>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="index.html"><i class="la la-home font-20"></i></a>

                    </li>

                </ol>

            </div>

            <div class="page-content fade-in-up">

                <div class="ibox">

                    <div class="ibox-head">

                        <div class="ibox-title">Edit Data Teknisi</div>

                    </div>

                    <div class="ibox-body">

                        <?php if(validation_errors()): ?>

                        <div class="alert alert-danger"><?= validation_errors(); ?></div>

                        <?php endif;?>

                        <form class="form-horizontal" method="post">

                        <div class="form-group row">

                                <label class="col-sm-2 col-form-label">ID Teknisi</label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="text" name="karyawan_id" value="<?= $ubah['karyawan_id'] ?>" readonly>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Nama</label>

                                <div class="col-sm-10">

                                <input class="form-control" type="text" name="nama" id="nama" oninput="validateInput(this)" value="<?= $ubah['nama'] ?>">

                                    <p id="error-message" style="color: red;"></p>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Username</label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="text" name="username" value="<?= $ubah['username'] ?>">

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Email</label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="email" name="email" value="<?= $ubah['email'] ?>">

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Bidang</label>

                                <div class="col-sm-10">

                                    <select class="form-control" name="bidang">

                                        <option value="<?= $ubah['kategori_id'] ?>"><?= $ubah['nama_kategori'] ?></option>

                                        <?php foreach ($kategori as $kategoris): ?>

                                            <?php if ($kategoris['kategori_id'] != $ubah['kategori_id']): ?>

                                                <option value="<?= $kategoris['kategori_id'] ?>"><?= $kategoris['nama_kategori'] ?></option>

                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-sm-10 ml-sm-auto">

                                    <button type="submit" name="save" class="btn btn-primary" value="Save">SAVE</button>

                                    <a href="<?= base_url('index.php/Administator/KelolaTeknisi'); ?>" class="btn btn-default">Kembali</a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>