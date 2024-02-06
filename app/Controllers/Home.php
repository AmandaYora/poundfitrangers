<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\UserModel;
use App\Models\ClassModel;
use App\Models\BookingModel;
use App\Models\BankAccountModel;

class Home extends BaseController
{
    public function index()
    {
        $request = \Config\Services::request();
        $code = $request->getGet('id');

        if ($code === null) {
            // Redirect jika 'id' tidak ditemukan
            return redirect()->to('/auth');
        }

        $classModel = new ClassModel();
        $bookingModel = new BookingModel();
        $bankModel = new BankAccountModel();

        $classData = $classModel->where('code', $code)->first();

        if (empty($classData)) {
            return redirect()->to('/auth');
        }

        $classId = $classData['classId'] ?? null;
        $userId = $classData['userId'] ?? null;
        $status = $classData['status'] ?? null;
        $capacity = $classData['capacity'] ?? null;
        $price = isset($classData['price']) ? (int)$classData['price'] : null;

        $totalPeople = $bookingModel->countTotalPeopleByClassId($classId);
        $kodeunik = $bookingModel->where('classId', $classId)
                    ->where('status_booking !=', 'reject')
                    ->countAllResults();

        if ($totalPeople == 0) {
            $countBooking = $bookingModel->where('classId', $classId)
                             ->where('status_booking !=', 'reject')
                             ->countAllResults();
        }else{
            $countBooking = $totalPeople;
        }
        

        $total = $kodeunik + 1;

        $bankData = $bankModel->where('userId', $userId)->findAll();

        if ($countBooking >= (int)$capacity) {
            $capacityFull = true;
        }else{
            $capacityFull = false;
        }

        $dateNow = date('Y-m-d');
        $dateClass = $classData['date'];
        if ($dateNow >= $dateClass) {
            $expired = true;
        } else {
            $expired = false;
        }
        
        $data['kodeunik'] =  $total;
        $data['harga'] = $price;
        $data['affiliate'] = $code;
        $data['bank'] = $bankData;
        $data['status'] = $status;
        $data['capacity'] = $capacity;
        $data['isFull'] = $capacityFull;
        $data['is_expired'] = $expired;

        return view('users/form', $data);
    }

