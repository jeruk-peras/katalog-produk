<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UploadFileLibrary;
use CodeIgniter\HTTP\ResponseInterface;

class HelperController extends BaseController
{
    public function index()
    {
        //
    }

    public function filepondupload()
    {
        $upload = new UploadFileLibrary();

        try {
            if ($imagefile = $this->request->getFiles()) {
                foreach ($imagefile['filepond'] as $img) {
                    $filename = $upload->uploadImage($img, 'assets/images/produk/');
                    return $this->response->setJSON($filename);
                }
            };
        } catch (\Throwable $th) {
            return 'Gagal mengunggah file.' . $th->getMessage();
        }
    }

    public function filepondrevert()
    {
        $fileName = $this->request->getBody(); // Ambil nama file dari request

        if (unlink('assets/images/produk/' . $fileName)) { // Hapus file
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'File berhasil dihapus.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 400,
            'message' => 'Gagal menghapus file.',
        ]);
    }
}
