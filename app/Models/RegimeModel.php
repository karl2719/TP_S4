<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table         = 'regimes';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'nom', 'description', 'pct_viande', 'pct_poisson', 'pct_volaille',
        'variation_poids_par_semaine', 'actif',
    ];
    protected $useTimestamps = true;

    public function getRegimesParObjectif(string $objectif_code): array
    {
        $builder = $this->where('actif', 1);
        if ($objectif_code === 'augmenter_poids') {
            $builder->where('variation_poids_par_semaine >', 0);
        } elseif ($objectif_code === 'reduire_poids') {
            $builder->where('variation_poids_par_semaine <', 0);
        }

        return $builder->findAll();
    }

    public function getRegimeAvecPrix(int $id): array
    {
        $regime = $this->find($id);
        if (!$regime) {
            return [];
        }

        $prixModel = new RegimePrixModel();
        $regime['prix'] = $prixModel->where('regime_id', $id)
            ->orderBy('duree_semaines', 'ASC')
            ->findAll();

        return $regime;
    }

    public function getAllAvecPrix(): array
    {
        $regimes = $this->findAll();
        $prixModel = new RegimePrixModel();
        foreach ($regimes as &$regime) {
            $regime['prix'] = $prixModel->where('regime_id', $regime['id'])
                ->orderBy('duree_semaines', 'ASC')
                ->findAll();
        }
        unset($regime);

        return $regimes;
    }
}
