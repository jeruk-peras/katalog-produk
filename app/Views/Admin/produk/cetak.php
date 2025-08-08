<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Order Produk</title>
    <style>
        @media print {
            body {
                margin: 0;
            }
        }

        body {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 0mm 5mm;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #000;
        }

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

        .info-perusahaan {
            margin-bottom: 25px;
        }

        .info-perusahaan table {
            width: 100%;
            font-size: 15px;
        }

        .order-list {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .order-list th {
            text-align: center !important;
        }

        .order-list th,
        .order-list td {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: left;
            font-size: 11px;
        }

        .order-list th {
            background: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
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
    <table class="order-list">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Stok</th>
                <th style="width: 8%">SO</th>
                <th style="width: 20%">Keterangan</th>
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
                    <td>
                        <small><?= $p['nama_kategori']; ?></small><br>
                        <?= $p['nama_produk']; ?>
                        <?php if ($produkVarianCount[$key] > 1): ?>
                            #<b><?= $p['nama_varian']; ?></b>
                        <?php endif; ?>
                    </td>
                    <td><?= $p['nama_satuan']; ?></td>
                    <td>Rp<?= number_format($p['harga_varian'], 0, '', '.'); ?></td>
                    <td class="text-end"><?= $p['stok_varian']; ?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach;  ?>
        </tbody>
    </table>
</body>
<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script>
    window.print();
    setInterval(function() {
        window.close()
    }, 500)
</script>

</html>