<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\KontakModel;
use App\Models\LayananModel;
use CodeIgniter\HTTP\ResponseInterface;

class KontakController extends BaseController
{
    protected $title = 'Kontak';
    protected $nav = 'kontak';

    protected $responseJSON;
    protected $kontakModel;
    protected $validator;

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->kontakModel = new KontakModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];

        foreach ($this->kontakModel->findAll() as $row) {
            $data[$row['kontak']] = $row['data'];
        }

        return view('Admin/kontak/index', $data);
    }

    public function update()
    {
        try {
            // validate input
            foreach ($this->request->getPost() as $key => $value) {
                $this->kontakModel->where('kontak', $key)->set('data', $value)->update();
            }
            return $this->responseJSON->success(
                [],
                'Data update successfully',
                ResponseInterface::HTTP_OK
            );
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, tangkap exception
            // dan kembalikan response error

            return $this->responseJSON->error(
                [],
                $e->getMessage(),
                ResponseInterface::HTTP_BAD_REQUEST
            );
        }
    }
}
