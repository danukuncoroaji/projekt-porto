<div class="app-sidebar">
    <div class="logo">
        <a href="index.html" class="logo-icon"><span class="logo-text">Satyagraha</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="../../assets/images/avatars/avatar.png">
                <span class="activity-indicator"></span>
                <span class="user-info-text"><?= $session->get('nama'); ?><br><span class="user-state-info">
                        <?php if ($session->get('level') == 1) {
                            echo 'Owner';
                        } else {
                            echo 'Customer';
                        } ?>
                    </span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">
            <li class="sidebar-title">
                Menu
            </li>

            <li <?php if (str_contains(base_url(uri_string()), 'beranda')) { ?> class="active-page" <?php } ?>>
                <a href="<?php echo base_url('/app'); ?>"><i class="material-icons-two-tone">home</i>Beranda</a>
            </li>
            <?php if ($session->get('level') == 1) { ?>
                <li <?php if (str_contains(base_url(uri_string()), 'reservasi')) { ?> class="active-page" <?php } ?>>
                    <a href="<?php echo base_url('/app/reservasi'); ?>"><i class="material-icons-two-tone">confirmation_number</i>Reservasi</a>
                </li>
                <li <?php if (str_contains(base_url(uri_string()), 'pembayaran')) { ?> class="active-page" <?php } ?>>
                    <a href="<?php echo base_url('/app/pembayaran'); ?>"><i class="material-icons-two-tone">payments</i>Pembayaran</a>
                </li>
                <li <?php if (str_contains(base_url(uri_string()), 'tanggal')) { ?> class="active-page" <?php } ?>>
                    <a href="<?php echo base_url('/app/tanggal'); ?>"><i class="material-icons-two-tone">calendar_month</i>Tanggal dan Harga</a>
                </li>
                <li <?php if (str_contains(base_url(uri_string()), 'laporan')) { ?> class="active-page" <?php } ?>>
                    <a href="<?php echo base_url('/app/laporan'); ?>"><i class="material-icons-two-tone">task</i>Laporan</a>
                </li>
                <li <?php if (str_contains(base_url(uri_string()), 'customer')) { ?> class="active-page" <?php } ?>>
                    <a href="<?php echo base_url('/app/customer'); ?>"><i class="material-icons-two-tone">group</i>Customer</a>
                </li>
                <li <?php if (str_contains(base_url(uri_string()), 'galeri')) { ?> class="active-page" <?php } ?>>
                    <a href="<?php echo base_url('/app/galeri'); ?>"><i class="material-icons-two-tone">photo_library</i>Galeri</a>
                </li>
                <li <?php if (str_contains(base_url(uri_string()), 'admin')) { ?> class="active-page" <?php } ?>>
                    <a href="#"><i class="material-icons-two-tone">badge</i>Admin<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('/app/admin'); ?>">List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('/app/admin/tambah'); ?>">Tambah</a>
                        </li>
                    </ul>
                </li>
            <?php } else if ($session->get('level') == 2) { ?>
            <?php } else if ($session->get('level') == 3) { ?>
                <li <?php if (str_contains(base_url(uri_string()), 'reservasi')) { ?> class="active-page" <?php } ?>>
                    <a href="#"><i class="material-icons-two-tone">confirmation_number</i>Reservasi<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('/app/reservasi/tambah'); ?>">Tambah Reservasi</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('/app/reservasi'); ?>">List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('/app/reservasi/riwayat'); ?>">Riwayat</a>
                        </li>
                    </ul>
                </li>
                <li <?php if (str_contains(base_url(uri_string()), 'pembayaran')) { ?> class="active-page" <?php } ?>>
                    <a href="#"><i class="material-icons-two-tone">payments</i>Pembayaran<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('/app/pembayaran'); ?>">Aktif</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('/app/pembayaran/riwayat'); ?>">Riwayat</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <li>
                <a href="<?php echo base_url('/app/logout'); ?>"><i class="material-icons-two-tone">meeting_room</i>Keluar</a>
            </li>
        </ul>
    </div>
</div>