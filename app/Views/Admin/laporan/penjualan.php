<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
        <div class="ps-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Penjualan</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto"></div>
    </div>

    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center table-responsive">
                <div class="me-5">
                    <h5 class="mb-0">Laporan Penjualan</h5>
                </div>
                <div class="ms-auto">
                    <form class="d-flex align-items-center" method="POST" action="/admin/penjualan-data" id="filter-form">
                        <?= csrf_field(); ?>
                        <label for="tanggal_awal" class="me-2 mb-0">Tanggal&nbsp;:</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control form-control-sm me-2" value="<?= esc($tanggal_awal ?? '') ?>">
                        <span class="me-2">s/d</span>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control form-control-sm me-2" value="<?= esc($tanggal_akhir ?? '') ?>">
                        <button type="submit" class="btn btn-sm btn-primary me-2" id="btn-filter">Filter</button>
                        <button type="button" class="btn btn-sm btn-primary" id="btn-print">Print</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="data-laporan">
                <div class="text-center my-5">
                    <h5>Silakan lakukan filter tanggal terlebih dahulu untuk melihat data.</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('/assets/js/jquery.PrintArea.js'); ?>"></script>
<script>
    $('#filter-form').submit(function(e) {
        e.preventDefault();
        var url, formData;
        url = $(this).attr('action');
        formData = $(this).serializeArray();
        $('#data-laporan').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#data-laporan').html(response.data.html);
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                console.error(response.message)
            }
        })
    })

    $('#btn-print').click(function() {
        // Jalankan PrintArea
        $('#data-laporan').printArea();
    });
</script>
<?= $this->endSection(); ?>