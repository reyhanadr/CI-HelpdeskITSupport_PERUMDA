        <!-- START SIDEBAR-->

        <nav class="page-sidebar sticky-top" id="sidebar">

            <div id="sidebar-collapse">

            <div class="admin-block d-flex">

            <div style="width: 45px; height: 45px; overflow: hidden; border-radius: 50%;">

                <img src="<?php echo base_url(); ?>./assets/img/users/<?php echo $users->foto_user?>" alt="User Foto" style="width: 100%; height: 100%; object-fit: cover;">

            </div>

            <div class="admin-info">

                <div class="font-strong"><?php echo $users->nama?></div><small><?php echo $users->nama_role?></small>

            </div>

        </div>

                <ul class="side-menu metismenu">

                    <li class="<?= ($active_menu === 'Dashboard') ? 'active' : ''; ?>">

                        <a class="" href="<?= base_url('index.php/Administator/Dashboard'); ?>"><i class="sidebar-item-icon fa fa-th-large"></i>

                            <span class="nav-label">Dashboard</span>

                        </a>

                    </li>

                    <li class="heading">DATA USER</li>

                    <li class="<?= ($active_menu === 'KelolaKaryawan') ? 'active' : ''; ?>">

                        <a class="" href="<?= base_url('index.php/Administator/KelolaKaryawan'); ?>"><i class="sidebar-item-icon fa fa-user"></i>

                            <span class="nav-label">Kelola Data Karyawan</span>

                        </a>

                    </li>

                    <li class="<?= ($active_menu === 'KelolaTeknisi') ? 'active' : ''; ?>">

                        <a class="" href="<?= base_url('index.php/Administator/KelolaTeknisi'); ?>"><i class="sidebar-item-icon fa fa-user"></i>

                            <span class="nav-label">Kelola Data Teknisi</span>

                        </a>

                    </li>

                    <li class="heading">MASTER DATA</li>

                    <li class="<?= ($active_menu === 'KelolaDepartemen') ? 'active' : ''; ?>">

                        <a class="" href="<?= base_url('index.php/Administator/KelolaDepartemen'); ?>"><i class="sidebar-item-icon fa fa-table"></i>

                            <span class="nav-label">Unit Kerja</span>

                        </a>

                    </li>

                    <li class="<?= ($active_menu === 'KelolaBagianIT') ? 'active' : ''; ?>">

                        <a class="" href="<?= base_url('index.php/Administator/KelolaBagianIT'); ?>"><i class="sidebar-item-icon fa fa-table"></i>

                            <span class="nav-label">Bagian IT</span>

                        </a>

                    </li>

                    <li class="heading">PROFIL</li>

                    <li class="<?= ($active_menu === 'KelolaProfil') ? 'active' : ''; ?>">

                        <a class="" href="<?= base_url('index.php/Administator/Profil/tampilEditProfile/') . $this->session->userdata('username'); ?>"><i class="sidebar-item-icon fa fa-user-circle-o"></i>

                            <span class="nav-label">Kelola Profil</span>

                        </a>

                    </li>

                </ul>

            </div>

        </nav>

        <!-- END SIDEBAR-->