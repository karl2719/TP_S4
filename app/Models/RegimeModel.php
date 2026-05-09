<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'description',
        'pct_viande',
        'pct_poisson',
        'pct_volaille',
        'variation_poids_kg',
        'objectif_cible',
        'is_active',
        'created_at',
    ];
}
