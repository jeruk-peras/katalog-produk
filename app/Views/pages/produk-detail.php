<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Start Item Details -->
<section class="item-details section">
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
                        <h2 class="title"><?= $produk['nama_produk']; ?></h2>
                        <p class="category">
                            <i class="lni lni-tag"></i>
                            Drones:<a href="javascript:void(0)"><?= $produk['nama_kategori']; ?></a>
                        </p>

                        <h3 class="price">
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
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="input-group">
                                        <button class="input-group-text" id="btn-minus">-</button>
                                        <input type="text" class="form-control text-center" id="qty" value="1" readonly>
                                        <button class="input-group-text" id="btn-plus">+</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="form-group">
                                     <input type="text" class="form-control form-control-lg border-0" id="total-display" value="Rp <?= number_format($produk['harga_produk']); ?>" readonly>
                                    </div>
                                </div>
                                <input type="hidden" name="total" id="total">
                                <div class="col-lg-12 col-md-12 col-12 mb-3">
                                    <div class="button cart-button">
                                        <button class="btn" style="width: 100%;">+ Keranjang</button>
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

<script>
$(function() {
    var $qtyInput = $('#qty');
    var $priceInput = $('#total-display');
    var basePrice = <?= $produk['harga_produk']; ?>;

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
});
</script>
<!-- End Item Details -->
<?= $this->endSection(); ?>