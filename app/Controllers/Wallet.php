<?php

namespace App\Controllers;

use App\Models\CodePortefeuilleModel;
use App\Models\UserModel;

class Wallet extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        return view('wallet/index', ['user' => $user]);
    }

    public function crediter()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/wallet');
        }

        $user_id = session()->get('user_id');
        $code = strtoupper(trim((string) $this->request->getPost('code')));

        $codeModel = new CodePortefeuilleModel();
        $code_row = $codeModel->findCodeValide($code);

        if (!$code_row) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Code invalide ou deja utilise.',
            ]);
        }

        $userModel = new UserModel();
        $userModel->crediterWallet($user_id, (float) $code_row['montant']);
        $codeModel->utiliserCode($code_row['id'], $user_id);

        $user = $userModel->find($user_id);

        return $this->response->setJSON([
            'success'       => true,
            'message'       => 'Portefeuille credite avec succes.',
            'montant'       => $code_row['montant'],
            'nouveau_solde' => number_format((float) $user['solde_wallet'], 2),
        ]);
    }
}
