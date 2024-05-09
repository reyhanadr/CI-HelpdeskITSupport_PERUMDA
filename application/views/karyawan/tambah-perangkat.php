<body class="fixed-navbar">
    <div class="page-wrapper">
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Tambah Perangkat</h1>
                <ol class="breadcrumb"> 
                    <li class="breadcrumb-item">Tambah Perangkat Yang Telah Diberikan Kepada Anda</li>
                </ol>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Tambah Data Perangkat Anda</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                    <?php if ($this->session->flashdata('error_upload')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error_upload'); ?></div>
                    <?php endif; ?>
                        <form class="form-horizontal" action="<?php echo site_url('Karyawan/KelolaPerangkat/simpanPerangkat/'); ?>" method="post" novalidate="novalidate" enctype="multipart/form-data" id="form-sample-1">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nomer Seri</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="nomer_seri" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Penanggung Jawab</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="penanggungjawab" value="<?php echo $users->nama?>" disabled>
                                    <input class="form-control" type="text" name="user_id" value="<?php echo $users->user_id?>" hidden>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Perangkat</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="nama_perangkat" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">IP Address Perangkat (Opsional)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="ipaddress">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jenis Perangkat</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="kategori_id">
                                        <option value="">Pilih</option>
                                        <?php foreach ($kategori as $kategori) : ?>
                                            <option value="<?php echo $kategori->kategori_id; ?>"><?php echo $kategori->nama_kategori; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Spesifikasi Perangkat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="4" name="spesifikasi" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Lokasi Perangkat</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="lokasi_fisik_tampil" value="<?php echo $users->nama_departemen?>" readonly>
                                    <input class="form-control" type="text" name="lokasi_fisik" value="<?php echo $users->departemen_id?>" hidden>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Status Perangkat</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="status_perangkat" readonly value="DIPAKAI" required>
                                </div>
                            </div>
                            <div class="form-group row" id="date_1">
                                <label class="col-sm-2 col-form-label">Tanggal Perangkat Masuk</label>
                                    <div class="col-sm-2 input-group date">
                                        <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                        <input class="form-control" type="text" name="tanggal_masuk" value="">
                                    </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Gambar Perangkat</label>
                                <div class="col-sm-10">
                                    <img id="previewImage" src="<?php echo base_url('assets/img/perangkat/default.jpg'); ?>" width="250px">
							        <input id="inputImage" class="form-control" type="file" name="foto" onchange="previewImage(event)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 ml-sm-auto">
                                    <button class="btn btn-primary" type="submit" >Submit</button>
				                    <a href="<?= base_url('index.php/Karyawan/KelolaPerangkat/'); ?>" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
           