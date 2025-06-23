<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Start Product Grids -->
<section class="product-grids section pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12">
                <!-- Start Product Sidebar -->
                <div class="product-sidebar">

                    <!-- Start Single Widget -->
                    <div class="single-widget">
                        <h3>Kategori Produk</h3>
                        <ul class="list">
                            <?php foreach (getKategori() as $row):  ?>
                                <li>
                                    <a href="<?= base_url('produk/kategori/' . $row['slug_kategori']); ?>"> <?= $row['nama_kategori']; ?> </a>
                                </li>
                            <?php endforeach;  ?>
                        </ul>
                    </div>
                    <!-- End Single Widget -->

                </div>
                <!-- End Product Sidebar -->
            </div>
            <div class="col-lg-9 col-12">
                <div class="product-grids-head">
                    <div class="product-grid-topbar">
                        <div class="row align-items-center">
                            <div class="col-lg-10 col-md-8 col-12">

                                <!-- <div class="product-sidebar"> -->
                                <!-- Start Single Widget -->
                                <div class="single-widget search">
                                    <form action="#">
                                        <input type="text" placeholder="Search Here...">
                                        <button type="submit"><i class="lni lni-search-alt"></i></button>
                                    </form>
                                </div>
                                <!-- </div> -->
                            </div>
                            <div class="col-lg-2 col-md-4 col-12">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab" data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid" aria-selected="true"><i class="lni lni-grid-alt"></i></button>
                                        <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list" aria-selected="false"><i class="lni lni-list"></i></button>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
                            <div class="row">
                                <?php foreach ($produk as $row): ?>
                                    <div class="col-lg-4 col-md-6 col-12">
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
                                                    <a href=""><?= (strlen($row['nama_produk']) > 24 ? substr($row['nama_produk'], 0, 24) . '.. ' : $row['nama_produk'] ); ?></a>
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
                                    </div>
                                <?php endforeach;  ?>
                            </div>
                            <!-- <div class="row">
                                <div class="col-12">
                                    <div class="pagination left">
                                        <ul class="pagination-list">
                                            <li><a href="javascript:void(0)">1</a></li>
                                            <li class="active"><a href="javascript:void(0)">2</a></li>
                                            <li><a href="javascript:void(0)">3</a></li>
                                            <li><a href="javascript:void(0)">4</a></li>
                                            <li><a href="javascript:void(0)"><i class="lni lni-chevron-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                            <div class="row">
                                <?php foreach ($produk as $row): ?>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <!-- Start Single Product -->
                                        <div class="single-product">
                                            <div class="row align-items-center">
                                                <div class="col-lg-4 col-md-4 col-12">
                                                    <div class="product-image">
                                                        <img src="<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>" alt="#">
                                                        <?= $row['harga_diskon'] > 0 ? '<span class="sale-tag">PROMOO</span>' : ''; ?> 
                                                        <div class="button">
                                                            <a href="<?= base_url('produk/') . $row['id_produk'] . '/' . $row['slug_kategori'] . '/' . $row['slug_produk']; ?>" class="btn">
                                                                <i class="lni lni-search-alt"></i> Detail
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-12">
                                                    <div class="product-info" id="data-produk-<?= $row['id_produk']; ?>" data-id_produk="<?= $row['id_produk']; ?>" data-nama_produk="<?= $row['nama_produk']; ?>" data-gambar_produk="<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>" data-harga_produk="<?= $row['harga_varian']; ?>" data-harga_promo="<?= $row['harga_varian']; ?>">
                                                        <span class="category"><?= $row['nama_kategori']; ?></span>
                                                        <h4 class="title">
                                                            <a href="" class="fs-5"><?= (strlen($row['nama_produk']) > 50 ? substr($row['nama_produk'], 0, 50) . '.. ' : $row['nama_produk'] ); ?></a> <br>
                                                            <a href="" class="fs-6"><?= $row['nama_varian']; ?></a>
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
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;  ?>
                            </div>
                            <!-- <div class="row">
                                <div class="col-12">
                                    <div class="pagination left">
                                        <ul class="pagination-list">
                                            <li><a href="javascript:void(0)">1</a></li>
                                            <li class="active"><a href="javascript:void(0)">2</a></li>
                                            <li><a href="javascript:void(0)">3</a></li>
                                            <li><a href="javascript:void(0)">4</a></li>
                                            <li><a href="javascript:void(0)"><i class="lni lni-chevron-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Product Grids -->
<link type="text/css" href="<?= base_url(); ?>assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>

<script>
    //alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
<script>
    $(document).ready(function() {
        var lastView = localStorage.getItem('produk_view_mode');
        if (lastView === 'list') {
            $('#nav-list-tab').tab('show');
        } else if (lastView === 'grid') {
            $('#nav-grid-tab').tab('show');
        }

        $('#nav-list-tab').on('click', function() {
            localStorage.setItem('produk_view_mode', 'list');
        });
        $('#nav-grid-tab').on('click', function() {
            localStorage.setItem('produk_view_mode', 'grid');
        });
    });
</script>
<?= $this->endSection(); ?>