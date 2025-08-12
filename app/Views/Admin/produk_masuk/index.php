<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Produk Masuk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Produk Masuk</li>
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
                    <h5 class="mb-0 text-uppercase">Data Produk Masuk</h5>
                </div>
                <div class="ms-auto">
                    <a href="<?= base_url('admin/produk-masuk/add'); ?>" type="button" class="btn btn-sm btn-primary"><i class="bx bx-plus"></i> Tambah Data</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Tanggal</th>
                            <th>Nama Suplier</th>
                            <th>No Delivery</th>
                            <th>total_harga</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-xl fade" id="modal-produk-masuk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="align-middle" rowspan="2">No</th>
                            <th class="align-middle" rowspan="2">Produk / Varian</th>
                            <th class="text-center" colspan="2">Harga</th>
                            <th class="text-center" colspan="2">Stok</th>
                            <th class="align-middle" rowspan="2">Status</th>
                        </tr>
                        <tr>
                            <th>Beli</th>
                            <th>Jual</th>
                            <th>Awal</th>
                            <th>Masuk</th>
                        </tr>
                    </thead>
                    <tbody id="item-masuk"></tbody>
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
                url: 'produk-masuk/data', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 1, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {
                    var $btn =
                        `<button role="button" data-id="${data}" class="btn btn-sm btn-primary btn-detail me-1" title="Detail data"><i class="bx bx-info-circle me-0"></i></button>` +
                        `<a href="/admin/produk-masuk/detail/${data}" ${(row[7] == 1 ? 'onclick="return event.preventDefault();"' : '')} class="btn btn-sm btn-primary me-1" title="Ubah data"><i class="bx bx-pencil me-0"></i></a>` +
                        `<button class="btn btn-sm btn-primary me-1 btn-sync" data-href="${row[7] == 1 ? '/admin/produk-masuk/'+ data +'/cancelsyncdatastok' : '/admin/produk-masuk/'+ data +'/syncdatastok'}" data-id="${data}" title="${row[7] == 1 ? 'Batalkan update data' : 'Singkron data'}" ><i class="bx bx-refresh me-0"></i></button>`
                    return $btn;
                }
            }, {
                targets: 7, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {
                    var $btn = data == 1 ? `<span role="button" class="badge bg-success">Updated</span>` : `<span role="button" class="badge bg-warning">Waiting</span>`
                    return $btn;
                }
            }],
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
            $('#item-masuk').html('');
            var $id = $(this).data('id');
            console.log($id);
            $('#modal-produk-masuk').modal('show');
            $.ajax({
                url: 'produk-masuk/' + $id + '/renderdetailitem',
                type: 'POST',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    id: $id
                },
                success: function(response) {
                    $('#item-masuk').html(response.data);
                },
                error: function() {
                    $('#item-masuk').html('<tr><td colspan="8" class="text-center fw-bolder">Loading...</td></tr>');
                }
            })
        });

        table.on('click', 'tbody tr td button.btn-sync', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var href = $(this).data('href');
            Swal.fire({
                title: 'Konfirmasi Singkron',
                text: "Apakah Anda yakin ingin melakukan aksi ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href
                }
            })
        });
    })
</script>
<?= $this->include('admin/produk_masuk/script');; ?>
<?= $this->endSection();  ?>