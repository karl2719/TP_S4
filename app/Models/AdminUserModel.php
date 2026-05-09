<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table = 'admin_users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'username',
        'password',
        'nom_complet',
        'role',
        'is_active',
        'last_login',
        'created_at',
    ];
}
