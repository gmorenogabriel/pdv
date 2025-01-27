<?php

namespace  App\Models;
use CodeIgniter\Model;

class ProductosModel extends Model{

    protected $table      = 'productos';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
    'codigo', 
    'nombre', 
    'precio_venta', 
    'precio_compra', 
    'existencias', 
    'stock_minimo',
    'inventariable',
    'id_unidad',
    'id_categoria',    
    'activo',
    'id_barcod'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = '';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function actualizaStock($id_producto, $cantidad){
        $this->set('existencias', "existencias + $cantidad", FALSE);
        $this->where('id', $id_producto);
        $this->update();
    }
    public function totalProductos(){
        return $this->where('activo', 1)->countAllResults(); // retorna num_rows
    }
    public function stockMinimoProductos(){
        $where = "stock_minimo >= existencias AND inventariable=1 AND activo=1";
        $this->where($where); 
        $sql = $this->countAllResults();
        return $sql;
    }
    
}   

?>