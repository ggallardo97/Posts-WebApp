<?php 
namespace App\Models;

use CodeIgniter\Model;

class TagsModel extends Model
{
    protected $table      = 'tags';
    protected $primaryKey = ['idpos','nametag'];

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['idpos','nametag'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deletedt';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>