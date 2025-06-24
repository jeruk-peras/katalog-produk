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
            padding: 20mm 15mm;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #000;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 2px solid #000;
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
            margin-bottom: 40px;
        }

        .order-list th,
        .order-list td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: left;
            font-size: 14px;
        }

        .order-list th {
            background: #f0f0f0;
        }

        .ttd {
            width: 100%;
            margin-top: 60px;
            text-align: right;
        }

        .ttd .nama-ttd {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <div style="display: flex; align-items: center; justify-content: center;">
            <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="Logo Perusahaan" style="max-height:70px; margin-right:20px;">
            <div style="text-align: left;">
            <h2 style="margin:0;">PT. NUR LISAN SAKTI</h2>
            <div><?= getKontak('alamat'); ?> | Telp: <?= getKontak('telepon'); ?> | Email: <?= getKontak('email') ?></div>
            </div>
        </div>
    </div>

    <div class="info-perusahaan">
        <table>
            <tr>
                <td style="width:180px;">Nama Perusahaan</td>
                <td>: <?= $data['nama_tempat'] ?? '-' ?></td>
            </tr>
            <tr>
                <td>Nama Kontak</td>
                <td>: <?= $data['nama'] ?? '-' ?></td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>: <?= $data['no_handphone'] ?? '-' ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: <?= $data['email'] ?? '-' ?></td>
            </tr>
            <tr>
                <td>Alamat Lengkap</td>
                <td>: <?= $data['alamat'] ?? '-' ?></td>
            </tr>
        </table>
    </div>

    <h3 style="text-align:center; margin-bottom:10px;">Daftar Order Produk</h3>
    <table class="order-list">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>QTY</th>
                <th style="width: 15%;">Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php
                $no = 1;
                $grand_total = 0;
                foreach ($orders as $order):
                    $harga = ($order['harga_diskon'] ? $order['harga_diskon'] : $order['harga']);
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($order['nama_produk'] . ' - ' . $order['nama_varian']) ?></td>
                        <td><?= $order['jumlah'] ?></td>
                        <td>Rp<?= number_format($harga, 0, ',', '.') ?></td>
                        <td>Rp<?= number_format($order['jumlah'] * $harga, 0, ',', '.') ?></td>
                    </tr>
                <?php $grand_total += $order['jumlah'] * $harga;
                endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align:right;font-weight:bold;">Grand Total</td>
                    <td style="font-weight:bold;">Rp<?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="ttd">
        <table style="width:100%;">
            <tr>
                <td style="text-align:left;">
                    <div><?= date('d F Y') ?></div>
                    <div style="margin-top:10px;">Penerima,</div>
                    <div class="nama-ttd" style="margin-top:80px;">____________________</div>
                </td>
                <td style="text-align:right;">
                    <div>&nbsp;</div>
                    <div style="margin-top:10px;">Hormat Kami,</div>
                    <div class="nama-ttd" style="margin-top:80px;">____________________</div>
                </td>
            </tr>
        </table>
    </div>
</body>

<script>
window.onload = function() {
    window.print();
    window.onafterprint = function() {
        window.close();
    };
    // Fallback for print cancel (some browsers)
    window.matchMedia('print').addEventListener('change', function(e) {
        if (!e.matches) window.close();
    });
};
</script>

</html>