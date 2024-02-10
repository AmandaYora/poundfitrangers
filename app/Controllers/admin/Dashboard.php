<?php

namespace App\Controllers\Admin;

use App\Models\CustomerModel;
use App\Models\BookingModel;
use App\Models\ClassModel;
use App\Models\BankAccountModel;
use App\Models\UserModel;
use App\Models\AccountModel;
use App\Models\IdentityModel;
use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class Dashboard extends BaseController
{
    private $isLoggedIn;
    private $accountId;
    private $userId;
    private $username;
    private $email;
    private $role;

    public function __construct()
    {
        // Panggil semua session
        $this->isLoggedIn = session()->get('isLoggedIn');
        $this->accountId = session()->get('accountId');
        $this->userId = session()->get('userId');
        $this->username = session()->get('username');
        $this->email = session()->get('email');
        $this->role = session()->get('role');
        
        // Cek apakah pengguna sudah login atau tidak
        if (!$this->isLoggedIn) {
            header('location: /auth');
            exit(); 
        }
    }

    public function index()
    {
        $data['active_page'] = 'dashboard';
        $data['username'] = $this->username;
        $data['role'] = $this->role;
    
        $customerModel = new CustomerModel();
        $classModel = new ClassModel();
        $bookingModel = new BookingModel();

        $currentYear = date("Y");
        $currentMonth = date("m");

        if ($this->role == 'admin') {
            $data['nominal'] = $bookingModel
                                ->select('SUM(customers.amount) as totalAmount')
                                ->join('customers', 'customers.customerId = bookings.customerId')
                                ->join('classes', 'bookings.classId = classes.classId')
                                ->where("DATE_FORMAT(classes.date, '%Y-%m') = ", $currentYear . '-' . $currentMonth)
                                ->first();

            $data['user'] = $bookingModel
                    ->select('SUM(jumlah_orang) as totalPeople')
                    ->where("DATE_FORMAT(booking_date, '%Y-%m') = ", $currentYear . '-' . $currentMonth)
                    ->where('status_booking', 'accept')
                    ->first();

            $data['jumlahClass'] = $classModel
                    ->select('COUNT(*) as totalClasses')
                    ->where("DATE_FORMAT(date, '%Y-%m') = ", $currentYear . '-' . $currentMonth)
                    ->first();
        } else {
            $data['nominal'] = $bookingModel
                                ->select('SUM(customers.amount) as totalAmount')
                                ->join('customers', 'customers.customerId = bookings.customerId')
                                ->join('classes', 'bookings.classId = classes.classId')
                                ->where('classes.userId', $this->userId)
                                ->where("DATE_FORMAT(classes.date, '%Y-%m') = ", $currentYear . '-' . $currentMonth)
                                ->where('status_booking', 'accept')
                                ->first();

             $data['user'] = $bookingModel
                            ->select('SUM(bookings.jumlah_orang) as totalPeople')
                            ->join('customers', 'customers.customerId = bookings.customerId')
                            ->join('classes', 'bookings.classId = classes.classId')
                            ->where('classes.userId', $this->userId)
                            ->where("DATE_FORMAT(bookings.booking_date, '%Y-%m') = ", $currentYear . '-' . $currentMonth)
                            ->first();

            $data['jumlahClass'] = $classModel
                            ->select('COUNT(*) as totalClasses')
                            ->where('userId', $this->userId)
                            ->where("DATE_FORMAT(date, '%Y-%m') = ", $currentYear . '-' . $currentMonth)
                            ->first();
        }



        $totalAmount = $data['nominal']['totalAmount'];
        $data['nominal'] = 'Rp. ' . number_format($totalAmount, 0, ',', '.');
        $data['people'] = $data['user']['totalPeople'] ?? 0;
        $data['customerCount'] = $this->countCurrentMonthRecords($customerModel);  
        $data['classCount'] = $this->countCurrentMonthClasses($classModel);
        
        $data['jumlahClass'] = $data['jumlahClass']['totalClasses'];
    
        echo view('templates/Header', $data);
        echo view('admin/Dashboard', $data);
        echo view('templates/Footer');
    }

    public function identity()
    {
        $data['active_page'] = 'identity';
        $data['username'] = $this->username;
        $data['role'] = $this->role;
    
        $identity = new IdentityModel();
        
        $data['identity'] = $identity->findAll();
    
        echo view('templates/Header', $data);
        echo view('admin/Landingpage', $data);
        echo view('templates/Footer');
    }
    
    public function countCurrentMonthRecords($model)
    {
        $startOfMonth = date('Y-m-01'); 
        $endOfMonth = date('Y-m-t');  
    
        return $model->where('created_at >=', $startOfMonth)
                     ->where('created_at <=', $endOfMonth)
                     ->countAllResults();
    }
    
    public function countCurrentMonthClasses($model)
    {
        $startOfMonth = date('Y-m-01'); 
        $endOfMonth = date('Y-m-t'); 
    
        return $model->where('date >=', $startOfMonth)
                     ->where('date <=', $endOfMonth)
                     ->countAllResults();
    }    

    public function class()
    {
        $classModel = new ClassModel();

        // Generate new code
        $year = date("Y");  // Tahun ini
        
        $query = $classModel->selectMax('code')
                            ->like('code', "D{$year}", 'after')  // Memfilter berdasarkan tahun ini
                            ->get();
        
        $lastCode = $query->getRowArray();
        $lastCode = $lastCode['code'];
        
        if ($lastCode) {
            $number = (int) substr($lastCode, -4);  // Mengambil 4 digit terakhir dari kode
            $number++;
        } else {
            $number = 1; // Jika tidak ada data, mulai dari 0001
        }
        
        $newCode = "D{$year}" . str_pad($number, 4, '0', STR_PAD_LEFT);  // Membuat kode baru
        
        if ($this->role == 'admin') {
            $data['class'] = $classModel->select('classes.*, users.name as pemilik')
                                        ->orderBy("CASE WHEN status = 'open' THEN 1 ELSE 2 END, classId DESC")
                                        ->join('users', 'classes.userId = users.userId', 'left')
                                        ->findAll();
        } else {
            $data['class'] = $classModel->select('classes.*, users.name as pemilik')
                                        ->where('userId', $this->userId)
                                        ->orderBy("CASE WHEN status = 'open' THEN 1 ELSE 2 END, classId DESC")
                                        ->findAll();
        }        
    
        $data['active_page'] = 'open_class';
        $data['username'] = $this->username;
        $data['role'] = $this->role;
        $data['userId'] = $this->userId;
        $data['code'] = $newCode;
    
        echo view('templates/Header', $data);
        echo view('admin/Class', $data); 
        echo view('templates/Footer');
    }
    
    

    public function booking()
    {   
        $bookingModel = new BookingModel();

        $bookingModel->orderBy('CAST(customers.amount AS UNSIGNED)', 'ASC');
        $bookingModel->join('customers', 'customers.customerId = bookings.customerId');
        $bookingModel->join('classes', 'classes.classId = bookings.classId');
        $bookingModel->where('bookings.deleted_at', null);

        if ($this->role == 'admin') {
            $data['bookings'] = $bookingModel
                ->select('bookings.*, customers.*, classes.*, users.name as pemilik, users.userId')
                ->join('users', 'classes.userId = users.userId', 'left')
                ->findAll();
        } else {
            $data['bookings'] = $bookingModel
                ->select('bookings.*, customers.*, classes.*, users.name as pemilik, users.userId')
                ->join('users', 'classes.userId = users.userId', 'left')
                ->where('classes.userId', $this->userId)->findAll();
        }  

        $uniqueCodeModel = new BookingModel();

        $uniqueCodes = $uniqueCodeModel->join('classes', 'classes.classId = bookings.classId')
                               ->groupBy('classes.code')
                               ->findAll();

        $data['uniqueCodes'] = $uniqueCodes;

        $data['active_page'] = 'booking';
        $data['username'] = $this->username;
        $data['role'] = $this->role;

        echo view('templates/Header', $data);
        echo view('admin/Booking', $data); 
        echo view('templates/Footer');
    }

    public function deleteBooking($bookingId)
    {
        $bookingModel = new BookingModel();
        // Melakukan soft delete
        if ($bookingModel->delete($bookingId)) {
            // Jika berhasil, set flashdata untuk sukses
            session()->setFlashdata('success', 'Booking berhasil dihapus.');
        } else {
            // Jika gagal, set flashdata untuk error
            session()->setFlashdata('error', 'Gagal menghapus booking.');
        }

        // Redirect ke halaman yang diinginkan setelah penghapusan
        return redirect()->to('/booking'); // Sesuaikan dengan URL tujuan Anda
    }

    public function action_booking()
    {
        $response = [
            'info' => 'error',
            'message' => 'Gagal mengubah status',
            'data' => null
        ];

        if ($this->request->getMethod() == 'post') {

            $bookingModel = new BookingModel();
            $customerModel = new CustomerModel();

            $bookingId = (int)$this->request->getPost('bookingId');
            $customerId = (int)$this->request->getPost('customerId');
            $status = $this->request->getPost('status');

            // Mengambil data dari BookingModel berdasarkan bookingId
            $bookingData = $bookingModel->find($bookingId);
            $bookingDate = $bookingData['booking_date'] ?? null;

            // Mengambil data dari CustomerModel berdasarkan customerId
            $customerData = $customerModel->find($customerId);
            $customerName = $customerData['name'] ?? null;
            $customerPhone = $customerData['phone'] ?? null;
            $customerAmount = $customerData['amount'] ?? null;
            $customerEmail = $customerData['email'] ?? null;
            $customerCreatedAt = $customerData['created_at'] ?? null;

            $dataPdf = [
                'nama' => $customerName,
                'nominal' => $customerAmount,
                'tanggal_transfer' => $customerCreatedAt,
                'tanggal_kegiatan' => $bookingDate,
                'status' => $status
            ];

            $pdfPath = $this->generatePdf($dataPdf);

            $emailDetails = [
                'targetEmail' => $customerEmail,
                'subject' => 'Kelas PoundFit',
                'messageContent' => $this->generateHtml('Pemberitahuan','Harap disimpan berkas yang kami lampirkan'),
                'isHtml' => true,
                'attachments' => [$pdfPath]
            ];

            $bodyMessageWa = "Kepada Yth. *{$customerName}*, kami informasikan bahwa registrasi Anda telah kami *{$status}*. Sebagai konfirmasi, dokumen terkait telah kami kirim ke alamat email Anda: *{$customerEmail}*. Mohon periksa inbox email tersebut untuk mengunduh dokumen yang tersedia. Terima kasih atas perhatian dan kerjasama Anda.";

            $whatsappDetail = [
                'target' => $customerPhone,
                'message' => $bodyMessageWa,
                'filename' => $pdfPath 
            ];
            //var_dump($this->sendWhatsApp($whatsappDetail)); die;


            $updateData = ['status_booking' => $status];
            $result = $bookingModel->update($bookingId, $updateData);

            if ($result) {
                
                if ($this->sendEmail($emailDetails) && $this->sendWhatsApp($whatsappDetail)) {
                    $response = [
                        'info' => 'success',
                        'message' => 'Berhasil mengubah status menjadi '.$status,
                        'data' => $bookingModel->find($bookingId)  // Menampilkan data booking yang telah diupdate
                    ];
                } else {
                    $response = [
                        'info' => 'error',
                        'message' => 'Email gagal dikirim',
                        'data' => null  // Menampilkan data booking yang telah diupdate
                    ];
                }
                
            }else{
                $response = [
                    'info' => 'error',
                    'message' => 'Gagal mengubah status',
                    'data' => null  
                ];
            }
        }

        return $this->response->setJSON($response);
    }

    public function affiliate()
    {
        $affiliateModel = new UserModel();
    
        $affiliateModel->where('users.deleted_at', null);
    
        $affiliateModel->join('accounts', 'users.accountId = accounts.accountId');
    
        $data['affiliate'] = $affiliateModel->findAll();
    
        $data['active_page'] = 'affiliate';
        $data['username'] = $this->username;
        $data['role'] = $this->role;
    
        echo view('templates/Header', $data);
        echo view('admin/Affiliate');  // Pastikan Anda memiliki view ini
        echo view('templates/Footer');
    }
    

    public function customers()
    {
        $customerModel = new CustomerModel();
        $allCustomers = $customerModel->findAll();

        $uniqueCustomers = [];
        $seen = [];
        foreach ($allCustomers as $customer) {
            $uniqueKey = $customer['email'] . $customer['phone'];  
            if (!isset($seen[$uniqueKey])) {
                $uniqueCustomers[] = $customer;
                $seen[$uniqueKey] = true;
            }
        }

        $data['customers'] = $uniqueCustomers;

        $data['active_page'] = 'customers';
        $data['username'] = $this->username;
        $data['role'] = $this->role;

        echo view('templates/Header', $data);
        echo view('admin/Customers', $data);  
        echo view('templates/Footer');
    }

    public function bank()
    {
        $bankModel = new BankAccountModel();

        $data['bank'] = $bankModel->where('userId', $this->userId)->findAll();

        $data['active_page'] = 'bank';
        $data['username'] = $this->username;
        $data['role'] = $this->role;
        $data['userId'] = $this->userId;

        echo view('templates/Header', $data);
        echo view('admin/Bank');  // Pastikan Anda memiliki view ini
        echo view('templates/Footer');
    }

    public function logout()
    {
        // Hapus semua data session
        session()->destroy();
        
        header('location: /auth');
        exit();
    }

    public function downloadPdf()
    {
        // Ambil code dari request AJAX
        $code = $this->request->getVar('code');

        // Contoh cara mendapatkan data dari database
        $bookingModel = new BookingModel();
        $bookingModel->join('customers', 'customers.customerId = bookings.customerId');
        $bookingModel->join('classes', 'classes.classId = bookings.classId');
        $bookings = $bookingModel->where('code', $code)->orderBy('amount', 'ASC')->findAll();

        // HTML dengan desain lebih profesional
        $html = <<<HTML
        <html>
            <head>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                    }
                    .header {
                        text-align: center;
                        border-bottom: 2px solid #000;
                        padding-bottom: 10px;
                        margin-bottom: 20px;
                    }
                    .header h1 {
                        margin: 0;
                        font-size: 24px;
                    }
                    .header p {
                        margin: 5px 0;
                        font-size: 18px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ccc;
                        padding: 10px;
                        text-align: left;
                        font-size: 12px;
                    }
                    th {
                        background-color: #4CAF50;
                        color: white;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Daftar Peserta Class PoundFit</h1>
                    <p>Code: {$code}</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Phone</th>
                            <th>Age</th>
                            <th>Jumlah</th>
                            <th>Nama Tambahan</th>
                            <th>Amount</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
    HTML;

        $no = 1;
        foreach ($bookings as $booking) {
            $html .= <<<HTML
                        <tr>
                            <td>{$no}</td>
                            <td>{$booking['name']}</td>
                            <td>{$booking['phone']}</td>
                            <td>{$booking['age']}</td>
                            <td>{$booking['jumlah_orang']}</td>
                            <td><textarea rows="3"
                                readonly>{$booking['nama_tambahan']}</textarea>
                            </td>
                            <td>{$booking['amount']}</td>
                            <td>{$booking['created_at']}</td>
                        </tr>
    HTML;
            $no++;
        }

        $html .= <<<HTML
                    </tbody>
                </table>
            </body>
        </html>
    HTML;

        // Initialize Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF
        $dompdf->render();

        // Output sebagai string
        $output = $dompdf->output();

        // Kirim output sebagai base64 dalam format JSON
        return $this->response->setJSON(['pdf' => base64_encode($output)]);

    }

}