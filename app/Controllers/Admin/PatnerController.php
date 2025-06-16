<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Libraries\UploadFileLibrary;
use App\Models\PatnerModel;
use CodeIgniter\HTTP\ResponseInterface;

class PatnerController extends BaseController
{
    protected $title = 'Patner';
    protected $nav = 'patner';

    protected $responseJSON;
    protected $ModelPatner;
    protected $validator;

    protected $setRules = [
        'nama_patner' => [
            'label' => 'Nama patner',
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
        $this->ModelPatner = new PatnerModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('admin/patner/index', $data);
    }

    public function datatables()
    {
        $table = 'patner';
        $primaryKey = 'id_patner';
        $columns = ['id_patner', 'nama_patner', 'logo_patner'];
        $orderableColumns = ['id_patner', 'nama_patner', 'logo_patner'];
        $searchableColumns = ['nama_patner'];
        $defaultOrder = ['nama_patner', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countAllData = $sideDatatable->countAllData();

        // $row['id_kategori'] = '<a href="'.base_url('admin/kategori/edit/'.$row['id_kategori']).'" class="btn btn-sm btn-primary">Edit</a> ' .
        //                       '<a href="'.base_url('admin/kategori/delete/'.$row['id_kategori']).'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>';
        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_patner']),
                htmlspecialchars($row['logo_patner']),
                htmlspecialchars($row['id_patner']),
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

        $this->setRules += [
            'logo_patner' => [
                'rules'  => 'uploaded[logo_patner]|max_size[logo_patner,2048]|is_image[logo_patner]|mime_in[logo_patner,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'uploaded' => 'Maaf kolom gambar kosong!.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in' => 'Format gambar tidak valid. Hanya jpg, jpeg, png, gif yang diperbolehkan.'
                ],
            ],
        ];

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
            $upload = new UploadFileLibrary();
            $uploadfile = $upload->uploadImage($this->request->getFile('logo_patner'), './assets/images/patner/');

            $datavalid = $this->validator->getValidated();
            $datavalid['logo_patner'] = $uploadfile; // menyimpan nama file gambar

            $this->ModelPatner->save($datavalid); // Simpan data ke database

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
        $data = $this->ModelPatner->find($id);
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

        $this->setRules += [
            'logo_patner' => [
                'rules'  => 'max_size[logo_patner,2048]|is_image[logo_patner]|mime_in[logo_patner,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in' => 'Format gambar tidak valid. Hanya jpg, jpeg, png, gif yang diperbolehkan.'
                ],
            ],
        ];

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
            if ($this->request->getFile('logo_patner') !== null) {
                // simpan data
                $upload = new UploadFileLibrary();
                $uploadfile = $upload->uploadImage($this->request->getFile('logo_patner'), './assets/images/patner/');
                $datavalid['logo_patner'] = $uploadfile; // menyimpan nama file gambar

                // Hapus gambar lama jika ada
                $oldData = $this->ModelPatner->find($id);
                if ($oldData && $oldData['logo_patner']) {
                    $oldImagePath = './assets/images/patner/' . $oldData['logo_patner'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Hapus file gambar lama
                    }
                }
            }
            $this->ModelPatner->update($id, $datavalid); // Simpan data ke database

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
        $data = $this->ModelPatner->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {

            if ($data && $data['logo_patner']) {
                $oldImagePath = './assets/images/patner/' . $data['logo_patner'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Hapus file gambar lama
                }
            }

            // Hapus data dari database
            $this->ModelPatner->delete($id);

            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
