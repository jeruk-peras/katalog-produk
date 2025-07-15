<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Start Product Grids -->
<section class="product-grids section pt-5 pb-5 ps-lg-5 pe-lg-5">
    <div class="container-fluid">
        <div class="row">
            <div class="d-lg-none d-md-none col-md-3 col-12">
                <div class="product-sidebar">
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
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-12">
                <div class="product-grids-head">
                    <div class="product-grid-topbar">
                        <div class="row align-items-center">
                            <div class="col-lg-10 col-md-10 col-9">
                                <div class="single-widget search">
                                    <form action="" method="get"> 
                                        <input type="text" name="query" placeholder="Cari disini ... " value="<?= request()->getGet('query') ?? ''; ?>">
                                        <button type="submit"><i class="lni lni-search-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-3">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab" data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid" aria-selected="true"><i class="lni lni-grid-alt"></i></button>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="nav-grid" role="tabpanel" aria-labelledby="nav-grid-tab">
                            <div class="row">
                                <?php foreach ($produk as $row): ?>
                                    <div class="col-lg-2 col-md-3 col-4">
                                        <div class="single-product">
                                            <div class="product-image" style="height: 200px; background-position: center; background-repeat: no-repeat; background-size: 100%; background-image: url('<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>');">
                                                <?= $row['harga_diskon'] > 0 ? '<span class="sale-tag">PROMOO</span>' : ''; ?>
                                                <div class="button">
                                                    <a href="<?= base_url('produk/') . $row['id_produk'] . '/' . $row['slug_kategori'] . '/' . $row['slug_produk']; ?>" class="btn">
                                                        <i class="lni lni-search-alt"></i> Detail
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-info p-1" id="data-produk-<?= $row['id_produk']; ?>" data-id_produk="<?= $row['id_produk']; ?>" data-nama_produk="<?= $row['nama_produk']; ?>" data-gambar_produk="<?= base_url(); ?>assets/images/produk/<?= $row['gambar']; ?>" data-harga_produk="<?= $row['harga_varian']; ?>" data-harga_promo="<?= $row['harga_varian']; ?>">
                                                <!-- <span class="category"><?= $row['nama_kategori']; ?></span> -->
                                                <h4 class="title" style="font-size: 10%;">
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
                                    </div>
                                <?php endforeach;  ?>
                            </div>
                            <?php if($page > 0):  ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="pagination left">
                                        <ul class="pagination-list">
                                            <?php for ($i = 0; $i <= $page; $i++):  ?>
                                                <li class="<?= (request()->getGet('page') == $i + 1 ? 'active' : ((request()->getGet('page') == null && $i == 0) ? 'active' : '' )); ?>"><a href="?page=<?= $i + 1; ?>"><?= $i + 1; ?></a></li>
                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endif;  ?>
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