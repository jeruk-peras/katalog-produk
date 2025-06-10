<script>
    $(document).ready(function() {
        // load data
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ordering: true, // Set true agar bisa di sorting
            ajax: {
                url: 'pesan/data', // URL file untuk proses select datanya
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                } // Kirim token CSRF
            },
            columnDefs: [
                {
                    targets: 5, // Target kolom aksi
                    orderable: false, // Nonaktifkan sorting untuk kolom aksi
                    render: function(data, type, row, meta) {
                        return '<a href="/admin/pesan/delete/' + data + '" class="ms-2 btn btn-sm btn-danger"> hapus</a>';
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