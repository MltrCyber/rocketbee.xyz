<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Logout extends BaseController
{
    public function index()
    {
        if(session()->get('status') == 'Admin') {
            session()->destroy();
            return redirect()->to('/login/admin');
        } else {
            session()->destroy();
            return redirect()->to('/login/karyawan');
        }
    }
}
