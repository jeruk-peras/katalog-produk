<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Jalan / Delivery Order</title>
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

        .order-list th {
            text-align: center !important;
        }

        .order-list th,
        .order-list td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: left;
            font-size: 14px;
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
                <h2 style="margin:0; font-size: 80px; font-weight: 600;">DO</h2>
            </div>
        </div>
    </div>

    <div class="info-perusahaan" style="margin-bottom: 0;">
        <table style="font-weight: 700;">
            <tr>
                <td style="width:140px;">BILL TO :</td>
                <td style="width:140px; text-align: end;">PT. Nur Lisan Sakti</td>
                <td style="width:40px;"></td>
                <td style="width:140px;">Delivery No</td>
                <td style="width:140px; text-align: end;">DONLS.2025.06.0051</td>
            </tr>
            <tr>
                <td style="width:140px;"></td>
                <td style="width:140px; text-align: end;"></td>
                <td style="width:40px;"></td>
                <td style="width:140px;">Delivery Date</td>
                <td style="width:140px; text-align: end;">2025/06/25</td>
            </tr>
            <tr>
                <td style="width:140px;">SHIP TO :</td>
                <td style="width:140px; text-align: end;">Astro Bali</td>
                <td style="width:40px;"></td>
                <td style="width:140px;">PO Date</td>
                <td style="width:140px; text-align: end;">2025/06/25</td>
            </tr>
        </table>
    </div>

    <table class="order-list">
        <thead>
            <tr>
                <th>No ITEM</th>
                <th>NAMA ITEM</th>
                <th>QTY</th>
                <th>PACKING</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_qty = 0;
            if (!empty($orders)):
                $no = 1;
                foreach ($orders as $order):
                    $total_qty += $order['jumlah'];
            ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= ($order['nama_produk'] . ' <br/> - ' . $order['nama_varian']) ?></td>
                        <td><?= $order['jumlah'] ?></td>
                        <td><?= $order['nama_satuan'] ?></td>
                        <td><?= $order['keterangan'] ?? '-' ?></td>
                    </tr>
                <?php
                endforeach;
                ?>
                <tr>
                    <td colspan="2" style="text-align:right; font-weight:bold;">Total QTY</td>
                    <td style="font-weight:bold;"><?= $total_qty ?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- <div class="info-perusahaan">
        <table>
            <tr>
                <td style="width:180px;">Catatan</td>
                <td>: <?= $data['catatan'] ?? '-' ?></td>
            </tr>
        </table> -->
    </div>
    <div class="info-perusahaan" style="margin-bottom: 0;">
        <table style="font-weight: 600; width: 100%;">
            <tr>
                <td style="text-align:  start;">Prepared By</td>
                <td style="text-align:  center;">Appoved By</td>
                <td style="text-align:  center;">Received By</td>
                <td style="text-align:  end;">Shipped By</td>
            </tr>
        </table>
    </div>

</body>
<script>
    window.print();
    setInterval(function(){
        window.close()
    }, 500)
</script>

</html>