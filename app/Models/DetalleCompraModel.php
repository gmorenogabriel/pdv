<?php

namespace  App\Models;
use CodeIgniter\Model;

class DetalleCompraModel extends Model{

    protected $table      = 'detalle_compra';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_compra', 'id_producto','nombre', 'cantidad', 'precio'];

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
            'id_usuario' => $id_usuario
        ]);
        return $this->insertID();
    }
    public function getGrafAllDetalleCompra(){
        // $query = $this->query('SELECT descripcion, stock FROM Productos limit 6');
		$where = "where precio<>0)";
        $query = $this->query('SELECT nombre, cantidad FROM detalle_compra where precio<>0');
		$results = $query->getResultArray();
        return ( $results );
    }
    
}   

?>