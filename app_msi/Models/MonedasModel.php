<?php

namespace  App\Models;
use CodeIgniter\Model;

class MonedasModel extends Model{

    protected $table      = 'monedas';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['moneda', 'nombre', 'nombre_corto', 'simbolo', 'tipo_moneda', 'divide_mult', 'tc_compra', 'tc_venta', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}   

?>