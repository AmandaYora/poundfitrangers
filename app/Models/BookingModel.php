<?php namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';  // nama tabel
    protected $primaryKey = 'bookingId';  // primary key tabel

    protected $returnType = 'array';  // tipe return
    protected $useSoftDeletes = true;  // mengaktifkan soft deletes

    protected $allowedFields = [
        'customerId', 'classId', 'status_booking', 
        'deleted_at', 'jumlah_orang', 'nama_tambahan'  // tambahkan 'jumlah_orang' di field yang diizinkan untuk diubah
    ];

    // tanggal otomatis diset oleh database
    protected $useTimestamps = true;  // mengaktifkan timestamps
    protected $createdField  = 'booking_date';
    protected $updatedField  = '';  // diisi jika ada field untuk updated time
    protected $deletedField  = 'deleted_at';  // diisi untuk menggunakan soft deletes

    // Validasi
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function countTotalPeopleByClassId($classId)
    {
        $result = $this->selectSum('jumlah_orang')
                       ->where('classId', $classId)
                       ->where('status_booking !=', 'reject')
                       ->first();

        return $result['jumlah_orang'] ?? 0;
    }
}
