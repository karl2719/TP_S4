<?php

namespace App\Models;

use CodeIgniter\Model;

class regime_prix extends Model
{
    protected $table = 'regime_prix';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'regime_id',
        'duree_jours',
        'prix',
    ];
}
