<header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="index-2.html">Home</a></li>
                                <li><a href="about-us.html">About Us</a></li>
                                <li><a href="contact.html">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                            <div class="user">
                                <i class="lni lni-user"></i>
                                Hello
                            </div>
                            <ul class="user-login">
                                <li>
                                    <a href="login.html">Sign In</a>
                                </li>
                                <li>
                                    <a href="register.html">Register</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-3 col-md-3 col-7">
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
                    <div class="col-lg-7 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <!-- navbar search start -->
                            <div class="navbar-search search-style-5">
                                <div class="search-input">
                                    <input type="text" placeholder="Search">
                                </div>
                                <div class="search-btn">
                                    <button><i class="bx bx-search"></i></button>
                                </div>
                            </div>
                            <!-- navbar search Ends -->
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-2 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="navbar-cart">
                                <div class="cart-items">
                                    <a href="javascript:void(0)" class="main-btn">
                                        <i class="lni lni-cart"></i>
                                        <span class="total-items">2</span>
                                    </a>
                                    <!-- Shopping Item -->
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>2 Items</span>
                                            <a href="cart.html">View Cart</a>
                                        </div>
                                        <ul class="shopping-list">
                                            <li>
                                                <a href="javascript:void(0)" class="remove" title="Remove this item"><i
                                                        class="lni lni-close"></i></a>
                                                <div class="cart-img-head">
                                                    <a class="cart-img" href="product-details.html"><img
                                                            src="<?= base_url(); ?>assets/images/header/cart-items/item1.jpg" alt="#"></a>
                                                </div>

                                                <div class="content">
                                                    <h4><a href="product-details.html">
                                                            Apple Watch Series 6</a></h4>
                                                    <p class="quantity">1x - <span class="amount">$99.00</span></p>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="remove" title="Remove this item"><i
                                                        class="lni lni-close"></i></a>
                                                <div class="cart-img-head">
                                                    <a class="cart-img" href="product-details.html"><img
                                                            src="<?= base_url(); ?>assets/images/header/cart-items/item2.jpg" alt="#"></a>
                                                </div>
                                                <div class="content">
                                                    <h4><a href="product-details.html">Wi-Fi Smart Camera</a></h4>
                                                    <p class="quantity">1x - <span class="amount">$35.00</span></p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span class="total-amount">$134.00</span>
                                            </div>
                                            <div class="button">
                                                <a href="checkout.html" class="btn animate">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Shopping Item -->
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
                <div class="col-lg-12 col-md-6 col-12">
                    <div class="nav-inner">
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
                                        <a href="<?= base_url('beranda'); ?>" class="active" aria-label="Toggle navigation">Beranda</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="contact.html" aria-label="Toggle navigation">Tentang Kami</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="contact.html" aria-label="Toggle navigation">Produk</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('kontak'); ?>" aria-label="Toggle navigation">Kontak Kami</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->
    </header>