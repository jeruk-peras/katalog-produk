<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\SideServerDatatables;
use App\Models\CustomerModel;
use App\Models\OrderSelesModel;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerController extends BaseController
{
    protected $title = 'Customer';
    protected $nav = 'customer';

    protected $responseJSON;
    protected $ModelCustomer;
    protected $validator;

    protected $setRules = [
        'id'              => 'permit_empty',
        'nama_lengkap'    => 'required|max_length[300]',
        'no_handphone'    => 'required|max_length[15]',
        'email'           => 'required|valid_email|max_length[300]',
        'nama_perusahaan' => 'required|max_length[300]|is_unique[customer.nama_perusahaan,customer.id,{id}]',
        'provinsi'        => 'required|max_length[300]',
        'kota_kabupaten'  => 'required|max_length[300]',
        'kecamatan'       => 'required|max_length[300]',
        'kelurahan'       => 'required|max_length[300]',
        'alamat'          => 'required',
        'sales_id'        => 'required|integer',
    ];

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelCustomer = new CustomerModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];

        $salesModel = new OrderSelesModel();
        $data['sales'] = $salesModel->findAll();

        return view('admin/customer/index', $data);
    }

    public function datatables()
    {
        $table = 'customer';
        $primaryKey = 'id';
        $columns = ['customer.id', 'customer.nama_lengkap', 'customer.no_handphone', 'customer.email', 'customer.nama_perusahaan', 'customer.provinsi', 'customer.kota_kabupaten', 'customer.kecamatan', 'customer.kelurahan', 'customer.alamat', 'order_sales.nama_sales'];
        $orderableColumns = ['id', 'customer.nama_lengkap', 'customer.no_handphone', 'customer.email', 'customer.nama_perusahaan', 'customer.provinsi', 'customer.kota_kabupaten', 'customer.kecamatan', 'customer.kelurahan', 'customer.alamat', 'order_sales.nama_sales'];
        $searchableColumns = ['customer.nama_lengkap', 'customer.no_handphone', 'customer.email', 'customer.nama_perusahaan', 'customer.provinsi', 'customer.kota_kabupaten', 'customer.kecamatan', 'customer.kelurahan', 'customer.alamat'];
        $defaultOrder = ['nama_suplier', 'DESC'];

        $join = [
            [
                'table' => 'order_sales',
                'on' => 'order_sales.id = customer.sales_id',
                'type' => ''
            ],
        ];

        $sideDatatable = new SideServerDatatables($table, $primaryKey);

        $data = $sideDatatable->get_datatables($columns, $orderableColumns, $searchableColumns, $defaultOrder, $join);
        $countAllData = $sideDatatable->countAllData();

        $No = $this->request->getPost('start') + 1;
        $rowData = [];
        foreach ($data as $row) {
            $rowData[] = [
                $No++,
                htmlspecialchars($row['nama_lengkap']),
                htmlspecialchars($row['no_handphone']),
                htmlspecialchars($row['email']),
                htmlspecialchars($row['nama_perusahaan']),
                htmlspecialchars($row['provinsi']),
                htmlspecialchars($row['kota_kabupaten']),
                htmlspecialchars($row['kecamatan']),
                htmlspecialchars($row['kelurahan']),
                htmlspecialchars($row['alamat']),
                htmlspecialchars($row['nama_sales']),
                htmlspecialchars($row['id']),
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

            $this->ModelCustomer->save($datavalid); // Simpan data ke database

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
        $data = $this->ModelCustomer->find($id);
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

        $arratpost['id'] = $id;
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

            $this->ModelCustomer->update($id, $datavalid); // Simpan data ke database

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
        $data = $this->ModelCustomer->find($id);
        if (!$data) {
            return $this->responseJSON->error(null, 'Data not found', ResponseInterface::HTTP_NOT_FOUND);
        }

        try {
            // Hapus data dari database
            $this->ModelCustomer->delete($id);

            // Kembalikan response sukses
            return $this->responseJSON->success(null, 'Data deleted successfully', ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            return $this->responseJSON->error(null, $e->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
