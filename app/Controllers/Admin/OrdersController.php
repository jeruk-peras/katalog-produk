<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\OrdersModel;
use CodeIgniter\HTTP\ResponseInterface;

class OrdersController extends BaseController
{
    protected $title = 'Orders';
    protected $nav = 'orders';

    protected $responseJSON;
    protected $ModelOrders;
    protected $validator;

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelOrders = new OrdersModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('Admin/orders/index', $data);
    }

    public function datatables()
    {
        $table = 'orders';
        $primaryKey = 'id_order';
        $columns = ['id_order', 'no_order', 'nama', 'no_handphone', 'email', 'nama_tempat', 'alamat', 'catatan', 'created_at'];
        $orderableColumns = ['id_order', 'no_order', 'nama', 'no_handphone', 'email', 'nama_tempat', 'alamat', 'catatan', 'created_at'];
        $searchableColumns = ['no_order', 'nama', 'no_handphone', 'nama_tempat', 'created_at'];
        $defaultOrder = ['id_order', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_order']),
                htmlspecialchars(date_format(date_create($row['created_at']), "d M Y")),
                htmlspecialchars($row['no_order']),
                htmlspecialchars($row['nama']),
                htmlspecialchars($row['no_handphone']),
                htmlspecialchars($row['email']),
                htmlspecialchars($row['nama_tempat']),
                htmlspecialchars($row['alamat']),
                htmlspecialchars($row['catatan']),
            ];
        }

        $outputdata = [
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $countData,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function detail_order(){
        $id_data = $this->request->getPost('id_order');

        $data = $this->ModelOrders
        ->select('orders_detail.*, produk.nama_produk')
        ->join('orders_detail', 'orders_detail.order_id = orders.id_order', 'left')
        ->join('produk', 'produk.id_produk = orders_detail.produk_id', 'left')
        ->where('orders.id_order', $id_data)
        ->findAll();

        return $this->responseJSON->success($data, 'Berhasil mengambil data detail', ResponseInterface::HTTP_OK);
    }

    public function delete($id)
    {
        $data = $this->ModelOrders->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }
        
        try {
            // Hapus data dari database
            $this->ModelOrders->delete($id);
            
            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
