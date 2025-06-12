<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\UploadFileLibrary;
use App\Models\AboutModel;
use CodeIgniter\HTTP\ResponseInterface;

class AboutController extends BaseController
{
    protected $title = 'About';
    protected $nav = 'about';

    protected $responseJSON;
    protected $ModelAbout;
    protected $validator;

    public function __construct()
    {
        // You can load models or libraries here if needed
        $this->responseJSON = new ResponseJSONCollection();
        $this->ModelAbout = new AboutModel();
        $this->validator = \Config\Services::validation();
    }

    public function index()
    {
        // Load the model
        $data = [
            'title' => $this->title,
            'nav' => $this->nav,
        ];

        foreach ($this->ModelAbout->findAll() as $row) {
            $data[$row['data']] = $row['nilai'];
        }

        return view('Admin/about/index', $data);
    }

    public function update()
    {
        $upload = new UploadFileLibrary();

        $data = [
            'judul' => $this->request->getPost('judul'),
            'text' => $this->request->getPost('text')
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            // simpan data
            $upload = new UploadFileLibrary();
            $uploadfile = $upload->uploadImage(
                $this->request->getFile('gambar'),
                './assets/images/'
            );
            $data['gambar'] = $uploadfile; // menyimpan nama file gambar

            // Hapus gambar lama jika ada
            $oldData = $this->ModelAbout->where('data', 'gambar')->first();
            if ($oldData && $oldData['nilai']) {
                $oldImagePath = './assets/images/' . $oldData['nilai'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Hapus file gambar lama
                }
            }
        }

        try {
            foreach ($data as $key => $value) {
                $this->ModelAbout->where('data', $key)->set('nilai', $value)->update();
            }
            return redirect()->to('admin/about')->with('message', 200);
        } catch (\Throwable $th) {
            return redirect()->to('admin/about')->with('message', 500);
        }
    }
}
