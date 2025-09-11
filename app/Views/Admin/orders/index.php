<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Orders</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Orders</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <hr />
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="mb-0 text-uppercase">Data Orders</h3>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-primary btn-filter px-3" data-status="0"><i class="bx bx-bookmark mr-1"></i>Baru</button>
                    <button type="button" class="btn btn-sm text-primary btn-filter px-3" data-status="3"><i class="bx bx-send mr-1"></i>Kirim</button>
                    <button type="button" class="btn btn-sm text-primary btn-filter px-3" data-status="1"><i class="bx bx-check-circle mr-1"></i>Terima</button>
                    <button type="button" class="btn btn-sm text-primary btn-filter px-3" data-status="2"><i class="bx bx-x-circle mr-1"></i>Tolak</button>
                    <a href="<?= base_url('/admin/orders/add'); ?>" class="btn btn-sm btn-outline-primary px-5"><i class="bx bx-plus mr-1"></i>Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="filter-data" data-status="0">
                <table id="datatable" class="table table-striped table-bordered" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Tanggal</th>
                            <th>No Order</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama</th>
                            <th>No Handphone</th>
                            <th>Nama Sales</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detail-modal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <span type="button" style="margin: calc(-.5 * var(--bs-modal-header-padding-y)) calc(-.5 * var(--bs-modal-header-padding-x)) calc(-.5 * var(--bs-modal-header-padding-y)) auto; font-weight: 700; margin-right: 5px;">Aksi : </span>
                <a href="" class="ms-2 btn btn-sm btn-primary fw-bolder" target="_balank" id="print-do" titile="Print Data"><i class="bx bx-printer"></i> DO</a>
                <a href="" class="ms-2 btn btn-sm btn-primary fw-bolder" target="_balank" id="print-po" titile="Print Data"><i class="bx bx-printer"></i> PO</a>
            </div>
            <div class="modal-body">
                <div class="mb-3" id="alamat-pengirim" style="color: #212529;"></div>
                <table class="table mb-0 table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Harga Diskon</th>
                            <th scope="col">QYT</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="detail-data"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->include('admin/orders/script'); ?>
<?= $this->endSection(); ?>