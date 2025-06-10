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
use CodeIgniter\HTTP\ResponseInterface;

class ProdukController extends BaseController
{
    protected $validator;

    protected $title = 'Produk';
    protected $nav = 'produk';

    protected $ProdukModel;
    protected $KategoriModel;
    protected $SpesifikasiModel;

    protected $VarianModel;
    protected $PSpesifikasiModel;
    protected $GambarModel;

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
        $this->SpesifikasiModel =  new SpesifikasiModel();

        $this->VarianModel =  new ProdukVarianModel();
        $this->PSpesifikasiModel =  new ProdukSpesifikasiModel();
        $this->GambarModel =  new ProdukGambarModel();
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
        $columns = ['produk.id_produk', 'kategori.nama_kategori', 'produk.nama_produk', 'produk.slug_produk'];
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
            'slug_produk' => url_title($arrayPost['nama_produk'], '-', true),
            'status' => 1
        ];

        try {
            $db->transBegin();
            // input produk
            $produk_id = $this->ProdukModel->insert($dataInput, true);

            // input gambar
            $gambarProduk = [];
            foreach ($gambar as $item) {
                $gambarProduk = [
                    'gambar' => $item,
                    'produk_id' => $produk_id
                ];
                // var_dump($gambarProduk);
                $ModelProdukGambar->insert($gambarProduk);
            }
            // dd();

            // input spesifikasi
            $spesifikasiProduk = [];
            foreach ($spesifikasi as $key => $value) {
                $spesifikasiProduk = [
                    'spesifikasi_id' => $key,
                    'value' => $value,
                    'produk_id' => $produk_id
                ];
                // var_dump($spesifikasiProduk);
                $ModelProdukSpesifikasi->insert($spesifikasiProduk);
            }
            // dd();

            // input varian
            $varianProduk = [];
            for ($i = 0; $i < count($varian); $i++) {
                $varianProduk = [
                    'nama_varian_produk' => $arrayPost['nama_varian'][$i],
                    'harga_varian_produk' => $arrayPost['harga_varian'][$i],
                    'stok_varian_produk' => $arrayPost['stok_varian'][$i],
                    'status' => 1,
                    'produk_id' => $produk_id
                ];
                // var_dump($varianProduk);
                $ModelProdukVarian->insert($varianProduk);
            }
            // dd();

            // dd($gambarProduk, $spesifikasiProduk, $varianProduk);
            $db->transCommit();
            return $this->responseJSON->success(
                '',
                'Success',
                ResponseInterface::HTTP_OK
            );
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->responseJSON->error(
                '',
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }

    public function detail_produk()
    {
        $id_produk = $this->request->getPost('id_produk') ?? 4;
        $responseJSON = new ResponseJSONCollection();

        $dataDeskripsi = $this->ProdukModel->find($id_produk)['deskripsi_produk'];
        $dataGambar = $this->GambarModel->where("produk_id = $id_produk")->findAll();
        $dataSpesifikasi = $this->PSpesifikasiModel->getProdukSpesifikasi($id_produk);
        $dataVarian = $this->VarianModel->where("produk_id = $id_produk")->findAll();

        $data = [
            'deskripsi' => $dataDeskripsi,
            'gambar' => $dataGambar,
            'spesifikasi' => $dataSpesifikasi,
            'varian' => $dataVarian,
        ];

        return $responseJSON->success(
            $data,
            'Berhasil mengambil data detail',
            ResponseInterface::HTTP_OK
        );

        // var_dump($dataGambar, $dataSpesifikasi, $dataVarian);
        // dd();
    }

    public function edit($id_produk)
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
            'id_produk' => $id_produk
        ];

        $dataEdit = $this->ProdukModel->getProdukWithKategoriAndSubKategori($id_produk);
        $dataGambar = $this->GambarModel->where("produk_id = $id_produk")->findAll();
        $dataSpesifikasi = $this->PSpesifikasiModel->getProdukSpesifikasi($id_produk);
        $dataVarian = $this->VarianModel->where("produk_id = $id_produk")->findAll();

        $data['arraydata'] = $dataEdit;
        $data['gambar'] = $dataGambar;
        $data['spesifikasi'] = $dataSpesifikasi;
        $data['varian'] = $dataVarian;

        $data['kategori'] = $this->KategoriModel->findAll();

        return view('admin/produk/edit', $data);
    }

    public function update($id_produk)
    {
        $db = \Config\Database::connect();
        // dd($this->request->getPost());
        $arrayPost = $this->request->getPost();
        // dd($arrayPost); 

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
            'slug_produk' => url_title($arrayPost['nama_produk'], '-', true),
            'status' => 1
        ];

        try {
            $db->transBegin();

            // remove data detiil
            $this->__deleteImage($id_produk);
            $ModelProdukSpesifikasi->deleteData($id_produk);
            $ModelProdukVarian->deleteData($id_produk);

            // input produk
            $produk_id = $id_produk;
            $this->ProdukModel->update($id_produk, $dataInput);

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
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->responseJSON->error(
                '',
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }

    public function delete($id_produk = null)
    {

        try {
            $id_produk = $this->request->getPost('id_produk');
            $this->__deleteImage($id_produk);
            $this->ProdukModel->delete($id_produk);
            return $this->responseJSON->success(
                '',
                'Berhasil menghapus data',
                ResponseInterface::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseJSON->error(
                '',
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }

    private function __deleteImage($id_produk)
    {
        $ModelProdukGambar = new ProdukGambarModel();
        define('EXT', '.' . pathinfo(__FILE__, PATHINFO_EXTENSION));
        // define('FCPATH', __FILE__);
        define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
        define('PUBPATH', str_replace(SELF, '', FCPATH)); // added

        $Images = $ModelProdukGambar->where(['produk_id' => $id_produk])->findAll();

        foreach ($Images as $row) {
            // hapus image 
            $filestring = PUBPATH . 'assets/images/produk/' . $row['gambar'];
            unlink($filestring);
        }

        return $ModelProdukGambar->deleteData($id_produk);
    }
}
