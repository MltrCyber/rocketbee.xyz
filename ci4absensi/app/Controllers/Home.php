<?php

namespace App\Controllers;

use App\Models\AbsensimasukModel;
use App\Models\AbsensikeluarModel;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Home extends BaseController
{
    protected $db;
    protected $absensimasukModel;
    protected $absensikeluarModel;

    public function __construct()
    {
        $this->db = db_connect();
        $this->absensimasukModel = new AbsensimasukModel();
        $this->absensikeluarModel = new AbsensikeluarModel();
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function menu()
    {
        $getAbsenMasuk = $this->db->table('absensi_masuk')->getWhere([
            'tanggal' => date('Y-m-d'),
            'karyawan_id'    => session()->get('id')
        ])->getRowArray();

        $getAbsenKeluar = $this->db->table('absensi_keluar')->getWhere([
            'tanggal' => date('Y-m-d'),
            'karyawan_id'    => session()->get('id')
        ])->getRowArray();

        if ($getAbsenMasuk) {
            $data['absenmasuk'] = 'ada';
        } else {
            $data['absenmasuk'] = 'belumada';
        }

        if ($getAbsenKeluar) {
            $data['absenkeluar'] = 'ada';
        } else {
            $data['absenkeluar'] = 'belumada';
        }

        $data['title'] = 'Menu';
        return view('menu', $data);
    }

    public function absensimasuk()
    {
        $data['title'] = 'Absensi Masuk';
        return view('menu_absensimasuk', $data);
    }

    public function absensisaya()
    {
        $data = [
            'title' => 'Absensi Saya',
            'absensiMasuk'   => $this->absensimasukModel->select('*')->where('karyawan_id', session()->get('id'))->findAll(),
            'absensiKeluar'  => $this->absensikeluarModel->select('*')->where('karyawan_id', session()->get('id'))->findAll()
        ];
        return view('menu_absensisaya', $data);
    }

    public function absensikeluar()
    {
        $data['title'] = 'Absensi Keluar';
        return view('menu_absensikeluar', $data);
    }
}
