<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/filepond/filepond.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-file-poster.min.css">
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet" />
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
    <form class="row g-3" id="form-produk" action="<?= base_url('admin/produk/update/' . $id_produk); ?>" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body row p-4">
                <?= csrf_field() ?>
                <div class="col-md-12">
                    <input type="file" id="filepond" name="filepond[]" multiple />
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label">Nama Produk <span class="text-danger">*<?= validation_show_error('nama_produk'); ?></span></label>
                    <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" value="<?= $arraydata['nama_produk']; ?>">
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label">Deskripsi Produk <span class="text-danger">*<?= validation_show_error('deskripsi_produk'); ?></span></label>
                    <textarea name="deskripsi_produk" class="form-control" rows="5" id="tyni-mce"><?= $arraydata['deskripsi_produk']; ?></textarea>
                </div>

                <hr class="mt-4">

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlushvarian">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-varian" aria-expanded="false" aria-controls="flush-varian">
                                Varian Produk <span class="text-danger"> *<?= validation_show_error('nama_varian.*'); ?> <?= validation_show_error('harga_varian.*'); ?> <?= validation_show_error('stok_varian.*'); ?></span>
                            </button>
                        </h2>
                        <div id="flush-varian" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushvarian">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12" id="item-varian">
                                        <?php $i = 0;
                                        foreach ($varian as $row):  ?>
                                            <?php if ($i == 0):  ?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nama Varian</label>
                                                        <input type="text" name="nama_varian[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['nama_varian']; ?>" placeholder="Nama Varian">
                                                    </div>
                                                    <div class="col-md-2" id="satuan-select">
                                                        <label class="form-label">Satuan Varian</label>
                                                        <select name="satuan_id[<?= $row['id_varian']; ?>]" class="form-select" id="">
                                                            <?php foreach ($satuan as $s):  ?>
                                                                <option value="<?= $s['id_satuan']; ?>" <?= $s['id_satuan'] == $row['satuan_id'] ? 'selected' : ''; ?>><?= $s['nama_satuan']; ?></option>
                                                            <?php endforeach;  ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Harga Beli</label>
                                                        <input type="text" name="harga_beli[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['harga_beli']; ?>" placeholder="Harga Beli">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Harga Varian</label>
                                                        <input type="text" name="harga_varian[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['harga_varian']; ?>" placeholder="Harga Varian">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label class="form-label">Stok</label>
                                                        <input type="text" name="stok_varian[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['stok_varian']; ?>" placeholder="Stok Varian">
                                                    </div>
                                                    <button class="col-md-1 mt-4 btn btn-primary btn-add">+</button>
                                                </div>
                                            <?php $i++;
                                            else:  ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <input type="text" name="nama_varian[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['nama_varian']; ?>" placeholder="Nama Varian">
                                                    </div>
                                                    <div class="col-md-2" id="satuan-select">
                                                        <select name="satuan_id[<?= $row['id_varian']; ?>]" class="form-select" id="">
                                                            <?php foreach ($satuan as $s):  ?>
                                                                <option value="<?= $s['id_satuan']; ?>" <?= $s['id_satuan'] == $row['satuan_id'] ? 'selected' : ''; ?>><?= $s['nama_satuan']; ?></option>
                                                            <?php endforeach;  ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="harga_beli[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['harga_beli']; ?>" placeholder="Harga Beli">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="harga_varian[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['harga_varian']; ?>" placeholder="Harga Varian">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <input type="text" name="stok_varian[<?= $row['id_varian']; ?>]" class="form-control" value="<?= $row['stok_varian']; ?>" placeholder="Stok Varian">
                                                    </div>
                                                    <button class="col-md-1 btn btn-danger btn-remove">-</button>
                                                </div>
                                            <?php endif;  ?>
                                        <?php endforeach;  ?>
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
                <div class="accordion accordion-flush" id="accordionFlushReferensi">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-referensi" aria-expanded="false" aria-controls="flush-referensi">
                                Referensi Produk <span class="text-danger">*<?= validation_show_error('kategori_id'); ?></span>
                            </button>
                        </h2>
                        <div id="flush-referensi" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushReferensi">
                            <div class="accordion-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select" id="kategori_id" name="kategori_id">
                                            <option value="<?= $arraydata['kategori_id']; ?>" hidden><?= $arraydata['nama_kategori']; ?></option>
                                            <?php foreach ($kategori as $row):  ?>
                                                <option value="<?= $row['id_kategori']; ?>"><?= $row['nama_kategori']; ?></option>
                                            <?php endforeach; ?>
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
                                Spesifikasi Produk <span class="text-danger">*<?= validation_show_error('spesifikasi.*'); ?></span>
                            </button>
                        </h2>
                        <div id="flush-spesifikasi" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushspecifikasi">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12" id="item-spesifikasi">
                                        <?php foreach ($spesifikasi as $row):  ?>
                                            <div class="row mb-3">
                                                <label for="input35" class="col-sm-3 col-form-label"><?= $row['nama_spesifikasi']; ?></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="spesifikasi[<?= $row['id_spesifikasi']; ?>]" class="form-control" value="<?= $row['value']; ?>">
                                                </div>
                                            </div>
                                        <?php endforeach;  ?>
                                    </div>
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
                    <a href="<?= base_url('admin/produk'); ?>" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
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

        // Handle add varianAdd commentMore actions
        $('#item-varian').on('click', '.btn-add', function(e) {
            e.preventDefault();
            var satuan = $('#satuan-select select').html()
            var newVarian = `
                <div class="row mt-3">
                    <div class="col-md-4">
                        <input type="text" name="nama_varian[]" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-2">
                        <select name="satuan_id[]" class="form-select" id="">
                            ${satuan}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="harga_beli[]" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="harga_varian[]" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="stok_varian[]" class="form-control" placeholder="">
                    </div>
                    <button class="col-md-1 btn btn-danger btn-remove">-</button>
                </div>`;
            $('#item-varian').append(newVarian);
        });

        // Handle remove varian
        $('#item-varian').on('click', '.btn-remove', function(e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });
    })
</script>

<script src="<?= base_url(); ?>assets/plugins/filepond/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
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

    // This registers the plugins with Pintura Image Editor
    // setPlugins(plugin_crop, plugin_finetune, plugin_annotate);

    var pond = FilePond.create(document.querySelector('input#filepond'), {
        // FilePond generic properties
        filePosterMaxHeight: 356,
        imageCropAspectRatio: '1:1',
    });

    // pond.files = [];

    FilePond.setOptions({
        files: [
            <?php foreach ($gambar as $row): ?> {
                    source: '<?= base_url('assets/images/produk/' . $row['gambar']) ?>'
                },
            <?php endforeach; ?>
        ],
        server: {
            url: '<?= base_url('admin/produk') ?>',
            process: '/upload', // Endpoint untuk mengunggah file
            revert: '/revert', // Endpoint untuk menghapus file yang diunggah
        },
    });

    $('a.filepond--credits').remove(); // Menghapus tautan kredit FilePond
</script>
<?= $this->endSection(); ?>