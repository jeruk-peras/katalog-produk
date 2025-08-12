<script>
    $(document).ready(function() {
        // load data
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true, // Set true agar bisa di sorting
            ajax: {
                url: 'customer/data', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 11, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {
                    return '<a href="/admin/customer/edit/' + data + '" class="btn btn-sm btn-primary"><i class="bx bx-pencil me-0"></i></a>' +
                        '<a href="/admin/customer/delete/' + data + '" class="ms-2 btn btn-sm btn-danger"><i class="bx bx-trash me-0"></i></a>';
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

        // hendle data alamat wilahayah indonesia
        function loadWilayah(url, $select, placeholder, selected = null, callback = null) {
            $select.html(`<option value="0">${placeholder}</option>`);
            var id = 0;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $.each(response, function(_, item) {
                        let val = item.id;
                        let name = item.name;
                        let selectedAttr = (selected && selected == name) ? 'selected' : '';
                        id = (selected && selected == name) ? val : id;
                        $select.append(`<option value="${name}" data-id="${val}" ${selectedAttr}>${name}</option>`);
                    });
                    if (callback) callback(id);
                },
                error: function(er) {
                    console.log(er.error);
                }
            })
        }

        // open modal
        $('#btn-add').on('click', function() {
            $('#modal-form').modal('show');
            // Load provinsi on page load
            loadWilayah('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', $('#provinsi'), 'Provinsi');

            // When provinsi changes, load kabupaten/kota
            $('#provinsi').on('change', function() {
                let provId = $(this).find(':selected').data('id');
                $('#kota_kabupaten').html('<option value="0">Kota/Kabupaten</option>');
                $('#kecamatan').html('<option value="0">Kecamatan</option>');
                $('#kelurahan').html('<option value="0">Desa/Kelurahan</option>');
                if (provId != "0") {
                    loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`, $('#kota_kabupaten'), 'Kota/Kabupaten');
                }
            });

            // When kabupaten/kota changes, load kecamatan
            $('#kota_kabupaten').on('change', function() {
                let kabId = $(this).find(':selected').data('id');
                $('#kecamatan').html('<option value="0">Kecamatan</option>');
                $('#kelurahan').html('<option value="0">Desa/Kelurahan</option>');
                if (kabId != "0") {
                    loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabId}.json`, $('#kecamatan'), 'Kecamatan');
                }
            });

            // When kecamatan changes, load kelurahan
            $('#kecamatan').on('change', function() {
                let kecId = $(this).find(':selected').data('id');
                $('#kelurahan').html('<option value="0">Desa/Kelurahan</option>');
                if (kecId != "0") {
                    loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`, $('#kelurahan'), 'Desa/Kelurahan');
                }
            });
        });

        $('#modal-form').on('hidden.bs.modal', function() {
            $('#form-suplier').attr('action', '');
            $('#form-suplier')[0].reset(); // Reset form saat modal ditutup
            $('#form-suplier .form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('#summit-btn-form').attr('disabled', false).text('Simpan data'); // button dan ubah teks
        });

        // Handle form submission
        $('#form-suplier').on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit secara default

            $('#form-suplier .form-control').removeClass('is-invalid');
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
                        $('#form-suplier')[0].reset(); // Reset form setelah submit
                        $('#form-suplier .form-control').removeClass('is-invalid');
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
        $('#datatable').on('click', 'tbody tr td a.btn-primary', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        $('#nama_lengkap').val(response.data.nama_lengkap);
                        $('#no_handphone').val(response.data.no_handphone);
                        $('#email').val(response.data.email);
                        $('#nama_perusahaan').val(response.data.nama_perusahaan);
                        loadWilayah('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', $('#provinsi'), 'Provinsi', response.data.provinsi, function(id) {
                            loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`, $('#kota_kabupaten'), 'Kota/Kabupaten', response.data.kota_kabupaten, function(id) {
                                loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`, $('#kecamatan'), 'Kecamatan', response.data.kecamatan, function(id) {
                                    loadWilayah(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`, $('#kelurahan'), 'Desa/Kelurahan', response.data.kelurahan);
                                });
                            });
                        });
                        $('#alamat').val(response.data.alamat);
                        $('#sales').val(response.data.sales_id);
                        $('#form-suplier').attr('action', '<?= base_url('admin/customer/edit/'); ?>' + response.data.id);
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