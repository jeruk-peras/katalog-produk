<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()

    {
        $data = [
            'title' => 'Dashboard Admin',
            'nav' => 'dashboard'
        ];
        return view('admin/dashboard', $data);
    }
}
