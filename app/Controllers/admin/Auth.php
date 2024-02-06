<?php

namespace App\Controllers\Admin;

use App\Models\AccountModel;
use App\Models\UserModel;
use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function __construct()
    {
        // Periksa apakah user sudah login
        if (session()->get('isLoggedIn')) {
            header('location: /dashboard');
            exit();
        }
    }

    public function index()
    {
        // Jika method POST, proses data form
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            // Menggunakan AccountModel untuk mengakses database
            $accountModel = new AccountModel();
            $account = $accountModel->where('username', $username)
                                     ->where('deleted_at', null)  // Pastikan akun tidak di-soft delete
                                     ->first();

            if ($account && password_verify($password, $account['password'])) {
                // Menggunakan UserModel untuk mencari userId berdasarkan accountId
                $userModel = new UserModel();
                $user = $userModel->where('accountId', $account['accountId'])->first();

                // Cek apakah user ditemukan
                if ($user) {
                    $userId = $user['userId'];
                } else {
                    $userId = null;
                }

                if ($userId !== null) {
                    $sessionData = [
                        'isLoggedIn' => true,
                        'accountId'  => $account['accountId'],
                        'userId'     => $userId,
                        'username'   => $account['username'],
                        'email'      => $account['email'],
                        'role'       => $account['role']
                    ];
    
                    session()->set($sessionData);
                    header('location: /dashboard');
                    exit();
                }else{
                    session()->setFlashdata('error', 'Tidak ada user di temukan');
                    header('location: /auth');
                    exit();
                }
                
            } else {
                // Login gagal
                session()->setFlashdata('error', 'Username atau password salah');
                header('location: /auth');
                exit();
            }
        }

        $data['role'] = 'admin';
        $data['active_page'] = 'dashboard';
        $data['username'] = 'dimas';

        echo view('admin/Auth', $data);
    }
}