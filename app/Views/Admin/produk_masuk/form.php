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
                    <li class="breadcrumb-item" aria-current="page">Data Produk</li>
                    <li class="breadcrumb-item active" aria-current="page">Form Produk Masuk</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <div>
                    <h6 class="mb-0 text-uppercase">Data Promo Produk</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= ($item !== false ? base_url('admin/produk-masuk/update/' . $data['id_masuk']) : ''); ?>" method="post" id="form-setting" data-add="true">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control <?= validation_show_error('tanggal_masuk') ? 'is-invalid' : ''; ?>" id="tanggal_masuk" name="tanggal_masuk" value="<?= $data['tanggal_masuk'] ?? date('Y-m-d'); ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('tanggal_masuk'); ?></div>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 mb-3">
                        <label class="form-label">Nama suplier</label>
                        <select name="suplier_id" class="form-select" id="">
                            <?php foreach ($suplier as $row):  ?>
                                <option value="<?= $row['id_suplier']; ?>" <?= ($data['suplier_id'] ?? old('suplier_id') == $row['id_suplier'] ? 'selected' : ''); ?>><?= $row['nama_suplier']; ?></option>
                            <?php endforeach;  ?>
                        </select>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 mb-3">
                        <label class="form-label">Nomor DO</label>
                        <input type="text" class="form-control <?= validation_show_error('no_delivery') ? 'is-invalid' : ''; ?>" id="no_delivery" name="no_delivery" value="<?= old('no_delivery') ? old('no_delivery') : ($data ? $data['no_delivery'] : ''); ?>">
                        <div class="invalid-feedback" id="error_no_delivery"><?= validation_show_error('no_delivery'); ?></div>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 mb-3">
                        <label class="form-label">Total Harga</label>
                        <input type="number" class="form-control <?= validation_show_error('total_harga') ? 'is-invalid' : ''; ?>" id="total_harga" name="total_harga" value="<?= old('total_harga') ? old('total_harga') : ($data ? $data['total_harga'] : ''); ?>">
                        <div class="invalid-feedback" id="error_total_harga"><?= validation_show_error('total_harga'); ?></div>
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control <?= validation_show_error('keterangan') ? 'is-invalid' : ''; ?>" id="keterangan" name="keterangan"><?= old('keterangan') ? old('keterangan') : ($data ? $data['keterangan'] : ''); ?></textarea>
                        <div class="invalid-feedback" id="error_keterangan"><?= validation_show_error('keterangan'); ?></div>
                    </div>
                    <div class="col mb-3 text-end">
                        <a href="<?= base_url('admin/produk-masuk'); ?>" class="btn btn-sm btn-light px-4">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if ($item !== false): ?>

        <div class="row mb-3">
            <div class="col">
                <button type="button" class="btn btn-sm btn-primary" id="btn-refresh"><i class="bx bx-refresh me-0"></i></button>
                <button type="button" class="btn btn-sm btn-primary" id="btn-produk" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
            </div>
            <div class="col-auto text-end">
                <button class="btn btn-sm btn-warning" data-id="<?= $data['id_masuk']; ?>" id="btn-hapus">Batal masuk</button>
                <button class="btn btn-sm btn-primary" id="btn-simpan">Singkronkan Data</button>
            </div>
        </div>
        <form action="/admin/produk-masuk/<?= $data['id_masuk']; ?>/syncdatastok" id="form-data" method="post">
            <?= csrf_field(); ?>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div>
                            <h5 class="mb-0 text-uppercase">Item Masuk</h5>
                        </div>
                        <div class="ms-auto"></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk / Varian</th>
                                    <th>Sisa Stok</th>
                                    <th style="width: 200px;">Harga Beli</th>
                                    <th style="width: 200px;">Harga</th>
                                    <th style="width: 80px;">Stok Masuk</th>
                                    <th style="width: 50px;">#</th>
                                </tr>
                            </thead>
                            <tbody id="items"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>

    <?php endif;  ?>
</div>
<?= $this->include('admin/produk_masuk/script'); ?>
<?php if ($item !== false):  ?>
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
        var table = $('#datatable');
        $('#btn-produk').click(function() {
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
                            return `<img src="/assets/images/produk/${data}" width="60" class="img-fluid" alt="">`;
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
                                `<span class="badge bg-light text-dark">${row[2]}</span><br> ${data}`
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
                            return `<button role="button" data-href="/admin/produk-masuk/${data}/<?= $data['id_masuk'] ?>/add" class="btn btn-sm btn-primary btn-add-item"><i class="bx bx-plus"></i> Tambah Data</button>`;
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
        });

        $('#modal-form').on('hidden.bs.modal', function() {
            // alert('ok')
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
                    renderItem()
                    if (response.status == 200) {
                        Toast.fire({
                            timer: 2000,
                            icon: 'success',
                            title: response.message
                        });
                    }
                },
                error: function(xhr) {
                    let message = 'Terjadi kesalahan.';
                    if (xhr.status === 400 && xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Toast.fire({
                        timer: 2000,
                        icon: 'error',
                        title: message
                    });
                }
            })
        })

        $('#btn-simpan').click(function() {
            // submit form #form-data
            Swal.fire({
                title: 'Konfirmasi Singkron',
                text: "Apakah Anda yakin ingin mengupdate ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-data').submit()
                }
            });
        })

        $('#btn-hapus').click(function() {
            var id = $(this).data('id') || '<?= $data['id_masuk'] ?>';
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin membatalkan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/produk-masuk/delete/' + id
                }
            });
        });

        $(document).on('click', '.btn-del-item', function() {
            $(this).attr('disabled', true);
            $.ajax({
                url: $(this).data('href'),
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    renderItem()
                }
            })
        });

        $(document).on('keyup change', '.input-masuk', function() {
            var form = $('#form-data');
            var formData = form.serializeArray();
            console.log(formData);

            $.ajax({
                url: '<?= base_url('admin/produk-masuk/' . $data['id_masuk'] . '/savetempt') ?>',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // renderItem();
                },
            });
        });

        $('#btn-refresh').click(function() {
            renderItem()
        })

        function renderItem() {
            $.ajax({
                url: '<?= base_url('admin/produk-masuk/' . $data['id_masuk'] . '/render-item') ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    $('#items').html(response.data);
                },
                error: function() {
                    $('#items').html('<tr><td colspan="6" class="text-center fw-bolder">Gagal memuat data item.</td></tr>');
                }
            });
        }
        renderItem();
    </script>
<?php endif;  ?>
<?= $this->endSection();  ?>