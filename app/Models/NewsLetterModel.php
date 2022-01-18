<?php 
namespace App\Models;
use CodeIgniter\Model;

class NewsLetterModel extends Model
{
    protected $table      = 'newsletter';
    protected $primaryKey = 'idnew';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['email','added_at'];

    protected $useTimestamps = false;
    protected $deletedField  = 'deletedn';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>