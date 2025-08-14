<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add Order</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">Data Orders</li>
                    <li class="breadcrumb-item active" aria-current="page">Form Add Order</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <form action="" method="post" id="form-data" data-add="true">
                <?= csrf_field(); ?>
                <div class="row">

                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-1">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= $data['nama'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('nama'); ?></div>
                    </div>

                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-1">
                        <label class="form-label">No Handphone</label>
                        <input type="text" class="form-control <?= validation_show_error('no_handphone') ? 'is-invalid' : ''; ?>" id="no_handphone" name="no_handphone" value="<?= $data['no_handphone'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('no_handphone'); ?></div>
                    </div>

                    <div class="col-12 col-lg-4 col-md-4 col-sm-12 mb-1">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control <?= validation_show_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= $data['email'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('email'); ?></div>
                    </div>

                    <div class="col-12 mb-1">
                        <label class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control <?= validation_show_error('nama_tempat') ? 'is-invalid' : ''; ?>" id="nama_tempat" name="nama_tempat" value="<?= $data['nama_tempat'] ?? '' ?>">
                        <div class="invalid-feedback" id="error_tanggal_masuk"><?= validation_show_error('nama_tempat'); ?></div>
                    </div>

                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-1">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control <?= validation_show_error('alamat') ? 'is-invalid' : ''; ?>" id="alamat" name="alamat"><?= old('alamat') ? old('alamat') : ($data ? $data['alamat'] : ''); ?></textarea>
                        <div class="invalid-feedback" id="error_keterangan"><?= validation_show_error('alamat'); ?></div>
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-1">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control <?= validation_show_error('catatan') ? 'is-invalid' : ''; ?>" id="catatan" name="catatan"><?= old('catatan') ? old('catatan') : ($data ? $data['catatan'] : ''); ?></textarea>
                        <div class="invalid-feedback" id="error_keterangan"><?= validation_show_error('catatan'); ?></div>
                    </div>

                    <div class="col-6 col-lg-6 col-md-6 col-sm-6 mb-1">
                        <label class="form-label">Methode Pembayaran</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" <?= (isset($data['metode_pembayaran']) && $data['metode_pembayaran'] === 'cod') ? 'checked' : '' ?> id="cod" value="cod">
                                <label class="form-check-label" for="cod">Cash on Delivery</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" <?= (isset($data['metode_pembayaran']) && $data['metode_pembayaran'] === 'top') ? 'checked' : '' ?> id="top" value="top">
                                <label class="form-check-label" for="top">Terms of Payment</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 col-md-6 col-sm-6 mb-1">
                        <label class="form-label">Sales</label>
                        <div class="mt-1">
                            <select name="sales_id" class="form-select" id="">
                                <option hidden >-- Pilih Sales --</option>
                                <?php foreach($sales as $row): ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['nama_sales']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="form-check-label m-0 p-0"><?= $data['nama_sales'] ?? ''; ?></label>
                        </div>
                    </div>

                    <div class="col mb-1 text-end">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan Data</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // hendle save
    $('#form-data').submit(function(e) {
        e.preventDefault();
        var url, formData;
        url = $(this).attr('action');
        formData = $(this).serializeArray();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                Toast.fire({
                    timer: 2000,
                    icon: 'success',
                    title: response.message
                });

                window.location.href = response.data.redirect;
            },
            error: function(xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                Toast.fire({
                    timer: 2000,
                    icon: 'error',
                    title: response.message
                });
            }
        })
    })
</script>

<?= $this->endSection();  ?>