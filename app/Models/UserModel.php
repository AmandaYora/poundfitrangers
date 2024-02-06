<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';  // Nama tabel
    protected $primaryKey = 'userId';  // Primary key tabel

    protected $returnType = 'array';  // Tipe return

    // Menggunakan soft deletes
    protected $useSoftDeletes = true;  // Aktifkan soft deletes

    // Field yang diizinkan untuk diubah
    protected $allowedFields = ['accountId', 'name', 'gender', 'birthday', 'phone', 'address', 'deleted_at'];  // Tambahkan 'deleted_at' ke allowedFields

    // Menggunakan timestamps
    protected $useTimestamps = true;  // Aktifkan timestamps
    protected $createdField  = 'created_at';  // Nama field created_at
    protected $updatedField  = 'updated_at';  // Nama field updated_at
    protected $deletedField  = 'deleted_at';  // Nama field deleted_at

    // Validasi
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
