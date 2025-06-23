<script>
    $(document).ready(function() {
        // load data
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ordering: true, // Set true agar bisa di sorting
            ajax: {
                url: 'spesifikasi/data', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [
                {
                    targets: 3, // Target kolom aksi
                    orderable: false, // Nonaktifkan sorting untuk kolom aksi
                    render: function(data, type, row, meta) {
                        return '<a href="/admin/spesifikasi/edit/' + data + '" class="btn btn-sm btn-primary" id="btn-edit"><i class="bx bx-pencil me-0"></i></a>' +
                            '<a href="/admin/spesifikasi/delete/' + data + '" class="ms-2 btn btn-sm btn-danger"><i class="bx bx-trash me-0"></i></a>';
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

        // Tambah baris input spesifikasi
        $(document).on('click', '.btn-add', function() {
            var newRow = `
                <div class="row mb-3 spesifikasi-item">
                    <div class="col">
                        <input type="text" class="form-control" name="nama_spesifikasi[]" placeholder="Masukkan nama spesifikasi">
                    </div>
                    <div class="col-auto d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-remove">-</button>
                    </div>
                </div>`;
            $('#spesifikasi-container').append(newRow);
        });

        // Hapus baris input spesifikasi
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('.spesifikasi-item').remove();
        });

        $('#modal-form').on('hidden.bs.modal', function() {
            $('#form-spesifikasi')[0].reset(); // Reset form saat modal ditutup
            $('#form-spesifikasi').attr('action', '');
            $('#form-spesifikasi .form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#summit-btn-form').attr('disabled', false).text('Simpan data'); // button dan ubah teks
        });

        // Handle form submission
        $('#form-spesifikasi').on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit secara default

            $('#form-spesifikasi .form-control').removeClass('is-invalid');
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
                    console.log($('#form-spesifikasi').data('add')); // Log untuk debugging
                    if (response.status === 200) {
                        $('#modal-form').modal('hide');

                        Toast.fire({
                            timer: 2000,
                            icon: 'success',
                            title: response.message || 'Data berhasil disimpan.'
                        });

                        if($('#form-spesifikasi').data('add')){
                            // Redirect ke halaman spesifikasi
                            window.location.href = '<?= base_url('admin/spesifikasi'); ?>'; // Redirect ke halaman spesifikasi
                        }
                        // Reload DataTables
                        table.ajax.reload(null, false); // Reload data tanpa reset pagination
                        $('#form-spesifikasi')[0].reset(); // Reset form setelah submit
                        $('#form-spesifikasi .form-control').removeClass('is-invalid');
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

        // hendle edit button click
        $('#datatable').on('click', 'tbody tr td a#btn-edit', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        $('#form-spesifikasi').attr('action', '<?= base_url('admin/spesifikasi/edit/'); ?>' + response.data.id_spesifikasi);
                        $('#nama_spesifikasi').val(response.data.nama_spesifikasi);
                        $('#kategori_id').val(response.data.kategori_id);
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
    })
</script>