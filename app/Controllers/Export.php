<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserRegimeModel;
use Dompdf\Dompdf;

class Export extends BaseController
{
    public function pdf(int $user_regime_id)
    {
        $user_id = session()->get('user_id');

        $urModel = new UserRegimeModel();
        $userModel = new UserModel();

        $ur = $urModel
            ->select('user_regimes.*, regimes.nom as regime_nom, regimes.description, regimes.pct_viande, regimes.pct_poisson, regimes.pct_volaille, regime_prix.duree_semaines, regime_prix.prix')
            ->join('regimes', 'regimes.id = user_regimes.regime_id')
            ->join('regime_prix', 'regime_prix.id = user_regimes.regime_prix_id')
            ->where('user_regimes.id', $user_regime_id)
            ->where('user_regimes.user_id', $user_id)
            ->first();

        if (!$ur) {
            return redirect()->to('/dashboard')->with('error', 'Plan introuvable.');
        }

        $user = $userModel->find($user_id);
        $imc = UserModel::calculerIMC($user['poids'], $user['taille']);

        $html = view('export/pdf_template', [
            'ur' => $ur,
            'user' => $user,
            'imc' => $imc,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('plan-diet-' . $user_regime_id . '.pdf', ['Attachment' => true]);
        exit;
    }
}
