<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/filepond/filepond.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-file-poster.min.css">
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>
<style>
    .filepond--item {
        width: calc(25% - 0.5em);
    }
</style>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Produk</li>
                    <li class="breadcrumb-item active" aria-current="page">Forms Produk</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <hr>
    <form class="row g-3" id="form-produk" action="<?= base_url('admin/produk/save'); ?>" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body row p-4">
                <?= csrf_field() ?>
                <div class="col-md-12">
                    <label class="form-label">Form Produk</label>
                    <input type="file" id="filepond" name="filepond[]" multiple />
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk">
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label">Deskripsi Produk</label>
                    <textarea name="deskripsi_produk" class="form-control" rows="5" id="tyni-mce"></textarea>
                </div>

                <hr class="mt-4">

                <div class="col-md-6 mt-4">
                    <label class="form-label">Harga Produk</label>
                    <input type="text" name="harga_produk" class="form-control" placeholder="Harga Produk">
                </div>

                <div class="col-md-6 mt-4">
                    <label class="form-label">Stok Produk</label>
                    <input type="text" name="stok_produk" class="form-control" placeholder="Stok Produk">
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlushReferensi">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-referensi" aria-expanded="false" aria-controls="flush-referensi">
                                Referensi Produk
                            </button>
                        </h2>
                        <div id="flush-referensi" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushReferensi">
                            <div class="accordion-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select" id="kategori_id" name="kategori_id">
                                            <option value="" hidden>Pilih Kategori</option>
                                            <?php foreach ($kategori as $row):  ?>
                                                <option value="<?= $row['id_kategori']; ?>"><?= $row['nama_kategori']; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlushspecifikasi">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-spesifikasi" aria-expanded="false" aria-controls="flush-spesifikasi">
                                Spesifikasi Produk
                            </button>
                        </h2>
                        <div id="flush-spesifikasi" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushspecifikasi">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12" id="item-spesifikasi"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 col-md-12">
            <div class="card-body">
                <div class="d-md-flex d-grid align-items-center justify-content-end gap-3">
                    <button type="button" class="btn btn-light px-4">Reset</button>
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#kategori_id').change(function() {
            var kategoriId = $(this).val();
            hendleSpesifikasi(kategoriId);
        });


        function hendleSpesifikasi(kategoriId) {
            $.ajax({
                url: '<?= base_url('admin/produk/fecthspesifiksai'); ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    kategori_id: kategoriId
                },
                success: function(response) {
                    if (response.status === 200) {
                        var html = '';
                        $.each(response.data, function(index, spesifikasi) {
                            html += `<div class="row mb-3">
                            <label for="input35" class="col-sm-3 col-form-label">${spesifikasi.nama_spesifikasi}</label>
                            <div class="col-sm-9">
                            <input type="text" name="spesifikasi[${spesifikasi.id_spesifikasi}]" class="form-control">
                            </div>
                            </div>`;
                        });
                        $('#item-spesifikasi').html(html);
                        console.log('Message: ' + response.message);
                    } else {
                        Toast.fire({
                            timer: 2000,
                            icon: 'error',
                            title: response.message || 'Terjadi kesalahan saat mengambil data.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        timer: 2000,
                        icon: 'error',
                        title: 'Terjadi kesalahan saat mengambil data.'
                    });
                }
            });
        }

    })
</script>

<script src="<?= base_url(); ?>assets/plugins/filepond/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<!-- <script src="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-file-poster.min.js"></script> -->
 <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-image-editor.min.js"></script>
<script type="module">
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateType,
        FilePondPluginImageEditor,
        FilePondPluginImageCrop,
    );

    var pond = FilePond.create(document.querySelector('input#filepond'), {
        // FilePond generic properties
        filePosterMaxHeight: 356,
        imageCropAspectRatio: '1:1',
    });

    FilePond.setOptions({
        server: {
            url: '<?= base_url('admin/produk') ?>',
            process: '/upload', // Endpoint untuk mengunggah file
            revert: '/revert', // Endpoint untuk menghapus file yang diunggah
        },
    });

    // $('a.filepond--credits').remove(); // Menghapus tautan kredit FilePond
</script>
<?= $this->endSection(); ?>