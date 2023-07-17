<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\AbsensimasukModel;

class Absensimasuk extends BaseController
{

	protected $absensimasukModel;
	protected $validation;
	protected $db;

	public function __construct()
	{
		$this->db = db_connect();
		$this->absensimasukModel = new AbsensimasukModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> ucwords('absensimasuk'),
			'title'     		=> ucwords('absensi masuk')
		];

		return view('absensimasuk', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->absensimasukModel->select('*', 'karyawan.nama_lengkap')
		->join('karyawan', 'karyawan.id = absensi_masuk.karyawan_id')				
		->findAll();
		$no = 1;
		foreach ($result as $key => $value) {
			// $ops = '<div class="btn-group text-white">';
			// $ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
			// $ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
			// $ops .= '</div>';
			$imgQr = '<img src="'. QRCodeMaster::qrcode_absensi($value->qr_code) .'" width="80"/>';
			$data['data'][$key] = array(
				$no,
				$value->nama_lengkap,
				$imgQr,
				$value->waktu,
				$value->tanggal,
				$value->keterangan
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}


	public function hadir()
	{
		$qr = $this->request->getPost('qr');
		
		$getHadir = $this->db->table('absensi_masuk')->getWhere([
			'tanggal' => date('Y-m-d'),
			'karyawan_id'	=> session()->get('id')
		])->getRowArray();

		if ($getHadir) {
			$pesan = [
				'error' => [
					'absensi' => 'Anda telah mengisi Absensi'
				]
			];
			echo json_encode($pesan);
		} else {
			$data = [
				'qr_code' => $qr,
				'waktu' => date('H:i:s'),
				'tanggal' => date('Y-m-d'),
				'keterangan' => 'Hadir',
				'karyawan_id' => session()->get('id'),
			];

			$this->absensimasukModel->insert($data);

			$pesan = [
				'sukses' => [
					'absensi' => 'Berhasil mengisi absensi masuk'
				]
			];
			echo json_encode($pesan);
		}
	}


	// public function getOne()
	// {
	// 	$response = array();

	// 	$id = $this->request->getPost('id');

	// 	if ($this->validation->check($id, 'required|numeric')) {

	// 		$data = $this->absensimasukModel->where('id', $id)->first();

	// 		return $this->response->setJSON($data);
	// 	} else {
	// 		throw new \CodeIgniter\Exceptions\PageNotFoundException();
	// 	}
	// }

	// public function add()
	// {
	// 	$response = array();

	// 	$fields['id'] = $this->request->getPost('id');
	// 	$fields['qr_code'] = $this->request->getPost('qr_code');
	// 	$fields['waktu'] = $this->request->getPost('waktu');
	// 	$fields['tanggal'] = $this->request->getPost('tanggal');
	// 	$fields['keterangan'] = $this->request->getPost('keterangan');
	// 	$fields['karyawan_id'] = $this->request->getPost('karyawan_id');


	// 	$this->validation->setRules([
	// 		'qr_code' => ['label' => 'Qr code', 'rules' => 'required|numeric|min_length[0]'],
	// 		'waktu' => ['label' => 'Waktu', 'rules' => 'required|valid_date|min_length[0]'],
	// 		'tanggal' => ['label' => 'Tanggal', 'rules' => 'required|valid_date|min_length[0]'],
	// 		'keterangan' => ['label' => 'Keterangan', 'rules' => 'required|min_length[0]|max_length[50]'],
	// 		'karyawan_id' => ['label' => 'Karyawan id', 'rules' => 'required|numeric|min_length[0]'],

	// 	]);

	// 	if ($this->validation->run($fields) == FALSE) {

	// 		$response['success'] = false;
	// 		$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

	// 	} else {

	// 		if ($this->absensimasukModel->insert($fields)) {

	// 			$response['success'] = true;
	// 			$response['messages'] = lang("App.insert-success");
	// 		} else {

	// 			$response['success'] = false;
	// 			$response['messages'] = lang("App.insert-error");
	// 		}
	// 	}

	// 	return $this->response->setJSON($response);
	// }

	// public function edit()
	// {
	// 	$response = array();

	// 	$fields['id'] = $this->request->getPost('id');
	// 	$fields['qr_code'] = $this->request->getPost('qr_code');
	// 	$fields['waktu'] = $this->request->getPost('waktu');
	// 	$fields['tanggal'] = $this->request->getPost('tanggal');
	// 	$fields['keterangan'] = $this->request->getPost('keterangan');
	// 	$fields['karyawan_id'] = $this->request->getPost('karyawan_id');


	// 	$this->validation->setRules([
	// 		'qr_code' => ['label' => 'Qr code', 'rules' => 'required|numeric|min_length[0]'],
	// 		'waktu' => ['label' => 'Waktu', 'rules' => 'required|valid_date|min_length[0]'],
	// 		'tanggal' => ['label' => 'Tanggal', 'rules' => 'required|valid_date|min_length[0]'],
	// 		'keterangan' => ['label' => 'Keterangan', 'rules' => 'required|min_length[0]|max_length[50]'],
	// 		'karyawan_id' => ['label' => 'Karyawan id', 'rules' => 'required|numeric|min_length[0]'],

	// 	]);

	// 	if ($this->validation->run($fields) == FALSE) {

	// 		$response['success'] = false;
	// 		$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

	// 	} else {

	// 		if ($this->absensimasukModel->update($fields['id'], $fields)) {

	// 			$response['success'] = true;
	// 			$response['messages'] = lang("App.update-success");
	// 		} else {

	// 			$response['success'] = false;
	// 			$response['messages'] = lang("App.update-error");
	// 		}
	// 	}

	// 	return $this->response->setJSON($response);
	// }

	// public function remove()
	// {
	// 	$response = array();

	// 	$id = $this->request->getPost('id');

	// 	if (!$this->validation->check($id, 'required|numeric')) {

	// 		throw new \CodeIgniter\Exceptions\PageNotFoundException();
	// 	} else {

	// 		if ($this->absensimasukModel->where('id', $id)->delete()) {

	// 			$response['success'] = true;
	// 			$response['messages'] = lang("App.delete-success");
	// 		} else {

	// 			$response['success'] = false;
	// 			$response['messages'] = lang("App.delete-error");
	// 		}
	// 	}

	// 	return $this->response->setJSON($response);
	// }
}
