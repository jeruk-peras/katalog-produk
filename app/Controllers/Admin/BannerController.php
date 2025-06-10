<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Libraries\UploadFileLibrary;
use App\Models\BannerModel;
use CodeIgniter\HTTP\ResponseInterface;

class BannerController extends BaseController
{
    private $title = 'Banner';
    private $nav = 'banner';

    private $ModelBanner;
    private $validation;
    private $responseJSON;

    protected $setRules = [
        'nama_banner' => [
            'label' => 'Nama banner',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'deskripsi_banner' => [
            'label' => 'deskripsi',
            'rules' => 'max_length[300]',
            'errors' => [
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
    ];

    public function __construct()
    {
        $this->ModelBanner = new BannerModel();
        $this->validation = \Config\Services::validation();
        $this->responseJSON = new ResponseJSONCollection();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('Admin/banner/index', $data);
    }

    public function datatables()
    {
        $table = 'banner';
        $primaryKey = 'id_banner';
        $columns = ['id_banner', 'nama_banner', 'deskripsi_banner', 'gambar_banner', 'status'];
        $orderableColumns = ['id_banner', 'nama_banner', 'status'];
        $searchableColumns = ['nama_banner'];
        $defaultOrder = ['nama_banner', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_banner']),
                htmlspecialchars($row['gambar_banner']),
                htmlspecialchars($row['status']),
                htmlspecialchars($row['id_banner']),
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
            'gambar_banner' => [
                'rules'  => 'uploaded[gambar_banner]|max_size[gambar_banner,2048]|is_image[gambar_banner]|mime_in[gambar_banner,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'uploaded' => 'Maaf kolom gambar kosong!.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in' => 'Format gambar tidak valid. Hanya jpg, jpeg, png, gif yang diperbolehkan.'
                ],
            ],
        ];

        $this->validation->setRules($this->setRules); // set rules untuk validasi
        $isValid = $this->validation->run($arratpost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validation->getErrors();
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
            $uploadfile = $upload->uploadImage($this->request->getFile('gambar_banner'), './assets/images/banner/');

            $datavalid = $this->validation->getValidated();
            $datavalid['gambar_banner'] = $uploadfile; // menyimpan nama file gambar
            // dd($datavalid);
            $this->ModelBanner->save($datavalid); // Simpan data ke database

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
        $data = $this->ModelBanner->find($id);
        if (!$data) {
            return $this->responseJSON->error(
                null,
                'Data not found',
                ResponseInterface::HTTP_BAD_REQUEST
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
            'gambar_banner' => [
                'rules'  => 'max_size[gambar_banner,2048]|is_image[gambar_banner]|mime_in[gambar_banner,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar.',
                    'mime_in' => 'Format gambar tidak valid. Hanya jpg, jpeg, png, gif yang diperbolehkan.'
                ],
            ],
        ];

        $this->validation->setRules($this->setRules); // set rules untuk validasi
        $isValid = $this->validation->run($arratpost); // menjalankan validasi

        if (!$isValid) { // jika validasi gagal
            // Mengambil error dari validasi
            $errors = $this->validation->getErrors();
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
            $datavalid = $this->validation->getValidated();
            if ($this->request->getFile('gambar_banner') !== null) {
                // simpan data
                $upload = new UploadFileLibrary();
                $uploadfile = $upload->uploadImage($this->request->getFile('gambar_banner'), './assets/images/banner/');
                $datavalid['gambar_banner'] = $uploadfile; // menyimpan nama file gambar

                // Hapus gambar lama jika ada
                $oldData = $this->ModelBanner->find($id);
                if ($oldData && $oldData['gambar_banner']) {
                    $oldImagePath = './assets/images/banner/' . $oldData['gambar_banner'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Hapus file gambar lama
                    }
                }
            }
            $this->ModelBanner->update($id, $datavalid); // Simpan data ke database

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
        $data = $this->ModelBanner->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelBanner->delete($id);

            // Hapus gambar dari server jika ada
            if ($data['gambar_banner']) {
                $imagePath = './assets/images/banner/' . $data['gambar_banner'];
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Hapus file gambar
                }
            }

            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function status($id)
    {
        $data = $this->ModelBanner->find($id);
        if ($data) {
            try {
                $data['status'] = ($data['status'] == 1 ? 0 : 1);
                $this->ModelBanner->update($id, $data);

                // Kembalikan response sukses
                return $this->responseJSON->success(null, 'Data successfully', ResponseInterface::HTTP_OK);
            } catch (\Exception $e) {
                return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
            }
        } else {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }
    }
}
