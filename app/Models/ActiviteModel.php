<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table         = 'activites';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'nom', 'description', 'calories_heure', 'intensite', 'objectif_code', 'actif',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;
}
