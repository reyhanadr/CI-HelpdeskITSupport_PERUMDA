

        <div class="content-wrapper">

            <!-- START PAGE CONTENT-->

        <div class="page-heading">

                <h1 class="page-title">Form Edit Data Unit Kerja</h1>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="index.html"><i class="la la-home font-20"></i></a>

                    </li>

                </ol>

            </div>

            <div class="page-content fade-in-up">

                <div class="ibox">

                    <div class="ibox-head">

                        <div class="ibox-title">Edit Data Unit Kerja</div>

                    </div>

                    <div class="ibox-body">

                    <?= validation_errors(); ?>

                        <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">



                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Nama Unit Kerja</label>

                                <div class="col-sm-10">

                                <input class="form-control" type="text" name="nama" id="nama" oninput="validateInput(this)" value="<?= $ubah['nama_departemen'] ?>">
                                <input class="form-control" type="text" name="id" value="<?= $ubah['departemen_id'] ?>" hidden>
                                    <p id="error-message" style="color: red;"></p>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-sm-10 ml-sm-auto">

                                <input type="submit" name="save" class="btn btn-primary" value="Save">

                                <a href="<?= base_url('index.php/Administator/KelolaDepartemen'); ?>" class="btn btn-default">Kembali</a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>