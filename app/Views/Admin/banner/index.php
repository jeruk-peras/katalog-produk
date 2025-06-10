<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Banner</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data banner</li>
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
                    <h3 class="mb-0 text-uppercase">Data banner</h3>
                </div>
                <div class="ms-auto">
                    <button href="<?= base_url('admin/banner/add'); ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Banner</th>
                            <th>Gambar</th>
                            <th>Status</th>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-data" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Nama banner</label>
                        <input type="text" class="form-control" id="nama_banner" name="nama_banner" placeholder="Masukkan nama banner">
                        <div class="invalid-feedback" id="error_nama_banner"></div>
                    </div>
                    <div class="mb-3">
                        <label for="banner" class="form-label">Deskripsi banner</label>
                        <textarea class="form-control" id="deskripsi_banner" name="deskripsi_banner" placeholder="Masukkan deskripsi banner" rows="4"><h2>Ex, Promo .....</h2>
<p>Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.</p>
<h3>Diskon 50%</h3></textarea>
<div class="form-text">* Silahkan sesuaikan dengan informasi banner, atau kosongkan isian</div>
                        <div class="invalid-feedback" id="error_deskripsi_banner"></div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar_banner" name="gambar_banner" accept="image/*">
                        <div class="invalid-feedback" id="error_gambar_banner"></div>
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
<?= $this->include('Admin/banner/script'); ?>
<?= $this->endSection(); ?>