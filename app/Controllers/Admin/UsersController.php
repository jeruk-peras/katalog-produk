<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class UsersController extends BaseController
{
    protected $title = 'Users';
    protected $nav = 'users';

    protected $responseJSON;
    protected $ModelUsers;
    protected $validator;

    protected $setRules = [
        'nama_user' => [
            'label' => 'Nama user',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'role' => [
            'label' => 'role',
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi.',
            ]
        ],
        'username' => [
            'label' => 'Username',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'password' => [
            'label' => 'password',
            'rules' => 'required|min_length[6]|max_length[10]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 6 karakter.',
                'max_length' => '{field} maksimal 10 karakter.'
            ]
        ],
        'confirm_password' => [
            'label' => 'Konformasi password',
            'rules' => 'required|min_length[6]|max_length[10]|matches[password]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 6 karakter.',
                'max_length' => '{field} maksimal 10 karakter.',
                'matches' => 'Password tidak sama, periksa kembali',
            ]
        ],
    ];

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelUsers = new UsersModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('Admin/users/index', $data);
    }

    public function datatables()
    {
        $table = 'users';
        $primaryKey = 'id_user';
        $columns = ['id_user', 'nama_user', 'role', 'username'];
        $orderableColumns = ['id_user', 'nama_user', 'role', 'username'];
        $searchableColumns = ['nama_user', 'role', 'username'];
        $defaultOrder = ['nama_user', 'DESC'];

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
                htmlspecialchars($row['nama_user']),
                htmlspecialchars($row['role']),
                htmlspecialchars($row['username']),
                htmlspecialchars($row['id_user']),
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

            $datavalid = [
                'nama_user' => $datavalid['nama_user'],
                'role' => $datavalid['role'],
                'username' => $datavalid['username'],
                'password' => password_hash($datavalid['password'], PASSWORD_DEFAULT),
            ];

            $this->ModelUsers->save($datavalid); // Simpan data ke database

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
        $data = $this->ModelUsers->find($id);
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

             $datavalid = [
                'nama_user' => $datavalid['nama_user'],
                'role' => $datavalid['role'],
                'username' => $datavalid['username'],
                'password' => password_hash($datavalid['password'], PASSWORD_DEFAULT),
            ];

            $this->ModelUsers->update($id, $datavalid); // Simpan data ke database

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
        $data = $this->ModelUsers->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelUsers->delete($id);

            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
