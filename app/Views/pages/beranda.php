<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>

<!-- Start Hero Area -->
<section class="hero-area">
    <div class="">
        <div class="row">
            <div class="col-lg-12 col-12 custom-padding-right">
                <div class="slider-head">
                    <!-- Start Hero Slider -->
                    <div class="hero-slider">
                        <?php foreach ($banner as $row):  ?>
                            <!-- Start Single Slider -->
                            <div class="single-slider"
                                style="background-image: url(<?= base_url('assets/images/banner/') . $row['gambar_banner']; ?>);">
                                <div class="content">
                                    <?= $row['deskripsi_banner']; ?>
                                </div>
                            </div>
                            <!-- End Single Slider -->
                        <?php endforeach;  ?>
                    </div>
                    <!-- End Hero Slider -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Area -->

<!-- Start Featured Categories Area -->
<section class="featured-categories section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Kategori Produk</h2>
                    <p>Temukan semua kebutuhan body repair kendaraan Anda</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($kategori as $row):  ?>
                <a href="" class="col-lg-3 col-md-4 col-6">
                    <!-- Start Single Category -->
                    <div class="single-category">
                        <h3 class="heading"><?= $row['nama_kategori']; ?></h3>
                    </div>
                    <!-- End Single Category -->
                </a>
            <?php endforeach;  ?>
        </div>
    </div>
</section>
<!-- End Features Area -->

<!-- Start Trending Product Area -->
<?php if ($promo):  ?>
    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <div>
                            <h2>Promo Produk</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($promo as $row):  ?>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-image">
                                <img src="<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>" alt="#">
                                <?= $row['harga_diskon'] > 0 ? '<span class="sale-tag">PROMOO</span>' : ''; ?>
                                <div class="button">
                                    <a href="<?= base_url('produk/') . $row['id_produk'] . '/' . $row['slug_kategori'] . '/' . $row['slug_produk']; ?>" class="btn">
                                        <i class="lni lni-search-alt"></i> Detail
                                    </a>
                                </div>
                            </div>
                            <div class="product-info" id="data-produk-<?= $row['id_produk']; ?>" data-id_produk="<?= $row['id_produk']; ?>" data-nama_produk="<?= $row['nama_produk']; ?>" data-gambar_produk="<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>" data-harga_produk="<?= $row['harga_varian']; ?>" data-harga_promo="<?= $row['harga_varian']; ?>">
                                <span class="category"><?= $row['nama_kategori']; ?></span>
                                <h4 class="title">
                                    <a href=""><?= (strlen($row['nama_produk']) > 24 ? substr($row['nama_produk'], 0, 24) . '.. ' : $row['nama_produk']); ?></a>
                                </h4>
                                <div class="price mt-1 mb-2">
                                    <?php if ($row['harga_diskon'] > 0):  ?>
                                        <span>Rp<?= number_format($row['harga_diskon'],); ?></span>
                                        <span class="discount-price">Rp<?= number_format($row['harga_varian'],); ?></span>
                                    <?php else:  ?>
                                        <span>Rp<?= number_format($row['harga_varian'],); ?></span>
                                    <?php endif;  ?>
                                </div>
                                <div>
                                    <a href="<?= base_url('produk/') . $row['id_produk'] . '/' . $row['slug_kategori'] . '/' . $row['slug_produk']; ?>" class="btn btn-primary btn-sm"><i class="lni lni-cart"></i> keranjang</a>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                    </div>
                <?php endforeach;  ?>
            </div>
        </div>
    </section>
<?php endif;  ?>

<section class="featured-categories section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <div>
                        <h2>Daftar Produk</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($produk as $row):  ?>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-image">
                            <img src="<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>" alt="#">
                            <?= $row['harga_diskon'] > 0 ? '<span class="sale-tag">PROMOO</span>' : ''; ?>
                            <div class="button">
                                <a href="<?= base_url('produk/') . $row['id_produk'] . '/' . $row['slug_kategori'] . '/' . $row['slug_produk']; ?>" class="btn">
                                    <i class="lni lni-search-alt"></i> Detail
                                </a>
                            </div>
                        </div>
                        <div class="product-info" id="data-produk-<?= $row['id_produk']; ?>" data-id_produk="<?= $row['id_produk']; ?>" data-nama_produk="<?= $row['nama_produk']; ?>" data-gambar_produk="<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>" data-harga_produk="<?= $row['harga_varian']; ?>" data-harga_promo="<?= $row['harga_varian']; ?>">
                            <span class="category"><?= $row['nama_kategori']; ?></span>
                            <h4 class="title">
                                <a href=""><?= (strlen($row['nama_produk']) > 24 ? substr($row['nama_produk'], 0, 24) . '.. ' : $row['nama_produk']); ?></a>
                            </h4>
                            <div class="price mt-1 mb-2">
                                <?php if ($row['harga_diskon'] > 0):  ?>
                                    <span>Rp<?= number_format($row['harga_diskon'],); ?></span>
                                    <span class="discount-price">Rp<?= number_format($row['harga_varian'],); ?></span>
                                <?php else:  ?>
                                    <span>Rp<?= number_format($row['harga_varian'],); ?></span>
                                <?php endif;  ?>
                            </div>
                            <div>
                                <a href="<?= base_url('produk/') . $row['id_produk'] . '/' . $row['slug_kategori'] . '/' . $row['slug_produk']; ?>" class="btn btn-primary btn-sm"><i class="lni lni-cart"></i> keranjang</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                </div>
            <?php endforeach;  ?>
        </div>
    </div>
</section>
<!-- End Trending Product Area -->

<!-- shop info -->
<section class="shipping-info">
    <div class="container">
        <ul>
            <?php foreach ($layanan as $row):  ?>
                <li>
                    <div class="media-icon">
                        <?= $row['icon_layanan']; ?>
                    </div>
                    <div class="media-body">
                        <h5><?= $row['nama_layanan']; ?></h5>
                        <span><?= $row['deskripsi_layanan']; ?></span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<!-- end shop info -->

<div class="brands">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <div>
                        <h2>Produk Material & Patner Kami </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="brands-logo-wrapper">
            <div class="brands-logo-carousel d-flex align-items-center justify-content-between">
                <?php foreach ($patner as $row):  ?>
                    <div class="brand-logo">
                        <img src="<?= base_url('assets/images/patner/' . $row['logo_patner']); ?>" alt="#">
                    </div>
                <?php endforeach;  ?>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>assets/js/tiny-slider.js"></script>
<script type="text/javascript">
    //========= Hero Slider 
    tns({
        container: '.hero-slider',
        slideBy: 'page',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 0,
        items: 1,
        nav: false,
        controls: true,
        controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
    });

    //======== Brand Slider
    tns({
        container: '.brands-logo-carousel',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 15,
        nav: false,
        controls: false,
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 3,
            },
            768: {
                items: 5,
            },
            992: {
                items: 6,
            }
        }
    });
</script>
<?= $this->endSection(); ?>