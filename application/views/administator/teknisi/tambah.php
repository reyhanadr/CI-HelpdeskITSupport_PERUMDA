

        <div class="content-wrapper">

            <!-- START PAGE CONTENT-->

        <div class="page-heading">

                <h1 class="page-title">Form Tambah Data Teknisi</h1>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="index.html"><i class="la la-home font-20"></i></a>

                    </li>

                </ol>

            </div>

            <div class="page-content fade-in-up">

                <div class="ibox">

                    <div class="ibox-head">

                        <div class="ibox-title">Tambah Data Teknisi</div>

                    </div>

                    <div class="ibox-body">
                        <?php if(validation_errors()): ?>
                        <div class="alert alert-danger"><?= validation_errors(); ?></div>
                        <?php endif;?>

                        <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">

                        <div class="form-group row">

                                <label class="col-sm-2 col-form-label">ID Teknisi</label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="text" name="karyawan_id">

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Nama</label>

                                <div class="col-sm-10">

                                <input class="form-control" type="text" name="nama" id="nama" oninput="validateInput(this)">

                                    <p id="error-message" style="color: red;"></p>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Username</label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="text" name="username">

                                    <?php if (validation_errors()): ?>

                                    <?php endif; ?>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Email</label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="text" name="email">

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Password</label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="text" name="password">

                                </div>

                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Bagian</label>

                                <div class="col-sm-10">

                                    <select class="form-control" name="kategori">

                                        <option value="">Pilih</option>

                                        <?php foreach ($kategori as $kategoris): ?>

                                            <option value="<?= $kategoris['kategori_id'] ?>"><?= $kategoris['nama_kategori'] ?></option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-sm-10 ml-sm-auto">

                                    <button class="btn btn-info" type="submit">Submit</button>

                                    <a href="<?= base_url('index.php/Administator/KelolaTeknisi'); ?>" class="btn btn-default">Kembali</a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>