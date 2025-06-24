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

    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <div>
                    <h6 class="mb-0 text-uppercase">Data Promo Produk</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= ($item !== false ? base_url('admin/produk/promo/update/' . $data['id_promo']) : ''); ?>" method="post" id="form-setting" data-add="true">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                        <label class="form-label">Nama Promo </label>
                        <input type="text" class="form-control <?= validation_show_error('nama_promo') ? 'is-invalid' : ''; ?>" id="nama_promo" name="nama_promo" value="<?= old('nama_promo') ? old('nama_promo') : ($data ? $data['nama_promo'] : ''); ?>">
                        <div class="invalid-feedback" id="error_nama_promo"><?= validation_show_error('nama_promo'); ?></div>
                    </div>
                    <div class="col mb-3 text-end">
                        <a href="<?= base_url('admin/produk/promo'); ?>" class="btn btn-sm btn-light px-4">Kembali</a>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if ($item !== false): ?>

        <div class="row justify-content-end">
            <div class="mb-4 text-end">
                <button class="btn btn-sm btn-warning" data-id="<?= $data['id_promo']; ?>" id="btn-hapus-promo">Batal Promo</button>
                <button class="btn btn-sm btn-primary" id="btn-simpan-promo">Simpan Promo</button>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div>
                        <h5 class="mb-0 text-uppercase">Produk Promo</h5>
                    </div>
                    <div class="ms-auto">
                        <button href="" type="button" class="btn btn-sm btn-primary" id="btn-produk" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="<?= base_url('admin/produk/promo/promosave'); ?>" method="post" id="form-data-promo">
                        <?= csrf_field(); ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">No</th>
                                    <th style="width: 35%;">Produk</th>
                                    <th style="width: 10%;">Harga Awal</th>
                                    <th style="width: 15%;">Harga Diskon</th>
                                    <th style="text-wrap: auto; width: 10%;">Aktifkan/ NonAktifkan</th>
                                    <th style="width: 4%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($dataproduk as $row):  ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td colspan="4"><?= $row['nama_produk']; ?></td>
                                        <td>
                                            <div class="d-flex order-actions">
                                                <a href="<?= base_url('admin/produk/promo/delete-item/' . $row['id_produk'] . '/' . $data['id_promo']); ?>"><i class="bx bxs-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php foreach ($item as $itemrow):  ?>
                                        <?php if ($itemrow['produk_id'] == $row['id_produk']):  ?>
                                            <tr style="border-top-style: hidden;">
                                                <td></td>
                                                <td>- <?= $itemrow['nama_varian']; ?></td>
                                                <td>Rp <?= number_format((int)$itemrow['harga_awal']); ?></td>
                                                <td style="padding: 0;">
                                                    <div class="d-flex">
                                                        <input type="hidden" name="id[<?= $itemrow['id']; ?>]" value="<?= $itemrow['id']; ?>" id="">
                                                        <div class="input-group input-group-sm" style="width: 135px;">
                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                            <input type="tel" class="form-control" name="harga_diskon[<?= $itemrow['id']; ?>]" value="<?= $itemrow['harga_diskon']; ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="status[<?= $itemrow['id']; ?>]" <?= $itemrow['status'] ? 'checked' : ''; ?> id="switchCheckReverse">
                                                        <label class="form-check-label" for="switchCheckReverse"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif;  ?>
                                    <?php endforeach;  ?>
                                <?php endforeach;  ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

    <?php endif;  ?>
</div>
<?= $this->include('admin/promo/script'); ?>
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
                                    <th>Kategori</th>
                                    <th>Nama Produk</th>
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
                    url: '<?= base_url('admin/produk/promo-dataproduk') ?>', // URL file untuk proses select datanya
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    } // Kirim token CSRF
                },
                columnDefs: [{
                    targets: 3, // Target kolom aksi
                    orderable: false, // Nonaktifkan sorting untuk kolom aksi
                    render: function(data, type, row, meta) {
                        return `<button role="button" data-href="/admin/produk/promo/${data}/<?= $data['id_promo'] ?>/add" class="btn btn-sm btn-primary btn-add-item"><i class="bx bx-plus"></i> Tambah Data</button>`;
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
                    if (response.status == 200) window.location.reload();
                }
            })
        })

        $('#btn-simpan-promo').click(function() {
            // submit form #form-data-promo
            $('#form-data-promo').submit()
        })

        $('#btn-hapus-promo').click(function() {
            var id = $(this).data('id') || '<?= $data['id_promo'] ?>';
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin membatalkan promo ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/produk/promo/delete/' + id,
                        type: 'POST',
                        data: {
                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Toast.fire({
                                    timer: 2000,
                                    icon: 'success',
                                    title: response.message || 'Promo berhasil dibatalkan.'
                                });
                                setTimeout(function() {
                                    window.location.href = '<?= base_url('admin/produk/promo'); ?>';
                                }, 2000);
                            } else {
                                Toast.fire({
                                    timer: 2000,
                                    icon: 'error',
                                    title: response.message || 'Gagal membatalkan promo.'
                                });
                            }
                        },
                        error: function() {
                            Toast.fire({
                                timer: 2000,
                                icon: 'error',
                                title: 'Terjadi kesalahan saat menghapus promo.'
                            });
                        }
                    });
                }
            });
        });
    </script>
<?php endif;  ?>
<?= $this->endSection();  ?>