    public function uploadData()
    {
        $customerModel = new CustomerModel();
        $bookingModel = new BookingModel();
        $classModel = new ClassModel();

        $response = [
            'info' => 'error',
            'message' => 'Gagal menambahkan data',
            'data' => null
        ];
    
        if ($this->request->getMethod() == 'post') {
    
            $namaLengkap = $this->request->getPost('namaLengkap');
            $umur = $this->request->getPost('umur');
            $nomorHp = $this->request->getPost('nomorHp');
            $jumlahOrang = $this->request->getPost('jumlahOrang');
            $email = $this->request->getPost('email');
            $bankTujuan = $this->request->getPost('bankTujuan');
            $nominalTransfer = $this->request->getPost('nominalTransfer');
            $code = $this->request->getPost('affiliate');
            $file = $this->request->getFile('lampiranFile');
            $namaTambahan = $this->request->getPost('namaTambahan');


            $classData = $classModel->where('code', $code)->first();
            $classId = $classData['classId'] ?? null;
    
            $countBooking = $bookingModel->countTotalPeopleByClassId($classId);
    
            if ($countBooking >= (int)$classData['capacity']) {
                $response['info'] = 'error';
                $response['message'] = 'Capacity Full';
                return $this->response->setJSON($response);
            }
    
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $tempPath = $file->getTempName();
                $imgInfo = getimagesize($tempPath);
                $mime = $imgInfo['mime'];
    
                // Cek tipe MIME untuk menentukan jenis gambar
                switch ($mime) {
                    case 'image/jpeg':
                        $imageResource = imagecreatefromjpeg($tempPath);
                        break;
                    case 'image/png':
                        $imageResource = imagecreatefrompng($tempPath);
                        break;
                    case 'image/gif':
                        $imageResource = imagecreatefromgif($tempPath);
                        break;
                    default:
                        $imageResource = false;
                        break;
                }
    
                if ($imageResource !== false) {
                    // Kompresi gambar ke direktori 'uploads'
                    $uploadPath = 'uploads/' . $newName;
                    imagejpeg($imageResource, $uploadPath, 10); // Angka 10 untuk kualitas sangat rendah dan ukuran file kecil
                    imagedestroy($imageResource); // Hapus resource gambar dari memori
    
                    $dataToInsert = [
                        'name' => $namaLengkap,
                        'age' => $umur,
                        'phone' => $nomorHp,
                        'email' => $email,
                        'bank' => $bankTujuan,
                        'amount' => $nominalTransfer,
                        'file_transfer' => $newName
                    ];
    
                    if ($customerModel->insert($dataToInsert)) {
                        $customerId = $customerModel->insertID();
                        $classData = $classModel->where('code', $code)->first();
                        $classId = $classData['classId'] ?? null;
    
                        if ($classId !== null) {
                            $bookingData = [
                                'customerId' => $customerId,
                                'classId' => $classId,
                                'jumlah_orang' => $jumlahOrang,
                                'nama_tambahan' => $namaTambahan,
                                'status_booking' => 'pending'
                            ];

                            $bodyMessage = "Booking anda dengan nama *{$namaLengkap}* dengan nominal *Rp. {$nominalTransfer}* untuk *{$jumlahOrang} Orang* sudah tercatat dalam sistem kami dan sedang di proses mohon tunggu untuk dapat email selanjutnya max 3 x 24 jam. \n\n _pesan tidak untuk di balas_";
                            $bMessage = "Booking anda dengan nama <b>{$namaLengkap}</b> dengan nominal <b>Rp. {$nominalTransfer}</b> untuk <b>{$jumlahOrang} Orang</b> sudah tercatat dalam sistem kami dan sedang di proses mohon tunggu untuk dapat email selanjutnya max 3 x 24 jam.";

                            if ($bookingModel->insert($bookingData)) {
                                $emailDetails = [
                                    'targetEmail' => $email,
                                    'subject' => 'Kelas Olahraga',
                                    'messageContent' => $this->generateHtml('Pemberitahuan',$bMessage),
                                    'isHtml' => true
                                ];

                                $whatsappDetail = [
                                    'target' => $nomorHp,
                                    'message' => $bodyMessage,
                                    //'filename' => 'namafile.pdf' 
                                ];

                                //var_dump($this->sendWhatsApp($whatsappDetail)); die;

                                if ($this->sendEmail($emailDetails)) {
                                    $this->sendWhatsApp($whatsappDetail);
                                    
                                    $identityModel = new \App\Models\IdentityModel();
                                    $nope = $identityModel->getEmailConfig('phone_pribadi')['value'] ?? env('whatsapp.TOKEN');

                                    $whatsappDetail2 = [
                                        'target' => $nope,
                                        'message' => "Ada customer daftar class baru dengan nominal Rp. {$nominalTransfer} untuk *{$jumlahOrang} Orang* sudah masuk ke sistem, mohon dicek dan dikonfirmasi melalui website. \n\n _tidak untuk di balas_",
                                        //'filename' => 'namafile.pdf' 
                                    ];
                                    usleep(1200000);
                                    $this->sendWhatsApp($whatsappDetail2);

                                    $response['info'] = 'success';
                                    $response['message'] = 'Data berhasil di tambahkan';
                                    $response['data'] = $dataToInsert;
                                    $response['booking'] = $bookingData; 
                                }else{
                                    $response['info'] = 'error';
                                    $response['message'] = 'Email dan Whatsapp gagal dikirim';
                                    $response['data'] = $dataToInsert;
                                    $response['booking'] = $bookingData; 
                                }
                            } else {
                                $response['info'] = 'error';
                                $response['message'] = 'Gagal menambahkan data booking ke database';
                            }
                        } else {
                            $response['info'] = 'error';
                            $response['message'] = 'Class Tidak tersedia';
                        }
                    } else {
                        $response['info'] = 'error';
                        $response['message'] = 'Gagal menambahkan data ke database';
                    }
                } else {
                    $response['info'] = 'error';
                    $response['message'] = 'Format file tidak didukung untuk kompresi atau file tidak valid';
                }
            } else {
                $response['info'] = 'error';
                $response['message'] = 'Gagal mengunggah file';
            }
        } else {
            $response['info'] = 'error';
            $response['message'] = 'Invalid request method';
        }
        
        header('Content-Type: application/json');
        return $this->response->setJSON($response);
    }
}