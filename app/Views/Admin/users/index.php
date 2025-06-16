<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Users</li>
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
                    <h5 class="mb-0 text-uppercase">Data Users</h5>
                </div>
                <div class="ms-auto">
                    <button href="<?= base_url('admin/Users/add'); ?>" type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form"><i class="bx bx-plus"></i> Tambah Data</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Role</th>
                            <th>Username</th>
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
            <form action="" method="post" id="form-users" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Nama user</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Masukkan nama user">
                            <div class="invalid-feedback" id="error_nama_user"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                            <div class="invalid-feedback" id="error_username"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-control" id="role" name="role">
                                <option value="" hidden>Pilih Role</option>
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <div class="invalid-feedback" id="error_role"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                            <div class="invalid-feedback" id="error_password"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Konformasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Masukkan Konformasi Password">
                            <div class="invalid-feedback" id="error_confirm_password"></div>
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
<?= $this->include('admin/users/script'); ?>
<?= $this->endSection(); ?>