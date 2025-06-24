<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Start Item Details -->
<section class="item-details section pt-5 pb-5">
    <div class="container">
        <div>
            <a href="<?= base_url('produk'); ?>" class="badge bg-primary mb-2 fs-6">
                < daftar produk</a>
        </div>
        <div class="top-area" id="data-produk" data-id_produk="<?= $produk['id_produk']; ?>" data-nama_produk="<?= $produk['nama_produk']; ?>" data-id_varian="<?= $produk['id_varian']; ?>" data-stok_varian="<?= $produk['stok_varian']; ?>" data-nama_varian="<?= $produk['nama_varian']; ?>" data-harga_produk="<?= $produk['harga_varian']; ?>" data-harga_diskon="<?= $produk['harga_diskon']; ?>" data-gambar="<?= base_url('assets/images/produk/' . $gambar[0]['gambar']); ?>">
            <div class="row align-align-items-start">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="product-images">
                        <main id="gallery">
                            <div class="main-img">
                                <img src="<?= base_url('assets/images/produk/' . $gambar[0]['gambar']); ?>" id="current" alt="#">
                            </div>
                            <div class="images">
                                <?php foreach ($gambar as $row):  ?>
                                    <img src="<?= base_url('assets/images/produk/' . $row['gambar']); ?>" class="img" alt="#">
                                <?php endforeach;  ?>
                            </div>
                        </main>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 col-12">
                    <div class="product-info">
                        <h2 class="title"><?= $produk['nama_produk']; ?> <br> <span class="fs-6" id="nama_varian"><?= $produk['nama_varian']; ?></span></h2>
                        <p class="category">
                            <i class="lni lni-tag"></i> <?= $produk['nama_kategori']; ?>
                        </p>

                        <h3 class="price" id="price-produk">
                            <?php if ($produk['harga_diskon'] > 0):  ?>
                                Rp<a id="harga_produk"><?= number_format($produk['harga_diskon']); ?></a>
                                <span class="discount-price" id="harga_diskon">Rp <?= number_format($produk['harga_varian'],); ?></span>
                            <?php else:  ?>
                                Rp<a id="harga_produk"><?= number_format($produk['harga_varian']); ?></a>
                                <span class="discount-price d-none" id="harga_diskon">Rp <?= number_format($produk['harga_varian'],); ?></span>
                            <?php endif;  ?>
                        </h3>

                        <div class="product-details-info">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="info-body g-2">
                                        <?php foreach ($varian as $row): ?>
                                            <input type="radio" class="btn-check" name="varian" <?= ($produk['id_varian'] == $row['id_varian'] ? 'checked' : ''); ?> id="<?= $row['id_varian']; ?>" autocomplete="off">
                                            <label
                                                class="btn btn-sm btn-outline-primary mb-1 btn-varian position-relative"
                                                for="<?= $row['id_varian']; ?>"
                                                data-id_varian="<?= $row['id_varian']; ?>"
                                                data-nama_varian="<?= $row['nama_varian']; ?>"
                                                data-stok_varian="<?= $row['stok_varian']; ?>"
                                                data-harga_varian="<?= $row['harga_varian']; ?>"
                                                data-harga_diskon="<?= $row['harga_diskon']; ?>">
                                                <?= $row['nama_varian']; ?>
                                                <?= $row['harga_diskon'] > 0 ? '<span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger">%</span>' : ''; ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
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
                                            <span class="me-2">Sisa Stok : <span id="stok_produk"><?= $produk['stok_varian']; ?></span></span>
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
                                                <input type="text" class="form-control form-control-lg border-0" id="total-display" value="Rp <?= number_format( ($produk['harga_diskon'] ? $produk['harga_diskon'] : $produk['harga_varian'])); ?>" readonly>
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
        <div class="product-details-info">
            <div class="single-block">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="info-body custom-responsive-margin">
                            <h4>Details</h4>
                            <?= $produk['deskripsi_produk']; ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="info-body">
                            <h4>Spesifikasi</h4>
                            <ul class="normal-list">
                                <?php foreach ($spesifikasi as $row):  ?>
                                    <li><strong><?= $row['nama_spesifikasi']; ?>:</strong> <?= $row['value']; ?></li>
                                <?php endforeach;  ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
    $(function() {
        var $qtyInput = $('#qty');
        var $priceInput = $('#total-display');

        $qtyInput.keyup(function() {
            var harga_produk, harga_diskon, stok_varian;
            harga_produk = $('#data-produk').attr('data-harga_produk');
            harga_diskon = $('#data-produk').attr('data-harga_diskon');
            stok_varian = $('#data-produk').attr('data-stok_varian');
            
            var basePrice = (harga_diskon > 0 ? harga_diskon : harga_produk)
            var qty = parseInt($qtyInput.val(), 10);

            if(qty > stok_varian ){
                $qtyInput.val(stok_varian)
                qty = stok_varian
            }

            var $price = (basePrice * qty) || 0
            $priceInput.val('Rp ' + ($price).toLocaleString('id-ID'));
            $('#total').val($price);
        })
        
        $('#btn-minus').on('click', function() {
            var harga_produk, harga_diskon, stok_varian;
            harga_produk = $('#data-produk').attr('data-harga_produk');
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
            harga_produk = $('#data-produk').attr('data-harga_produk');
            harga_diskon = $('#data-produk').attr('data-harga_diskon');
            stok_varian = $('#data-produk').attr('data-stok_varian');
            
            var basePrice = (harga_diskon > 0 ? harga_diskon : harga_produk)
            var qty = parseInt($qtyInput.val(), 10);

            if(qty < stok_varian){
                qty++;
                $qtyInput.val(qty);
                $priceInput.val('Rp ' + (basePrice * qty).toLocaleString('id-ID'));
                $('#total').val(basePrice * qty);
            }

        });


        // hendle varian
        $('.btn-varian').click(function() {
            var id_varian, nama_varian, harga_varian, harga_diskon, stok_varian;
            id_varian = $(this).data('id_varian')
            nama_varian = $(this).data('nama_varian')
            harga_varian = $(this).data('harga_varian')
            stok_varian = $(this).data('stok_varian')
            harga_diskon = $(this).data('harga_diskon')
            var qty = parseInt($qtyInput.val(), 10);
            $qtyInput.val(1)

            $('span#nama_varian').text(nama_varian);
            $('span#stok_produk').text(stok_varian);
            if (harga_diskon > 0) {
                $('a#harga_produk').text(harga_diskon.toLocaleString('id-ID'))
                $('span#harga_diskon').text(`Rp` + (harga_varian.toLocaleString('id-ID')));
                $('span#harga_diskon').removeClass('d-none');
                $('input#total-display').val((harga_diskon * qty).toLocaleString('id-ID'))
            } else {
                $('a#harga_produk').text(harga_varian.toLocaleString('id-ID'))
                $('span#harga_diskon').addClass('d-none');
                $('input#total-display').val((harga_varian * qty).toLocaleString('id-ID'))
            }

            $('#data-produk').attr('data-id_varian', id_varian);
            $('#data-produk').attr('data-nama_varian', nama_varian);
            $('#data-produk').attr('data-stok_varian', stok_varian);
            $('#data-produk').attr('data-harga_produk', harga_varian);
            $('#data-produk').attr('data-harga_diskon', harga_diskon);
        })


        $('#cart-button').on('click', function() {
            var gambar = $('#data-produk').data('gambar');
            var id_produk = $('#data-produk').data('id_produk');
            var nama_produk = $('#data-produk').data('nama_produk');
            var id_varian = $('#data-produk').attr('data-id_varian');
            var nama_varian = $('#data-produk').attr('data-nama_varian');
            var stok_varian = $('#data-produk').attr('data-stok_varian');
            var harga = $('#data-produk').attr('data-harga_produk');
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
            if(jumlah > stok_varian){
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
<!-- End Item Details -->
<?= $this->endSection(); ?>