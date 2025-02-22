<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Codeigniter\API\ResponseTrait; //tambahkan response trait
use App\Models\UserModel; //memanggil model user

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    use ResponseTrait;
    public function index()
    {
        //membuat validasi form input
        helper(['form']);
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());

        //membuat fungsi login
        $model = new UserModel();
        $user = $model->where('email', $this->request->getVar('email'))->first();
        if (!$user) {
            return $this->failNotFound('Email tidak ditemukan');
        }

        $verify = password_verify($this->request->getVar('password'), $user['password']);
        if (!$verify) {
            return $this->failUnauthorized('Password salah');
        }
        return $this->respond('Login berhasil');
        // return $this->respond($user, 200);

        //CARA LAIN
        // $email = $this->request->getVar('email');
        // $password = $this->request->getVar('password');
        // $model = new UserModel();
        // $data = $model->where('email', $email)->first();
        // if ($data) {
        //     $pass = $data['password'];
        //     $verify_pass = password_verify($password, $pass);
        //     if ($verify_pass) {
        //         $response = [
        //             'status' => 200,
        //             'error' => null,
        //             'data' => $data
        //         ];
        //         return $this->respond($response, 200);
        //     } else {
        //         $response = [
        //             'status' => 401,
        //             'error' => 'password salah',
        //             'data' => null
        //         ];
        //         return $this->respond($response, 401);
        //     }
        // } else {
        //     $response = [
        //         'status' => 401,
        //         'error' => 'email tidak ditemukan',
        //         'data' => null
        //     ];
        //     return $this->respond($response, 401);
        // }
    }
}
