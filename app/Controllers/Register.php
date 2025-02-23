<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Codeigniter\API\ResponseTrait; //tambahkan response trait
use App\Models\UserModel; //memanggil model user

class Register extends ResourceController
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
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confpassword' => 'matches[password]'
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());

        //membuat fungsi register
        $data = [
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
        ];
        $model = new UserModel();
        // $model->save($data);
        // return $this->respondCreated($data);
        $registered = $model->save($data);
        $this->respondCreated($registered);
        $this->respond(message: 'Register Berhasil');
    }
}
