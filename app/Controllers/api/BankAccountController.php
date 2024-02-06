<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BankAccountModel;

class BankAccountController extends ResourceController
{
    protected $modelName = 'App\Models\BankAccountModel';
    protected $format = 'json';

    public function index()
    {
        $data = $this->model->findAll();
        
        if ($data) {
            $response = [
                'info' => 'success',
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ];
            return $this->respond($response, 200);
        }
        
        return $this->respond([
            'info' => 'error',
            'message' => 'Data tidak ditemukan'
        ], 404);
    }

    public function create()
    {
        $data = $this->request->getPost();  // Menggunakan getPost()
        if ($id = $this->model->insert($data)) {
            $newData = $this->model->find($id);
            $response = [
                'info' => 'success',
                'message' => 'Data berhasil ditambahkan',
                'data' => $newData
            ];
            return $this->respondCreated($response);
        }
        return $this->respond([
            'info' => 'error',
            'message' => $this->model->errors()
        ], 400);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();  // Menggunakan getPost()

        if ($this->model->update($id, $data)) {
            $updatedData = $this->model->find($id);
            $response = [
                'info' => 'success',
                'message' => 'Data berhasil diperbarui',
                'data' => $updatedData
            ];
            return $this->respond($response);
        }
        return $this->respond([
            'info' => 'error',
            'message' => $this->model->errors()
        ], 400);
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            $response = [
                'info' => 'success',
                'message' => 'Data berhasil dihapus',
                'data' => null
            ];
            return $this->respondDeleted($response);
        }
        return $this->respond([
            'info' => 'error',
            'message' => 'Data tidak ditemukan dengan id ' . $id
        ], 404);
    }
}
