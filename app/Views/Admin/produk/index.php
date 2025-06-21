<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Produk</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <hr />
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <div>
                    <h5 class="mb-0 text-uppercase">Data Produk</h5>
                </div>
                <div class="ms-auto">
                    <a href="<?= base_url('admin/produk/add'); ?>" type="button" class="btn btn-sm btn-primary"><i class="bx bx-plus"></i> Tambah Data</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nama Produk</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detail-produk-modal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- gambar produk -->
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <h5 class="fw-bold mb-2">Gambar Produk</h5>
                        <div id="gambar-produk"></div>
                    </div>

                    <div class="col-6 mb-3">
                        <h5 class="fw-bold mb-2">Varian Produk</h5>
                        <div>
                            <table style="width: 80%;">
                                <thead>
                                    <th>Varian</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </thead>
                                <tbody id="varian-produk"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <h5 class="fw-bold mb-2">Spesifiksai Produk</h5>
                        <div>
                            <table id="spesifikasi-produk"></table>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <h5 class="fw-bold mb-2">Deskripsi Produk</h5>
                        <p id="deskripsi-produk"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        function msg(status) {
            if (status === 200) {
                Toast.fire({
                    timer: 2000,
                    icon: 'success',
                    title: 'Success.'
                });

            }
            if (status === 500) {
                Toast.fire({
                    timer: 2000,
                    icon: 'error',
                    title: 'Error.'
                });
            }
        }

        msg(<?= session()->get('message') ?>);

        // load data
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            // responsive: true,
            ordering: true, // Set true agar bisa di sorting
            ajax: {
                url: 'produk/data', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 3, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {
                    return '<button type="button" class="btn btn-sm btn-primary btn-detail" data-id-produk="' + data + '">detail</button>';
                }
            }, {
                targets: 4, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {
                    return '<a href="/admin/produk/edit/' + data + '" class="btn btn-sm btn-warning">edit</a>' +
                        '<a href="/admin/produk/delete/' + data + '" class="ms-2 btn btn-sm btn-danger btn-delete" data-id-produk="' + data + '"> hapus</a>';
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

        // detail data
        table.on('click', 'tbody tr td button.btn-detail', function(e) {
            var id_produk = $(this).data('id-produk');
            $.ajax({
                url: '<?= base_url('admin/produk/detail'); ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    id_produk: id_produk
                },
                success: function(response) {
                    $("#deskripsi-produk").html(response.data.deskripsi);
                    fetchGambarProduk(response.data.gambar, '#gambar-produk');
                    fetchSpesifikasiProduk(response.data.spesifikasi, '#spesifikasi-produk');
                    fetchVarianProduk(response.data.varian, '#varian-produk');
                    $('#detail-produk-modal').modal('show');
                },
                error: function() {

                }
            })
        });

        // hendler detail produk
        function fetchGambarProduk(arrayData, containerId) {
            var html = '';
            $.each(arrayData, function(index, data) {
                html += `<img src="../../assets/images/produk/${data.gambar}" alt="Gambar Kategori" class="img-thumbnail" style="max-width: 100px;">`;
            })
            $(containerId).html(html);
        }

        function fetchSpesifikasiProduk(arrayData, containerId) {
            var html = '';
            $.each(arrayData, function(index, data) {
                html += `<tr>
                            <td>${data.nama_spesifikasi}</td>
                            <td>: ${data.value}</td>
                        </tr>`;
            })
            $(containerId).html(html);
        }

        function fetchVarianProduk(arrayData, containerId) {
            var html = '';
            $.each(arrayData, function(index, data) {
                html += `<tr>
                            <td>${data.nama_varian}</td>
                            <td>${data.harga_varian}</td>
                            <td>${data.stok_varian}</td>
                        </tr>`;
            })
            $(containerId).html(html);
        }

        // delete data
        table.on('click', 'tbody tr td a.btn-delete', function(e) {
            e.preventDefault();
            var id_produk = $(this).data('id-produk');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('admin/produk/delete/'); ?>' + id_produk,
                        type: 'POST',
                        data: {
                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                            id_produk: id_produk
                        },
                        success: function(response) {

                            if (response.status === 200) {
                                Toast.fire({
                                    timer: 2000,
                                    icon: 'success',
                                    title: response.message,
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
                                title: 'Terjadi kesalahan saat mengirim data.'
                            });
                        }
                    })
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>