<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="<?= base_url(); ?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Rocker</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="javascript:;">
                <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="widgets.html">
                <div class="parent-icon"><i class='bx bx-notification'></i></div>
                <div class="menu-title">Banner</div>
            </a>
        </li>
        <hr>
        <li class="menu-label">Referensi</li>
        <li class="<?= $nav == 'kategori' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/kategori'); ?>">
                <div class="parent-icon"><i class='bx bx-poll'></i></div>
                <div class="menu-title">Kategori</div>
            </a>
        </li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="widgets.html">
                <div class="parent-icon"><i class='bx bx-filter'></i></div>
                <div class="menu-title">Sub Kategori</div>
            </a>
        </li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="widgets.html">
                <div class="parent-icon"><i class='bx bx-columns'></i></div>
                <div class="menu-title">Spesifikasi</div>
            </a>
        </li>

        <li class="menu-label">Produk</li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="widgets.html">
                <div class="parent-icon"><i class='bx bx-news'></i></div>
                <div class="menu-title">Data Produk</div>
            </a>
        </li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="widgets.html">
                <div class="parent-icon"><i class='bx bx-cookie'></i></div>
                <div class="menu-title">Promo Produk</div>
            </a>
        </li>

        <li class="menu-label">Setting</li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="widgets.html">
                <div class="parent-icon"><i class='bx bx-columns'></i></div>
                <div class="menu-title">Kontak</div>
            </a>
        </li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="widgets.html">
                <div class="parent-icon"><i class='bx bx-server'></i></div>
                <div class="menu-title">General</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>