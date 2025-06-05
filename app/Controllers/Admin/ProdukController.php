<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\KategoriModel;
use App\Models\ProdukGambarModel;
use App\Models\ProdukModel;
use App\Models\ProdukSpesifikasiModel;
use App\Models\ProdukVarianModel;
use App\Models\SpesifikasiModel;
use App\Models\SubKategoriModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProdukController extends BaseController
{
    protected $validator;

    protected $title = 'Produk';
    protected $nav = 'produk';

    protected $ProdukModel;
    protected $KategoriModel;
    protected $SubKategoriModel;
    protected $SpesifikasiModel;

    protected $setRules = [
        // data produk
        'nama_produk' => [
            'label' => 'Nama Produk',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'deskripsi_produk' => [
            'label' => 'Deskripsi Produk',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus dipilih.',
            ]
        ],
        'harga_produk' => [
            'label' => 'Deskripsi Produk',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus dipilih.',
                'numeric' => '{field} harus berupa angka.'
            ]
        ],
        'stok_produk' => [
            'label' => 'Deskripsi Produk',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus dipilih.',
                'numeric' => '{field} harus berupa angka.'
            ]
        ],

        // referensi

        'kategori_id' => [
            'label' => 'Kategori',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus dipilih.',
                'numeric' => '{field} harus berupa angka.'
            ]
        ],
        'sub_kategori_id' => [
            'label' => 'Sub Kategori',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus dipilih.',
                'numeric' => '{field} harus berupa angka.'
            ]
        ],

        // spesifikasi
        'spesifikasi.*' => [
            'label' => 'Spesifikasi ',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} tidak boleh kosong.',
            ]
        ],

    ];

    public function __construct()
    {
        $this->validator = \Config\Services::validation();
        $this->responseJSON = new ResponseJSONCollection();
        $this->ProdukModel =  new ProdukModel();
        $this->KategoriModel =  new KategoriModel();
        $this->SubKategoriModel =  new SubKategoriModel();
        $this->SpesifikasiModel =  new SpesifikasiModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('admin/produk/index', $data);
    }

     public function datatables()
    {   
        $table = 'produk';
        $primaryKey = 'id_produk';
        $columns = ['id_produk', 'nama_produk', 'deskripsi_produk', 'slug_produk'];
        $orderableColumns = ['id_produk', 'nama_produk', 'deskripsi_produk', 'slug_produk'];
        $searchableColumns = ['nama_produk', 'slug_produk'];
        $defaultOrder = ['nama_produk', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_produk']),
                htmlspecialchars($row['slug_produk']),
                htmlspecialchars($row['id_produk']),
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
        ];

        $data['kategori'] = $this->KategoriModel->findAll();

        return view('admin/produk/add', $data);
    }

    public function fecthSubKategori($id_kategori = null)
    {
        $responsJSON = new ResponseJSONCollection();
        $id_kategori = $this->request->getPost('kategori_id') ?? $id_kategori;
        try {
            $sub_kategori = $this->SubKategoriModel->where('kategori_id', $id_kategori)->findAll();
            // var_dump($sub_kategori);
            return $responsJSON->success($sub_kategori, 'Data sub kategori berhasil.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            return $responsJSON->error(null, $th->getMessage(), ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fecthSpesifiksai($id_kategori = null)
    {
        $responsJSON = new ResponseJSONCollection();
        $id_kategori = $this->request->getPost('kategori_id') ?? $id_kategori;
        try {
            $spesifikasi = $this->SpesifikasiModel->where('kategori_id', $id_kategori)->findAll();
            // var_dump($spesifikasi);
            return $responsJSON->success($spesifikasi, 'Data Spesifikasi berhasil.', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            return $responsJSON->error(null, $th->getMessage(), ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function save()
    {
        $db = \Config\Database::connect();
        // dd($this->request->getPost());
        $arrayPost = $this->request->getPost();

        $this->validator->setRules($this->setRules); // set rules untuk validasi
        $isValid = $this->validator->run($arrayPost); // menjalankan validasi

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

        $ModelProdukSpesifikasi = new ProdukSpesifikasiModel();
        $ModelProdukGambar = new ProdukGambarModel();
        $ModelProdukVarian = new ProdukVarianModel();

        $gambar = $arrayPost['filepond'];
        $spesifikasi = $arrayPost['spesifikasi'];
        $varian = $arrayPost['nama_varian'];

        $produk_id = '';
        $dataInput = [
            'nama_produk' => $arrayPost['nama_produk'],
            'deskripsi_produk' => $arrayPost['deskripsi_produk'],
            'harga_produk' => $arrayPost['harga_produk'],
            'stok_produk' => $arrayPost['stok_produk'],
            'kategori_id' => $arrayPost['kategori_id'],
            'sub_kategori_id' => $arrayPost['sub_kategori_id'],
            'slug_produk' => url_title($arrayPost['nama_produk'],'-', true),
            'status' => 1
        ];

        try {
            $db->transBegin();
            // input produk
            $produk_id = $this->ProdukModel->insert($dataInput, true);
            
            // input gambar
            $gambarProduk = [];
            foreach ($gambar as $item) {
                $gambarProduk[] = [
                    'gambar' => $item,
                    'produk_id' => $produk_id
                ];
            }
            $ModelProdukGambar->insertBatch($gambarProduk);

            // input spesifikasi
            $spesifikasiProduk = [];
            foreach ($spesifikasi as $key => $value) {
                $spesifikasiProduk[] = [
                    'spesifikasi_id' => $key,
                    'value' => $value,
                    'produk_id' => $produk_id
                ];
            }
            $ModelProdukSpesifikasi->insertBatch($spesifikasiProduk);
            
            // input varian
            $varianProduk = [];
            for ($i = 0; $i < count($varian); $i++) {
                $varianProduk[] = [
                    'nama_varian_produk' => $arrayPost['nama_varian'][$i],
                    'harga_varian_produk' => $arrayPost['harga_varian'][$i],
                    'stok_varian_produk' => $arrayPost['stok_varian'][$i],
                    'status' => 1,
                    'produk_id' => $produk_id
                ];
            }
            $ModelProdukVarian->insertBatch($varianProduk);
            $db->transCommit();
            return $this->responseJSON->success(
                '',
                'Success',
                ResponseInterface::HTTP_OK
            );
        } catch (\Exception $e){
            $db->transRollback();
            return $this->responseJSON->error(
                '',
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
        // dd($gambarProduk, $spesifikasiProduk, $varianProduk);
    }
}
