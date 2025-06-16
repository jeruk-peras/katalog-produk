<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\PesanModel;
use CodeIgniter\HTTP\ResponseInterface;

class PesanController extends BaseController
{
   protected $title = 'Pesan';
    protected $nav = 'pesan';

    protected $responseJSON;
    protected $ModelPesan;
    protected $validator;

    protected $setRules = [
        'nama' => [
            'label' => 'Nama',
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 3 karakter.',
                'max_length' => '{field} maksimal 100 karakter.'
            ]
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|max_length[320]|valid_email',
            'errors' => [
                'required' => '{field} harus diisi.',
                'max_length' => '{field} maksimal 320 karakter.',
                'valid_mail' => 'Mohon masukan email yang valid'
            ]
        ],
        'notlp' => [
            'label' => 'notlp',
            'rules' => 'required|min_length[13]|max_length[20]|numeric',
            'errors' => [
                'required' => '{field} harus diisi.',
                'min_length' => '{field} minimal 13 karakter.',
                'max_length' => '{field} maksimal 20 karakter.',
                'numeric' => '{field} harus anggka.',
            ]
        ],
        'pesan' => [
            'label' => 'pesan',
            'rules' => 'required|max_length[500]',
            'errors' => [
                'required' => '{field} harus diisi.',
                'max_length' => '{field} maksimal 20 karakter.',
            ]
        ],
    ];

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelPesan = new PesanModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];
        return view('admin/pesan/index', $data);
    }

    public function datatables()
    {
        $table = 'pesan';
        $primaryKey = 'id_pesan';
        $columns = ['id_pesan', 'nama', 'email', 'notlp', 'pesan', 'created_at'];
        $orderableColumns = ['id_pesan', 'nama', 'email', 'notlp', 'pesan', 'created_at'];
        $searchableColumns = ['nama', 'email', 'notlp', 'pesan', 'create_at'];
        $defaultOrder = ['id_pesan', 'DESC'];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama']),
                htmlspecialchars($row['email']),
                htmlspecialchars($row['notlp']),
                htmlspecialchars($row['pesan']),
                htmlspecialchars($row['id_pesan']),
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
            $this->ModelPesan->save($datavalid); // Simpan data ke database

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

    public function delete($id)
    {
        $data = $this->ModelPesan->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelPesan->delete($id);
            
            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
