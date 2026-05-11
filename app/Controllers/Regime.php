<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\RegimePrixModel;
use App\Models\UserModel;
use App\Models\UserRegimeModel;

class Regime extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        $db = \Config\Database::connect();
        $objectif = $db->table('objectifs')->where('id', $user['objectif_id'])->get()->getRowArray();

        $objectif_code = $objectif['code'];
        if ($objectif_code === 'imc_ideal') {
            $imc = UserModel::calculerIMC($user['poids'], $user['taille']);
            if ($imc > 24.9) {
                $objectif_code = 'reduire_poids';
            } elseif ($imc < 18.5) {
                $objectif_code = 'augmenter_poids';
            }
        }

        $regimeModel = new RegimeModel();
        $regimes = $regimeModel->getRegimesParObjectif($objectif_code);

        $prixModel = new RegimePrixModel();
        foreach ($regimes as &$regime) {
            $regime['prix'] = $prixModel->where('regime_id', $regime['id'])
                ->orderBy('duree_semaines', 'ASC')
                ->findAll();
        }
        unset($regime);

        return view('regime/liste', [
            'regimes'  => $regimes,
            'user'     => $user,
            'objectif' => $objectif,
        ]);
    }

    public function detail(int $id)
    {
        $regimeModel = new RegimeModel();
        $regime = $regimeModel->getRegimeAvecPrix($id);

        if (!$regime) {
            return redirect()->to('/regimes')->with('error', 'Regime introuvable.');
        }

        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        return view('regime/detail', [
            'regime' => $regime,
            'user'   => $user,
        ]);
    }

    public function acheter()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/regimes');
        }

        $user_id = session()->get('user_id');
        $regime_prix_id = (int) $this->request->getPost('regime_prix_id');

        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        $prixModel = new RegimePrixModel();
        $prix_row = $prixModel->find($regime_prix_id);

        if (!$prix_row) {
            return $this->response->setJSON(['success' => false, 'message' => 'Regime introuvable.']);
        }

        $prix_final = $prix_row['prix'];
        $gold_applique = 0;
        if ($user['option_gold']) {
            $prix_final = round($prix_final * 0.85, 2);
            $gold_applique = 1;
        }

        if ($user['solde_wallet'] < $prix_final) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Solde insuffisant. Veuillez crediter votre portefeuille.',
            ]);
        }

        $userModel->debiterWallet($user_id, $prix_final);

        $urModel = new UserRegimeModel();
        $date_debut = date('Y-m-d');
        $date_fin = date('Y-m-d', strtotime('+' . $prix_row['duree_semaines'] . ' weeks'));

        $urModel->insert([
            'user_id'        => $user_id,
            'regime_id'      => $prix_row['regime_id'],
            'regime_prix_id' => $regime_prix_id,
            'prix_paye'      => $prix_final,
            'gold_applique'  => $gold_applique,
            'date_debut'     => $date_debut,
            'date_fin'       => $date_fin,
        ]);

        $user_updated = $userModel->find($user_id);

        return $this->response->setJSON([
            'success'       => true,
            'message'       => 'Regime souscrit avec succes.',
            'nouveau_solde' => number_format($user_updated['solde_wallet'], 2),
        ]);
    }
}
