<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    // public function sendEmail($emailDetails)
    // {
    //     $email = \Config\Services::email();
        
    //     // Memuat variabel dari .env
    //     $senderEmail = env('email.SMTPUser');
    //     $senderName = env('email.SENDER_NAME');
    
    //     // Mengeset detail email
    //     $email->setFrom($senderEmail, $senderName);
    //     $email->setTo($emailDetails['targetEmail']);
    //     $email->setSubject($emailDetails['subject']);
    //     if ($emailDetails['isHtml'] == true) {
    //         $email->setMailType('html');
    //     }
    //     $email->setMessage($emailDetails['messageContent']);

    //     if (isset($emailDetails['attachments'])) {
    //         foreach ($emailDetails['attachments'] as $attachment) {
    //             $email->attach($attachment);
    //         }
    //     }
        
    //     // Mengirim email
    //     if ($email->send()) {
    //         return true;
    //     } else {
    //         $data = $email->printDebugger(['headers']);
    //         print_r($data);
    //         return false;
    //     }
    // }

    public function sendEmail($emailDetails)
    {
        $identityModel = new \App\Models\IdentityModel();
        
        // Ambil konfigurasi dari database, gunakan nilai default jika null
        $smtpUser = $identityModel->getEmailConfig('email')['value'] ?? env('email.SMTPUser');
        $smtpPass = $identityModel->getEmailConfig('pass_email')['value'] ?? env('email.SMTPPass');
        $senderName = $emailDetails['senderName'] ?? env('email.SENDER_NAME');
    
        $email = \Config\Services::email();
    
        // // Mengeset konfigurasi email secara dinamis
        $config = [
            'SMTPUser' => $smtpUser,
            'SMTPPass' => $smtpPass,
            // Tambahkan konfigurasi lain jika diperlukan
        ];
        $email->initialize($config);
    
        // Set up the email details
        $email->setFrom($smtpUser, $senderName);
        $email->setTo($emailDetails['targetEmail']);
        $email->setSubject($emailDetails['subject']);
        if ($emailDetails['isHtml'] == true) {
            $email->setMailType('html');
        }
        $email->setMessage($emailDetails['messageContent']);
    
        // Handle attachments
        if (isset($emailDetails['attachments'])) {
            foreach ($emailDetails['attachments'] as $attachment) {
                $email->attach($attachment);
            }
        }
    
        // Send the email
        if ($email->send()) {
            return true;
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
            return false;
        }
    }
    


    function sendWhatsApp($params) {
        $identityModel = new \App\Models\IdentityModel();
        
        // Ambil konfigurasi dari database, gunakan nilai default jika null
        $tokenWhatsapp = $identityModel->getEmailConfig('token_wa')['value'] ?? env('whatsapp.TOKEN');

        $postData = [
            'target' => $params['target'],
            'message' => $params['message'],
            'countryCode' => '62'
        ];
    
        if (isset($params['filename'])) {
            $postData['filename'] = $params['filename'];
        }
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                "Authorization: " . $tokenWhatsapp
            ],
        ]);
    
        $response = curl_exec($curl);
        curl_close($curl);
    
        return $response;
    }
    
    public function generateHtml($title, $isi)
    {
        return '<html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            padding: 20px;
                            background-color: #f2f2f2;
                        }
                        .container {
                            background-color: #fff;
                            padding: 20px;
                            border-radius: 8px;
                            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                        }
                        .header {
                            font-size: 24px;
                            font-weight: bold;
                            margin-bottom: 20px;
                        }
                        .content {
                            font-size: 16px;
                            line-height: 1.6;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="header">
                            '.$title.'
                        </div>
                        <div class="content">
                            '.$isi.'
                        </div>
                    </div>
                </body>
            </html>';
    }

    public function generatePdf(array $data)
    {
        // Instansiasi Options dan Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
        
        // Buat konten HTML untuk PDF
        $html = "<html><head><style>
                    body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
                    .container { background-color: #fff; margin: 20px auto; padding: 40px; width: 80%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
                    h1 { text-align: center; font-size: 36px; color: #333; margin-bottom: 20px; }
                    h2 { text-align: center; font-size: 28px; margin: 20px 0; }
                    p { font-size: 18px; color: #666; line-height: 1.5; }
                    .footer { text-align: center; font-style: italic; font-size: 16px; margin-top: 30px; }
                </style></head><body>";
                
        $html .= "<div class='container'>";
        if ($data['status'] == 'accept') {
            $html .= "<h1>Bukti Pembayaran</h1>";
            $html .= "<p>Terima kasih, Bapak/Ibu <strong>{$data['nama']}</strong>. Kami telah menerima pembayaran Anda sebesar:</p>";
            $html .= "<h2>Rp. " . number_format((int)str_replace(',', '', $data['nominal']), 0, ',', '.') . "</h2>";
            $html .= "<p>Transaksi ini dilakukan pada <strong>{$data['tanggal_transfer']}</strong> dan ditujukan untuk kegiatan Kelas PoundFit yang akan diselenggarakan pada tanggal <strong>{$data['tanggal_kegiatan']}</strong>.</p>";
            $html .= "<p class='footer'>Mohon simpan dan tunjukkan bukti ini saat hadir di kelas.</p>";
        } elseif ($data['status'] == 'reject') {
            $html .= "<h1>Pemberitahuan Penolakan Pembayaran</h1>";
            $html .= "<p>Maaf, Bapak/Ibu <strong>{$data['nama']}</strong>. Nominal yang Anda transfer tidak sesuai dengan bukti transfer.</p>";
            $html .= "<p>Untuk penanganan lebih lanjut, harap hubungi kami.</p>";
            $html .= "<p class='footer'>Terima kasih.</p>";
        }
        
        $html .= "</div>";
        $html .= "</body></html>";
        
        // Load HTML content
        $dompdf->loadHtml($html);
        
        // Atur ukuran kertas dan orientasi
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF (konversi HTML ke PDF)
        $dompdf->render();
        
        // Output PDF ke file sementara
        $status = $data['status'] == 'accept' ? 'bukti_pembayaran' : 'pemberitahuan_penolakan';
        $outputPath = sys_get_temp_dir() . "/{$status}_{$data['nama']}.pdf";
        file_put_contents($outputPath, $dompdf->output());
        
        return $outputPath;
    }
}
