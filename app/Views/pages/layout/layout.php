<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title><?= $title; ?> - PT. NUR LISAN SAKTI.</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?= base_url(); ?>assets/images/favicon-32x32.png" type="image/png" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/LineIcons.3.0.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/tiny-slider.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/glightbox.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/main.css" />
    <link href="<?= base_url(); ?>assets/css/icons.css" rel="stylesheet">

    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>

</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <?= $this->include('pages/layout/header'); ?>
    <!-- End Header Area -->
     
    <?= $this->renderSection('content'); ?>

    <!-- Start Footer Area -->
    <?= $this->include('pages/layout/footer'); ?>
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
    <!-- <script src="<?= base_url() ?>assets/js/glightbox.min.js"></script> -->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var totalItems = localStorage.getItem('total-items') || 0;
            $('#total-items').text(totalItems);
        });

        const current = document.getElementById("current");
        const opacity = 0.6;
        const imgs = document.querySelectorAll(".img");
        imgs.forEach(img => {
            img.addEventListener("click", (e) => {
                //reset opacity
                imgs.forEach(img => {
                    img.style.opacity = 1;
                });
                current.src = e.target.src;
                //adding class 
                //current.classList.add("fade-in");
                //opacity
                e.target.style.opacity = opacity;
            });
        });
    </script>
</body>

</html>