<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\RegimeModel;
use App\Models\RegimePrixModel;

class AdminRegimes extends BaseController
{
    public function index()
    {
        $model = new RegimeModel();
        $regimes = $model->getAllAvecPrix();
        return view('admin/regimes/index', ['regimes' => $regimes]);
    }

    public function create()
    {
        return view('admin/regimes/create');
    }

    public function store()
    {
        $pct_viande = (int) $this->request->getPost('pct_viande');
        $pct_poisson = (int) $this->request->getPost('pct_poisson');
        $pct_volaille = (int) $this->request->getPost('pct_volaille');

        if ($pct_viande + $pct_poisson + $pct_volaille !== 100) {
            return redirect()->back()->withInput()->with('error', 'Les pourcentages doivent totaliser 100%.');
        }

        $model = new RegimeModel();
        $regime_id = $model->insert([
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'pct_viande' => $pct_viande,
            'pct_poisson' => $pct_poisson,
            'pct_volaille' => $pct_volaille,
            'variation_poids_par_semaine' => $this->request->getPost('variation_poids'),
            'actif' => 1,
        ]);

        $prixModel = new RegimePrixModel();
        $durees = $this->request->getPost('durees');
        $prix = $this->request->getPost('prix');

        if ($durees && $prix) {
            foreach ($durees as $i => $duree) {
                if (!empty($duree) && !empty($prix[$i])) {
                    $prixModel->insert([
                        'regime_id' => $regime_id,
                        'duree_semaines' => (int) $duree,
                        'prix' => (float) $prix[$i],
                    ]);
                }
            }
        }

        return redirect()->to('/admin/regimes')->with('success', 'Regime cree avec succes.');
    }

    public function edit(int $id)
    {
        $model = new RegimeModel();
        $regime = $model->getRegimeAvecPrix($id);
        if (!$regime) {
            return redirect()->to('/admin/regimes')->with('error', 'Regime introuvable.');
        }
        return view('admin/regimes/edit', ['regime' => $regime]);
    }

    public function update(int $id)
    {
        $pct_viande = (int) $this->request->getPost('pct_viande');
        $pct_poisson = (int) $this->request->getPost('pct_poisson');
        $pct_volaille = (int) $this->request->getPost('pct_volaille');

        if ($pct_viande + $pct_poisson + $pct_volaille !== 100) {
            return redirect()->back()->withInput()->with('error', 'Les pourcentages doivent totaliser 100%.');
        }

        $model = new RegimeModel();
        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'pct_viande' => $pct_viande,
            'pct_poisson' => $pct_poisson,
            'pct_volaille' => $pct_volaille,
            'variation_poids_par_semaine' => $this->request->getPost('variation_poids'),
            'actif' => (int) $this->request->getPost('actif'),
        ]);

        $prixModel = new RegimePrixModel();
        $prixModel->where('regime_id', $id)->delete();

        $durees = $this->request->getPost('durees');
        $prix = $this->request->getPost('prix');

        if ($durees && $prix) {
            foreach ($durees as $i => $duree) {
                if (!empty($duree) && !empty($prix[$i])) {
                    $prixModel->insert([
                        'regime_id' => $id,
                        'duree_semaines' => (int) $duree,
                        'prix' => (float) $prix[$i],
                    ]);
                }
            }
        }

        return redirect()->to('/admin/regimes')->with('success', 'Regime mis a jour.');
    }

    public function delete(int $id)
    {
        $model = new RegimeModel();
        $model->delete($id);
        return redirect()->to('/admin/regimes')->with('success', 'Regime supprime.');
    }
}
