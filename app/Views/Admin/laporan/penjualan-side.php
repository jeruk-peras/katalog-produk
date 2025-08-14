<table class="table align-middle mb-0" id="datatable" style="width: 100%;">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>No Order</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>QTY</th>
            <th>Total</th>
            <th>Sales</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($data as $row): $harga = !empty($row['harga_diskon']) ? $row['harga_diskon'] : $row['harga']; ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['created_at']; ?></td>
                <td><?= $row['no_order']; ?></td>
                <td><?= $row['nama_produk']; ?> #<b><?= $row['nama_varian']; ?></b></td>
                <td>Rp<?= number_format($harga, 0, '', '.'); ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td>Rp<?= number_format(($harga * $row['jumlah']), 0, '', '.'); ?></td>
                <td><?= $row['nama_sales']; ?></td>
            </tr>
        <?php endforeach;  ?>
    </tbody>
</table>