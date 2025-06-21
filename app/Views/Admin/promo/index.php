<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Promo Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Promo Produk</li>
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
                    <h5 class="mb-0 text-uppercase">Data Promo Produk</h5>
                </div>
                <div class="ms-auto">
                    <a href="<?= base_url('admin/produk/promo/add'); ?>" type="button" class="btn btn-sm btn-primary"><i class="bx bx-plus"></i> Tambah Data</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Promo</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-lg fade" id="modal-produk-promo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produk Promo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Awal</th>
                        <th>Harga Diskon</th>
                    </thead>
                    <tbody id="item-promo"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#datatable');
        // load data
        table.DataTable({
            processing: true,
            serverSide: true,
            // responsive: true,
            ordering: true, // Set true agar bisa di sorting
            ajax: {
                url: '<?= base_url('admin/produk/promo/data') ?>', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 4, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {
                    var $btn =
                    `<button role="button" data-id="${data}" class="btn btn-sm btn-primary btn-detail me-1"><i class="bx bx-info-circle me-0"></i></button>` +
                    `<a href="/admin/produk/promo/item/${data}" class="btn btn-sm btn-primary me-1"><i class="bx bx-pencil me-0"></i></a>` +
                    `<button role="button" data-href="/admin/produk/promo/delete/${data}" class="btn btn-sm btn-danger me-1"><i class="bx bx-trash me-0"></i></button>`
                    return $btn;
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

        table.on('click', 'tbody tr td button.btn-detail', function() {
            var $id = $(this).data('id');
            console.log($id);
            $('#modal-produk-promo').modal('show');
            $.ajax({
                url: './promo/detail_promo',
                type: 'POST',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    id: $id
                },
                success: function(response) {
                    var item = response.data.item;
                    var html = '';
                    if (item && item.length > 0) {
                        item.forEach(function(row, i) {
                            html += `<tr>
                                <td>${i + 1}</td>
                                <td>${row.nama_varian} <br/> <small>${row.nama_produk}</small></td>
                                <td>Rp${parseInt(row.harga_awal).toLocaleString('id-ID')}</td>
                                <td>Rp${parseInt(row.harga_diskon).toLocaleString('id-ID')}</td>
                            </tr>`;
                        });
                    } else {
                        html = `<tr><td colspan="4" class="text-center">Tidak ada data produk promo</td></tr>`;
                    }
                    $('#item-promo').html(html);
                }
            })
        })

        table.on('click', 'tbody tr td button.btn-danger', function(e) {
            e.preventDefault();
            var url = $(this).data('href');
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
                        url: url,
                        type: 'POST',
                        data: { <?= csrf_token() ?>: '<?= csrf_hash() ?>',},
                        success: function(response) {
                            if (response.status === 200) {
                                Toast.fire({
                                    timer: 2000,
                                    icon: 'success',
                                    title: response.message || 'Data berhasil dihapus.'
                                });
                                table.DataTable().ajax.reload();
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
                }
            })
        });
    })
</script>
<?= $this->endSection();  ?>