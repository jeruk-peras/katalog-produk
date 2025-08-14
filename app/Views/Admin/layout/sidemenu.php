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

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-book-open"></i></div>
                <div class="menu-title">Referensi</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('admin/suplier'); ?>"><i class='bx bx-radio-circle'></i>Suplier</a></li>
                <li><a href="<?= base_url('admin/satuan'); ?>"><i class='bx bx-radio-circle'></i>Satuan</a></li>
                <li><a href="<?= base_url('admin/kategori'); ?>"><i class='bx bx-radio-circle'></i>Kategori</a></li>
                <li><a href="<?= base_url('admin/spesifikasi'); ?>"><i class='bx bx-radio-circle'></i>Spesifikasi</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-box"></i></div>
                <div class="menu-title">Produk</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('admin/produk'); ?>"><i class='bx bx-radio-circle'></i>Data Produk</a></li>
                <li><a href="<?= base_url('admin/produk-masuk'); ?>"><i class='bx bx-radio-circle'></i>Produk Masuk</a></li>
                <!-- <li><a href="<?= base_url('admin/produk-paket'); ?>"><i class='bx bx-radio-circle'></i>Paket Produk</a></li> -->
                <li><a href="<?= base_url('admin/produk/promo'); ?>"><i class='bx bx-radio-circle'></i>Promo Produk</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-news"></i></div>
                <div class="menu-title">Orderan</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('admin/orders/setting'); ?>"><i class='bx bx-radio-circle'></i>Order Setting</a></li>
                <li><a href="<?= base_url('admin/orders'); ?>"><i class='bx bx-radio-circle'></i>Data Order</a></li>
                <li><a href="<?= base_url('admin/customer'); ?>"><i class='bx bx-radio-circle'></i>Data Customer</a></li>
            </ul>
        </li>
         <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-detail"></i></div>
                <div class="menu-title">Laporan</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('admin/penjualan'); ?>"><i class='bx bx-radio-circle'></i>Panjualan</a></li>
                <li><a href="<?= base_url('admin/stok-produk'); ?>"><i class='bx bx-radio-circle'></i>Stok Produk</a></li>
            </ul>
        </li>

        
        <li class="menu-label">Setting</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-notification"></i></div>
                <div class="menu-title">Website</div>
            </a>
            <ul class="mm-collapse">
                <li><a href="<?= base_url('admin/banner'); ?>"><i class='bx bx-radio-circle'></i>Banner</a></li>
                <li><a href="<?= base_url('admin/pesan'); ?>"><i class='bx bx-radio-circle'></i>Pesan</a></li>
                <li><a href="<?= base_url('admin/patner'); ?>"><i class='bx bx-radio-circle'></i>Patner Kami</a></li>
                <li><a href="<?= base_url('admin/layanan'); ?>"><i class='bx bx-radio-circle'></i>Layanan Kami</a></li>
                <li><a href="<?= base_url('admin/kontak'); ?>"><i class='bx bx-radio-circle'></i>Kontak</a></li>
            </ul>
        </li>
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

