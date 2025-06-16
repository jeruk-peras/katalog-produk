<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Spesifikasi</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Spesifikasi</li>
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
                    <h3 class="mb-0 text-uppercase">Tambah data spesifikasi</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post" id="form-spesifikasi" data-add="true">
                <?= csrf_field() ?>
                <div class="col mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($kategori as $kat) : ?>
                            <option value="<?= $kat['id_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback" id="error_kategori_id"></div>
                </div>
                <div id="spesifikasi-container">
                    <div class="row mb-3 spesifikasi-item">
                        <div class="col">
                            <label class="form-label">Nama Spesifikasi</label>
                            <input type="text" class="form-control" id="nama_spesifikasi.0" name="nama_spesifikasi[]" placeholder="Masukkan nama spesifikasi">
                            <div class="invalid-feedback" id="error_nama_spesifikasi.0"></div>
                        </div>
                        <div class="col-auto d-flex align-items-end">
                            <button type="button" class="btn btn-primary btn-add">+</button>
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="summit-btn-form" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->include('admin/spesifikasi/script'); ?>
<?= $this->endSection(); ?>