<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Libraries\UploadFileLibrary;
use App\Models\KategoriModel;
use App\Models\SubKategoriModel;
use CodeIgniter\HTTP\ResponseInterface;

class SubKategoriController extends BaseController
{
    protected $title = 'Sub Kategori';
    protected $nav = 'subkategori';

    protected $responseJSON;
    protected $ModelSubKategori;
    protected $ModelKategori;
    protected $validator;

    protected $setRules = [
        'nama_sub_kategori' => [
            'label' => 'Nama Sub Kategori',
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
        $this->ModelSubKategori = new SubKategoriModel();
        $this->ModelKategori = new KategoriModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $this->ModelSubKategori = new SubKategoriModel();
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
            'kategori' => $this->ModelKategori->findAll(), // Assuming you have a method to get all categories
        ];
        return view('Admin/sub-kategori/index', $data);
    }

    public function datatables()
    {
        $table = 'sub_kategori';
        $primaryKey = 'id_sub_kategori';
        $columns = ['id_sub_kategori', 'nama_kategori', 'nama_sub_kategori', 'slug_sub_kategori'];
        $orderableColumns = ['id_sub_kategori', 'nama_kategori', 'nama_sub_kategori', 'slug_sub_kategori'];
        $searchableColumns = ['nama_sub_kategori', 'slug_sub_kategori'];
        $defaultOrder = ['nama_sub_kategori', 'DESC'];

        $join = [
            [
                'table' => 'kategori',
                'on' => 'kategori.id_kategori = sub_kategori.kategori_id',
                'type' => 'LEFT'
            ]
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join);
        $countAllData = $sideDatatable->countAllData();

        // $row['id_kategori'] = '<a href="'.base_url('admin/kategori/edit/'.$row['id_kategori']).'" class="btn btn-sm btn-primary">Edit</a> ' .
        //                       '<a href="'.base_url('admin/kategori/delete/'.$row['id_kategori']).'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>';
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_kategori']),
                htmlspecialchars($row['nama_sub_kategori']),
                htmlspecialchars($row['slug_sub_kategori']),
                htmlspecialchars($row['id_sub_kategori']),
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
            $datavalid['slug_sub_kategori'] = url_title($datavalid['nama_sub_kategori'], '-', true); // Membuat slug dari nama kategori

            $this->ModelSubKategori->save($datavalid); // Simpan data ke database

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
        $data = $this->ModelSubKategori->find($id);
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
            $datavalid['slug_sub_kategori'] = url_title(
                $datavalid['nama_sub_kategori'],
                '-',
                true
            ); // Membuat slug dari nama kategori
            $this->ModelSubKategori->update($id, $datavalid); // Simpan data ke database

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
        $data = $this->ModelSubKategori->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelSubKategori->delete($id);

            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
