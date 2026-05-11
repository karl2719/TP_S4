<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->findByEmail((string) $email);

        if (!$user || !password_verify((string) $password, $user['password'])) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id'     => $user['id'],
            'user_nom'    => $user['nom'],
            'user_prenom' => $user['prenom'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function registerStep1()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register_step1');
    }

    public function doRegisterStep1()
    {
        $rules = [
            'nom'              => 'required|min_length[2]|max_length[100]',
            'prenom'           => 'required|min_length[2]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'genre'            => 'required|in_list[M,F]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        session()->set('reg_step1', [
            'nom'      => $this->request->getPost('nom'),
            'prenom'   => $this->request->getPost('prenom'),
            'email'    => $this->request->getPost('email'),
            'genre'    => $this->request->getPost('genre'),
            'password' => $this->request->getPost('password'),
        ]);

        return redirect()->to('/register/step2');
    }

    public function registerStep2()
    {
        if (!session()->get('reg_step1')) {
            return redirect()->to('/register/step1');
        }

        $db = \Config\Database::connect();
        $objectifs = $db->table('objectifs')->get()->getResultArray();

        return view('auth/register_step2', ['objectifs' => $objectifs]);
    }

    public function doRegisterStep2()
    {
        if (!session()->get('reg_step1')) {
            return redirect()->to('/register/step1');
        }

        $rules = [
            'taille'      => 'required|decimal|greater_than[100]|less_than[250]',
            'poids'       => 'required|decimal|greater_than[20]|less_than[300]',
            'objectif_id' => 'required|is_not_unique[objectifs.id]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $step1 = session()->get('reg_step1');
        $model = new UserModel();

        $data = [
            'nom'          => $step1['nom'],
            'prenom'       => $step1['prenom'],
            'email'        => $step1['email'],
            'genre'        => $step1['genre'],
            'password'     => password_hash($step1['password'], PASSWORD_DEFAULT),
            'taille'       => $this->request->getPost('taille'),
            'poids'        => $this->request->getPost('poids'),
            'objectif_id'  => $this->request->getPost('objectif_id'),
            'solde_wallet' => 0.00,
            'option_gold'  => 0,
        ];

        $user_id = $model->insert($data);

        session()->remove('reg_step1');
        session()->set([
            'user_id'     => $user_id,
            'user_nom'    => $data['nom'],
            'user_prenom' => $data['prenom'],
        ]);

        return redirect()->to('/dashboard');
    }
}
