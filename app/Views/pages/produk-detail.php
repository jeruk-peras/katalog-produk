<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Start Item Details -->
<section class="item-details section pt-5 pb-5">
    <div class="container">
        <div class="top-area">
            <div class="row align-align-items-start">
                <div class="col-lg-6 col-md-12 col-12">
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
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="product-info">
                        <h2 class="title" id="product-name" data-id_product="<?= $produk['id_produk']; ?>"><?= $produk['nama_produk']; ?></h2>
                        <p class="category">
                            <i class="lni lni-tag"></i> <a href="?l=<?= $produk['slug_kategori']; ?>"><?= $produk['nama_kategori']; ?></a>
                        </p>

                        <h3 class="price" data-price="<?= number_format($produk['harga_produk']); ?>" data-disc-price="<?= number_format($produk['harga_produk']); ?>">
                            Rp <?= number_format($produk['harga_produk']); ?> <span>Rp <?= number_format($produk['harga_produk']); ?></span>
                        </h3>

                        <div class="product-details-info">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="info-body custom-responsive-margin">
                                        <h4 class="mb-0">Details</h4>
                                        <p class="mt-1">
                                            <?= $produk['deskripsi_produk']; ?>
                                        </p>
                                    </div>

                                    <div class="info-body">
                                        <h4 class="mb-2">Spesifikasi</h4>
                                        <ul class="normal-list">
                                            <?php foreach ($spesifikasi as $row):  ?>
                                                <li><strong><?= $row['nama_spesifikasi']; ?>:</strong> <?= $row['value']; ?></li>
                                            <?php endforeach;  ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-content">
                            <div class="row align-items-end justify-content-center">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
                                    <div class="input-group">
                                        <button class="input-group-text" id="btn-minus">-</button>
                                        <input type="tel" class="form-control text-center" id="qty" maxlength="4" value="1">
                                        <button class="input-group-text" id="btn-plus">+</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg border-0" id="total-display" value="Rp <?= number_format($produk['harga_produk']); ?>" readonly>
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
        var basePrice = <?= $produk['harga_produk']; ?>;

        $qtyInput.keyup(function() {
            var qty = parseInt($qtyInput.val(), 10);
            var $price = (basePrice * qty) || 0
            $priceInput.val('Rp ' + ($price).toLocaleString('id-ID'));
            $('#total').val($price);
        })

        $('#btn-minus').on('click', function() {
            var qty = parseInt($qtyInput.val(), 10);
            if (qty > 1) {
                qty--;
                $qtyInput.val(qty);
                $priceInput.val('Rp ' + (basePrice * qty).toLocaleString('id-ID'));
                $('#total').val(basePrice * qty);
            }
        });

        $('#btn-plus').on('click', function() {
            var qty = parseInt($qtyInput.val(), 10);
            qty++;
            $qtyInput.val(qty);
            $priceInput.val('Rp ' + (basePrice * qty).toLocaleString('id-ID'));
            $('#total').val(basePrice * qty);
        });


        $('#cart-button').on('click', function() {
            var id_produk = $('#product-name').data('id_product')
            var gambar = $('img#current').attr('src')
            var nama_produk = $('#product-name').text();
            var harga = parseInt($('.price').data('price').replace(/[^0-9]/g, '')) || 0;
            var harga_promo = parseInt($('.price').data('disc-price').replace(/[^0-9]/g, '')) || 0;
            var jumlah = parseInt($('#qty').val(), 10) || 1;
            var total = harga * jumlah;

            var item = {
                id_produk: id_produk,
                gambar: gambar,
                nama_produk: `${nama_produk}`,
                harga: harga,
                harga_promo: harga_promo,
                jumlah: jumlah,
                total: total
            };


            var keranjang = JSON.parse(localStorage.getItem('keranjang_belanja')) || [];
            var exists = keranjang.some(function(prod) {
                return prod.id_produk == id_produk;
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