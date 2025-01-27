<?php

namespace  App\Models;
use CodeIgniter\Model;

class ClientesModel extends Model{

    protected $table      = 'clientes';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
    'nombre', 
    'direccion', 
    'telefono', 
    'correo', 
    'activo'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function inicioClientes(){
        $query = $this->query('SELECT nombre, direccion, correo FROM clientes');
        $results = $query->getResult();
        return $results;
    }
}   
?>