<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Forms</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Form Layouts</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <form action="" method="post" autocomplete="off">
                        <?= csrf_field(); ?>
                        <!-- Alamat -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Alamat</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <textarea type="text" name="alamat" id="field-alamat" class="form-control mb-1" rows="3"><?= $alamat; ?></textarea>
                            </div>
                        </div>
                        <!-- Google Maps -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Google Maps</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <input value="<?= $google_maps; ?>" type="text" name="google_maps" id="field-google_maps" class="form-control mb-1" placeholder="Google Maps URL">
                                <small class="text-muted">Add your Google Maps URL. (https://goo.gl/maps/xyz123)</small>
                            </div>
                        </div>
                        <!-- Embed Google Maps -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Embed Google Maps</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <textarea type="text" name="embed_google_maps" id="field-embed_google_maps" class="form-control mb-1" rows="3" placeholder="Embed Google Maps URL"><?= $embed_google_maps; ?></textarea>
                                <small class="text-muted">Add your Google Maps embed URL. (https://www.google.com/maps/embed?pb=...)</small>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Email</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <input value="<?= $email; ?>" type="text" name="email" id="field-email" class="form-control mb-1">
                                <small class="text-muted">Add your email address. (e.g. example@abc.com)</small>
                            </div>
                        </div>
                        <!-- Telepon -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Telepon</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <input value="<?= $telepon; ?>" type="text" name="telepon" id="field-telepon" class="form-control mb-1">
                                <small class="text-muted">Add your phone number. (e.g. 021-12345678)</small>
                            </div>
                        </div>
                        <!-- WhatsApp -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>WhatsApp</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <input value="<?= $whatsApp; ?>" type="text" name="whatsApp" id="field-whatsApp" class="form-control mb-1">
                                <small class="text-muted">Add your WhatsApp number. (e.g. 628123456789)</small>
                            </div>
                        </div>
                        <!-- youtube -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Youtube</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <input value="<?= $youtube; ?>" type="text" name="youtube" id="field-youtube" class="form-control mb-1">
                                <small class="text-muted">Add your Youtube username (e.g. johnsmith).</small>
                            </div>
                        </div>
                        <!-- instagram -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Instagram</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <input value="<?= $instagram; ?>" type="text" name="instagram" id="field-instagram" class="form-control mb-1">
                                <small class="text-muted">Add your Instagram username (e.g. johnsmith).</small>
                            </div>
                        </div>
                        <!-- Facebook -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-4 col-12">
                                <label>Facebook</label>
                            </div>
                            <div class="col-lg-9 col-md-8 col-12">
                                <input value="<?= $facebook; ?>" type="text" name="facebook" id="field-facebook" class="form-control mb-1">
                                <small class="text-muted">Add your Facebook username (e.g. johnsmith).</small>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="row">
                            <div class="offset-lg-3 col-lg-6 col-12">
                                <button type="submit" class="btn btn-primary">Simpan Kontak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--end row-->
</div>
<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                url: '', // gunakan action form, atau isi dengan endpoint jika berbeda
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        Toast.fire({
                            timer: 2000,
                            icon: 'success',
                            title: response.message || 'Data berhasil dihapus.'
                        });
                        table.ajax.reload(null, false); // Reload data tanpa reset pagination
                    } else {
                        Toast.fire({
                            timer: 2000,
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function() {
                    Toast.fire({
                        timer: 2000,
                        icon: 'error',
                        title: 'Terjadi kesalahan saat menghapus data.'
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>