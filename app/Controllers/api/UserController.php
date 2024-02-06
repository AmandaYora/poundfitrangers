<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Models\AccountModel;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->table('users')
                    ->select('users.*, accounts.username, accounts.email, accounts.role')
                    ->join('accounts', 'users.accountId = accounts.accountsId')
                    ->get();

        $data = $query->getResult();
        return $this->respond(['info' => 'success', 'data' => $data], 200);
    }

    public function create()
    {
        $userModel = new UserModel();
        $accountModel = new AccountModel();

        $input = $this->request->getJSON();

        // Input untuk table 'users'
        $userData = [
            'name' => $input->name,
            'gender' => $input->gender,
            'birthday' => $input->birthday,
            'phone' => $input->phone,
            'address' => $input->address
        ];

        // Input untuk table 'accounts'
        $accountData = [
            'username' => $input->username,
            'email' => $input->email,
            'password' => password_hash($input->password, PASSWORD_BCRYPT),
            'role' => $input->role
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Simpan ke table 'accounts' dan ambil 'accountsId'
            $accountModel->insert($accountData);
            $accountId = $db->insertID();

            // Tambahkan 'accountId' ke data user dan simpan ke table 'users'
            $userData['accountId'] = $accountId;
            $userModel->insert($userData);

            $db->transComplete();

            $dataResponse = [
                'info' => 'success',
                'message' => 'Berhasil menambahkan data',
                'data' => [
                    'user' => $userData,
                    'account' => $accountData
                ]
            ];
            
            return $this->respond($dataResponse, 201);

        } catch (\Exception $e) {
            $db->transRollback();

            $dataResponse = [
                'info' => 'error',
                'message' => 'Gagal menambahkan data',
                'data' => null
            ];

            return $this->respond($dataResponse, 500);
        }
    }

    public function update($id = null)
    {
        $userModel = new UserModel();
        $accountModel = new AccountModel();
        $input = $this->request->getJSON();
        $db = \Config\Database::connect();

        $db->transStart();

        try {
            $userData = [
                'name' => $input->name,
                'gender' => $input->gender,
                'birthday' => $input->birthday,
                'phone' => $input->phone,
                'address' => $input->address
            ];

            $updateUserResult = $userModel->update($id, $userData);

            if (!$updateUserResult) {
                throw new \Exception('Gagal memperbarui data user');
            }

            $updatedUser = $userModel->find($id);
            $accountId = $updatedUser['accountId'];

            $accountData = [
                'username' => $input->username,
                'email' => $input->email,
                'role' => $input->role
            ];

            if (!empty($input->password)) {
                $accountData['password'] = password_hash($input->password, PASSWORD_BCRYPT);
            }

            $updateAccountResult = $accountModel->update($accountId, $accountData);

            if (!$updateAccountResult) {
                throw new \Exception('Gagal memperbarui data akun '. $accountId);
            }

            $db->transComplete();

            return $this->respond([
                'info' => 'success',
                'message' => 'Berhasil memperbarui data',
                'data' => [
                    'user' => $userData,
                    'account' => $accountData
                ]
            ], 200);

        } catch (\Exception $e) {
            $db->transRollback();

            return $this->respond([
                'info' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }


    public function delete($id = null)
    {
        $userModel = new UserModel();
        $accountModel = new AccountModel();
        $db = \Config\Database::connect();
    
        $db->transStart();
    
        try {
            // Cari user
            $user = $userModel->find($id);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $deleteUserResult = $userModel->delete($id);
            if ($deleteUserResult === false || $deleteUserResult == 0) {
                throw new \Exception('Failed to delete user');
            }
    
            $accountId = $user['accountId'];
    
            $deleteAccountResult = $accountModel->delete($accountId);
            if ($deleteAccountResult === false) {
                $error = $db->error();
                throw new \Exception('Failed to delete account. Error: ' . json_encode($error));
            } elseif ($deleteAccountResult == 0) {
                throw new \Exception('No account found to delete.');
            }
    
            $db->transComplete();
    
            return $this->respond([
                'info' => 'success',
                'message' => 'Successfully deleted data'
            ], 200);
    
        } catch (\Exception $e) {
            $db->transRollback();
    
            return $this->respond([
                'info' => 'error',
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    


    public function readByUsername($username)
    {
        $db = \Config\Database::connect();
        $query = $db->table('users')
                    ->select('users.*, accounts.username, accounts.email, accounts.role')
                    ->join('accounts', 'users.accountId = accounts.accountId')
                    ->where('accounts.username', $username)
                    ->get();

        $data = $query->getRow();
        
        if ($data) {
            return $this->respond([
                'info' => 'success',
                'data' => $data
            ], 200);
        } else {
            return $this->respond([
                'info' => 'error',
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

}