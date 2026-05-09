<?php

namespace App\Models;

use CodeIgniter\Model;

class UserActiviteModel extends Model
{
    protected $table = 'user_activites';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'activite_id',
        'regime_id',
        'assigned_at',
    ];
}
