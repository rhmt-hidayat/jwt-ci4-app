<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EmployeModel;
use Codeigniter\API\ResponseTrait;

class About extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $employeModel = new EmployeModel();

        return $this->respond([
            'karyawan' => $employeModel->findAll()
        ], 200);
    }
}
