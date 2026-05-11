<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserRegimeModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        $imc = UserModel::calculerIMC($user['poids'], $user['taille']);
        $interpretation = UserModel::interpreterIMC($imc);
        $poids_ideal = UserModel::calculerPoidsIdeal($user['taille'], $user['genre']);
        $delta_poids = abs($poids_ideal - $user['poids']);

        $db = \Config\Database::connect();
        $objectif = $db->table('objectifs')->where('id', $user['objectif_id'])->get()->getRowArray();

        $urModel = new UserRegimeModel();
        $regimes_actifs = $urModel->getRegimesActifsUser($user_id);

        $duree_estimee_semaines = null;
        if (!empty($regimes_actifs)) {
            $variation = (float) $regimes_actifs[0]['variation_poids_par_semaine'];
            if ($variation !== 0.0) {
                $duree_estimee_semaines = abs($poids_ideal - $user['poids']) / abs($variation);
            }
        }

        return view('dashboard/index', compact(
            'user',
            'imc',
            'interpretation',
            'poids_ideal',
            'delta_poids',
            'objectif',
            'regimes_actifs',
            'duree_estimee_semaines'
        ));
    }
}
