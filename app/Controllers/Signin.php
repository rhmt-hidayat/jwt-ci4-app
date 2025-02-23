<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EmployeModel;
use Codeigniter\API\ResponseTrait;
use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

class Signin extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $EmployeModel = new EmployeModel();
        $Employe = $EmployeModel->where('email', $email)->first();
        if (!$Employe) {
            return $this->respond([
                'status' => false,
                'message' => 'Email tidak ditemukan',
            ], 401);
        }

        if (!password_verify($password, $Employe['password'])) {
            return $this->respond([
                'status' => false,
                'message' => 'Password salah',
            ], 401);    
        }

        //setting JWT
        $key = getenv('JWT_KEY');
        $iat = time(); //issu at
        $exp = $iat + (60 * 60); //expired token 1 jam
        $payload = [
            'iss' => 'jwt-ci4-app', //nama aplikasi
            'sub' => 'logintoken',
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $Employe['id'],
            'email' => $Employe['email'],
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        $response = [
            'status' => true,
            'message' => 'Login Berhasil',
            'token' => $token,
        ];
        
        return $this->respond($response, 200);
    }
}
