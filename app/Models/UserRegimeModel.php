<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRegimeModel extends Model
{
    protected $table         = 'user_regimes';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id', 'regime_id', 'regime_prix_id', 'prix_paye',
        'gold_applique', 'date_debut', 'date_fin',
    ];
    protected $useTimestamps = false;

    public function getRegimesActifsUser(int $user_id): array
    {
        return $this->select('user_regimes.*, regimes.nom as regime_nom, regimes.variation_poids_par_semaine, regime_prix.duree_semaines, regime_prix.prix')
            ->join('regimes', 'regimes.id = user_regimes.regime_id')
            ->join('regime_prix', 'regime_prix.id = user_regimes.regime_prix_id')
            ->where('user_regimes.user_id', $user_id)
            ->where('user_regimes.date_fin >=', date('Y-m-d'))
            ->findAll();
    }

    public function getTotalVentes(): float
    {
        $result = $this->selectSum('prix_paye')->first();
        return $result['prix_paye'] ?? 0.0;
    }
}
