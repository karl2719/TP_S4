<?php

namespace App\Models;

use CodeIgniter\Model;

class user_regimes_paiement extends Model
{
    protected $table = 'user_regimes_paiement';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'regime_id',
        'prix_paye',
        'remise_gold',
        'duree_jours',
        'date_debut',
        'date_fin',
        'statut',
        'created_at',
    ];
}
