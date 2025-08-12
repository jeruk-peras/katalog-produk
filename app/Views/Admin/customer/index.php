<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Customer</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Customer</li>
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
                    <h5 class="mb-0 text-uppercase">Data Customer</h5>
                </div>
                <div class="ms-auto">
                    <button href="<?= base_url('admin/customer/add'); ?>" type="button" class="btn btn-sm btn-primary" id="btn-add"><i class="bx bx-plus"></i> Tambah Data</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>No Handphone</th>
                            <th>Email</th>
                            <th>Nama Perusahaan</th>
                            <th>Provinsi</th>
                            <th>Kota/Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Kelurahan</th>
                            <th>Alamat</th>
                            <th>Sales</th>
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
<div class="modal modal-xl fade" id="modal-form" tabindex="-1" aria-hidden="true">
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
                            <label for="nama_lengkap" class="form-label">Nama lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap">
                            <div class="invalid-feedback" id="error_nama_lengkap"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="no_handphone" class="form-label">No Kontak</label>
                            <input type="text" class="form-control" id="no_handphone" maxlength="15" name="no_handphone" placeholder="Masukkan No Kontak">
                            <div class="invalid-feedback" id="error_no_handphone"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                            <div class="invalid-feedback" id="error_email"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" placeholder="Masukkan Nama Perusahaan">
                            <div class="invalid-feedback" id="error_nama_perusahaan"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select class="form-select" name="provinsi" id="provinsi">
                                <option value="0">Provinsi</option>
                            </select>
                            <div class="invalid-feedback" id="error_provinsi"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="kota_kabupaten" class="form-label">Kota/Kabupaten</label>
                            <select class="form-select" name="kota_kabupaten" id="kota_kabupaten">
                                <option value="0">Kota/Kabupaten</option>
                            </select>
                            <div class="invalid-feedback" id="error_kota_kabupaten"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select class="form-select" name="kecamatan" id="kecamatan">
                                <option value="0">Kecamatan</option>
                            </select>
                            <div class="invalid-feedback" id="error_kecamatan"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <select class="form-select" name="kelurahan" id="kelurahan">
                                <option value="0">Desa/Kelurahan</option>
                            </select>
                            <div class="invalid-feedback" id="error_kelurahan"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea type="text" class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan Alamat"></textarea>
                            <div class="invalid-feedback" id="error_alamat"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="sales" class="form-label">Sales</label>
                            <select class="form-select" name="sales_id" id="sales">
                                <?php foreach ($sales as $row):  ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['nama_sales']; ?></option>
                                <?php endforeach;  ?>
                            </select>
                            <div class="invalid-feedback" id="error_kelurahan"></div>
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
<?= $this->include('admin/customer/script'); ?>
<?= $this->endSection(); ?>