<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Codeigniter\API\ResponseTrait; //tambahkan response trait
use App\Models\UserModel; //memanggil model user
use Firebase\JWT\JWT; //memanggil library jwt
use Firebase\JWT\Key;

class Profil extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    use ResponseTrait;
    public function index()
    {
        //memanggil token JWT
        $key = getenv('JWT_KEY');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if(!$header) return $this->failUnauthorized('Token Required');
        // $token = str_replace('Bearer ', '', $header);
        $token = explode(' ', $header)[1];

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $response = [
                'id' => $decoded->uid,
                'email' => $decoded->email
            ];
            return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail('Token Invalid');
        }
        // } catch (\UnexpectedValueException $e) {
        //     return $this->failUnauthorized('Token Invalid');
        // } catch (\DomainException $e) {
        //     return $this->failUnauthorized('Token Expired');
        // }
    }
}
