<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukVarianModel extends Model
{
    protected $table            = 'produk_varian';
    protected $primaryKey       = 'id_varian';
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
    protected $useTimestamps = true;
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

    public function deleteData($id_produk){
        $builder = $this->db->table($this->table);
        return $builder->delete(['produk_id' => $id_produk]);        
    }

    public function getAllData($id_produk){
        return $this->db->table($this->table)
            ->select('produk_varian.*, satuan.nama_satuan')
            ->join('satuan', 'satuan.id_satuan = produk_varian.satuan_id', 'LEFT')
            ->where('produk_varian.produk_id', $id_produk)
            ->get()
            ->getResultArray();
    }
}
