<?php foreach ($data as $r): ?>
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" name="nama_varian[<?= $r['id_varian']; ?>]" class="form-control" value="<?= $r['nama_varian']; ?>">
        </div>
        <div class="col-md-2" id="satuan-select">
            <select name="satuan_id[<?= $r['id_varian']; ?>]" class="form-select" id="">
                <?php foreach ($satuan as $s):  ?>
                    <option value="<?= $s['id_satuan']; ?>" <?= $s['id_satuan'] == $r['satuan_id'] ? 'selected' : ''; ?>><?= $s['nama_satuan']; ?></option>
                <?php endforeach;  ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="harga_beli[<?= $r['id_varian']; ?>]" class="form-control" value="<?= $r['harga_beli']; ?>">
        </div>
        <div class="col-md-2">
            <input type="text" name="harga_varian[<?= $r['id_varian']; ?>]" class="form-control" value="<?= $r['harga_varian']; ?>">
        </div>
        <div class="col-md-2">
            <input type="text" name="stok_varian[<?= $r['id_varian']; ?>]" class="form-control" value="<?= $r['stok_varian']; ?>">
        </div>
    </div>
<?php endforeach; ?>