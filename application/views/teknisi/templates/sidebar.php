<!-- START SIDEBAR-->
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div style="width: 45px; height: 45px; overflow: hidden; border-radius: 50%;">
                <img src="<?php echo base_url(); ?>./assets/img/users/<?php echo $users->foto_user ?>" alt="User Foto"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="admin-info">
                <div class="font-strong">
                    <?php echo $users->nama ?>
                </div><small>
                    <?php echo $users->nama_role; ?> <?php echo $users->nama_kategori; ?>
                </small>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li class="<?= ($active_menu === 'Dashboard') ? 'active' : ''; ?>">
                <a href="<?= base_url('index.php/Teknisi/Dashboard'); ?>"><i
                        class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">Terkait Pengelolaan</li>
                <li class="<?= ($active_menu === 'kelolaRequest' || $active_menu === 'request-pengajuan' || $active_menu === 'request-proses' || $active_menu === 'request-selesai') ? 'active' : ''; ?>">
                    <a href="javascript:;"><i class="sidebar-item-icon fa-solid fa-code-pull-request"></i>
                        <span class="nav-label">Kelola Request</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level">
                        <li class="<?= ($active_menu === 'kelolaRequest') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/Teknisi/KelolaRequest'); ?>">
                                <span class="nav-label">Semua Request</span>
                            </a>
                        </li>
                        <li class="<?= ($active_menu === 'request-pengajuan') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/Teknisi/KelolaRequest/requestPengajuan'); ?>">
                                <span class="nav-label">Request Pengajuan</span>
                            </a>
                        </li>
                        <li class="<?= ($active_menu === 'request-proses') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/Teknisi/KelolaRequest/requestProses'); ?>">
                                <span class="nav-label">Request Diproses</span>
                            </a>
                        </li>
                        <li class="<?= ($active_menu === 'request-selesai') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/Teknisi/KelolaRequest/requestSelesai'); ?>">
                                <span class="nav-label">Selesai (Berjalan/Rusak)</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </li>
            <!-- <li class="<?= ($active_menu === 'kelolaPerangkat') ? 'active' : ''; ?>">
                <a href="<?= base_url('index.php/Teknisi/KelolaPerangkat'); ?>"><i
                        class="sidebar-item-icon fa-solid fa-desktop"></i>
                    <span class="nav-label">Daftar Perangkat</span>
                </a>
            </li> -->

            <li class="heading">Terkait Pesan</li>
                <li class="<?= ($active_menu === 'pesan-view' || $active_menu === 'pesan-pengajuan' || $active_menu === 'pesan-berlangsung' || $active_menu === 'pesan-end') ? 'active' : ''; ?>">
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-comments"></i>
                        <span class="nav-label">Kelola Pesan</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level">
                        <li class="<?= ($active_menu === 'pesan-view') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/KelolaPesan'); ?>">
                                <span class="nav-label">Semua Pesan</span>
                            </a>
                        </li>
                        <li class="<?= ($active_menu === 'pesan-pengajuan') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/KelolaPesan/pesanPengajuan'); ?>">
                                <span class="nav-label">Pesan Pengajuan</span>
                            </a>
                        </li>
                        <li class="<?= ($active_menu === 'pesan-proses') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/KelolaPesan/pesanBerlangsung'); ?>">
                                <span class="nav-label">Pesan Berlangsung</span>
                            </a>
                        </li>
                        <li class="<?= ($active_menu === 'pesan-end') ? 'active' : ''; ?>">
                            <a href="<?= base_url('index.php/KelolaPesan/pesanBerakhir'); ?>">
                                <span class="nav-label">Pesan Berakhir</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </li>





            <li class="heading">Terkait Profil</li>
            <li class="<?= ($active_menu === 'kelolaprofil') ? 'active' : ''; ?>">
                <a href="<?= base_url('index.php/Teknisi/Profil/tampilEditProfile/'.$this->session->userdata('username').''); ?>">
                <i class="sidebar-item-icon fa-solid fa-user"></i>
                    <span class="nav-label">Kelola Profil</span>
                </a>
            </li>
        </ul>
        </li>
        </ul>
    </div>
</nav>
<!-- END SIDEBAR-->