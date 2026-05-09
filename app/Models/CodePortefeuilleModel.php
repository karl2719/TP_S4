<?php

namespace App\Models;

use CodeIgniter\Model;

class CodePortefeuilleModel extends Model
{
    protected $table = 'codes_portefeuille';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'code',
        'montant',
        'is_used',
        'used_at',
        'created_at',
        'used_by',
    ];
}
