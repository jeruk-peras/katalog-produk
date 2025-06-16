<header class="header navbar-area">
    <!-- Start Topbar -->
    <!-- End Topbar -->
    <!-- Start Header Middle -->
    <div class="header-middle p-3">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-3 col-md-6 col-7">
                    <!-- Start Header Logo -->
                    <a class="navbar-brand d-flex align-items-center" href="">
                        <div>
                            <img src="<?= base_url(); ?>assets/images/logo-icon.png" style="width: 40px;" alt="Logo">
                        </div>
                        <div>
                            <h5 class="ms-3 fw-bold">PT. Nur Lisan Sakti</h5>
                        </div>
                    </a>
                    <!-- End Header Logo -->
                </div>

                <div class="col-auto text-end">
                    <div class="middle-right-area">
                        <div class="navbar-cart">
                            <div class="cart-items">
                                <a href="<?= base_url('keranjang'); ?>" class="main-btn">
                                    <i class="lni lni-cart"></i>
                                    <span class="total-items" id="total-items">0</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Middle -->

    <!-- Start Header Bottom -->
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-6 col-12">
                <div class="nav-inner">
                    <!-- Start Mega Category Menu -->
                    <div class="mega-category-menu">
                        <span class="cat-button"><i class="lni lni-menu"></i>Kategori</span>
                        <ul class="sub-category">
                            <?php foreach(getKategori() as $row):  ?>
                            <li><a href="<?= base_url('produk/kategori/'.$row['slug_kategori']); ?>"><?= $row['nama_kategori']; ?></a></li>
                            <?php endforeach;  ?>
                        </ul>
                    </div>
                    <!-- End Mega Category Menu -->
                    <!-- Start Navbar -->
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="<?= base_url('beranda'); ?>" <?= $nav == 'beranda' ? 'class="active"' : ''; ?> aria-label="Toggle navigation">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('tentang-kami'); ?>" <?= $nav == 'about' ? 'class="active"' : ''; ?> aria-label="Toggle navigation">Tentang Kami</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('produk'); ?>" <?= $nav == 'produk' ? 'class="active"' : ''; ?> aria-label="Toggle navigation">Produk</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('kontak'); ?>" <?= $nav == 'kontak' ? 'class="active"' : ''; ?> aria-label="Toggle navigation">Kontak Kami</a>
                                </li>
                            </ul>
                        </div> <!-- navbar collapse -->
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Start Nav Social -->
                <div class="nav-social">
                    <h5 class="title">Follow Us:</h5>
                    <ul>
                        <li><a href="<?= getKontak('facebook') ?? 'javascript:void(0)' ?>"><i class="lni lni-facebook-filled"></i></a></li>
                        <li><a href="<?= getKontak('instagram') ?? 'javascript:void(0)' ?>"><i class="lni lni-instagram"></i></a></li>
                        <li><a href="<?= getKontak('youtube') ?? 'javascript:void(0)' ?>"><i class="lni lni-youtube"></i></a></li>
                    </ul>
                </div>
                <!-- End Nav Social -->
            </div>
        </div>
    </div>
    <!-- End Header Bottom -->
</header>