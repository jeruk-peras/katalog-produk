<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Edit Order</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Data Orders</li>
                    <li class="breadcrumb-item active" aria-current="page">Form Edit Order</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <form action="" method="post" id="form-data" data-add="true">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_order" id="id_order" value="<?= $data['id_order']; ?>">
                <div class="row">

                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-1">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= $data['nama'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('nama'); ?></div>
                    </div>

                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-1">
                        <label class="form-label">No Handphone</label>
                        <input type="text" class="form-control <?= validation_show_error('no_handphone') ? 'is-invalid' : ''; ?>" id="no_handphone" name="no_handphone" value="<?= $data['no_handphone'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('no_handphone'); ?></div>
                    </div>

                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-1">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control <?= validation_show_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= $data['email'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('email'); ?></div>
                    </div>

                    <div class="col-12 mb-1">
                        <label class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control <?= validation_show_error('nama_tempat') ? 'is-invalid' : ''; ?>" id="nama_tempat" name="nama_tempat" value="<?= $data['nama_tempat'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('nama_tempat'); ?></div>
                    </div>

                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-1">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control <?= validation_show_error('alamat') ? 'is-invalid' : ''; ?>" id="alamat" name="alamat"><?= old('alamat') ? old('alamat') : ($data ? $data['alamat'] : ''); ?></textarea>
                        <div class="invalid-feedback" id="error_keterangan"><?= validation_show_error('alamat'); ?></div>
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-1">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control <?= validation_show_error('catatan') ? 'is-invalid' : ''; ?>" id="catatan" name="catatan"><?= old('catatan') ? old('catatan') : ($data ? $data['catatan'] : ''); ?></textarea>
                        <div class="invalid-feedback" id="error_keterangan"><?= validation_show_error('catatan'); ?></div>
                    </div>

                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 mb-1">
                        <label class="form-label">Methode Pembayaran</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" <?= (isset($data['metode_pembayaran']) && $data['metode_pembayaran'] === 'cod') ? 'checked' : '' ?> id="cod" value="cod">
                                <label class="form-check-label" for="cod">Cash on Delivery</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" <?= (isset($data['metode_pembayaran']) && $data['metode_pembayaran'] === 'top') ? 'checked' : '' ?> id="top" value="top">
                                <label class="form-check-label" for="top">Terms of Payment</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 col-md-6 col-sm-6 mb-1">
                        <label class="form-label">Sales</label>
                        <div class="mt-1">
                            <label class="form-check-label m-0 p-0"><?= $data['nama_sales'] ?? ''; ?></label>
                        </div>
                    </div>

                    <div class="col mb-1 text-end">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Data</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="mb-3">
            <a href="<?= base_url('admin/orders'); ?>" class="btn btn-sm btn-secondary px-4">Kembali</a>
            <button class="btn btn-sm btn-primary" id="btn-singkron">Singkron Data</button>
            <button type="button" class="btn btn-sm btn-primary" id="btn-produk" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table mb-0 table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Harga Diskon</th>
                        <th scope="col" style="width: 6%;">QYT</th>
                        <th scope="col">#</th>
                    </tr>
                </thead>
                <tbody id="detail-data"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
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
                                <th>Gambar</th>
                                <th>Kategori</th>
                                <th>Nama Produk</th>
                                <th>varian</th>
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
    var id = $('#id_order').val();
    var table = $('#datatable');
    $('#btn-produk').click(function() {
        setTimeout(function(){
            // load data
            table.DataTable({
                processing: true,
                serverSide: true,
                // responsive: true,
                ordering: true, // Set true agar bisa di sorting
                ajax: {
                    url: '<?= base_url('admin/produk-masuk-dataproduk') ?>', // URL file untuk proses select datanya
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    } // Kirim token CSRF
                },
                columnDefs: [{
                        targets: 1, // Target kolom aksi
                        orderable: false, // Nonaktifkan sorting untuk kolom aksi
                        render: function(data, type, row, meta) {
                            return `<img src="/assets/images/produk/${data}" width="50" class="img-fluid" alt="">`;
                        }
                    },
                    {
                        targets: 2, // Target kolom aksi
                        orderable: false, // Nonaktifkan sorting untuk kolom aksi
                        visible: false,
                    },
                    {
                        targets: 3, // Target kolom aksi
                        orderable: false, // Nonaktifkan sorting untuk kolom aksi
                        render: function(data, type, row, meta) {
                            var html =
                                `<span class="badge bg-light text-dark">${row[2]}</span><br> ${data} <br> *${row[4]}`
                            return html;
                        }
                    },
                    {
                        targets: 4, // Target kolom aksi
                        orderable: false, // Nonaktifkan sorting untuk kolom aksi
                        visible: false,
                    },
                    {
                        targets: 7, // Target kolom aksi
                        orderable: false, // Nonaktifkan sorting untuk kolom aksi
                        render: function(data, type, row, meta) {
                            return `<button role="button" data-href="/admin/orders/item/${id}/${data}/add" class="btn btn-sm btn-primary btn-add-item"><i class="bx bx-plus"></i></button>`;
                        }
                    },
                ],
                pageLength: 25,
                lengthMenu: [
                    25, 50, 150, 200, 'All'
                ],
                scrollX: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
                },
            });
        }, 100);
    });

    $('#modal-form').on('hidden.bs.modal', function() {
        table.DataTable().clear().destroy();
    });

    table.on('click', 'tbody tr td button.btn-add-item', function(e) {
        $.ajax({
            url: $(this).data('href'),
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            success: function(response) {
                fetchItem()
                if (response.status == 200) {
                    Toast.fire({
                        timer: 1000,
                        icon: 'success',
                        title: response.message
                    });
                }
            },
            error: function(xhr) {
                var response = JSON.parse(xhr.responseText);
                Toast.fire({
                    timer: 1000,
                    icon: 'error',
                    title: response.message
                });
            }
        })
    })


    // hendle get items
    fetchItem();

    function fetchItem() {
        $.ajax({
            url: '<?= base_url('admin/orders/detail_order') ?>',
            type: 'POST',
            data: {
                <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                id_order: id
            },
            success: function(response) {
                if (response.status == 200) {
                    var data = response.data.data
                    var html = ``;
                    var i = 1;
                    var total = 0;
                    var qyt = 0;
                    $.each(response.data.detail, function(index, data) {
                        html += `<tr>
                                    <th>${i++}</th>
                                    <td>${data.nama_produk} #<small><b>${data.nama_varian}</b></small></td>
                                    <td>${data.harga_diskon == 0 ? formatRupiah(data.harga): '-' }</td>
                                    <td>${data.harga_diskon == 0 ? '-' : formatRupiah(data.harga_diskon)}</td>
                                    <td>
                                        <input type="text" class="form-control text-end qty-item" data-id="${data.id}" name="jumlah" value="${data.jumlah}" ${data.status == 1 ? 'disabled' : ''}>
                                    </td>
                                    <td><a href="/admin/orders/item-del/${data.id}" class="ms-2 btn btn-sm btn-danger del-item"><i class="bx bx-trash me-0"></i></a></td>
                                </tr>`;
                        total += parseInt(data.total);
                        qyt += parseInt(data.jumlah);
                    });
                    $('#detail-data').html(html);
                }
            },
            error: function() {

            }
        })
    }

    $(document).on('click', 'a.del-item', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            success: function(response) {
                fetchItem()
                if (response.status == 200) {
                    Toast.fire({
                        timer: 1000,
                        icon: 'success',
                        title: response.message
                    });
                }
            },
            error: function(xhr) {
                var response = JSON.parse(xhr.responseText);
                Toast.fire({
                    timer: 1000,
                    icon: 'error',
                    title: response.message
                });
            }
        })

    })

    // hendle update qty
    $(document).on('keyup click', 'input.qty-item', function(e) {
        e.preventDefault();

        var id = $(this).attr('data-id');
        var qty = $(this).val();

        $.ajax({
            url: '/admin/orders/update-qty',
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                id: id,
                qty: qty
            },
            success: function(response) {
                // fetchItem();
            }
        })
    })

    // hendle singkron
    $('#btn-singkron').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/admin/orders/singkronitem/' + id,
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
            },
            success: function(response) {
                console.log(response);
                window.location.href = '/admin/orders';
            }
        })
    })

    // hendle save
    $('#form-data').submit(function(e) {
        e.preventDefault();
        var url, formData;
        url = $(this).attr('action');
        formData = $(this).serializeArray();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                Toast.fire({
                    timer: 2000,
                    icon: 'success',
                    title: response.message
                });
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                Toast.fire({
                    timer: 2000,
                    icon: 'error',
                    title: response.message
                });
            }
        })
    })

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(angka);
    }
</script>

<?= $this->endSection();  ?>