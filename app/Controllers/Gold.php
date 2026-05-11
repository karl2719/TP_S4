<?php

namespace App\Controllers;

use App\Models\ParametreModel;
use App\Models\UserModel;

class Gold extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        $paramModel = new ParametreModel();
        $prix_gold = (float) $paramModel->get('prix_gold', 49.99);

        return view('gold/index', [
            'user' => $user,
            'prix_gold' => $prix_gold,
        ]);
    }

    public function activer()
    {
        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        if ((int) $user['option_gold'] === 1) {
            return redirect()->to('/gold')->with('info', 'Option Gold deja activee.');
        }

        $paramModel = new ParametreModel();
        $prix_gold = (float) $paramModel->get('prix_gold', 49.99);

        if ((float) $user['solde_wallet'] < $prix_gold) {
            return redirect()->to('/gold')->with('error', 'Solde insuffisant pour activer Gold.');
        }

        $userModel->debiterWallet($user_id, $prix_gold);
        $userModel->update($user_id, ['option_gold' => 1]);

        return redirect()->to('/dashboard')->with('success', 'Option Gold activee.');
    }
}
