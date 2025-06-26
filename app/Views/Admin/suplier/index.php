<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Suplier</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data suplier</li>
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
                    <h5 class="mb-0 text-uppercase">Data suplier</h5>
                </div>
                <div class="ms-auto">
                    <button href="<?= base_url('admin/suplier/add'); ?>" type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama suplier</th>
                            <th>Nama Sales</th>
                            <th>No Handphone</th>
                            <th>Alamat</th>
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
            <form action="" method="post" id="form-suplier" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="kategori" class="form-label">Nama suplier</label>
                            <input type="text" class="form-control" id="nama_suplier" name="nama_suplier" placeholder="Masukkan nama suplier">
                            <div class="invalid-feedback" id="error_nama_suplier"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="kategori" class="form-label">Nama Sales</label>
                            <input type="text" class="form-control" id="nama_sales" name="nama_sales" placeholder="Masukkan nama sales">
                            <div class="invalid-feedback" id="error_nama_sales"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="kategori" class="form-label">No Kontak</label>
                            <input type="text" class="form-control" id="no_handphone" maxlength="15" name="no_handphone" placeholder="Masukkan No Kontak">
                            <div class="invalid-feedback" id="error_no_handphone"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="kategori" class="form-label">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan Alamat"></textarea>
                            <div class="invalid-feedback" id="error_alamat"></div>
                        </div>
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
<?= $this->include('admin/suplier/script'); ?>
<?= $this->endSection(); ?>