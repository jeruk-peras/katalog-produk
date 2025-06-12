<?= $this->extend('pages/layout/layout'); ?>
<?= $this->section('content'); ?>
<!-- Start Contact Area -->
<section id="contact-us" class="contact-us section pt-5 pb-5">
    <div class="container">
        <div class="contact-head">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Kontak Kami</h2>
                        <p>Hubungi PT Nur Lisan Sakti untuk layanan body and painting terbaik. Kami siap membantu kebutuhan Anda dengan profesionalisme dan tanggung jawab.</p>
                    </div>
                </div>
            </div>
            <div class="contact-info">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="single-info-head">
                            <!-- Start Single Info -->
                            <div class="single-info">
                                <i class="lni lni-map"></i>
                                <h3>Alamat</h3>
                                <ul>
                                    <li><?= $alamat; ?></li>
                                </ul>
                            </div>
                            <!-- End Single Info -->
                            <!-- Start Single Info -->
                            <div class="single-info">
                                <i class="lni lni-phone"></i>
                                <h3>Telepon</h3>
                                <ul>
                                    <li><a href="tel:+18005554400"><?= $telepon; ?></a></li>
                                    <li><a href="https://wa.me/<?= $whatsApp; ?>"><?= $whatsApp; ?> (WhatsApp)</a></li>
                                </ul>
                            </div>
                            <!-- End Single Info -->
                            <!-- Start Single Info -->
                            <div class="single-info">
                                <i class="lni lni-envelope"></i>
                                <h3>EMail</h3>
                                <ul>
                                    <li><a href="mailto:<?= $email; ?>"><?= $email; ?></a></li>
                                </ul>
                            </div>
                            <!-- End Single Info -->
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-12">
                        <div class="contact-form-head">
                            <div class="form-main">
                                <form class="form" id="form-pesan" method="post" action="">
                                    <?= csrf_field();; ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="form-group">
                                                <input id="nama" type="text" name="nama" placeholder="Nama Lengkap">
                                                <div class="invalid-feedback" id="error_nama"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <input id="email" type="email" name="email" placeholder="Email">
                                                <div class="invalid-feedback" id="error_email"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <input id="notlp" type="text" name="notlp" placeholder="No Tepelon">
                                                <div class="invalid-feedback" id="error_notlp"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group message">
                                                <textarea id="pesan" name="pesan" maxlength="300" placeholder="Tuliskan pesan/pertanyaan disini"></textarea>
                                                <div class="invalid-feedback" id="error_pesan"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group button">
                                                <button type="submit" class="btn ">Kirim Pesan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <?= $embed_google_maps; ?>
</section>
<!--/ End Contact Area -->
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
        $('#form-pesan').on('submit', function(e) {
            e.preventDefault();

            var nama, email, notlp, pesan, url, formdata;

            nama = $('#nama').val()
            email = $('#email').val()
            notlp = $('#notlp').val()
            pesan = $('#pesan').val()

            url = $(this).attr('action')
            formdata = $(this).serializeArray()

            $('.invalid-feedback').text('');

            $.ajax({
                url: url,
                type: "POST",
                data: formdata,
                success: function(response) {
                    if (response.status === 200) {
                        $('#modal-form').modal('hide');

                        Toast.fire({
                            timer: 4000,
                            icon: 'success',
                            title: response.message || 'Pesan berhasil dikirim, silahkan tunggu balasan.'
                        });

                        $('#form-pesan')[0].reset(); // Reset form setelah submit

                        window.location.href = `https://api.whatsapp.com/send/?phone=<?= $whatsApp ?>&text=Saya ${nama}%0D%0AIngin bertanya tantang ${pesan}`

                    } else {

                        Toast.fire({
                            timer: 2000,
                            icon: 'error',
                            title: response.message
                        });
                        
                        // Jika ada error, tampilkan pesan error
                        for (var key in response.data) {
                            $('#' + key).addClass('is-invalid');
                            // Tambahkan pesan error ke dalam elemen yang sesuai
                            $('#error_' + key).text(response.data[key]);
                        }
                        
                    }
                },
                error: function() {
                    
                    Toast.fire({
                        timer: 2000,
                        icon: 'error',
                        title: 'Terjadi kesalahan saat mengirim data'
                    });
                }
            })
        })
    })
</script>

<?= $this->endSection(); ?>