<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukSpesifikasiModel extends Model
{
    protected $table            = 'produk_spesifikasi';
    protected $primaryKey       = 'id';
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

    public function getProdukSpesifikasi(int $id_produk){
        $builder = $this->db->table($this->table);
        $builder->select("produk_spesifikasi.id, spesifikasi.id_spesifikasi, spesifikasi.nama_spesifikasi, produk_spesifikasi.value, produk_spesifikasi.produk_id");
        $builder->join("spesifikasi","spesifikasi.id_spesifikasi = produk_spesifikasi.spesifikasi_id","left");
        $builder->where("produk_spesifikasi.produk_id = $id_produk");
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function deleteData($id_produk){
        $builder = $this->db->table($this->table);
        return $builder->delete(['produk_id' => $id_produk]);        
    }
}
