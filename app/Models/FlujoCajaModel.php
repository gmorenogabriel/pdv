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
	     // Variables para nuestras reglas de validac.del Form
		 
	

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
   // Función para insertar el registro asegurando que 'activo' se guarde como 1
    public function insertar($data)
    {
        // Si no se proporciona el valor de 'activo', configurarlo como 1
        if (!isset($data['activo'])) {
            $data['activo'] = 1;
        }

        // Verificar si ya existe un registro con 'nombre' o 'nombre_corto' donde 'activo' = 1
        $nombreExistente = $this->where('nombre', $data['nombre'])->where('activo', 1)->first();
        $nombreCortoExistente = $this->where('nombre_corto', $data['nombre_corto'])->where('activo', 1)->first();

        // Si ya existe, retornar error
        if ($nombreExistente) {
            return ['status' => 'error', 'message' => 'El campo nombre ya existe.'];
        }

        if ($nombreCortoExistente) {
            return ['status' => 'error', 'message' => 'El campo nombre_corto ya existe.'];
        }

        // Si no existe, insertar el registro con 'activo' = 1
        if ($this->save($data)) {
            return ['status' => 'success', 'message' => 'Registro insertado correctamente.'];
        } else {
            return ['status' => 'error', 'message' => 'Hubo un problema al insertar el registro.'];
        }
    }
}

?>