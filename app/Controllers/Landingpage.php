<?php

namespace App\Controllers;

use App\Models\IdentityModel;
use App\Models\ClassModel;

class Landingpage extends BaseController
{
    protected $identityModel;

    public function __construct()
    {
        $this->identityModel = new IdentityModel();
    }

    public function index()
    {
        // Mengecek apakah parameter 'id' ada di query string
        $request = \Config\Services::request();
        $id = $request->getGet('id');

        if ($id === null) {
            // Redirect jika 'id' tidak ditemukan
            return redirect()->to('/auth');
        }

        $classModel = new ClassModel();

        $classData = $classModel->where('code', $id)->first();

        if (empty($classData)) {
            return redirect()->to('/auth');
        }

        // Jika 'id' ada, lanjutkan dengan logika yang ada
        $data['code'] = $id;
        $data['identities'] = $this->identityModel->findAll();
        return view('users/landingpage', $data);
    }


    public function createIdentity()
    {
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();

            if ($this->identityModel->save($data)) {
                session()->setFlashdata('success', 'Identity created successfully.');
            } else {
                session()->setFlashdata('error', 'Failed to create identity.');
            }

        }

        return redirect()->to('/setting');
    }

    public function updateIdentity($id)
    {
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $file = $this->request->getFile('valueFile');
    
            // Check if the file is uploaded and valid
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Determine the destination folder and file name
                $newName = $file->getRandomName();
                
                // Specify the correct path for assets/uploads
                $targetPath = FCPATH . 'uploads/'; // Adjust this path as needed
    
                // Move the file to the target path
                $file->move($targetPath, $newName);
    
                // Add the file path to the data array
                $data['value'] = $newName; // Adjust this path as needed
            }
    
            // Update identity data
            if ($this->identityModel->update($id, $data)) {
                session()->setFlashdata('success', 'Identity updated successfully.');
            } else {
                session()->setFlashdata('error', 'Failed to update identity.');
            }
        }
    
        return redirect()->to('/setting'); // Redirect to the settings page
    }
    
    

    public function deleteIdentity($id)
    {
        if ($this->identityModel->delete($id)) {
            session()->setFlashdata('success', 'Identity deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete identity.');
        }

        return redirect()->to('/setting'); // Redirect ke halaman setting
    }
}
