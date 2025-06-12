<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">About</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Form About</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 col-12">
                                    <label>Gambar</label>
                                </div>
                                <div class="col-lg-9 col-md-8 col-12">
                                    <input value="" type="file" name="gambar" accept="image/*" id="gambar" class="form-control mb-1">
                                    <img src="<?= base_url('assets/images/'.$gambar); ?>" id="preview" alt="gambar">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 col-12">
                                    <label>Judul</label>
                                </div>
                                <div class="col-lg-9 col-md-8 col-12">
                                    <input value="<?= $judul; ?>" type="text" name="judul" id="judul" class="form-control mb-1">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 col-12">
                                    <label>Alamat</label>
                                </div>
                                <div class="col-lg-9 col-md-8 col-12">
                                    <textarea type="text" name="text" id="tyni-mce" class="form-control mb-1" rows="4"><?= $text; ?></textarea>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="row">
                                <div class="offset-lg-3 col-lg-6 col-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div><!--end row-->
</div>

<script>
$(function() {
    $('#gambar').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result).css({
                    'max-width': '200px',
                    'margin-top': '10px',
                    'display': 'block'
                });
            }
            reader.readAsDataURL(file);
        } else {
            $('#preview').attr('src', '').hide();
        }
    });
});
</script>
<?= $this->endSection(); ?>