<?php

namespace App\Models;

use CodeIgniter\Model;

class wallet_transactions extends Model
{
    protected $table = 'wallet_transactions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'type',
        'montant',
        'description',
        'created_at',
    ];
}
