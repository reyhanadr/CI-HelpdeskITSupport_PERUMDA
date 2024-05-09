
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-success color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?= $totalKaryawan ?></h2>
                                <div class="m-b-5">TOTAL USER KARYAWAN</div>
                                <i class="ti-user widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-primary color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?= $totalTeknisi ?></h2>
                                <div class="m-b-5">TOTAL USER TEKNISI</div>
                                <i class="ti-user widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="ibox bg-warning color-white widget-stat">
                            <div class="ibox-body">
                                <h2 class="m-b-5 font-strong"><?= $totalDepartemen ?></h2>
                                <div class="m-b-5">TOTAL DATA DEPARTEMEN</div>
                                <i class="ti-layout-grid2 widget-stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content fade-in-up">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Data Karyawan</div>
                                </div>
                                <div class="ibox-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Departemen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < 3; $i++) {
                                            $row = $karyawan[$i];
                                            ?>
                                            <tr>
                                                <td><?= $row->user_id ?></td>
                                                <td><?= $row->nama ?></td>
                                                <td><?= $row->email ?></td>
                                                <td><?= $row->nama_departemen ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Data Teknisi</div>
                                </div>
                                <div class="ibox-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Bagian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($i = 0; $i < 3; $i++) {
                                            $row = $teknisi[$i];
                                            ?>
                                            <tr>
                                                <td><?= $row->user_id ?></td>
                                                <td><?= $row->nama ?></td>
                                                <td><?= $row->email ?></td>
                                                <td><?= $row->nama_kategori ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content fade-in-up">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="ibox">
                                <div class="ibox-head">
                                    <div class="ibox-title">Data Departemen</div>
                                </div>
                                <div class="ibox-body">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nama Departemen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    for ($i = 0; $i < count($departemen) && $i < 3; $i++) {
                                        $row = $departemen[$i];
                                        ?>
                                        <tr>
                                            <td><?= $row->departemen_id ?></td>
                                            <td><?= $row->nama_departemen ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    .visitors-table tbody tr td:last-child {
                        display: flex;
                        align-items: center;
                    }

                    .visitors-table .progress {
                        flex: 1;
                    }

                    .visitors-table .progress-parcent {
                        text-align: right;
                        margin-left: 10px;
                    }
                </style>
            </div>
            <!-- END PAGE CONTENT-->
