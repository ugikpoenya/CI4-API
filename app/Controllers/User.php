<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class User extends ResourceController
{

    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $token = $this->request->getServer('HTTP_AUTHORIZATION');
        if ($token) {
            try {
                $payload = JWT::decode($token, new Key($key, 'HS256'));
                $data['payload'] = $payload;
                return $this->respond($data);
            } catch (\Throwable $th) {
                return $this->failUnauthorized($th->getMessage());
            }
        }
        return $this->failUnauthorized('Token Required');
    }

    public function login()
    {
        $user = $this->usersModel->where('email', $this->request->getVar('email'))->first();
        if ($user) {
            if (password_verify($this->request->getVar('password'), $user->password)) {
                $key = getenv('TOKEN_SECRET');
                $payload = array(
                    "iat" => strtotime('now'),
                    "nbf" => strtotime('now'),
                    "exp" => strtotime(date("Y-m-d") . ' 24:00:00'),
                    "jti" => 'login',
                    "uid" => $user->user_id,
                    "email" => $user->email,
                );
                $data['message'] = 'Login successfully';
                $data['token'] = JWT::encode($payload, $key, 'HS256');
                return $this->respond($data);
            }
            return $this->fail('Wrong Password');
        }
        return $this->failNotFound('Email Not Found');
    }
}
