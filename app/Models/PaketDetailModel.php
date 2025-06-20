<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketDetailModel extends Model
{
    protected $table            = 'produk_paket_detail ppd';
    protected $primaryKey       = 'id_paket_detail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function joinAllData($id_paket)
    {
        return $this->db->table($this->table)
            ->select('ppd.id_paket_detail, p.nama_produk, pv.nama_varian, pv.harga_varian, pv.stok_varian')
            ->join('produk p ', 'p.id_produk = ppd.produk_id')
            ->join('produk_varian pv', 'pv.id_varian = ppd.varian_id')
            ->where('ppd.paket_id', $id_paket)
            ->get()
            ->getResultArray();
    }
}
