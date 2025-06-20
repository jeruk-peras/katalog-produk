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
        <div class="breadcrumb-title pe-3">Paket Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Paket Produk</li>
                    <li class="breadcrumb-item active" aria-current="page">Forms Paket Produk</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <hr>
    <form action="<?= base_url('admin/produk-paket/add/' . $paket['id_paket']); ?>" method="post" class="row g-3" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card">
            <div class="card-body row p-4">
                <div class="col-md-12">
                    <label class="form-label">Gambar <span class="text-danger">*<?= validation_show_error('filepond'); ?></span></label>
                    <input type="file" id="filepond" name="gambar" />
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label">Nama paket <span class="text-danger">*<?= validation_show_error('nama_paket'); ?></span></label>
                    <input type="text" name="nama_paket" class="form-control" placeholder="Nama paket" value="<?= $paket['nama_paket']; ?>">
                </div>

                <div class="col-md-12 mt-4 mb-3">
                    <label class="form-label">Deskripsi paket <span class="text-danger">*<?= validation_show_error('deskripsi_paket'); ?></span></label>
                    <textarea name="deskripsi_paket" class="form-control" rows="5" id="tyni-mce"><?= $paket['deskripsi_paket'] ?? ''; ?></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga <span class="text-danger">*<?= validation_show_error('harga_awal'); ?></span></label>
                    <input type="text" name="harga_awal" id="harga_awal" value="<?= $paket['harga_awal'] ?? ''; ?>" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok <span class="text-danger">*<?= validation_show_error('stok_paket'); ?></span></label>
                    <input type="text" name="stok_paket" class="form-control" value="<?= $paket['stok_paket'] ?? ''; ?>">
                </div>
                <hr>
                <!-- <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Baru <span class="text-danger">*<?= validation_show_error('harga_baru'); ?></span></label>
                    <input type="text" name="harga_baru" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimal Beli <span class="text-danger">*<?= validation_show_error('min_order'); ?></span></label>
                    <input type="text" name="min_order" class="form-control">
                </div> -->
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div>
                        <h5 class="mb-0 text-uppercase">Produk Promo</h5>
                    </div>
                    <div class="ms-auto">
                        <button href="" type="button" class="btn btn-sm btn-primary" id="btn-produk" data-bs-toggle="modal" data-bs-target="#modal-form">
                            <i class="bx bx-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Varian</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data-item"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-md-flex d-grid align-items-center justify-content-end gap-3">
                    <a href="<?= base_url('admin/produk-paket'); ?>" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </div>
        </div>

    </form>
</div>

<div class="modal modal-xl fade" id="modal-form" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Varian</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#datatable');
        $('#btn-produk').click(function() {
            // load data
            table.DataTable({
                processing: true,
                serverSide: true,
                // responsive: true,
                ordering: true, // Set true agar bisa di sorting
                ajax: {
                    url: '<?= base_url('admin/produk-paket/fecthProduk') ?>', // URL file untuk proses select datanya
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    } // Kirim token CSRF
                },
                columnDefs: [{
                    targets: 5, // Target kolom aksi
                    orderable: false, // Nonaktifkan sorting untuk kolom aksi
                    render: function(data, type, row, meta) {
                        return `<button role="button" data-href="/admin/produk-paket/<?= $paket['id_paket'] ?>/${data}/item-add" class="btn btn-sm btn-primary btn-add-item"><i class="bx bx-plus"></i> Tambah Data</button>`;
                    }
                }, ],
                pageLength: 25,
                lengthMenu: [
                    25, 50, 150, 200, 'All'
                ],
                scrollX: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
                },
            });
        });

        $('#modal-form').on('hidden.bs.modal', function() {
            // alert('ok')
            table.DataTable().clear().destroy();
        });

        table.on('click', 'tbody tr td button.btn-add-item', function(e) {
            $(this).attr('disabled', true);
            $.ajax({
                url: $(this).data('href'),
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    if (response.status == 200) {
                        // Tambahkan baris baru ke tabel promo
                        loaditem(response.data)
                        $('#modal-form').modal('hide');

                    } else {
                        alert(response.message || 'Gagal menambah data.');
                    }
                }
            })
        })

        function renderitem() {
            $.ajax({
                url: '/admin/produk-paket/item-get/<?= $paket['id_paket'] ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    if (response.status == 200) {
                        // Tambahkan baris baru ke tabel promo
                        loaditem(response.data)
                    } else {
                        alert(response.message || 'Gagal menambah data.');
                    }
                }
            })
        }
        renderitem();

        function loaditem(item) {
            let row = '';
            var i = 1;
            var total = 0;
            item.forEach(function(item, idx) {
                row += `
                    <tr data-id="${item.id_paket_detail}">
                        <td>${i++}</td>
                        <td>${item.nama_produk}</td>
                        <td>${item.nama_varian}</td>
                        <td>${item.harga_varian}</td>
                        <td>${item.stok_varian}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-remove-item" data-id="${item.id_paket_detail}">
                                <i class="bx bx-trash"></i>
                        </td>
                    </tr>`;
                total = parseInt(total + parseInt(item.harga_varian));
            })
            $('#harga_awal').val(total);
            $('#data-item').html(row);
        }

        // Aksi hapus item
        $('#data-item').on('click', '.btn-remove-item', function() {
            let id = $(this).attr('data-id');
            $.ajax({
                url: `/admin/produk-paket/item-remove/${id}`,
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(res) {
                    console.log(res);
                    if (res.status == 200) {
                        renderitem();
                    } else {
                        alert(res.message || 'Gagal menghapus data.');
                    }
                }
            });
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

    var pond = FilePond.create(document.querySelector('input#filepond'), {
        // FilePond generic properties
        filePosterMaxHeight: 356,
        imageCropAspectRatio: '1:1',
    });

    FilePond.setOptions({
        files: [ <?= $paket['gambar'] ? "{source: '" . base_url('assets/images/produk/' . $paket['gambar']) ."'}" : "" ?>],
        server: {
            process: '<?= base_url('admin/produk-paket') ?>/upload', // Endpoint untuk mengunggah file
            revert: '<?= base_url('admin/produk') ?>/revert', // Endpoint untuk menghapus file yang diunggah
        },
    });

    // $('a.filepond--credits').remove(); // Menghapus tautan kredit FilePond
</script>
<?= $this->endSection(); ?>