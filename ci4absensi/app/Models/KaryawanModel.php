<?php
namespace App\Models;
use CodeIgniter\Model;

class KaryawanModel extends Model {
    
	protected $table = 'karyawan';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nama_lengkap', 'username', 'password', 'tgl_lahir', 'email', 'divisi', 'status'];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}