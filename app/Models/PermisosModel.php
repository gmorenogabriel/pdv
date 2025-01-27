<?php

namespace  App\Models;
use CodeIgniter\Model;

class PermisosModel extends Model{

    protected $table      = 'permisos';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
    'menu_id', 
    'rol_id', 
    'read', 
    'insert', 
    'update', 
    'delete',
    'activo',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function actualizaStock($id_permiso, $cantidad){
        $this->set('existencias', "existencias + $cantidad", FALSE);
        $this->where('id', $id_permiso);
        $this->update();
    }
    public function totalPermisos(){
        return $this->where('activo', 1)->countAllResults(); // retorna num_rows
    }
    public function stockMinimoPermisos(){
        $where = "stock_minimo >= existencias AND inventariable=1 AND activo=1";
        $this->where($where); 
        $sql = $this->countAllResults();
        return $sql;
    }
}   

?>