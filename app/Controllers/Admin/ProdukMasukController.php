<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\ProdukMasukDetailModel;
use App\Models\ProdukMasukModel;
use App\Models\ProdukModel;
use App\Models\ProdukVarianModel;
use App\Models\SuplierModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ProdukMasukController extends BaseController
{
    protected $validation;
    protected $responseJSON;

    protected $title = 'Produk Masuk';
    protected $nav = 'masuk';

    protected $ModelProdukMasuk;
    protected $ModelMasukDetail;
    protected $ModelSuplier;

    protected $db;

    protected $setRules = [
        'tanggal_masuk' => [
            'rules' => 'required|valid_date',
            'errors' => [
                'required' => '{field} harus diisi.',
                'valid_date' => 'Masukan tanggal yang valid.',
            ]
        ],
        'suplier_id' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus diisi.',
                'numeric' => '{field} harus angka.',
            ]
        ],
        'no_delivery' => [
            'rules' => 'required|min_length[3]|max_length[50]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 50 karakter.'
            ]
        ],
        'total_harga' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus diisi.',
                'numeric' => '{field} harus angka.',
            ]
        ],
        'keterangan' => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi.',
            ]
        ],
    ];

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelProdukMasuk = new ProdukMasukModel();
        $this->ModelMasukDetail = new ProdukMasukDetailModel();
        $this->ModelSuplier = new SuplierModel();

        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];

        return view('admin/produk_masuk/index', $data);
    }

    public function datatables()
    {
        $table = 'produk_masuk';
        $primaryKey = 'id_masuk';
        $columns = ['produk_masuk.id_masuk', 'produk_masuk.tanggal_masuk', 'suplier.nama_suplier', 'produk_masuk.no_delivery', 'produk_masuk.total_harga', 'produk_masuk.keterangan', 'produk_masuk.status'];
        $orderableColumns = ['tanggal_masuk', 'suplier_id', 'no_delivery', 'total_harga', 'keterangan'];
        $searchableColumns = ['tanggal_masuk', 'suplier_id', 'no_delivery', 'total_harga', 'keterangan'];
        $defaultOrder = ['tanggal_masuk', 'DESC'];

        $join = [
            [
                'table' => 'suplier',
                'on' => 'suplier.id_suplier = produk_masuk.suplier_id',
                'type' => 'LEFT'
            ],
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join);
        $countAllData = $sideDatatable->countAllData();

        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['id_masuk']),
                htmlspecialchars($row['tanggal_masuk']),
                htmlspecialchars($row['nama_suplier']),
                htmlspecialchars($row['no_delivery']),
                htmlspecialchars($row['total_harga']),
                htmlspecialchars($row['keterangan']),
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

    public function add()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
            'data' => false,
            'item' => false
        ];

        $data['suplier'] = $this->ModelSuplier->findAll();

        return view('admin/produk_masuk/form', $data);
    }

    public function insertheader()
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
            $id = $this->ModelProdukMasuk->insert($datavalid);

            return redirect()->to('admin/produk-masuk/detail/' . $id)->with('message', [ResponseInterface::HTTP_OK, 'Berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function updateheader($id)
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
            $id = $this->ModelProdukMasuk->update($id, $datavalid);

            return redirect()->to('admin/produk-masuk/detail/' . $id)->with('message', [ResponseInterface::HTTP_OK, 'Berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function detail($id)
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
            'item' => true
        ];

        // cek data
        if($this->ModelProdukMasuk->where(['status' => 1, 'id_masuk' => $id])->countAllResults()){
            return redirect()->to('admin/produk-masuk')->with('message', [500, 'Data sudah diupdate.']);
        }

        $data['data'] = $this->ModelProdukMasuk->find($id);
        $data['suplier'] = $this->ModelSuplier->findAll();

        return view('admin/produk_masuk/form', $data);
    }

    public function fecthProduk()
    {
        $table = 'produk';
        $primaryKey = 'id_produk';
        $columns = ['produk.id_produk', 'kategori.nama_kategori', 'produk.nama_produk', 'produk_varian.id_varian', 'produk_varian.nama_varian', 'produk_varian.harga_varian', 'produk_varian.stok_varian', 'produk_gambar.gambar'];
        $orderableColumns = ['id_produk', 'nama_produk', 'deskripsi_produk', 'slug_produk'];
        $searchableColumns = ['nama_produk', 'slug_produk'];
        $defaultOrder = ['nama_produk', 'DESC'];

        $join = [
            [
                'table' => 'kategori',
                'on' => 'kategori.id_kategori = produk.kategori_id',
                'type' => ''
            ],
            [
                'table' => 'produk_gambar',
                'on' => 'produk_gambar.produk_id = produk.id_produk',
                'type' => ''
            ],
            [
                'table' => 'produk_varian',
                'on' => 'produk_varian.produk_id = produk.id_produk',
                'type' => ''
            ],
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join);
        $countData = $sideDatatable->getCountFilter($columns, $searchableColumns, $join);
        $countAllData = $sideDatatable->countAllData();


        // var_dump($data);die;
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['gambar']),
                htmlspecialchars($row['nama_kategori']),
                htmlspecialchars($row['nama_produk']),
                htmlspecialchars($row['nama_varian']),
                htmlspecialchars(number_format($row['harga_varian'])),
                htmlspecialchars($row['stok_varian']),
                htmlspecialchars($row['id_varian']),
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

    public function additem(int $id_masuk, int $id_varian)
    {
        try {
            $ModelVarian = new ProdukVarianModel();
            $rowvarian = $ModelVarian->find($id_varian);

            // cek data
            if ($this->ModelMasukDetail->where('varian_id', $id_varian)->countAllResults()) {
                $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
                return $this->responseJSON->error([], 'Produk sudah dipilih', ResponseInterface::HTTP_BAD_REQUEST);
            }

            $data = [
                'masuk_id' => $id_masuk,
                'produk_id' => $rowvarian['produk_id'],
                'varian_id' => $rowvarian['id_varian'],
                'harga' => $rowvarian['harga_varian'],
            ];

            $this->ModelMasukDetail->save($data);
            return $this->responseJSON->success([]);
        } catch (\Exception $e) {
            $this->response->setStatusCode(ResponseInterface::HTTP_BAD_GATEWAY);
            return $this->responseJSON->success([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function delitem(int $id_varian)
    {
        try {
            $this->ModelMasukDetail->delete($id_varian);
            return $this->responseJSON->success([]);
        } catch (\Exception $e) {
            $this->response->setStatusCode(ResponseInterface::HTTP_BAD_GATEWAY);
            return $this->responseJSON->success([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function detail_item($id)
    {
        try {
            $data = $this->ModelMasukDetail
                ->select('produk_masuk_detail.id_masuk_detail, produk_masuk_detail.masuk_id, produk_masuk_detail.status, produk.id_produk, produk.nama_produk, produk_varian.id_varian ,produk_varian.nama_varian, produk_varian.stok_varian, produk_masuk_detail.harga, produk_masuk_detail.stok')
                ->join('produk', 'produk.id_produk = produk_masuk_detail.produk_id')
                ->join('produk_varian', 'produk_varian.id_varian = produk_masuk_detail.varian_id', 'left')
                ->where('produk_masuk_detail.masuk_id', $id)
                ->findAll();

            if (empty($data)) {
                $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
                return $this->responseJSON->success($data, 'Error', ResponseInterface::HTTP_BAD_REQUEST);
            }

            $html = "";
            $i = 1;
            foreach ($data as $row) {

                $html .=
                    '<tr>
                    <input type="hidden" name="id_masuk_detail[]" value="' . $row['id_masuk_detail'] . '">
                    <td>' . $i++ . '</td>
                    <td>' . $row['nama_produk'] . '<br>*' . $row['nama_varian'] . '</td>
                    <td>' . $row['stok_varian'] . '</td>
                    <td><input type="number" class="form-control input-masuk" name="harga[]" value="' . $row['harga'] . '"></td>
                    <td><input type="number" class="form-control input-masuk" name="stok[]" value="' . $row['stok'] . '"></td>
                    <td>
                        ' . ($row['status'] == 1 ? '<span role="button" class="badge bg-success">Updated</span>' : '<button role="button" data-href="/admin/produk-masuk/' . $row['id_masuk_detail'] . '/del" class="btn btn-sm btn-danger me-1 btn-del-item"><i class="bx bx-trash me-0"></i></button>') . '
                    </td>
                </tr>';
            }

            $this->response->setStatusCode(ResponseInterface::HTTP_OK);
            return $this->responseJSON->success($html, 'Berhasil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            $this->response->setStatusCode(ResponseInterface::HTTP_BAD_GATEWAY);
            return $this->responseJSON->success([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function saveTemptStok($id)
    {
        $post = $this->request->getPost();

        $data = [];
        foreach ($post['id_masuk_detail'] as $key => $row) {
            $data[] = [
                'id_masuk_detail' => $row,
                'harga' => $post['harga'][$key],
                'stok' => $post['stok'][$key],
            ];
        }

        // save data
        $this->ModelMasukDetail->updateBatch($data, 'id_masuk_detail');
    }

    public function syncDataStok($id)
    {
        // cek data
        if($this->ModelProdukMasuk->where(['status' => 1, 'id_masuk' => $id])->countAllResults()){
            return redirect()->to('admin/produk-masuk')->with('message', [500, 'Data sudah diupdate.']);
        }

        $post = $this->request->getPost();
        $ModelProduk = new ProdukVarianModel();

        $this->db->transException(true)->transStart();
        try {
            // mengambil data detail 
            $dataDetail = $this->ModelMasukDetail->where('masuk_id', $id)->findAll();

            $dataProdukUpdate = [];
            $dataMasukUpdate = [];
            foreach ($dataDetail as $row) {

                // cek data stok
                if($row['stok'] == 0) return redirect()->to('admin/produk-masuk/detail/'. $id)->with('message', [500, 'Stok masuk tidak boleh kosong.']);

                // data varian lama
                $oldData = $ModelProduk->where('id_varian', $row['varian_id'])->first();
                // logika update stok
                $oldStok = $oldData['stok_varian'];
                (int)$newStok = $row['stok'] + $oldStok;

                // set update produk harga, stok
                $dataProdukUpdate[] = [
                    'id_varian' => $row['varian_id'],
                    'harga_varian' => $row['harga'],
                    'stok_varian' => $newStok,
                ];

                // logika perhitungan harga // harga baru - harga lama
                $harga = $row['harga'] - $oldData['harga_varian'];

                // update detail masuk
                $dataMasukUpdate[] = [
                    'id_masuk_detail' => $row['id_masuk_detail'],
                    'harga' => $harga,
                    'status' => 1,
                ];
            }

            // update data
            $ModelProduk->updateBatch($dataProdukUpdate, 'id_varian');
            $this->ModelMasukDetail->updateBatch($dataMasukUpdate, 'id_masuk_detail');
            $this->ModelProdukMasuk->update($id, ['status' => 1]);

            $this->db->transComplete();
            return redirect()->to('admin/produk-masuk')->with('message', [200, "Input barang masuk berhasil"]);
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            return redirect()->to('admin/produk-masuk')->with('message', [501, $e->getMessage()]);
        }
    }

    public function CancelSyncDataStok($id)
    {
        $post = $this->request->getPost();
        $ModelProduk = new ProdukVarianModel();

        $this->db->transException(true)->transStart();
        try {
            // mengambil data detail 
            $dataDetail = $this->ModelMasukDetail->where('masuk_id', $id)->findAll();

            $dataProdukUpdate = [];
            $dataMasukUpdate = [];
            foreach ($dataDetail as $row) {

                // data varian 
                $oldData = $ModelProduk->where('id_varian', $row['varian_id'])->first();

                // logika update stok // ubah ke stok awal
                $oldStok = $oldData['stok_varian'];
                (int)$newStok = $oldStok - $row['stok'];

                // logika perhitungan harga // harga varian - harga detail
                $harga = $oldData['harga_varian'] - $row['harga'];

                // set update produk harga, stok
                $dataProdukUpdate[] = [
                    'id_varian' => $row['varian_id'],
                    'harga_varian' => $harga,
                    'stok_varian' => $newStok,
                ];

                // update detail masuk
                $dataMasukUpdate[] = [
                    'id_masuk_detail' => $row['id_masuk_detail'],
                    'harga' => $harga,
                    'status' => 0,
                ];
            }

            // update data
            $ModelProduk->updateBatch($dataProdukUpdate, 'id_varian');
            $this->ModelMasukDetail->updateBatch($dataMasukUpdate, 'id_masuk_detail');
            $this->ModelProdukMasuk->update($id, ['status' => 0]);

            $this->db->transComplete();
            return redirect()->to('admin/produk-masuk')->with('message', [200, "Batal singkron berhasil"]);
        } catch (DatabaseException $e) {
            $this->db->transRollback();
            return redirect()->to('admin/produk-masuk')->with('message', [501, $e->getMessage()]);
        }
    }

    public function renderDetailItem($id)
    {
        $id_masuk = $this->request->getPost('id') ?? $id;
        $ModelProduk = new ProdukVarianModel();

        try {
            // mengambil data detail barang masuk
            $dataDetailItem = $this->ModelMasukDetail
                ->select('produk_masuk_detail.*, produk.nama_produk')
                ->join('produk', 'produk.id_produk = produk_masuk_detail.produk_id')
                ->where('produk_masuk_detail.masuk_id', $id_masuk)->findAll();

            $html = "";
            $i = 1;
            foreach ($dataDetailItem as $row) {
                $varianData = $ModelProduk->where('id_varian', $row['varian_id'])->first();

                $html .=
                    '<tr>
                <td>' . $i++ . '</td>
                <td>' . $row['nama_produk'] . '<br> *' . $varianData['nama_varian'] . '</td>
                <td>Rp ' . ($row['status'] == 1 ? number_format($varianData['harga_varian'] - $row['harga']) : number_format($varianData['harga_varian'])) . '</td>
                <td>Rp ' . ($row['status'] == 1 ? number_format($varianData['harga_varian']) : number_format($row['harga'])) . '</td>
                <td>' . $varianData['stok_varian'] - $row['stok'] . '</td>
                <td>' . $row['stok'] . '</td>
                        <td>' . $varianData['stok_varian'] . '</td>
                        <td>' . ($row['status'] == 1 ? '<span role="button" class="badge bg-success">Updated</span>' : '<span role="button" class="badge bg-warning">Waiting</span>') . '</td>
                   </tr>';
            }

            $this->response->setStatusCode(ResponseInterface::HTTP_OK);
            return $this->responseJSON->success($html, 'Berhasil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            $this->response->setStatusCode(ResponseInterface::HTTP_BAD_GATEWAY);
            return $this->responseJSON->success([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function delete($id)
    {
        try {
            $this->ModelProdukMasuk->where(['status' => 0, 'id_masuk' => $id])->delete();
            return redirect()->to('admin/produk-masuk')->with('message', [200, "Hapus berhasil"]);
        } catch (\Exception $e) {
            return redirect()->to('admin/produk-masuk')->with('message', [501, $e->getMessage()]);
        }
    }
}
