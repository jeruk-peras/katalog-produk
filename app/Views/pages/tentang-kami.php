<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Start About Area -->
<section class="about-us section pt-5 pb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-12">
                <div class="content-left">
                    <img src="<?= base_url('assets/images/'.getAbout('gambar')); ?>" alt="#">
                    <!-- <a href="https://www.youtube.com/watch?v=r44RKWyfcFw&amp;fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM" class="glightbox video"><i class="lni lni-play"></i></a> -->
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <!-- content-1 start -->
                <div class="content-right">
                    <h2><?= getAbout('judul'); ?></h2>
                    <p><?= getAbout('text'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Area -->

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
<?= $this->endSection(); ?>