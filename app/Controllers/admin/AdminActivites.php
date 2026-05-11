<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\ActiviteModel;

class AdminActivites extends BaseController
{
    public function index()
    {
        $model = new ActiviteModel();
        $activites = $model->findAll();
        return view('admin/activites/index', ['activites' => $activites]);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $objectifs = $db->table('objectifs')->get()->getResultArray();
        return view('admin/activites/create', ['objectifs' => $objectifs]);
    }

    public function store()
    {
        $model = new ActiviteModel();
        $model->insert([
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories_heure' => (int) $this->request->getPost('calories_heure'),
            'intensite' => $this->request->getPost('intensite'),
            'objectif_code' => $this->request->getPost('objectif_code') ?: null,
            'actif' => (int) $this->request->getPost('actif'),
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activite creee.');
    }

    public function edit(int $id)
    {
        $model = new ActiviteModel();
        $activite = $model->find($id);
        if (!$activite) {
            return redirect()->to('/admin/activites')->with('error', 'Activite introuvable.');
        }

        $db = \Config\Database::connect();
        $objectifs = $db->table('objectifs')->get()->getResultArray();

        return view('admin/activites/edit', [
            'activite' => $activite,
            'objectifs' => $objectifs,
        ]);
    }

    public function update(int $id)
    {
        $model = new ActiviteModel();
        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories_heure' => (int) $this->request->getPost('calories_heure'),
            'intensite' => $this->request->getPost('intensite'),
            'objectif_code' => $this->request->getPost('objectif_code') ?: null,
            'actif' => (int) $this->request->getPost('actif'),
        ]);

        return redirect()->to('/admin/activites')->with('success', 'Activite mise a jour.');
    }

    public function delete(int $id)
    {
        $model = new ActiviteModel();
        $model->delete($id);
        return redirect()->to('/admin/activites')->with('success', 'Activite supprimee.');
    }
}
