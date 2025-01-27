<?php

namespace  App\Models;
use CodeIgniter\Model;

class CodigosBarraModel extends Model{

    protected $table      = 'codigos_barra';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['tipobarcod','nombre', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = false;
    protected $updatedField  = false;
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}   

?>