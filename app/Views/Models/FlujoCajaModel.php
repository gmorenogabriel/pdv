<?php

namespace  App\Models;
use CodeIgniter\Model;

class FlujoCajaModel extends Model{

    protected $table      = 'flujo_caja';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['fecha','descripcion', 'entrada', 'salida','saldo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function saldoActual(){
        $sQuery = "SELECT saldo FROM $this->table ORDER BY id desc LIMIT 1";
        $db = db_connect();
        $query = $db->query($sQuery)->getRow();
        if(isset($query)){
            return $query->saldo;    
        }else{
            return '0';
        }

    }
}   

?>