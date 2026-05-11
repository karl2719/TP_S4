<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($user_id);

        $db = \Config\Database::connect();
        $objectifs = $db->table('objectifs')->get()->getResultArray();

        return view('profil/edit', [
            'user'      => $user,
            'objectifs' => $objectifs,
        ]);
    }

    public function update()
    {
        $rules = [
            'taille'      => 'required|decimal|greater_than[100]|less_than[250]',
            'poids'       => 'required|decimal|greater_than[20]|less_than[300]',
            'objectif_id' => 'required|is_not_unique[objectifs.id]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user_id = session()->get('user_id');
        $userModel = new UserModel();
        $userModel->update($user_id, [
            'taille'      => $this->request->getPost('taille'),
            'poids'       => $this->request->getPost('poids'),
            'objectif_id' => $this->request->getPost('objectif_id'),
        ]);

        return redirect()->to('/profil')->with('success', 'Profil mis a jour.');
    }
}
