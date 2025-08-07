<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Data Produk</li>
                    <li class="breadcrumb-item active" aria-current="page">Cetak Data Produk</li>
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
                    <h5 class="mb-0 text-uppercase">Data Produk</h5>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-primary btn-print" id="btn-print"><i class="bx bx-printer"></i> Print</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="print-data">
                <div class="kop-surat">
                    <style>
                        .kop-surat {
                            text-align: center;
                            /* border-bottom: 2px solid #000; */
                            padding-bottom: 10px;
                            margin-bottom: 20px;
                        }

                        .kop-surat h2 {
                            margin-top: 0;
                            margin-bottom: 0;
                        }

                        .kop-surat img {
                            max-height: 70px;
                            margin-bottom: 10px;
                        }
                    </style>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center;">
                            <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="Logo Perusahaan" style="max-height:70px; margin-right:20px;">
                            <div>
                                <h2 style="margin:0; font-size: 48px; font-weight: 700; text-align: left;">PT. NUR LISAN SAKTI</h2>
                                <p style="width: 500px; margin: 0; text-align: end;"><?= getKontak('alamat'); ?></p>
                            </div>
                        </div>
                        <div>
                            <h2 style="margin:0; font-size: 80px; font-weight: 600;"></h2>
                        </div>
                    </div>
                </div>
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nama Produk</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th style="width: 5%">SO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        // Hitung jumlah varian per produk
                        $produkVarianCount = [];
                        foreach ($produk as $p) {
                            $key = $p['nama_produk'] . '|' . $p['nama_kategori'];
                            if (!isset($produkVarianCount[$key])) {
                                $produkVarianCount[$key] = 0;
                            }
                            $produkVarianCount[$key]++;
                        }

                        foreach ($produk as $p) :
                            $key = $p['nama_produk'] . '|' . $p['nama_kategori'];
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $p['nama_kategori']; ?></td>
                                <td>
                                    <?= $p['nama_produk']; ?>
                                    <?php if ($produkVarianCount[$key] > 1): ?>
                                        #<b><?= $p['nama_varian']; ?></b>
                                    <?php endif; ?>
                                </td>
                                <td><?= $p['nama_satuan']; ?></td>
                                <td>Rp<?= number_format($p['harga_varian'], 0, '', '.'); ?></td>
                                <td class="text-end"><?= $p['stok_varian']; ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url(); ?>assets/js/jquery.PrintArea.js"></script>
<script>
    $('#btn-print').click(function() {
        // Disable tombol
        $('#btn-print').prop('disabled', true).html('<i class="bx bx-printer"></i> Printing...');

        // Jalankan PrintArea
        $('#print-data').printArea();

        // Re-enable tombol setelah delay (estimasi proses print)
        setTimeout(function() {
            $('#btn-print').prop('disabled', false).html('<i class="bx bx-printer"></i> Print');
        }, 2000); // 2 detik, bisa disesuaikan
    });
</script>
<?= $this->endSection(); ?>