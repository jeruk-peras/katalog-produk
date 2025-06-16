<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Layanan</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Layanan</li>
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
                    <h3 class="mb-0 text-uppercase">Data Layanan</h3>
                </div>
                <div class="ms-auto">
                    <button href="<?= base_url('admin/layanan/add'); ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Icon</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
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
                        <label class="form-label">Icon</label>
                        <textarea type="text" class="form-control" id="icon_layanan" name="icon_layanan"></textarea>
                        <div class="invalid-feedback" id="error_icon_layanan"></div>
                        <div class="form-text">untuk icon silahkan cari di <a href="https://heroicons.com/" target="_blank">https://heroicons.com/</a> Copy SVG lalu paste dikolom icon</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama layanan</label>
                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" placeholder="Masukkan nama layanan">
                        <div class="invalid-feedback" id="error_nama_layanan"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi layanan</label>
                        <textarea type="text" class="form-control" id="deskripsi_layanan" name="deskripsi_layanan"></textarea>
                        <div class="invalid-feedback" id="error_deskripsi_layanan"></div>
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
<?= $this->include('admin/layanan/script'); ?>
<?= $this->endSection(); ?>