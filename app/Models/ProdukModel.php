<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id_produk';
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

    public function getProdukWithKategoriAndSubKategori($id_produk)
    {
        return $this->db->table($this->table)
            ->select('produk.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = produk.kategori_id', 'left')
            ->where("produk.id_produk = $id_produk")
            ->get()
            ->getRowArray();
    }

    public function getAllProduk()
    {
        return $this->db->table($this->table)
            ->select('produk.*, produk_gambar.gambar, kategori.nama_kategori, kategori.slug_kategori')
            ->join('produk_gambar', 'produk_gambar.produk_id = produk.id_produk', 'left')
            ->join('kategori', 'kategori.id_kategori = produk.kategori_id', 'left')
            ->groupBy('produk.id_produk')
            ->get()
            ->getResultArray();
    }

    public function getFindProduk($id_produk, $slug_kategori, $slug_produk)
    {
        return $this->db->table($this->table)
            ->select('produk.*, produk_gambar.gambar, kategori.nama_kategori, kategori.slug_kategori')
            ->join('produk_gambar', 'produk_gambar.produk_id = produk.id_produk', 'left')
            ->join('kategori', 'kategori.id_kategori = produk.kategori_id', 'left')
            ->groupBy('produk.id_produk')
            ->where(['produk.id_produk' => $id_produk, 'kategori.slug_kategori' => $slug_kategori, 'produk.slug_produk' => $slug_produk])
            ->get()
            ->getRowArray();
    }

    public function getGambarProduk($id_produk, $slug_kategori, $slug_produk)
    {
        return $this->db->table($this->table)
            ->select('produk.*, produk_gambar.gambar, kategori.nama_kategori, kategori.slug_kategori')
            ->join('produk_gambar', 'produk_gambar.produk_id = produk.id_produk', 'left')
            ->join('kategori', 'kategori.id_kategori = produk.kategori_id', 'left')
            ->where(['produk.id_produk' => $id_produk, 'kategori.slug_kategori' => $slug_kategori, 'produk.slug_produk' => $slug_produk])
            ->get()
            ->getResultArray();
    }

    public function getSpesifikasiProduk(){
        
    }
}
