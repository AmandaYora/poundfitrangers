<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';  // Nama tabel
    protected $primaryKey = 'customerId';  // Nama kolom primary key

    protected $useAutoIncrement = true;  // Menggunakan auto-increment untuk primary key

    protected $returnType = 'array';  // Jenis data yang di-return

    protected $allowedFields = ['name', 'age', 'phone', 'email', 'bank', 'amount', 'file_transfer'];  // Kolom yang diizinkan untuk diisi data

    protected $useTimestamps = true;  // Menggunakan timestamp untuk kolom created_at dan updated_at
    protected $createdField  = 'created_at';  // Nama kolom untuk waktu pembuatan record baru
    protected $updatedField  = 'updated_at';  // Nama kolom untuk waktu update record

    // ... Anda bisa menambahkan metode lain sesuai kebutuhan
}
