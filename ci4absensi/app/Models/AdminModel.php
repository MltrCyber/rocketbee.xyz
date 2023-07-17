<?php
namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model {
    
	protected $table = 'admin';
	protected $primaryKey = 'id';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['fullname', 'username', 'password'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}