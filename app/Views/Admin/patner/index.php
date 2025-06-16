<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Patner</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Patner</li>
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
                    <h3 class="mb-0 text-uppercase">Data Patner</h3>
                </div>
                <div class="ms-auto">
                    <button href="<?= base_url('admin/Patner/add'); ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Patner</th>
                            <th>Logo</th>
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
            <form action="" method="post" id="form-data" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Patner</label>
                        <input type="text" class="form-control" id="nama_patner" name="nama_patner">
                        <div class="invalid-feedback" id="error_nama_patner"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" id="logo_patner" name="logo_patner" accept="image/*">
                        <div class="invalid-feedback" id="error_logo_patner"></div>
                        <div class="form-text">Format gambar: jpg, jpeg, png, gif. Ukuran maksimal 2MB.</div>
                        <img id="preview-gambar" src="" alt="Preview Gambar" class="img-thumbnail" style="display: none; max-width: 200px;">
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
<?= $this->include('admin/patner/script'); ?>
<?= $this->endSection(); ?>