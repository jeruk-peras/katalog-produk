<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\LayananModel;
use CodeIgniter\HTTP\ResponseInterface;

class LayananController extends BaseController
{
    protected $title = 'Layanan';
    protected $nav = 'layanan';

    protected $responseJSON;
    protected $ModelLayanan;
    protected $validator;

    protected $setRules = [
        'nama_layanan' => [
            'label' => 'Nama',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'icon_layanan' => [
            'label' => 'icon',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi.',
            ]
        ],
        'deskripsi_layanan' => [
            'label' => 'deskripsi layanan',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
    ];

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelLayanan = new LayananModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('admin/layanan/index', $data);
    }

    public function datatables()
    {
        $table = 'layanan';
        $primaryKey = 'id_layanan';
        $columns = ['id_layanan', 'nama_layanan', 'icon_layanan', 'deskripsi_layanan'];
        $orderableColumns = ['id_layanan', 'nama_layanan', 'icon_layanan', 'deskripsi_layanan'];
        $searchableColumns = ['nama_layanan'];
        $defaultOrder = ['nama_layanan', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                $row['icon_layanan'],
                htmlspecialchars($row['nama_layanan']),
                htmlspecialchars($row['deskripsi_layanan']),
                htmlspecialchars($row['id_layanan']),
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

            $datavalid = $this->validator->getValidated();
            // var_dump($datavalid);
            // dd();
            $this->ModelLayanan->save($datavalid); // Simpan data ke database

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
        $data = $this->ModelLayanan->find($id);
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
            $this->ModelLayanan->update($id, $datavalid); // Simpan data ke database

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
        $data = $this->ModelLayanan->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelLayanan->delete($id);
            
            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
