<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\KategoriModel;
use App\Models\SpesifikasiModel;
use App\Models\SubKategoriModel;
use CodeIgniter\HTTP\ResponseInterface;

class SpesifikasiController extends BaseController
{

    protected $title = 'Spesifikasi';
    protected $nav = 'spesifikasi';

    protected $responseJSON;
    protected $ModelSpesifikasi;
    protected $ModelKategori;
    protected $validator;

    protected $setRules = [
        'nama_spesifikasi.*' => [
            'label' => 'Nama Spesifikasi',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'kategori_id' => [
            'label' => 'Kategori',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => '{field} harus dipilih.',
                'numeric' => '{field} harus berupa angka.'
            ]
        ],
    ];

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelSpesifikasi = new SpesifikasiModel();
        $this->ModelKategori = new KategoriModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
            'kategori' => $this->ModelKategori->findAll(), // Assuming you have a method to get all categories
        ];
        return view('Admin/spesifikasi/index', $data);
    }

    public function datatables()
    {
        $table = 'spesifikasi';
        $primaryKey = 'id_spesifikasi';
        $columns = ['id_spesifikasi', 'nama_kategori', 'nama_spesifikasi'];
        $orderableColumns = ['id_spesifikasi', 'nama_kategori', 'nama_spesifikasi'];
        $searchableColumns = ['nama_spesifikasi', 'nama_kategori',];
        $defaultOrder = ['nama_kategori', 'DESC'];

        $join = [
            [
                'table' => 'kategori',
                'on' => 'kategori.id_kategori = spesifikasi.kategori_id',
                'type' => 'LEFT'
            ]
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_kategori']),
                htmlspecialchars($row['nama_spesifikasi']),
                htmlspecialchars($row['id_spesifikasi']),
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
            'kategori' => $this->ModelKategori->findAll(),
        ];
        return view('Admin/spesifikasi/add', $data);
    }

    public function save()
    {
        $arratpost = $this->request->getPost(); // menampung data post

        $this->validator->setRules($this->setRules); // set rules untuk validasi
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

            $databatch = [];
            foreach ($datavalid['nama_spesifikasi'] as $key => $value) {
                // Tambahkan kategori_id ke setiap spesifikasi
                $databatch[] = [
                    'nama_spesifikasi' => $value,
                    'kategori_id' => $datavalid['kategori_id']
                ];
            }

            // var_dump($databatch);die; // Debugging line, remove in production
            $this->ModelSpesifikasi->insertBatch($databatch); // Simpan data ke database

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

    public function edit($id)
    {
        $data = $this->ModelSpesifikasi->find($id);
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

    public function update($id)
    {
        $arratpost = $this->request->getPost(); // menampung data post

        $this->validator->setRules($this->setRules); // set rules untuk validasi
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
            $this->ModelSpesifikasi->update($id, $datavalid); // Simpan data ke database

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

    public function delete($id)
    {
        $data = $this->ModelSpesifikasi->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelSpesifikasi->delete($id);

            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
