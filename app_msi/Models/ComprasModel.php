<?php

namespace  App\Models;
use CodeIgniter\Model;

class ComprasModel extends Model{

    protected $table      = 'compras';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'total', 'id_usuario', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertaCompra($id_compra, $total, $id_usuario){
        $this->insert([
            'folio' => $id_compra,
            'total' => $total,
            'id_usuario' => $id_usuario,
            'activo' => 1
        ]);
        return $this->insertID();
    }
    public function totalCompras($fecha=null){
        $this->select("sum(total) AS total");
        //return $this->where('activo', 1)->findAll(); // retorna total
        return $this->where('activo', 1)->first(); // retorna total
        // print_r($this->getLastQuery());
        // return $datos;
        //$where = "activo = 1 and DATE(fecha_alta) = '$fecha'";
        //return $this->where($where)->countAllResults(); // retorna num_rows
        //return $this->where('activo', 1)->countAllResults(); // retorna num_rows
        
    }
    
}   

?>