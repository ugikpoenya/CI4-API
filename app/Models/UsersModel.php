<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'full_name',
        'email',
        'phone',
        'password',

        'level',
        'status',
        'image',

        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',

        'restored_at',
        'restored_by',
        'verified_at',
        'verified_by',
        'approved_at',
        'approved_by',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'full_name'         => ['label' => 'Full Name', 'rules' => 'required|min_length[3]|max_length[255]'],
        'email'             => ['label' => 'Email', 'rules' => 'required|max_length[255]|valid_email|is_unique[users.email,user_id,{user_id}]'],
        'level'             => ['label' => 'Level', 'rules' => 'required|min_length[3]|max_length[25]'],
        'status'            => ['label' => 'Status', 'rules' => 'required|min_length[3]|max_length[25]'],
        'password'          => ['label' => 'Password', 'rules' => 'required|min_length[5]|max_length[25]'],
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function beforeInsert(array $data)
    {
        if ((isset($data['data']['password'])) && (!empty($data['data']['password']))) {
            $data['data']["password"] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if ((isset($data['data']['password'])) && (!empty($data['data']['password']))) {
            $data['data']["password"] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

}
