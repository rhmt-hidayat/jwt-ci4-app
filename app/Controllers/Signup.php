<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EmployeModel;
use Codeigniter\API\ResponseTrait;

class Signup extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[employes.email]',
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
            ]
        ];

        if($this->validate($rules)){
            $EmployeModel = new EmployeModel();
            $data = [
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            ];

            $EmployeModel->save($data);
            return $this->respond([
                'status' => true,
                'message' => 'Register Berhasil'
            ], 200);
        } else {
            $response = [
                'status' => false,
                'error' => $this->validator->getErrors(),
                'message' => 'Register Gagal'
            ];
            // return $this->respond($response, ResponseInterface::HTTP_BAD_REQUEST);
            return $this->respond($response, 422);
        }
    }
}
