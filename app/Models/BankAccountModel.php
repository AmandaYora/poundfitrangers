<?php namespace App\Models;

use CodeIgniter\Model;

class BankAccountModel extends Model
{
    protected $table = 'bank_account';  // nama tabel
    protected $primaryKey = 'bankId';  // primary key tabel

    protected $returnType = 'array';  // tipe return
    protected $useSoftDeletes = false;  // apakah menggunakan soft deletes

    protected $allowedFields = ['nama_rekening', 'nama_bank', 'nomor_rekening', 'userId'];  // field yang diizinkan untuk diubah

    // Tidak menggunakan timestamp dalam tabel ini
    protected $useTimestamps = false;
    protected $createdField  = '';  // diisi jika ada field untuk created time
    protected $updatedField  = '';  // diisi jika ada field untuk updated time
    protected $deletedField  = '';  // diisi jika menggunakan soft deletes

    // Validasi
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
