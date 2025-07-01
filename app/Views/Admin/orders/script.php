<script>
    $(document).ready(function() {
        // load data
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            // responsive: true,
            ordering: true, // Set true agar bisa di sorting
            ajax: {
                url: 'orders/data', // URL file untuk proses select datanya
                type: 'POST',
                data: function(d) {
                    d['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
                    d.status = $('#filter-data').attr('data-status');
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 1, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {

                    var btn = (row[8] > 0 ? '' : '<button role="button" data-id="' + data + '" class="ms-2 btn btn-sm btn-primary" id="btn-terima" titile="Terima Order"><i class="bx bx-check me-0"></i></button>' + '<button role="button" data-id="' + data + '" class="ms-2 btn btn-sm btn-primary" id="btn-tolak" titile="Tolak Order"><i class="bx bx-x me-0"></i></button>');
                    var del = (row[8] == 2 ? '<a href="/admin/orders/delete/' + data + '" class="ms-2 btn btn-sm btn-danger" titile="Hapus Data"><i class="bx bx-trash-alt me-0"></i></a>' : '');

                    return '<button role="button" data-id="' + data + '" class="ms-2 btn btn-sm btn-primary" id="btn-detail" titile="Detail Data"><i class="bx bx-info-circle me-0"></i></button>' + btn + del
                        
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

        $('#detail-modal').on('hidden.bs.modal', function() {
            $('#detail-data').html('');
        });

        // hendle detail order
        table.on('click', 'tbody tr td button#btn-detail', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('admin/orders/detail_order') ?>',
                type: 'POST',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    id_order: $(this).data('id')
                },
                success: function(response) {

                    if (response.status == 200) {
                        var data = response.data.data

                        $('#print-po').attr('href', '/admin/orders/print-po/' + data.id_order);
                        $('#print-do').attr('href', '/admin/orders/print-do/' + data.id_order);

                        $('#alamat-pengirim').html(`<strong> Alamat Pengirim </strong> : <br> ${data.nama}, ${data.no_handphone}, ${data.email} <br> ${data.nama_tempat} <br> ${data.alamat}`)

                        var html = ``;
                        var i = 1;
                        var total = 0;
                        $.each(response.data.detail, function(index, data) {
                            html += `<tr>
                                        <th>${i++}</th>
                                        <td>${data.nama_produk}<br> <small><b>${data.nama_varian}</b></small></td>
                                        <td>${data.harga_diskon == 0 ? formatRupiah(data.harga): '-' }</td>
                                        <td>${data.harga_diskon == 0 ? '-' : formatRupiah(data.harga_diskon)}</td>
                                        <td>${data.jumlah}</td>
                                        <td>${formatRupiah(data.total)}</td>
                                     </tr>`;
                            total += parseInt(data.total);
                        });
                        html += `<tr><td colspan="5"></td><th>${formatRupiah(total)}</th></tr>`;
                        $('#detail-data').html(html);
                    }
                },
                error: function() {

                }
            })
            $('#detail-modal').modal('show');
        })

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        // Handle reject accept
        table.on('click', 'tbody tr td button#btn-terima', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Konfirmasi Aksi',
                text: "Apakah Anda yakin ingin menerima data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Terima!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/orders/' + id + '/accept',
                        type: 'POST',
                        data: {
                            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Toast.fire({
                                    timer: 2000,
                                    icon: 'success',
                                    title: response.message
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

        table.on('click', 'tbody tr td button#btn-tolak', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Konfirmasi Aksi',
                text: "Apakah Anda yakin ingin menolak data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/orders/' + id + '/reject',
                        type: 'POST',
                        data: {
                            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Toast.fire({
                                    timer: 2000,
                                    icon: 'success',
                                    title: response.message
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

        // filter data
        $('button.btn-filter').click(function() {
            var status = $(this).data('status');
            $('#filter-data').attr('data-status', status);
            table.ajax.reload();

            // style
            if (status == '0') {
                $(this).addClass('btn-primary');
                $('button.btn-filter').removeClass('btn-success');
                $('button.btn-filter').removeClass('btn-danger');
                $('button.btn-filter').addClass('text-primary');
                $(this).removeClass('text-primary');
            }
            if (status == '1') {
                $(this).addClass('btn-success');
                $('button.btn-filter').removeClass('btn-primary');
                $('button.btn-filter').removeClass('btn-danger');
                $('button.btn-filter').addClass('text-primary');
                $(this).removeClass('text-primary');
            }
            if (status == '2') {
                $(this).addClass('btn-danger');
                $('button.btn-filter').removeClass('btn-success');
                $('button.btn-filter').removeClass('btn-primary');
                $('button.btn-filter').addClass('text-primary');
                $(this).removeClass('text-primary');
            }
        })
    })
</script>