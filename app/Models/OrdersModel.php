<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id_order';
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

    function generateNoOrder()
    {
        $prefix = 'NLS';
        $tahun = date('Y');
        $bulan = date('m');

        // Ambil nomor urut terakhir bulan ini dari database
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->selectMax('no_order');
        $builder->where('YEAR(created_at)', $tahun);
        $builder->where('MONTH(created_at)', $bulan);
        $last = $builder->get()->getRow();

        $noUrut = ($last && $last->no_order) ? (substr($last->no_order, 12, 4) + 1) : 1;

        // Simpan no_order ke tabel orders saat insert order baru
        $noUrutStr = str_pad($noUrut, 4, '0', STR_PAD_LEFT);

        return "{$prefix}.{$tahun}.{$bulan}.{$noUrutStr}";
    }
}
