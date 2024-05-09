        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <!-- <h1 class="page-title">Kumpulan Notifikasi</h1> -->
            </div>
            <div class="page-content fade-in-up">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox">
                            <div class="ibox-head">
                                <div class="ibox-title">Semua Notifikasi</div>
                                <span><strong><?php echo $jml_notif?> New</strong> Notifications</span>
                                
                            </div>
                            <div class="ibox-body">
                                <li class="list-group list-group-divider " data-height="240px" data-color="#71808f">
                                <?php foreach ($notif as $notifikasi) : ?>
                                    <?php if ($notifikasi->request_id || $notifikasi->sesi_pesan && $notifikasi->teknisi_id === NULL) : ?>
                                        <a  class="list-group-item">
                                            <div class="media">
                                                <div class="media-img">
                                                    <span class="badge badge-success badge-big">
                                                        <i class="fa fa-bell"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-13"><?= $notifikasi->message_for_teknisi?></div>
                                                    <small class="text-muted"><?php echo $notifikasi->created_at; ?></small>
                                                </div>
                                            </div>
                                        </a>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13">2018 © <b>AdminCAST</b> - All rights reserved.</div>
                <a class="px-4" href="http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank">BUY PREMIUM</a>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>