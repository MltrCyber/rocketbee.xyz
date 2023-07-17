<?php
namespace App\Models;
use CodeIgniter\Model;

class AbsensikeluarModel extends Model {
    
	protected $table = 'absensi_keluar';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['qr_code', 'waktu', 'tanggal', 'karyawan_id'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}