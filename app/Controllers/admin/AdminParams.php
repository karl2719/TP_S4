<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\ParametreModel;

class AdminParams extends BaseController
{
    public function index()
    {
        $model = new ParametreModel();
        $params = $model->orderBy('cle', 'ASC')->findAll();
        return view('admin/params/index', ['params' => $params]);
    }

    public function update()
    {
        $model = new ParametreModel();
        $params = $this->request->getPost('params');

        if (is_array($params)) {
            foreach ($params as $id => $valeur) {
                $model->update((int) $id, ['valeur' => $valeur]);
            }
        }

        return redirect()->to('/admin/params')->with('success', 'Parametres mis a jour.');
    }
}
