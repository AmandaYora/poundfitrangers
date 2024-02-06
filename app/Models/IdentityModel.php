<?php

namespace App\Models;

use CodeIgniter\Model;

class IdentityModel extends Model
{
    protected $table = 'identity'; // Nama tabel
    protected $primaryKey = 'identity_id'; // Kunci utama tabel

    protected $useAutoIncrement = true; // Gunakan auto increment untuk primaryKey
    protected $returnType = 'array'; // Tipe data yang dikembalikan

    protected $allowedFields = [
        'attribute',
        'code',
        'value',
        'is_active',
        'description'
    ]; // Daftar field yang dapat diisi

    protected $useTimestamps = true; // Mengaktifkan penggunaan timestamps
    protected $createdField  = 'created_at'; // Field untuk 'created_at'
    protected $updatedField  = 'updated_at'; // Field untuk 'updated_at'

    protected $dateFormat = 'datetime'; // Format tanggal

    // Jika Anda ingin menambahkan validasi, tambahkan rules di sini
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getEmailConfig($code)
    {
        return $this->where('code', $code)->first();
    }

}