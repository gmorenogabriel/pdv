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
	
 // Función para obtener el nombre de la clase
    public function obtenerNombreDeLaClase() {
        $nombreClaseCompleta = basename(__CLASS__);  // Obtiene el nombre completo de la clase
        $nombreClaseSinModel = substr($nombreClaseCompleta, 0, -5);  // Elimina "Model"
        return $nombreClaseSinModel;
    }
	
	public function obtenerFechaHoy() {
		// Obtener la fecha actual en formato Y-m-d
		$fechaHoy = date('Y-m-d');
		return $fechaHoy;
	}

	public function obtenerTodosLosRegistros(){
		$clase 	  = $this->obtenerNombreDeLaClase();
		$fechaHoy = $this->obtenerFechaHoy();	
		$datos    = $this->findAll();
		$data = [ 
            'titulo' => $clase,
            'datos'  => $datos,
            'fecha'  => $fechaHoy,
        ];
		// dd($data);
		return $data;
	}


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