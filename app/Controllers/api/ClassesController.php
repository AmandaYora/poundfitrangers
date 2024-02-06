<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClassModel;

class ClassesController extends ResourceController
{
    private $isLoggedIn;
    private $accountId;
    private $userId;
    private $username;
    private $email;
    private $role;

    public function __construct()
    {
        // Panggil semua session
        $this->isLoggedIn = session()->get('isLoggedIn');
        $this->accountId = session()->get('accountId');
        $this->userId = session()->get('userId');
        $this->username = session()->get('username');
        $this->email = session()->get('email');
        $this->role = session()->get('role');
    }

    protected $modelName = 'App\Models\ClassModel';
    protected $format    = 'json';

    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond([
            'info' => 'sukses',
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond([
                'info' => 'sukses',
                'message' => 'Data berhasil diambil',
                'data' => $data
            ]);
        } else {
            return $this->respond([
                'info' => 'gagal',
                'message' => 'Data dengan ID ' . $id . ' tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

    public function create()
    {
        $input = $this->request->getPost();
        if ($this->model->insert($input)) {
            return $this->respond([
                'info' => 'sukses',
                'message' => 'Data berhasil ditambahkan',
                'data' => $input
            ]);
        } else {
            return $this->respond([
                'info' => 'gagal',
                'message' => 'Penambahan data gagal',
                'data' => null
            ], 400);
        }
    }

    public function update($id = null)
    {
        $input = $this->request->getRawInput();
        $data = $this->model->find($id);

        if ($data) {
            if ($this->model->update($id, $input)) {
                return $this->respond([
                    'info' => 'sukses',
                    'message' => 'Data berhasil diperbarui',
                    'data' => $input
                ]);
            } else {
                return $this->respond([
                    'info' => 'gagal',
                    'message' => 'Pembaruan data gagal',
                    'data' => null
                ], 400);
            }
        } else {
            return $this->respond([
                'info' => 'gagal',
                'message' => 'Data dengan ID ' . $id . ' tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $updateData = ['status' => 'closed'];
            $this->model->update($id, $updateData);
            return $this->respond([
                'info' => 'sukses',
                'pesan' => 'Data berhasil diubah statusnya menjadi closed',
                'data' => ['id' => $id, 'status' => 'closed']
            ]);
        } else {
            return $this->respond([
                'info' => 'gagal',
                'pesan' => 'Data dengan ID ' . $id . ' tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
    
}
