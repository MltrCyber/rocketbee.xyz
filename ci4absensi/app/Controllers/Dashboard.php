<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensimasukModel;
use App\Models\AbsensikeluarModel;
use App\Models\KaryawanModel;
use App\Models\AdminModel;

class Dashboard extends BaseController
{
    protected $a_masuk;
    protected $a_keluar;
    protected $a;
    protected $k;
    protected $validation;

    function __construct() {
		$this->a_masuk  = new AbsensimasukModel();
		$this->a_keluar =  new AbsensikeluarModel();
		$this->a =  new AdminModel();
		$this->k =  new KaryawanModel();
		$this->validation =  \Config\Services::validation();
    }
    public function index()
    {
        $data = [
            'controller'        => 'Dashboard',
            'title'             => 'Dashboard',
            'tm'     => $this->a_masuk->select('COUNT(id) as tm')->first(),
            'tk'     => $this->a_keluar->select('COUNT(id) as tk')->first(),
            'a'     => $this->a->select('COUNT(id) as a')->first(),
            'k'     => $this->k->select('COUNT(id) as k')->first(),
        ];

        return view('dashboard', $data);
    }
}
