<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                        </a>
                    </li>
                    <li class="nav-item dark-mode d-none d-sm-flex"></li>
                </ul>
            </div>
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= base_url(); ?>assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0"><?= session()->get('nama_user'); ?></p>
                        <p class="designattion mb-0"><?= session()->get('username'); ?></p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout'); ?>"><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
