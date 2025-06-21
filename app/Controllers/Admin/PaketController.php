<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\PaketDetailModel;
use App\Models\ProdukPaketModel;
use CodeIgniter\HTTP\ResponseInterface;

class PaketController extends BaseController
{
    private $title = 'Paket Produk';
    private $nav = 'paket';

    private $ModelPaket;
    private $ModelPaketDetail;
    private $RESPONSEJSON;

    private $validation;
    private $setRules = [
        'gambar' => [
            'label' => 'Gambar',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi.',
            ]
        ],
        'nama_paket' => [
            'label' => 'Nama paket',
            'rules' => 'required|min_length[3]|max_length[200]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'deskripsi_paket' => [
            'label' => 'deskripsi paket',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi.',
            ]
        ],
        'harga_awal' => [
            'label' => 'harga awal',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus diisi.',
                'numeric' => '{field} harus angka.',
            ]
        ],
        'harga_baru' => [
            'label' => 'harga baru',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus diisi.',
                'numeric' => '{field} harus angka.',
            ]
        ],
        'stok_paket' => [
            'label' => 'stok paket',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus diisi.',
                'numeric' => '{field} harus angka.',
            ]
        ],
    ];

    public function __construct()
    {
        $this->ModelPaket = new ProdukPaketModel();
        $this->ModelPaketDetail = new PaketDetailModel();
        $this->RESPONSEJSON = new ResponseJSONCollection();

        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('admin/paket/index', $data);
    }

    public function datatables()
    {
        $table = 'produk_paket';
        $primaryKey = 'id_paket';
        $columns = ['id_paket', 'gambar', 'nama_paket', 'harga_awal', 'harga_baru', 'stok_paket'];
        $orderableColumns = ['id_paket', 'gambar', 'nama_paket', 'harga_awal', 'harga_baru', 'stok_paket'];
        $searchableColumns = ['nama_paket', 'harga_awal', 'harga_baru', 'stok_paket'];
        $defaultOrder = ['nama_paket', 'DESC'];

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
                htmlspecialchars($row['gambar']),
                htmlspecialchars($row['nama_paket']),
                htmlspecialchars('Rp' . number_format($row['harga_baru'])),
                htmlspecialchars($row['stok_paket']),
                htmlspecialchars($row['id_paket']),
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
        return view('admin/paket/add', $data);
    }

    public function save()
    {
        $arrayPost = $this->request->getPost();

        $setRules = [
            'nama_paket' => [
                'label' => 'Nama paket',
                'rules' => 'required|min_length[3]|max_length[200]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal 3 karakter.',
                    'max_length' => '{field} maksimal 100 karakter.'
                ]
            ]
        ];

        $this->validation->setRules($setRules); // set rules untuk validasi
        $isValid = $this->validation->run($arrayPost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validation->getErrors();
            // Mengembalikan response error dengan status 400
            return redirect()->back()->withInput()->with('message', [400, 'validasi gagal']);
        }

        try {
            $datavalid =  $this->validation->getValidated();
            $datavalid['slug_paket'] = url_title($datavalid['nama_paket'], '-', true);
            $id = $this->ModelPaket->insert($datavalid);

            return redirect()->to("admin/produk-paket/$id/detail/")->with('message', [ResponseInterface::HTTP_OK, 'Promo berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function detail(int $id_paket)
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];

        $data['paket'] = $this->ModelPaket->find($id_paket);

        return view('admin/paket/detail', $data);
    }

    public function fecthProduk()
    {
        $table = 'produk';
        $primaryKey = 'id_produk';
        $columns = ['produk.id_produk', 'produk_varian.id_varian', 'produk_varian.nama_varian', 'produk_varian.harga_varian', 'produk_varian.stok_varian', 'produk.nama_produk'];
        $orderableColumns = ['produk.id_produk', 'prodduk_varian.nama_varian', 'produk.nama_produk'];
        $searchableColumns = ['produk.id_produk', 'prodduk_varian.nama_varian', 'produk.nama_produk'];
        $defaultOrder = ['nama_produk', 'DESC'];

        $join = [
            [
                'table' => 'produk_varian',
                'on' => 'produk_varian.produk_id = produk.id_produk',
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
                htmlspecialchars($row['nama_produk']),
                htmlspecialchars($row['nama_varian']),
                htmlspecialchars($row['harga_varian']),
                htmlspecialchars($row['stok_varian']),
                htmlspecialchars("{$row['id_produk']}/{$row['id_varian']}"),
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

    public function update(int $id_paket)
    {
        $arrayPost = $this->request->getPost();

        // dd($arrayPost);
        $this->validation->setRules($this->setRules); // set rules untuk validasi
        $isValid = $this->validation->run($arrayPost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal

            // hapus gambar
            define('EXT', '.' . pathinfo(__FILE__, PATHINFO_EXTENSION));
            // define('FCPATH', __FILE__);
            define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
            define('PUBPATH', str_replace(SELF, '', FCPATH)); // added
            $filestring = PUBPATH . 'assets/images/produk/' . $arrayPost['gambar'];
            unlink($filestring);

            // Mengambil error dari validasi
            $errors = $this->validation->getErrors();
            // Mengembalikan response error dengan status 400
            return redirect()->back()->withInput()->with('message', [400, 'validasi gagal']);
        }

        try {
            $datavalid =  $this->validation->getValidated();
            $datavalid['slug_paket'] = url_title($datavalid['nama_paket'], '-', true);
            $this->ModelPaket->update($id_paket, $datavalid);

            return redirect()->to("admin/produk-paket")->with('message', [ResponseInterface::HTTP_OK, 'Promo berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', [ResponseInterface::HTTP_BAD_GATEWAY, $e->getMessage()]);
        }
    }

    public function get_item(int $id_paket)
    {
        try {
            $data = $this->ModelPaketDetail->joinAllData($id_paket);
            return $this->RESPONSEJSON->success($data, 'get data berhasil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->RESPONSEJSON->error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function add_item(int $id_paket, int $id_produk, int $id_varian)
    {
        $datadetail = [
            'paket_id' => $id_paket,
            'produk_id' => $id_produk,
            'varian_id' => $id_varian,
        ];

        $this->ModelPaketDetail->db->transStart();
        try {
            $save = $this->ModelPaketDetail->save($datadetail);
            if ($save) {
                $data = $this->ModelPaketDetail->joinAllData($id_paket);
                $this->ModelPaketDetail->db->transCommit();
                return $this->RESPONSEJSON->success($data, 'Simpan data berhasil', ResponseInterface::HTTP_OK);
            }
        } catch (\Exception $e) {
            $this->ModelPaketDetail->db->transRollback();
            return $this->RESPONSEJSON->error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function remove_item(int $id_paket)
    {
        try {
            $this->ModelPaketDetail->delete($id_paket);
            return $this->RESPONSEJSON->success([], 'Remove data berhasil', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->RESPONSEJSON->error([], $e->getMessage(), ResponseInterface::HTTP_BAD_GATEWAY);
        }
    }

    public function delete($id)
    {
        $data = $this->ModelPaket->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            define('EXT', '.' . pathinfo(__FILE__, PATHINFO_EXTENSION));
            // define('FCPATH', __FILE__);
            define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
            define('PUBPATH', str_replace(SELF, '', FCPATH)); // added
            $filestring = PUBPATH . 'assets/images/produk/' . $data['gambar'];
            unlink($filestring);

            // Hapus data dari database
            $this->ModelPaket->delete($id);

            // Kembalikan response sukses
            return $this->RESPONSEJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->RESPONSEJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
