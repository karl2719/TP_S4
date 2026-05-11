<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CodePortefeuilleModel;

class AdminCodes extends BaseController
{
    public function index()
    {
        $model = new CodePortefeuilleModel();
        $codes = $model->orderBy('id', 'DESC')->findAll();
        return view('admin/codes/index', ['codes' => $codes]);
    }

    public function create()
    {
        return view('admin/codes/create');
    }

    public function store()
    {
        $model = new CodePortefeuilleModel();
        $model->insert([
            'code' => strtoupper(trim((string) $this->request->getPost('code'))),
            'montant' => (float) $this->request->getPost('montant'),
            'actif' => (int) $this->request->getPost('actif'),
        ]);

        return redirect()->to('/admin/codes')->with('success', 'Code cree.');
    }

    public function delete(int $id)
    {
        $model = new CodePortefeuilleModel();
        $model->delete($id);
        return redirect()->to('/admin/codes')->with('success', 'Code supprime.');
    }
}
