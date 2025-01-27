<?php

namespace  App\Models;
use CodeIgniter\Model;

class UnidadesModel extends Model{

    protected $table      = 'unidades';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'nombre_corto', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'fecha_alta';
    protected $updatedField  = 'fecha_edit';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function saveBD($dataBD){
        try{
            $db = \Config\Database::connect();
            $this->transStrict(true);
            $db->transBegin();
            $this->insert($dataBD);
            $db->transComplete();
            if ($db->transStatus() === FALSE){
                $db->transRollback();    
                return false;
            }else{
                $db->transCommit();
                return true;
            }               
        } catch (\Exception $e) {
            $db->transRollback();
            return false;
        }
    }
}   

?>