<?php namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'classes';  // nama tabel
    protected $primaryKey = 'classId';  // primary key tabel

    protected $returnType = 'array';  // tipe return
    protected $useSoftDeletes = false;  // apakah menggunakan soft deletes

    protected $allowedFields = ['code', 'userId', 'location', 'date', 'capacity', 'status', 'price'];  // field yang diizinkan untuk diubah

    // tanggal otomatis diset oleh aplikasi, bukan oleh database
    protected $useTimestamps = false;
    protected $createdField  = '';  // diisi jika ada field untuk created time
    protected $updatedField  = '';  // diisi jika ada field untuk updated time
    protected $deletedField  = '';  // diisi jika menggunakan soft deletes

    // Validasi
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
