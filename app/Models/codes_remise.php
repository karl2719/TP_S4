<?php

namespace App\Models;

use CodeIgniter\Model;

class codes_remise extends Model
{
    protected $table = 'codes_remise';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'cle',
        'valeur',
        'description',
        'created_at',
    ];
}
