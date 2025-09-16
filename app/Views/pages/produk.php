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
                                                    <!-- <a href="<?= base_url('produk/') . $row['id_produk'] . '/' . $row['slug_kategori'] . '/' . $row['slug_produk']; ?>" class="btn btn-primary btn-sm"><i class="lni lni-cart"></i> keranjang</a> -->
                                                    <button type="button" data-produk_id="<?= $row['id_produk']; ?>" class="btn btn-primary btn-sm btn-chart"><i class="lni lni-cart"></i> keranjang</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;  ?>
                            </div>
                            <?php if ($page > 0):  ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="pagination left">
                                            <ul class="pagination-list">
                                                <?php for ($i = 0; $i <= $page; $i++):  ?>
                                                    <li class="<?= (request()->getGet('page') == $i + 1 ? 'active' : ((request()->getGet('page') == null && $i == 0) ? 'active' : '')); ?>"><a href="?page=<?= $i + 1; ?>"><?= $i + 1; ?></a></li>
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

<!-- Modal -->
<div class="modal modal-xl fade" id="modal-keranjang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body item-details">
                <div class="top-area" id="data-produk" data-id_produk="" data-nama_produk="" data-id_varian="" data-nama_varian="" data-stok_varian="" data-harga_varian="" data-harga_diskon="" data-gambar="">
                    <div class="row align-align-items-start">
                        <div class="col-lg-5 col-md-12 col-12">
                            <img src="" id="gambar-produk" style="max-width: 100%;" alt="Gambar Produk">
                        </div>
                        <div class="col-lg-7 col-md-12 col-12">
                            <div class="product-info">
                                <h2 class="title">
                                    <span id="nama-produk"></span> <br>
                                    <span class="fs-6" id="nama-varian"></span>
                                </h2>
                                <h3 class="price" id="price-produk">
                                    Rp<a id="harga_varian"></a>
                                    <span class="discount-price d-none" id="harga_diskon"></span>
                                </h3>

                                <div class="product-details-info">
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="info-body g-2" id="varian-data"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-content">
                                    <div class="row align-items-end justify-content-center">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-1">

                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="input-group">
                                                        <button class="input-group-text" id="btn-minus">-</button>
                                                        <input type="tel" class="form-control text-center" id="qty" maxlength="4" value="1">
                                                        <button class="input-group-text" id="btn-plus">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <span class="me-2">Sisa Stok : <span id="stok_varian"></span></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-4 text-end">
                                                    <span class="me-2">Subtotal :</span>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-lg border-0" id="total-display" value="" readonly="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="total" id="total">
                                        <div class="col-lg-12 col-md-12 col-12 mb-3">
                                            <div class="button cart-button">
                                                <button class="btn" style="width: 100%;" id="cart-button">+ Keranjang</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        var $qtyInput = $('#qty');
        var $priceInput = $('#total-display');

        // hendle modal keranjang
        $('.btn-chart').click(function(e) {
            e.preventDefault();

            var id = $(this).attr('data-produk_id');
            // get data produk by id
            $.ajax({
                url: id + '/produk',
                type: 'get',
                dataType: 'json',
                data: '',
                success: function(response) {
                    var qty = parseInt($qtyInput.val(), 10);
                    $qtyInput.val(1)

                    var produk = response.data.produk;
                    $('#gambar-produk').attr('src', produk.gambar);
                    $('span#nama-produk').text(produk.nama_produk);
                    $('span#nama-varian').text(produk.nama_varian);
                    $('span#stok_varian').text(produk.stok_varian);
                    $('input#total-display').val((produk.harga_varian * qty).toLocaleString('id-ID'))

                    if (produk.harga_diskon > 0) {
                        $('a#harga_varian').text(parseInt(produk.harga_diskon).toLocaleString('id-ID'));
                        $('span#harga_diskon').text(`Rp` + (parseInt(produk.harga_varian).toLocaleString('id-ID')));
                        $('span#harga_diskon').removeClass('d-none');
                        $('input#total-display').val((produk.harga_diskon * qty).toLocaleString('id-ID'));
                    } else {
                        $('a#harga_varian').text(parseInt(produk.harga_varian).toLocaleString('id-ID'));
                        $('span#harga_diskon').addClass('d-none');
                        $('input#total-display').val((produk.harga_varian * qty).toLocaleString('id-ID'));
                    }

                    $('#data-produk').attr('data-id_produk', produk.id_produk);
                    $('#data-produk').attr('data-nama_produk', produk.nama_produk);
                    $('#data-produk').attr('data-id_varian', produk.id_varian);
                    $('#data-produk').attr('data-nama_varian', produk.nama_varian);
                    $('#data-produk').attr('data-stok_varian', produk.stok_varian);
                    $('#data-produk').attr('data-harga_varian', produk.harga_varian);
                    $('#data-produk').attr('data-harga_diskon', produk.harga_diskon);

                    var varian = response.data.varian
                    var html = '';
                    $.each(varian, function(_, item) {
                        html += `
                            <input type="radio" class="btn-check" name="varian" ${item.id_varian == produk.id_varian ? 'checked' : ''} id="${item.id_varian}" autocomplete="off">
                            <label class="btn btn-sm btn-outline-primary mb-1 btn-varian position-relative" 
                                for="${item.id_varian}" 
                                data-id_varian="${item.id_varian}" 
                                data-nama_varian="${item.nama_varian}" 
                                data-stok_varian="${item.stok_varian}" 
                                data-harga_varian="${item.harga_varian}" 
                                data-harga_diskon="${item.harga_diskon}">
                                ${item.nama_varian} 
                                ${item.harga_diskon > 0 ? '<span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger">%</span>' : ''}
                                </label>`;
                    })
                    $('#varian-data').html(html);

                },
                error: function() {

                }
            })

            $('#modal-keranjang').modal('show');
        })

        // hendle varian
        $(document).on('click', '.btn-varian', function() {
            var id_varian, nama_varian, harga_varian, harga_diskon, stok_varian;
            id_varian = $(this).attr('data-id_varian')
            nama_varian = $(this).attr('data-nama_varian')
            harga_varian = $(this).attr('data-harga_varian')
            stok_varian = $(this).attr('data-stok_varian')
            harga_diskon = $(this).attr('data-harga_diskon')
            $qtyInput.val(1)
            var qty = parseInt($qtyInput.val(), 10);

            $('span#nama-varian').text(nama_varian);
            $('span#stok_varian').text(stok_varian);
            if (harga_diskon > 0) {
                $('a#harga_varian').text(harga_diskon.toLocaleString('id-ID'))
                $('span#harga_diskon').text(`Rp` + (harga_varian.toLocaleString('id-ID')));
                $('span#harga_diskon').removeClass('d-none');
                $('input#total-display').val((harga_diskon * qty).toLocaleString('id-ID'))
            } else {
                $('a#harga_varian').text(harga_varian.toLocaleString('id-ID'))
                $('span#harga_diskon').addClass('d-none');
                $('input#total-display').val((harga_varian * qty).toLocaleString('id-ID'))
            }

            $('#data-produk').attr('data-id_varian', id_varian);
            $('#data-produk').attr('data-nama_varian', nama_varian);
            $('#data-produk').attr('data-stok_varian', stok_varian);
            $('#data-produk').attr('data-harga_varian', harga_varian);
            $('#data-produk').attr('data-harga_diskon', harga_diskon);
        })

        $qtyInput.keyup(function() {
            var harga_produk, harga_diskon, stok_varian;
            harga_produk = $('#data-produk').attr('data-harga_varian');
            harga_diskon = $('#data-produk').attr('data-harga_diskon');
            stok_varian = $('#data-produk').attr('data-stok_varian');

            var basePrice = (harga_diskon > 0 ? harga_diskon : harga_produk)
            var qty = parseInt($qtyInput.val(), 10);

            if (qty > stok_varian) {
                $qtyInput.val(stok_varian)
                qty = stok_varian
            }

            var $price = (basePrice * qty) || 0
            $priceInput.val('Rp ' + ($price).toLocaleString('id-ID'));
            $('#total').val($price);
        })

        $('#btn-minus').on('click', function() {
            var harga_produk, harga_diskon, stok_varian;
            harga_produk = $('#data-produk').attr('data-harga_varian');
            harga_diskon = $('#data-produk').attr('data-harga_diskon');
            stok_varian = $('#data-produk').attr('data-stok_varian');

            var basePrice = (harga_diskon > 0 ? harga_diskon : harga_produk)
            var qty = parseInt($qtyInput.val(), 10);
            if (qty > 1) {
                qty--;
                $qtyInput.val(qty);
                $priceInput.val('Rp ' + (basePrice * qty).toLocaleString('id-ID'));
                $('#total').val(basePrice * qty);
            }
        });

        $('#btn-plus').on('click', function() {
            var harga_produk, harga_diskon, stok_varian;
            harga_produk = $('#data-produk').attr('data-harga_varian');
            harga_diskon = $('#data-produk').attr('data-harga_diskon');
            stok_varian = $('#data-produk').attr('data-stok_varian');

            var basePrice = (harga_diskon > 0 ? harga_diskon : harga_produk)
            var qty = parseInt($qtyInput.val(), 10);

            if (qty < stok_varian) {
                qty++;
                $qtyInput.val(qty);
                $priceInput.val('Rp ' + (basePrice * qty).toLocaleString('id-ID'));
                $('#total').val(basePrice * qty);
            }

        });

        $('#cart-button').on('click', function() {
            var gambar = $('#data-produk').attr('data-gambar');
            var id_produk = $('#data-produk').attr('data-id_produk');
            var nama_produk = $('#data-produk').attr('data-nama_produk');
            var id_varian = $('#data-produk').attr('data-id_varian');
            var nama_varian = $('#data-produk').attr('data-nama_varian');
            var stok_varian = $('#data-produk').attr('data-stok_varian');
            var harga = $('#data-produk').attr('data-harga_varian');
            var harga_diskon = $('#data-produk').attr('data-harga_diskon');
            var jumlah = parseInt($('#qty').val(), 10) || 1;
            var total = (harga_diskon > 0 ? harga_diskon : harga) * jumlah;

            var item = {
                gambar: gambar,
                id_produk: id_produk,
                nama_produk: `${nama_produk}`,
                id_varian: parseInt(id_varian),
                nama_varian: `${nama_varian}`,
                stok_varian: parseInt(stok_varian),
                harga: parseInt(harga),
                harga_diskon: parseInt(harga_diskon),
                jumlah: jumlah,
                total: total
            };

            // validasi stok
            if (jumlah > stok_varian) {
                Toast.fire({
                    timer: 2000,
                    icon: 'error',
                    title: 'Jumlah order melebihi sisa stok!'
                });
                return;
            }

            console.log(item)
            // return;

            var keranjang = JSON.parse(localStorage.getItem('keranjang_belanja')) || [];
            var exists = keranjang.some(function(prod) {
                return prod.id_produk == id_produk && prod.id_varian == id_varian;
            });

            if (exists) {
                Toast.fire({
                    timer: 2000,
                    icon: 'error',
                    title: 'Produk sudah ada di keranjang!'
                });
                return;
            }

            keranjang.push(item);
            localStorage.setItem('keranjang_belanja', JSON.stringify(keranjang));
            localStorage.setItem('total-items', keranjang.length);
            $('#total-items').text(keranjang.length);

            Toast.fire({
                timer: 2000,
                icon: 'success',
                title: 'Produk berhasil dimasukkan ke keranjang!'
            });
        });
    });
</script>
<?= $this->endSection(); ?>