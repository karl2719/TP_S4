<?php

namespace App\Models;

use CodeIgniter\Model;

class gold_payement extends Model
{
    protected $table = 'gold_payement';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'prix_paye',
        'code_remise_id',
        'created_at',
    ];
}
