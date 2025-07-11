<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Database\Migrations\OrdersSales;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\OrdersDetailModel;
use App\Models\OrderSelesModel;
use App\Models\OrderSettModel;
use App\Models\OrdersModel;
use App\Models\ProdukVarianModel;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;

class OrdersController extends BaseController
{
    protected $title = 'Orders Setting';
    protected $nav = 'orders';

    protected $responseJSON;
    protected $ModelOrders;
    protected $ModelDetailOrders;
    protected $ModelOrderSett;
    protected $ModelOrderSeles;
    protected $validator;

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelOrders = new OrdersModel();
        $this->ModelDetailOrders = new OrdersDetailModel();
        $this->ModelOrderSett = new OrderSettModel();
        $this->ModelOrderSeles = new OrderSelesModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('admin/orders/index', $data);
    }

    public function datatables()
    {
        $table = 'orders';
        $primaryKey = 'id_order';
        $columns = ['orders.id_order', 'orders.no_order', 'orders.nama', 'orders.no_handphone', 'orders.email', 'orders.nama_tempat', 'orders.alamat', 'orders.catatan', 'order_sales.nama_sales', 'orders.status', 'orders.created_at'];
        $orderableColumns = ['id_order', 'no_order', 'nama', 'no_handphone', 'email', 'nama_tempat', 'alamat', 'catatan', 'created_at'];
        $searchableColumns = ['no_order', 'orders.nama', 'orders.no_handphone', 'orders.nama_tempat', 'orders.created_at'];
        $defaultOrder = ['id_order', 'DESC'];

        $join = [
            [
                'table' => 'order_sales',
                'on' => 'order_sales.id = orders.sales_id',
                'type' => ''
            ],
        ];

        $where = [
            'orders.status' => $this->request->getPost('status') ?? 0
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join, $where);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join, $where);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_order']),
                htmlspecialchars(date_format(date_create($row['created_at']), "d M Y")),
                htmlspecialchars($row['no_order']),
                htmlspecialchars($row['nama_tempat']),
                htmlspecialchars($row['nama']),
                htmlspecialchars($row['no_handphone']),
                // htmlspecialchars($row['email']),
                // htmlspecialchars($row['alamat']),
                // htmlspecialchars($row['catatan']),
                htmlspecialchars($row['nama_sales']),
                htmlspecialchars($row['status']),
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

    public function detail_order()
    {
        $id_data = $this->request->getPost('id_order');

        $data = $this->ModelOrders->find($id_data);

        $detail = $this->ModelOrders
            ->select('orders_detail.*, produk.nama_produk, produk_varian.nama_varian')
            ->join('orders_detail', 'orders_detail.order_id = orders.id_order', 'left')
            ->join('produk', 'produk.id_produk = orders_detail.produk_id', 'left')
            ->join('produk_varian', 'produk_varian.id_varian = orders_detail.varian_id')
            ->groupBy('produk_varian.id_varian')
            ->where('orders.id_order', $id_data)
            ->findAll();

        $data = [
            'data' => $data,
            'detail' => $detail,
        ];


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

    public function print($id)
    {
        $data = $this->ModelOrders->find($id);

        $detail = $this->ModelOrders
            ->select('orders_detail.*, produk.nama_produk, produk_varian.nama_varian')
            ->join('orders_detail', 'orders_detail.order_id = orders.id_order', 'left')
            ->join('produk', 'produk.id_produk = orders_detail.produk_id', 'left')
            ->join('produk_varian', 'produk_varian.id_varian = orders_detail.varian_id')
            ->groupBy('produk_varian.id_varian')
            ->where('orders.id_order', $id)
            ->findAll();

        $data = [
            'data' => $data,
            'orders' => $detail,
        ];

        return view('admin/orders/print_po', $data);
    }

    public function print_do($id)
    {
        $data = $this->ModelOrders->find($id);

        $detail = $this->ModelOrders
            ->select('orders_detail.*, produk.nama_produk, produk_varian.nama_varian, satuan.nama_satuan')
            ->join('orders_detail', 'orders_detail.order_id = orders.id_order', 'left')
            ->join('produk', 'produk.id_produk = orders_detail.produk_id', 'left')
            ->join('produk_varian', 'produk_varian.id_varian = orders_detail.varian_id')
            ->join('satuan', 'satuan.id_satuan = produk_varian.satuan_id', 'left')
            ->groupBy('produk_varian.id_varian')
            ->where('orders.id_order', $id)
            ->findAll();

        $data = [
            'data' => $data,
            'orders' => $detail,
        ];

        return view('admin/orders/print_do', $data);
    }

    public function acceptOrder($id)
    {
        try {
            $this->ModelOrders->update($id, ['status' => 1]);
            $this->response->setStatusCode(ResponseInterface::HTTP_OK);
            return $this->responseJSON->success([], 'Berhasil terima data', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            $this->response->setStatusCode(ResponseInterface::HTTP_BAD_GATEWAY);
            return $this->responseJSON->success([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }
    public function rejectOrder($id)
    {
        $ModelVarian = new ProdukVarianModel();
        $detailOrder = $this->ModelDetailOrders->where('order_id', $id)->findAll();
        $db = \Config\Database::connect();

        $db->transException(true)->transBegin();
        try {
            $dataUpdate = [];
            foreach ($detailOrder as $row) {

                $dataVarian = $ModelVarian->find($row['varian_id']);

                // update stok
                $stok = $dataVarian['stok_varian'] + $row['jumlah'];

                $dataUpdate[] = [
                    'id_varian' => $row['varian_id'],
                    'stok_varian' => $stok,
                ];
            }

            // update varian
            $ModelVarian->updateBatch($dataUpdate, 'id_varian');

            $this->ModelOrders->update($id, ['status' => 2]);

            $db->transComplete();
            $this->response->setStatusCode(ResponseInterface::HTTP_OK);
            return $this->responseJSON->success([], 'Berhasil tolak data', ResponseInterface::HTTP_OK);
        } catch (DataException $e) {
            
            $db->transRollback();
            $this->response->setStatusCode(ResponseInterface::HTTP_BAD_GATEWAY);
            return $this->responseJSON->success([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    // penerima pesan
    public function setting()
    {
        $data = [
            'title' => $this->title,
            'nav' => 'order_set',
        ];

        // get data setting

        foreach ($this->ModelOrderSett->findAll() as $row) {
            $data[$row['setting']] = $row['data'];
        }

        return view('admin/orders/setting', $data);
    }

    public function update()
    {
        try {
            // validate input
            foreach ($this->request->getPost() as $key => $value) {
                $this->ModelOrderSett->where('setting', $key)->set('data', $value)->update();
            }
            return $this->responseJSON->success(
                [],
                'Data update successfully',
                ResponseInterface::HTTP_OK
            );
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, tangkap exception
            // dan kembalikan response error

            return $this->responseJSON->error(
                [],
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }

    // salessssssss
    private $RulesSales = [
        'nama_sales' => [
            'label' => 'Nama sales',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'no_handphone' => [
            'label' => 'No Handphone',
            'rules' => 'required|min_length[13]|max_length[15]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 13 karakter.',
                'max_length' => '{field} maksimal 15 karakter.'
            ]
        ],
        'kode_sales' => [
            'label' => 'kode sales',
            'rules' => 'required|min_length[6]|max_length[6]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 6 karakter.',
                'max_length' => '{field} maksimal 6 karakter.'
            ]
        ],
    ];

    public function data_sales()
    {
        $table = 'order_sales';
        $primaryKey = 'id';
        $columns = ['id', 'nama_sales', 'no_handphone', 'kode_sales'];
        $orderableColumns = ['id', 'nama_sales', 'no_handphone', 'kode_sales'];
        $searchableColumns = ['nama_sales', 'no_handphone', 'kode_sales'];
        $defaultOrder = ['nama_sales', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_sales']),
                htmlspecialchars($row['no_handphone']),
                htmlspecialchars($row['kode_sales']),
                htmlspecialchars($row['id']),
            ];
        }

        $outputdata = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $countAllData,
            "recordsFiltered" => $No - 1,
            "data" => $rowData,
        ];

        return $this->response->setJSON($outputdata);
    }

    public function save_sales()
    {
        $arratpost = $this->request->getPost(); // menampung data post

        $this->validator->setRules($this->RulesSales); // set rules untuk validasi
        $isValid = $this->validator->run($arratpost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validator->getErrors();
            // Mengembalikan response error dengan status 400
            return $this->responseJSON->error(
                $errors,
                'Validation failed',
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        // Jika validasi berhasil, ambil data yang sudah divalidasi
        try {

            $datavalid = $this->validator->getValidated();

            $this->ModelOrderSeles->save($datavalid); // Simpan data ke database

            return $this->responseJSON->success(
                $datavalid,
                'Data saved successfully',
                ResponseInterface::HTTP_OK
            );
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, tangkap exception
            // dan kembalikan response error

            return $this->responseJSON->error(
                null,
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }

    public function edit_sales($id)
    {
        $data = $this->ModelOrderSeles->find($id);
        if (!$data) {
            return $this->responseJSON->error(
                null,
                'Data not found',
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
        return $this->responseJSON->success(
            $data,
            'Data retrieved successfully',
            ResponseInterface::HTTP_OK
        );
    }

    public function update_sales($id)
    {
        $arratpost = $this->request->getPost(); // menampung data post

        $this->validator->setRules($this->RulesSales); // set rules untuk validasi
        $isValid = $this->validator->run($arratpost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validator->getErrors();
            // Mengembalikan response error dengan status 400
            return $this->responseJSON->error(
                $errors,
                'Validation failed',
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        // Jika validasi berhasil, ambil data yang sudah divalidasi
        try {
            // simpan data
            $datavalid = $this->validator->getValidated();

            $this->ModelOrderSeles->update($id, $datavalid); // Simpan data ke database

            return $this->responseJSON->success(
                $datavalid,
                'Data update successfully',
                ResponseInterface::HTTP_OK
            );
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, tangkap exception
            // dan kembalikan response error

            return $this->responseJSON->error(
                null,
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }

    public function delete_sales($id)
    {
        $data = $this->ModelOrderSeles->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }
        try {
            // Hapus data dari database
            $this->ModelOrderSeles->delete($id);

            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
