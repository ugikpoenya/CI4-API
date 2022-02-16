<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Home extends ResourceController
{
    public function index()
    {
        $data['message'] = 'Wellcome';
        return $this->respond($data);
    }
}
