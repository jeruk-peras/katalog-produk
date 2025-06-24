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
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [{
                targets: 1, // Target kolom aksi
                orderable: false, // Nonaktifkan sorting untuk kolom aksi
                render: function(data, type, row, meta) {
                    return '<a role="button" data-id="' + data + '" class="ms-2 btn btn-sm btn-primary" id="btn-detail" titile="Detail Data"><i class="bx bx-info-circle me-0"></i></a>' 
                    + '<a href="/admin/orders/delete/' + data + '" class="ms-2 btn btn-sm btn-danger" titile="Hapus Data"><i class="bx bx-trash-alt me-0"></i></a>' 
                    + '<a href="/admin/orders/print/' + data + '" class="ms-2 btn btn-sm btn-primary" target="_balank" titile="Print Data"><i class="bx bx-printer me-0"></i></a>';
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
        table.on('click', 'tbody tr td a#btn-detail', function(e) {
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