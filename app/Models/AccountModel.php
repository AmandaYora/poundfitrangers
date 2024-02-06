<?php namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'accounts';  // nama tabel
    protected $primaryKey = 'accountId';  // primary key tabel

    protected $returnType = 'array';  // tipe return
    protected $useSoftDeletes = true;  // apakah menggunakan soft deletes

    protected $allowedFields = ['username', 'email', 'password', 'role', 'deleted_at'];  // field yang diizinkan untuk diubah

    // Tidak menggunakan timestamp dalam tabel ini
    protected $useTimestamps = true;
    protected $createdField  = '';  // diisi jika ada field untuk created time
    protected $updatedField  = '';  // diisi jika ada field untuk updated time
    protected $deletedField  = 'deleted_at';  // diisi jika menggunakan soft deletes

    // Validasi
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
