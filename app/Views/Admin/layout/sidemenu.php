<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="<?= base_url(); ?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text fw-bold">PT. Nur Lisan Sakti</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="<?= $nav == 'dashboard' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/dashboard'); ?>">
                <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Referensi</li>
        <li class="<?= $nav == 'suplier' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/suplier'); ?>">
                <div class="parent-icon"><i class='bx bx-store'></i></div>
                <div class="menu-title">Suplier</div>
            </a>
        </li>
        <li class="<?= $nav == 'satuan' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/satuan'); ?>">
                <div class="parent-icon"><i class='bx bx-grid-small'></i></div>
                <div class="menu-title">Satuan</div>
            </a>
        </li>
        <li class="<?= $nav == 'kategori' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/kategori'); ?>">
                <div class="parent-icon"><i class='bx bx-poll'></i></div>
                <div class="menu-title">Kategori</div>
            </a>
        </li>
        <li class="<?= $nav == 'customer' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/spesifikasi'); ?>">
                <div class="parent-icon"><i class='bx bx-columns'></i></div>
                <div class="menu-title">Spesifikasi</div>
            </a>
        </li>

        <li class="menu-label">Produk</li>
        <li class="<?= $nav == 'produk' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/produk'); ?>">
                <div class="parent-icon"><i class='bx bx-news'></i></div>
                <div class="menu-title">Data Produk</div>
            </a>
        </li>
        <li class="<?= $nav == 'masuk' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/produk-masuk'); ?>">
                <div class="parent-icon"><i class='bx bx-archive'></i></div>
                <div class="menu-title">Produk Masuk</div>
            </a>
        </li>
        <!-- <li class="<?= $nav == 'paket' ? 'mm-active' : ''; ?>">
           <a href="<?= base_url('admin/produk-paket'); ?>">
               <div class="parent-icon"><i class='bx bx-carousel'></i></div>
               <div class="menu-title">Paket Produk</div>
           </a>
        </li> -->
        <li class="<?= $nav == 'promo' ? 'mm-active' : ''; ?>">
           <a href="<?= base_url('admin/produk/promo'); ?>">
               <div class="parent-icon"><i class='bx bx-purchase-tag'></i></div>
               <div class="menu-title">Promo Produk</div>
           </a>
        </li>

        <li class="menu-label">Orderan</li>

        <li class="<?= $nav == 'order_set' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/orders/setting'); ?>">
                <div class="parent-icon"><i class='bx bx-book-open'></i></div>
                <div class="menu-title">Order Setting</div>
            </a>
        </li>
        
        <li class="<?= $nav == 'orders' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/orders'); ?>">
                <div class="parent-icon"><i class='bx bx-news'></i></div>
                <div class="menu-title">Data Order</div>
            </a>
        </li>

        <li class="menu-label">Website</li>
        <li class="<?= $nav == 'banner' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/banner'); ?>">
                <div class="parent-icon"><i class='bx bx-notification'></i></div>
                <div class="menu-title">Banner</div>
            </a>
        </li>
        <li class="<?= $nav == 'pesan' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/pesan'); ?>">
                <div class="parent-icon"><i class='bx bx-chat'></i></div>
                <div class="menu-title">Pesan</div>
            </a>
        </li>
        <li class="<?= $nav == 'patner' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/patner'); ?>">
                <div class="parent-icon"><i class='bx bx-archive'></i></div>
                <div class="menu-title">Patner Kami</div>
            </a>
        </li>
        <li class="<?= $nav == 'layanan' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/layanan'); ?>">
                <div class="parent-icon"><i class='bx bx-credit-card-front'></i></div>
                <div class="menu-title">Layanan Kami</div>
            </a>
        </li>
        <li class="<?= $nav == 'kontak' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/kontak'); ?>">
                <div class="parent-icon"><i class='bx bx-columns'></i></div>
                <div class="menu-title">Kontak</div>
            </a>
        </li>

        <li class="menu-label">Setting</li>
        <li class="<?= $nav == 'about' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/about'); ?>">
                <div class="parent-icon"><i class='bx bx-server'></i></div>
                <div class="menu-title">General</div>
            </a>
        </li>
        <li class="<?= $nav == 'user' ? 'mm-active' : ''; ?>"> 
            <a href="<?= base_url('admin/users'); ?>">
                <div class="parent-icon"><i class='bx bx-user'></i></div>
                <div class="menu-title">Users</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>

