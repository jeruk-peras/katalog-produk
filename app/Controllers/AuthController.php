<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function proses_login(){
        $RESPONSEJSON = new ResponseJSONCollection();
        $ModelUsers = new UsersModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $ModelUsers->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            return $RESPONSEJSON->error([],'Username atau password salah', ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Set session jika login berhasil
        session()->set([
            'user_id'   => $user['id_user'],
            'nama_user' => $user['nama_user'],
            'username'  => $user['username'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        return $RESPONSEJSON->success(['redirect' => base_url('admin/dashboard')], 'Login berhasil.', ResponseInterface::HTTP_OK);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
