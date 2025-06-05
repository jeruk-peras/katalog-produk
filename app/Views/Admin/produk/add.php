<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/filepond/filepond.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-file-poster.min.css">
<style>
    .filepond--item {
        width: calc(25% - 0.5em);
    }
</style>
<link href="<?= base_url(); ?>assets/plugins/pintura-8.92.16/package/pintura.css" rel="stylesheet" />
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
                    <textarea name="deskripsi_produk" class="form-control" rows="5" id="editor"></textarea>
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

                                    <div class="col-md-6">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select" id="kategori_id" name="kategori_id">
                                            <option value="" hidden>Pilih Kategori</option>
                                            <?php foreach ($kategori as $row):  ?>
                                                <option value="<?= $row['id_kategori']; ?>"><?= $row['nama_kategori']; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="kategori" class="form-label">Sub Kategori</label>
                                        <select class="form-select" id="item-sub" name="sub_kategori_id">
                                            <option value="" hidden>Pilih Sub Kategori</option>
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

        <div class="card">
            <div class="card-body">
                <div class="accordion accordion-flush" id="accordionFlushvarian">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-varian" aria-expanded="false" aria-controls="flush-varian">
                                Varian Produk
                            </button>
                        </h2>
                        <div id="flush-varian" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushvarian">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12" id="item-varian">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label">Nama Varian</label>
                                                <input type="text" name="nama_varian[]" class="form-control" placeholder="Nama Varian">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Harga Varian</label>
                                                <input type="text" name="harga_varian[]" class="form-control" placeholder="Harga Varian">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Stok</label>
                                                <input type="text" name="stok_varian[]" class="form-control" placeholder="Stok Varian">
                                            </div>
                                            <button class="col-md-1 mt-4 btn btn-primary btn-add">+</button>
                                        </div>
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
            hendleSubKategori(kategoriId);
            hendleSpesifikasi(kategoriId);
        });

        // hendle function
        function hendleSubKategori(kategoriId) {
            $.ajax({
                url: '<?= base_url('admin/produk/fecthsubkategori'); ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    kategori_id: kategoriId
                },
                success: function(response) {
                    if (response.status === 200) {
                        var options = '<option value="" hidden>Pilih Sub Kategori</option>';
                        $.each(response.data, function(index, subKategori) {
                            options += '<option value="' + subKategori.id_sub_kategori + '">' + subKategori.nama_sub_kategori + '</option>';
                        });
                        $('#item-sub').html(options);
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

        // Handle add varian
        $('#item-varian').on('click', '.btn-add', function(e) {
            e.preventDefault();
            var newVarian = `
                <div class="row mt-3">
                    <div class="col-md-5">
                        <input type="text" name="nama_varian[]" class="form-control" placeholder="Nama Varian">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="harga_varian[]" class="form-control" placeholder="Harga Varian">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="stok_varian[]" class="form-control" placeholder="Stok Varian">
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


        // hendle post produk
        $('#form-produk').submit(function(e) {
            e.preventDefault();
            var formdata = $(this).serializeArray();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formdata,
                success: function(response) {

                    if (response.status === 200) {
                        Toast.fire({
                            timer: 2000,
                            icon: 'success',
                            title: response.message || 'Data berhasil disimpan.'
                        });

                        window.location.href = '<?= base_url('admin/produk'); ?>'; // Redirect ke halaman spesifikasi
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
                        title: 'Terjadi kesalahan saat mengirim data.'
                    });
                }
            })

        })

    })
</script>

<script src="<?= base_url(); ?>assets/plugins/filepond/filepond.js"></script>
<script src="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-file-poster.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url(); ?>assets/plugins/filepond/filepond-plugin-image-editor.min.js"></script>
<script type="module">
    // import Pintura Image Editor modules
    import {
        // Image editor
        openEditor,
        processImage,
        createDefaultImageReader,
        createDefaultImageWriter,
        createDefaultImageOrienter,

        // Only needed if loading legacy image editor data
        legacyDataToImageState,

        // Import the editor default configuration
        getEditorDefaults,

        // The method used to register the plugins
        setPlugins,

        // The plugins we want to use
        plugin_crop,
        plugin_finetune,
        plugin_annotate,

        // The user interface and plugin locale objects
        locale_en_gb,
        plugin_crop_locale_en_gb,
        plugin_finetune_locale_en_gb,
        plugin_annotate_locale_en_gb,

        // Because we use the annotate plugin we also need
        // to import the markup editor locale and the shape preprocessor
        markup_editor_locale_en_gb,
        createDefaultShapePreprocessor,

        // Import the default configuration for the markup editor and finetune plugins
        markup_editor_defaults,
        plugin_finetune_defaults,
    } from '/assets/plugins/pintura-8.92.16/package/pintura.js';

    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImageEditor,
        FilePondPluginFilePoster
    );

    // This registers the plugins with Pintura Image Editor
    setPlugins(plugin_crop, plugin_finetune, plugin_annotate);

    var pond = FilePond.create(document.querySelector('input#filepond'), {
        // FilePond generic properties
        filePosterMaxHeight: 356,

        // FilePond Image Editor plugin properties
        imageEditor: {
            // Maps legacy data objects to new imageState objects (optional)
            legacyDataToImageState: legacyDataToImageState,

            // Used to create the editor (required)
            createEditor: openEditor,

            // Used for reading the image data. See JavaScript installation for details on the `imageReader` property (required)
            imageReader: [
                createDefaultImageReader,
                {
                    // createDefaultImageReader options here
                },
            ],

            // Can leave out when not generating a preview thumbnail and/or output image (required)
            imageWriter: [
                createDefaultImageWriter,
                {
                    // We'll resize images to fit a 512 × 512 square
                    targetSize: {
                        width: 512,
                        height: 512,
                    },
                },
            ],

            // Used to generate poster images, runs an invisible "headless" editor instance. (optional)
            imageProcessor: processImage,

            // Pintura Image Editor options
            editorOptions: {
                // The markup editor default options, tools, shape style controls
                ...markup_editor_defaults,

                // The finetune util controls
                ...plugin_finetune_defaults,

                // This handles complex shapes like arrows / frames
                shapePreprocessor: createDefaultShapePreprocessor(),

                // This will set a square crop aspect ratio
                imageCropAspectRatio: 1,

                // The icons and labels to use in the user interface (required)
                locale: {
                    ...locale_en_gb,
                    ...plugin_crop_locale_en_gb,
                    ...plugin_finetune_locale_en_gb,
                    ...plugin_annotate_locale_en_gb,
                    ...markup_editor_locale_en_gb,
                },
            },
        },
    });

    FilePond.setOptions({
        server: {
            process: '<?= base_url('admin/produk/upload') ?>', // Endpoint untuk mengunggah file
            revert: '<?= base_url('admin/produk/revert') ?>', // Endpoint untuk menghapus file yang diunggah
            load: '/load/asdasd.png', // Endpoint untuk memuat file
            fetch: (url, load, error, progress, abort, headers) => {
                // Should get a file object from the URL here
                // ...
                url = 'http://somewhere/their-file.jpg';
                // Can call the error method if something is wrong, should exit after
                error('oh my goodness');

                // Can call the header method to supply FilePond with early response header string
                // https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/getAllResponseHeaders
                headers(headersString);

                // Should call the progress method to update the progress to 100% before calling load
                // (computable, loadedSize, totalSize)
                progress(true, 0, 1024);

                // Should call the load method with a file object when done
                load(file);

                // Should expose an abort method so the request can be cancelled
                return {
                    abort: () => {
                        // User tapped abort, cancel our ongoing actions here

                        // Let FilePond know the request has been cancelled
                        abort();
                    },
                };
            },
        },
    });

    $('a.filepond--credits').remove(); // Menghapus tautan kredit FilePond
</script>
<?= $this->endSection(); ?>