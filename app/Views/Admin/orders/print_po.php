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
            padding: 0mm 15mm;
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
            margin-top: 0px;
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
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <img src="<?= base_url('assets/images/logo-icon.png') ?>" alt="Logo Perusahaan" style="max-height:70px; margin-right:20px;">
                <div>
                    <h2 style="margin:0; font-size: 48px; font-weight: 700; text-align: left;">PT. NUR LISAN SAKTI</h2>
                    <p style="width: 500px; margin: 0; text-align: end;"><?= getKontak('alamat'); ?></p>
                </div>
            </div>
            <div>
                <h2 style="margin:0; font-size: 80px; font-weight: 600;">PO</h2>
            </div>
        </div>
    </div>

    <div class="info-perusahaan" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <table>
                    <tr>
                        <td style="width:140px;">Nomor Order</td>
                        <td>: <?= $data['no_order'] ?? '-' ?></td>
                    </tr>
                </table>
            </div>
            <div>
                <table>
                    <tr>
                        <td style="width:140px;">Tanggal Order</td>
                        <td>: <?= isset($data['created_at']) ? date('d F Y', strtotime($data['created_at'])) : '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="info-perusahaan">
        <h3 style="text-align:start; margin-bottom:15px;">Informasi Customer</h3>
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

    <h3 style="text-align:start; margin-bottom:15px;">Daftar Order</h3>
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
                        <!-- <td><?= ($order['nama_varian']) ?></td> -->
                        <td><?= ($order['nama_produk'] . ' #' . $order['nama_varian']) ?></td>
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
    <div class="info-perusahaan">
        <table>
            <tr>
                <td style="width:180px;">Catatan</td>
                <td>: <?= $data['catatan'] ?? '-' ?></td>
            </tr>
        </table>
    </div>

    <div class="info-perusahaan" style="margin-top: 25px;">
        <h3 style="text-align:start; margin-bottom:5px;">Metode Pembayaran</h3>
        <div style="display: flex; gap: 40px;">
            <div style="display: flex; align-items: center;">
                <input type="checkbox" id="cod" <?= (isset($data['metode_pembayaran']) && $data['metode_pembayaran'] === 'cod') ? 'checked' : '' ?>>
                <label for="cod" style="margin-left:8px;">Cash on Delivery</label>
            </div>
            <div style="display: flex; align-items: center;">
                <input type="checkbox" id="top" <?= (isset($data['metode_pembayaran']) && $data['metode_pembayaran'] === 'top') ? 'checked' : '' ?>>
                <label for="top" style="margin-left:8px;">Terms of Payment</label>
            </div>
        </div>
    </div>


    <div class="ttd">
        <table style="width:100%;">
            <tr>
                <td style="text-align:left;">
                    <div>&nbsp;</div>
                    <div style="margin-top:10px;">Customer,</div>
                    <div class="nama-ttd" style="margin-top:80px;">____________________</div>
                </td>
                <td style="text-align:right;">
                    <div>&nbsp;</div>
                    <div style="margin-top:10px;">Sales,</div>
                    <div class="nama-ttd" style="margin-top:80px;">____________________</div>
                </td>
            </tr>
        </table>
    </div>
</body>
<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script>
    window.print();
    setInterval(function(){
        window.close()
    }, 500)
</script>

</html>