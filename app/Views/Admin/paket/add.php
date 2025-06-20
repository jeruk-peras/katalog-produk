<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Paket Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">Paket Produk</li>
                    <li class="breadcrumb-item active" aria-current="page">Forms Paket Produk</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <hr>
    <form class="row g-3" action="" method="post">
        <div class="card">
            <div class="card-body row p-4">
                <?= csrf_field() ?>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Nama Paket <span class="text-danger">*<?= validation_show_error('nama_paket'); ?></span></label>
                    <input type="text" name="nama_paket" class="form-control" placeholder="Nama Paket">
                </div>

                <div class="d-md-flex d-grid align-items-center justify-content-end gap-3">
                    <button type="button" class="btn btn-light px-4">Reset</button>
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </div>
        </div>

    </form>
</div>

<?= $this->endSection(); ?>