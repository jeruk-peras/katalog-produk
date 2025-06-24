<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\ProdukModel;
use App\Models\PromoDetailModel;
use App\Models\PromoProdukMOdel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukPromoController extends BaseController
{
    private $title = 'Promo Produk';
    private $nav = 'promo';

    private $ModelPromo;
    private $ModelPromoDetail;
    private $RESPONSEJSON;

    private $validation;
    private $setRules = [
        'nama_promo' => [
            'label' => 'Nama promo',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ]
    ];

    public function __construct()
    {
        $this->ModelPromo = new PromoProdukMOdel();
        $this->ModelPromoDetail = new PromoDetailModel();
        $this->RESPONSEJSON = new ResponseJSONCollection();

        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('admin/promo/index', $data);
    }

    public function datatables()
    {
        $table = 'produk_promo';
        $primaryKey = 'id_promo';
        $columns = ['id_promo', 'nama_promo', 'created_at', 'status'];
        $orderableColumns = ['id_promo', 'nama_promo', 'created_at', 'status'];
        $searchableColumns = ['nama_promo', 'created_at', 'status'];
        $defaultOrder = ['nama_promo', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables(
            $columns,
            $orderableColumns,
            $searchableColumns,
            $defaultOrder
        );

        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_promo']),
                htmlspecialchars(date_format(date_create($row['created_at']), "d M Y")),
                htmlspecialchars($row['status']),
                htmlspecialchars($row['id_promo']),
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

    public function fecthProduk()
    {
        $table = 'produk';
        $primaryKey = 'id_produk';
        $columns = ['produk.id_produk', 'kategori.nama_kategori', 'produk.nama_produk'];
        $orderableColumns = ['id_produk', 'nama_produk', 'deskripsi_produk', 'slug_produk'];
        $searchableColumns = ['nama_produk', 'slug_produk'];
        $defaultOrder = ['nama_produk', 'DESC'];

        $join = [
            [
                'table' => 'kategori',
                'on' => 'kategori.id_kategori = produk.kategori_id',
                'type' => ''
            ],
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_kategori']),
                htmlspecialchars($row['nama_produk']),
                htmlspecialchars($row['id_produk']),
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

    public function add()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
            'data' => false,
            'item' => false
        ];
        return view('admin/promo/add', $data);
    }

    public function save()
    {
        $arrayPost = $this->request->getPost();

        $this->validation->setRules($this->setRules); // set rules untuk validasi
        $isValid = $this->validation->run($arrayPost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validation->getErrors();
            // Mengembalikan response error dengan status 400
            return redirect()->back()->withInput()->with('message', [400, 'validasi gagal']);
        }

        try {
            $datavalid =  $this->validation->getValidated();
            $idpromo = $this->ModelPromo->insert($datavalid);

            return redirect()->to('admin/produk/promo/item/' . $idpromo)->with('message', [ResponseInterface::HTTP_OK, 'Promo berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function update($id_promo)
    {
        $arrayPost = $this->request->getPost();

        $this->validation->setRules($this->setRules); // set rules untuk validasi
        $isValid = $this->validation->run($arrayPost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validation->getErrors();
            // Mengembalikan response error dengan status 400
            return redirect()->back()->withInput()->with('message', [400, 'validasi gagal']);
        }

        try {
            $datavalid =  $this->validation->getValidated();
            $idpromo = $this->ModelPromo->update($id_promo, $datavalid);

            return redirect()->to('admin/produk/promo/item/' . $id_promo)->with('message', [ResponseInterface::HTTP_OK, 'Promo berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function item($id_promo)
    {
        $datapromo = $this->ModelPromo->find($id_promo);

        $dataproduk = $this->ModelPromoDetail
            ->select('produk.nama_produk, produk.id_produk')
            ->join('produk', 'produk.id_produk = produk_promo_detail.produk_id')
            ->where('produk_promo_detail.promo_id', $id_promo)
            ->groupBy('produk_promo_detail.produk_id')
            ->find();
        $dataitem = $this->ModelPromoDetail
            ->join('produk_varian', 'produk_varian.id_varian = produk_promo_detail.varian_id', 'left')
            ->where('produk_promo_detail.promo_id', $id_promo)
            ->findAll();

        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
            'item' => $dataitem,
            'data' => $datapromo,
            'dataproduk' => $dataproduk
        ];
        return view('admin/promo/add', $data);
    }

    public function add_item($id_promo, $id_produk)
    {
        $ModelProduk = new ProdukModel();
        $dataproduk = $ModelProduk->getAllProdukVarian($id_produk);
        $data = [];
        foreach ($dataproduk as $row) {

            $data[] = [
                'promo_id' => $id_promo,
                'produk_id' => $row['id_produk'],
                'varian_id' => $row['id_varian'],
                'harga_awal' => $row['harga_varian'],
                'harga_diskon' => $row['harga_varian'],
                'status' => 0,
            ];
        }
        try {
            $this->ModelPromoDetail->insertBatch($data);
            return $this->RESPONSEJSON->success([], 'Berhasil ditambahkan', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->RESPONSEJSON->success([], 'Berhasil ditambahkan', ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function promosave()
    {

        $data = $this->request->getPost();
        $i = $data['id'];
        // dd($data);

        try {
            $arrayData = [];
            foreach ($i as $key => $value) {
                $arrayData[] = [
                    'id' => (int)$data['id'][$key],
                    'harga_diskon' => $data['harga_diskon'][$key],
                    'status' => (isset($data['status'][$key]) ? 1 : 0)
                ];
            }
            // var_dump($arrayData);
            $update = $this->ModelPromoDetail->updateBatch($arrayData, 'id');
            // dd();
            return redirect()->to('admin/produk/promo')->with('message', [ResponseInterface::HTTP_OK, 'Promo berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()->to('admin/produk/promo')->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function detail_promo()
    {
        $id_promo = $this->request->getPost('id');
        $dataitem = $this->ModelPromoDetail
            ->select('produk.id_produk, produk.nama_produk, produk_varian.nama_varian, produk_promo_detail.harga_awal, produk_promo_detail.harga_diskon')
            ->join('produk', 'produk.id_produk = produk_promo_detail.produk_id')
            ->join('produk_varian', 'produk_varian.id_varian = produk_promo_detail.varian_id', 'left')
            ->where('produk_promo_detail.promo_id', $id_promo)
            ->findAll();
        $data = [
            'item' => $dataitem,
            // 'data' => $datapromo,
        ];
        return $this->RESPONSEJSON->success($data, 'Berhasil Mengambil data', ResponseInterface::HTTP_OK);
    }

    public function delete_item($id, $id_promo){
        $data = $this->ModelPromoDetail->where('produk_id', $id)->findAll();
        if (!$data) {
            return throw PageNotFoundException::forPageNotFound();
        }

        try {
            // Hapus data dari database
            $this->ModelPromoDetail->where('produk_id', $id)->delete();

            // Kembalikan response sukses
            return redirect()->to('admin/produk/promo/item/' . $id_promo)->with('message', [ResponseInterface::HTTP_OK, 'Item Berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->to('admin/produk/promo/item/' . $id_promo)->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $data = $this->ModelPromo->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelPromo->delete($id);

            // Kembalikan response sukses
            return $this->RESPONSEJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->RESPONSEJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function changeStatus($id)
    {
        $status = $this->request->getPost('status');
        $promo = $this->ModelPromo->find($id);

        if (!$promo) {
            return $this->RESPONSEJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            $this->ModelPromo->update($id, ['status' => $status]);
            return $this->RESPONSEJSON->success(null, 'Status updated successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->RESPONSEJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
