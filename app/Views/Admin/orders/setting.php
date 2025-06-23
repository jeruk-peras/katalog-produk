<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Orders</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Orders Setting</li>
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
                    <h5 class="mb-0 text-uppercase">Data Penerima Oorder</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post" id="form-setting" data-add="true">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Nama Penerima Oorder</label>
                        <input type="text" class="form-control" id="nama_penerima_order" name="nama_penerima_order" value="<?= $nama_penerima_order; ?>">
                        <div class="invalid-feedback" id="error_nama_penerima_order"></div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Nomor Penerima Oorder</label>
                        <input type="text" class="form-control" id="nomor_penerima_order" name="nomor_penerima_order" value="<?= $nomor_penerima_order; ?>">
                        <div class="invalid-feedback" id="error_nomor_penerima_order"></div>
                    </div>
                    <div class="col mb-3 text-end">
                        <button type="submit" id="summit-btn-form-sett" class="btn btn-sm btn-primary">Ubah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <div>
                    <h5 class="mb-0 text-uppercase">Data Sales</h5>
                </div>
                <div class="ms-auto">
                    <button href="<?= base_url('admin/order-sales/add'); ?>" type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sales</th>
                            <th>No Handphone</th>
                            <th>Kode Sales</th>
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
<div class="modal modal-lg fade" id="modal-form" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/orders/save_sales'); ?>" method="post" id="form-sales" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nama sales</label>
                        <input type="text" class="form-control" id="nama_sales" name="nama_sales">
                        <div class="invalid-feedback" id="error_nama_sales"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Handphone</label>
                        <input type="text" class="form-control" maxlength="15" id="no_handphone" name="no_handphone">
                        <div class="invalid-feedback" id="error_no_handphone"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Sales</label>
                        <input type="text" class="form-control" maxlength="6" id="kode_sales" name="kode_sales">
                        <div class="invalid-feedback" id="error_kode_sales"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="summit-btn-form" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // submit penerima pesan
    $('#form-setting').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#summit-btn-form-sett');
        btn.prop('disabled', true).text('Menyimpan...');
        $.ajax({
            url: '<?= base_url('admin/orders/setting'); ?>',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                btn.prop('disabled', false).text('Ubah Data');
                if (response.status == 200) {
                    Toast.fire({
                        timer: 2000,
                        icon: 'success',
                        title: response.message || 'Data berhasil dihapus.'
                    });
                } else {
                    Toast.fire({
                        timer: 2000,
                        icon: 'success',
                        title: response.message || 'Terjadi kesalahan saat mengirim data.'
                    });
                }
            },
            error: function() {
                btn.prop('disabled', false).text('Ubah Data');
                Toast.fire({
                    timer: 2000,
                    icon: 'success',
                    title: 'Terjadi kesalahan saat mengirim data.'
                });
            }
        });
    });

    // load data
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        ordering: true, // Set true agar bisa di sorting
        ajax: {
            url: '<?= base_url() ?>admin/orders/data_sales', // URL file untuk proses select datanya
            type: 'POST',
            data: {
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            } // Kirim token CSRF
        },
        columnDefs: [{
            targets: 4, // Target kolom aksi
            orderable: false, // Nonaktifkan sorting untuk kolom aksi
            render: function(data, type, row, meta) {
                return '<a href="/admin/orders/edit_sales/' + data + '" class="btn btn-sm btn-primary btn-edit"><i class="bx bx-pencil me-0"></i></a>' +
                    '<a href="/admin/orders/delete_sales/' + data + '" class="ms-2 btn btn-sm btn-danger"><i class="bx bx-trash me-0"></i></a>';
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

    // on close modal
    $('#modal-form').on('hidden.bs.modal', function() {
        $('#form-sales')[0].reset(); // Reset form saat modal ditutup
        $('#form-sales .form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#form-sales').attr('action', '<?= base_url('admin/orders/save_sales'); ?>');
        $('#summit-btn-form').attr('disabled', false).text('Simpan data'); // button dan ubah teks
    });

    // Handle form submission sales
    $('#form-sales').on('submit', function(e) {
        e.preventDefault(); // Mencegah form submit secara default

        $('#form-sales .form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        $('#summit-btn-form').attr('disabled', true).text('Menyimpan...'); // Disable button dan ubah teks

        var url = $(this).attr('action'); // Ambil URL action dari form

        var formData = new FormData(this); // Ambil data form
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false, // Jangan proses data
            contentType: false, // Jangan tetapkan tipe konten
            success: function(response) {
                if (response.status === 200) {
                    $('#modal-form').modal('hide');

                    Toast.fire({
                        timer: 2000,
                        icon: 'success',
                        title: response.message || 'Data berhasil disimpan.'
                    });

                    // Reload DataTables
                    table.ajax.reload(null, false); // Reload data tanpa reset pagination
                    $('#form-sales')[0].reset(); // Reset form setelah submit
                    $('#form-sales .form-control').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                } else {

                    Toast.fire({
                        timer: 2000,
                        icon: 'error',
                        title: response.message
                    });

                    // Jika ada error, tampilkan pesan error
                    for (var key in response.data) {
                        $('#' + key).addClass('is-invalid');
                        // Tambahkan pesan error ke dalam elemen yang sesuai
                        $('#error_' + key).text(response.data[key]);
                    }
                    $('#summit-btn-form').attr('disabled', false).text('Simpan data'); // button dan ubah teks

                }
            },

            error: function() {
                Toast.fire({
                    timer: 2000,
                    icon: 'error',
                    title: 'Terjadi kesalahan saat mengirim data.'
                });
                $('#summit-btn-form').attr('disabled', false).text('Simpan data'); // button dan ubah teks
            }
        });
    })

    // hendle edit sales
    $('#datatable').on('click', 'tbody tr td a.btn-edit', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.status === 200) {
                    $('#nama_sales').val(response.data.nama_sales);
                    $('#no_handphone').val(response.data.no_handphone);
                    $('#kode_sales').val(response.data.kode_sales);

                    $('#form-sales').attr('action', '<?= base_url('admin/orders/edit_sales/'); ?>' + response.data.id);
                    $('#modal-form').modal('show');
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
                    title: 'Terjadi kesalahan saat mengambil data.'
                });
            }
        });
    });

    // Handle delete confirmation
    table.on('click', 'tbody tr td a.btn-danger', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
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
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 200) {
                            Toast.fire({
                                timer: 2000,
                                icon: 'success',
                                title: response.message || 'Data berhasil dihapus.'
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
                            title: 'Terjadi kesalahan saat menghapus data.'
                        });
                    }
                });
            }
        })
    });
</script>
<?= $this->endSection(); ?>