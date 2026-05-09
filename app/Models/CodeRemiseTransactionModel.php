<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeRemiseTransactionModel extends Model
{
    protected $table = 'codes_remise_transactions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'code_remise_id',
        'created_at',
    ];
}
