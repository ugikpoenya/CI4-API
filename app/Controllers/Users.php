<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        return $this->respond($this->usersModel->findAll());
    }

    public function show($id = null)
    {
        if ($found = $this->usersModel->find($id)) {
            return $this->respond($found);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    public function create()
    {
        if ($this->usersModel->save($this->request->getVar())) {
            return $this->respond(['message' => "Saved successfully"]);
        }
        return $this->fail($this->usersModel->errors());
    }


    public function update($id = null)
    {
        if ($id == 1)  return $this->failUnauthorized('Access denied');
        if ($this->usersModel->find($id)) {
            if ($this->usersModel->update($id, $this->request->getVar())) {
                return $this->respond(['message' => "Updated successfully"]);
            } else {
                return $this->fail($this->usersModel->errors());
            }
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    public function delete($id = null)
    {
        if($id==1)  return $this->failUnauthorized('Access denied');
        
        if ($this->usersModel->find($id)) {
            if ($this->usersModel->delete($id)) {
                return $this->respond(['message' => "Successfully deleted"]);
            }
            return $this->fail('Failed to deleted', 422);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
