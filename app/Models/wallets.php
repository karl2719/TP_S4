<?php

namespace App\Models;

use CodeIgniter\Model;

class wallets extends Model
{
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'is_gold',
        'gold_activated_at',
        'sold'
    ];
}
