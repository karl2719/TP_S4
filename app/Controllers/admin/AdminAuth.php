<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AdminAuth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_id')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/login');
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new AdminModel();
        $admin = $model->where('email', $email)->first();

        if (!$admin || !password_verify((string) $password, $admin['password'])) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

        session()->set([
            'admin_id'   => $admin['id'],
            'admin_nom'  => $admin['nom'],
            'admin_mail' => $admin['email'],
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->remove(['admin_id', 'admin_nom', 'admin_mail']);
        return redirect()->to('/admin');
    }
}
