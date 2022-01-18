<?php 
namespace App\Models;
use CodeIgniter\Model;

class CommentsModel extends Model
{
    protected $table      = 'commentaries';
    protected $primaryKey = 'idcom';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['post','cname','cemail','cmessage','added_m'];

    protected $useTimestamps = false;
    protected $deletedField  = 'deletedc';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

?>