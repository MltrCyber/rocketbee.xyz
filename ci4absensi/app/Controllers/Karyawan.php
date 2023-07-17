<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\KaryawanModel;

class Karyawan extends BaseController
{

	protected $karyawanModel;
	protected $validation;

	public function __construct()
	{
		$this->karyawanModel = new KaryawanModel();
		$this->validation =  \Config\Services::validation();
	}

	public function index()
	{

		$data = [
			'controller'    	=> ucwords('karyawan'),
			'title'     		=> ucwords('karyawan')
		];

		return view('karyawan', $data);
	}

	public function getAll()
	{
		$response = $data['data'] = array();

		$result = $this->karyawanModel->select()->findAll();
		$no = 1;
		foreach ($result as $key => $value) {
			$ops = '<div class="btn-group text-white">';
			$ops .= '<a class="btn btn-dark" onClick="save(' . $value->id . ')"><i class="fas fa-pencil-alt"></i></a>';
			$ops .= '<a class="btn btn-secondary text-dark" onClick="remove(' . $value->id . ')"><i class="fas fa-trash-alt"></i></a>';
			$ops .= '</div>';
			$data['data'][$key] = array(
				$no,
				$value->nama_lengkap,
				$value->username,
				$value->tgl_lahir,
				$value->email,
				$value->divisi,
				$value->status,
				$ops
			);
			$no++;
		}

		return $this->response->setJSON($data);
	}

	public function getOne()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->karyawanModel->where('id', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function add()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_lengkap'] = $this->request->getPost('nama_lengkap');
		$fields['username'] = $this->request->getPost('username');
		$fields['password'] = password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT);
		$fields['tgl_lahir'] = $this->request->getPost('tgl_lahir');
		$fields['email'] = $this->request->getPost('email');
		$fields['divisi'] = $this->request->getPost('divisi');
		$fields['status'] = $this->request->getPost('status');


		$this->validation->setRules([
			'nama_lengkap' => ['label' => 'Nama lengkap', 'rules' => 'required|min_length[0]|max_length[100]'],
			'username' => ['label' => 'Username', 'rules' => 'required|min_length[0]|max_length[100]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[0]|max_length[200]'],
			'tgl_lahir' => ['label' => 'Tgl lahir', 'rules' => 'required|valid_date|min_length[0]'],
			'email' => ['label' => 'Email', 'rules' => 'required|valid_email|min_length[0]|max_length[100]'],
			'divisi' => ['label' => 'Divisi', 'rules' => 'required|min_length[0]|max_length[100]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->karyawanModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("App.insert-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.insert-error");
			}
		}

		return $this->response->setJSON($response);
	}

	public function edit()
	{
		$response = array();

		$fields['id'] = $this->request->getPost('id');
		$fields['nama_lengkap'] = $this->request->getPost('nama_lengkap');
		$fields['username'] = $this->request->getPost('username');
		$fields['password'] = password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT);
		$fields['tgl_lahir'] = $this->request->getPost('tgl_lahir');
		$fields['email'] = $this->request->getPost('email');
		$fields['divisi'] = $this->request->getPost('divisi');
		$fields['status'] = $this->request->getPost('status');


		$this->validation->setRules([
			'nama_lengkap' => ['label' => 'Nama lengkap', 'rules' => 'required|min_length[0]|max_length[100]'],
			'username' => ['label' => 'Username', 'rules' => 'required|min_length[0]|max_length[100]'],
			'password' => ['label' => 'Password', 'rules' => 'required|min_length[0]|max_length[200]'],
			'tgl_lahir' => ['label' => 'Tgl lahir', 'rules' => 'required|valid_date|min_length[0]'],
			'email' => ['label' => 'Email', 'rules' => 'required|valid_email|min_length[0]|max_length[100]'],
			'divisi' => ['label' => 'Divisi', 'rules' => 'required|min_length[0]|max_length[100]'],
			'status' => ['label' => 'Status', 'rules' => 'required|numeric|min_length[0]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->karyawanModel->update($fields['id'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("App.update-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.update-error");
			}
		}

		return $this->response->setJSON($response);
	}

	public function remove()
	{
		$response = array();

		$id = $this->request->getPost('id');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->karyawanModel->where('id', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("App.delete-success");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.delete-error");
			}
		}

		return $this->response->setJSON($response);
	}
}
