<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Stok Produk</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center table-responsive">
                <div class="me-5">
                    <h5 class="mb-0">Laporan Stok Produk</h5>
                </div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-sm btn-primary" id="btn-print">Print</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="data-laporan"></div>
        </div>
    </div>
</div>
<script src="<?= base_url('/assets/js/jquery.PrintArea.js'); ?>"></script>
<script>
    LoadData();
    function LoadData() {
        $('#data-laporan').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: '/admin/stok-produk-data',
            type: 'GET',
            success: function(response) {
                $('#data-laporan').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                console.error(response.message)
            }
        })
    }

    $('#btn-print').click(function() {
        // Jalankan PrintArea
        $('#data-laporan').printArea();
    });
</script>
<?= $this->endSection(); ?>