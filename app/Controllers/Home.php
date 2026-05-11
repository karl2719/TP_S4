<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function signup(): string
    {
        return view('sing_up/sing_up');
    }
}
