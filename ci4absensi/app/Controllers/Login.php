<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\AdminModel;

class Login extends BaseController
{
    protected $Admin;
    protected $Karyawan;
    
    public function __construct()
	{
	    $this->Admin = new AdminModel();
        $this->Karyawan = new KaryawanModel();
		
	}

    public function admin()
    {
        $data = [
            'title' => 'Login Admin'
        ];
        return view('login_admin', $data);
    }

    public function karyawan()
    {
        $data = [
            'title' => 'Login Karyawan'
        ];

        return view('login_karyawan', $data);
    }

    public function ceklogin()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $userType = $this->request->uri->getSegment(2);

        $model = $userType == "admin" ? $this->Admin : $this->Karyawan;

        $findUser = $model->where('username', $login)->first();
        if (!$findUser || !password_verify((string)$password, $findUser->password)) {
            return redirect()->to('/login/' . $userType)->withInput()->with('error', 'Invalid credentials');
        }

        session()->set([
            'id' => $findUser->id,
            'username' => $findUser->username,
            'fullname' => $userType == 'admin' ? $findUser->fullname :  $findUser->nama_lengkap,
            'status' => $userType == 'admin' ? 'Admin' :  'Karyawan',
        ]);


        if($userType == "admin") {

            return redirect()->to('/dashboard');
        } else {
            return redirect()->to('/home/menu');
        }
  
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
