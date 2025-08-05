<?php

namespace App\Libraries;

class SideServerDatatables
{
    protected $table;
    protected $primaryKey;

    public function __construct($table, $primaryKey)
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    private function _hendleSearch($builder, $searchableColumns, $searchValue)
    {
        if ($searchValue) {
            $builder->groupStart();
            foreach ($searchableColumns as $column) {
                $builder->orLike($column, $searchValue);
            }
            $builder->groupEnd();
        }
    }

    private function _hendleOrder($builder, $orderableColumns, $defaultOrder)
    {
        if (request()->getPost('order') && (request()->getPost('order')[0]['column'] < count($orderableColumns))) {
            $orderColumn = request()->getPost('order')[0]['column'] ?? 0;
            $orderDirection = request()->getPost('order')[0]['dir'] ?? 'asc';
            $builder->orderBy($orderableColumns[$orderColumn], $orderDirection); // Default order 
        } else {
            $builder->orderBy($defaultOrder[0], $defaultOrder[1]); // Default order 
        }
    }

    private function _hendleJoin($builder, $arrayJoin)
    {
        if ($arrayJoin) {
            foreach ($arrayJoin as $join) {
                $builder->join($join['table'], $join['on'], $join['type'] ?? 'inner');
            }
        }
    }

    private function _hendleWhere($builder, $Where)
    {
        if ($Where) {
            $builder->where($Where);
        }
    }

    private function _hendleGroupBy($builder, $group)
    {
        if ($group) {
            $builder->groupBy($group);
        }
    }

    /**
     * Get data untuk DataTables side server processing.
     *
     * @param array $columns
     * @param array $orderableColumns
     * @param array $searchableColumns
     * @param array $defaultOrder
     * @param array|null $join
     * @param string|null $where
     * 
     * @return array
     */
    public function get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, array $join = [], $where = null, array $groupby = [])
    {
        $db = \Config\Database::connect(); // koneksi ke database

        $builder = $db->table($this->table);
        $builder->select($columns);

        // hendle join
        $this->_hendleJoin($builder, $join);

        // hendle group by
        $this->_hendleGroupBy($builder, $groupby);

        // hendle where
        $this->_hendleWhere($builder, $where);

        // hendle search
        $searchValue = request()->getPost('search')['value'] ?? false;
        $this->_hendleSearch($builder, $searchableColumns, $searchValue);

        // hendle order
        $this->_hendleOrder($builder, $orderableColumns, $defaultOrder);

        // sett limit
        // $builder->limit(25);
        // $builder->offset(0);
        // $builder->limit(10, 0);
        $builder->limit(request()->getPost('length'), request()->getPost('start') ?? 0);

        // output
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getCountFilter($columns, $searchableColumns, array $join = [], $where = null)
    {
        $db = \Config\Database::connect(); // koneksi ke database

        $builder = $db->table($this->table);
        $builder->select($columns);

        // hendle join
        $this->_hendleJoin($builder, $join);

        // hendle where
        $this->_hendleWhere($builder, $where);

        // hendle search
        $searchValue = request()->getPost('search')['value'] ?? false;
        $this->_hendleSearch($builder, $searchableColumns, $searchValue);

        // output
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function countAllData()
    {
        $db = \Config\Database::connect(); // koneksi ke database
        $builder = $db->table($this->table);
        return $builder->countAllResults();
    }
}
