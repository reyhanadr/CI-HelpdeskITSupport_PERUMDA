<div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Kelola Data Bagian IT</h1>
            </div>
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
            <div class="row">
            <div class="col-xl-6">
                <div class="ibox">
                    <div class="ibox-head">
                    <div class="ibox-title">Data Bagian IT<a href="<?= base_url('index.php/Administator/KelolaBagianIT/tambah'); ?>">
                            <button class="btn btn-primary" type="submit">Tambah Data</button></a>
                    </div>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nama Bagian IT</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php

                                foreach ($BagianIT as $row) { ?>
                                    <tr>
                                        <td><?= $row->kategori_id ?></td>
                                        <td><?= $row->nama_kategori ?></td>

                                        <td>
                                        <div class="btn-group">
                                        <a href="<?= base_url() ?>index.php/Administator/KelolaBagianIT/ubah/<?= $row->kategori_id ?>" class="mr-2">
                                            <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14" aria-hidden="true"></i></button>
                                        </a>
                                        <a href="#" class="mr-2" onclick="showDeleteConfirmationModal(<?= $row->kategori_id ?>);">
                                            <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Delete">
                                                <i class="fa fa-trash font-14" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                        </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- Buat modal konfirmasi penghapusan -->
                        <div id="deleteConfirmationModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Penghapusan</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a id="deleteButton" href="#" class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Fungsi untuk menampilkan modal konfirmasi penghapusan
                            function showDeleteConfirmationModal(kategori_id) {
                                // Atur tautan Hapus di modal untuk sesuai dengan ID kategori yang akan dihapus
                                var deleteLink = "<?= base_url() ?>index.php/Administator/KelolaBagianIT/hapus/" + kategori_id;
                                document.getElementById('deleteButton').setAttribute('href', deleteLink);
                                $('#deleteConfirmationModal').modal('show');
                            }
                        </script>
                    </div>
                </div>
        </div>