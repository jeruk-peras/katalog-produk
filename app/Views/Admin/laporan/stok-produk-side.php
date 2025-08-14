<table class="table align-middle mb-0" id="datatable" style="width: 100%;">
    <thead class="table-light align-middle">
        <tr>
            <th rowspan="2" >No</th>
            <th rowspan="2" >Kategori</th>
            <th rowspan="2" >Produk</th>
            <th rowspan="2" >Stok</th>
            <th colspan="2" class="text-center">Harga</th>
            <th colspan="2" class="text-center">Total</th>
        </tr>
        <tr>
            <th class="text-center">Beli</th>
            <th class="text-center">Jual</th>
            <th class="text-center">Beli</th>
            <th class="text-center">Jual</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; $total_beli = 0; $total_varian = 0;
        foreach ($data as $row): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['nama_kategori']; ?></td>
                <td><?= $row['nama_produk']; ?> #<b><?= $row['nama_varian']; ?></b></td>
                <td><?= $row['stok_varian']; ?></td>
                <td>Rp<?= number_format($row['harga_beli'], 0, '', '.'); ?></td>
                <td>Rp<?= number_format($row['harga_varian'], 0, '', '.'); ?></td>
                <td>Rp<?= number_format($row['harga_beli'] * $row['stok_varian'], 0, '', '.'); ?></td>
                <td>Rp<?= number_format($row['harga_varian'] * $row['stok_varian'], 0, '', '.'); ?></td>
            </tr>
        <?php 
            $total_beli += ($row['harga_beli'] * $row['stok_varian']); 
            $total_varian += ($row['harga_varian'] * $row['stok_varian']); 
        ?>
        <?php endforeach;  ?>
        <tr>
            <th colspan="6" class="text-end">Total</th>
            <th>Rp<?= number_format($total_beli, 0, '', '.'); ?></th>
            <th>Rp<?= number_format($total_varian, 0, '', '.'); ?></th>
        </tr>
    </tbody>
</table>