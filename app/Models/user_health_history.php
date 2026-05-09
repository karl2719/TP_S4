<?php

namespace App\Models;

use CodeIgniter\Model;

class user_health_history extends Model
{
    protected $table = 'user_health_history';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'taille_cm',
        'poids_kg',
        'objectif',
        'updated_at',
    ];
}
