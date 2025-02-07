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

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // Opción para lanzar excepciones en errores de validación
    protected $skipValidation = false; // Asegúrate de que esté en `false` si deseas validar
   
   
	protected $validationRules = [
		'nombre' 		=> 'required|min_length[3]|max_length[50]',
        'nombre_corto'	=> 'required|min_length[2]|max_length[10]',		
       // 'nombre' 		=> 'required|is_unique[unidades.nombre]|min_length[3]|max_length[50]',
       // 'nombre_corto'	=> 'required|is_unique[unidades.nombre_corto]|min_length[2]|max_length[10]',
	
    ];
	
    protected $validationMessages = [
        'nombre' => [
         // 'is_unique' => 'El campo {field} ya existe.',
			'required' 	=> 'El campo {field} es obligatorio.',
			'min_length'=> 'El campo {field} debe tener al menos 3 caracteres.',
			'max_length'=> 'El campo {field} no debe exceder 50 caracteres.',				
        ],
		'nombre_corto' => [
		 // 'is_unique' => 'El campo {field} ya existe.',
			'required' 	=> 'El campo {field} es obligatorio.',
			'min_length'=> 'El campo {field} debe tener al menos 2 caracteres.',
			'max_length'=> 'El campo {field} no debe exceder 10 caracteres.',
        ],
	];
	
	   // Función para obtener el nombre de la clase y la función
    public function getClassAndMethod()
    {
        // Obtener el seguimiento de la pila de llamadas
        $backtrace = debug_backtrace();

        // El primer elemento de $backtrace[0] es la información sobre la llamada actual
        $class = isset($backtrace[1]['class']) ? $backtrace[1]['class'] : 'N/A';
		
		// Extraer solo el nombre de la clase (sin la ruta completa)
        preg_match('/([A-Za-z0-9_]+)$/', $class, $matches);
        $className = isset($matches[0]) ? $matches[0] : 'N/A';  // Tomamos solo el nombre de la clase
		$function = isset($backtrace[1]['function']) ? $backtrace[1]['function'] : 'N/A';
		
		// Obtener solo el nombre de la función sin la ruta completa
        //$functionName = basename(str_replace('\\', '/', $class)) . '/' . $function;
		$functionName = basename(str_replace('\\', '/', $function));
        return $className.'/'.$functionName;
    }
	
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
	    /**
     * Inserta datos en la base de datos con manejo de errores.
     *
     * @param array $data Datos a insertar.
     * @return array Resultado del intento de inserción.
     */
    public function insertData(array $data): array
    {
        try {
            // Intentar insertar datos
            if (!$this->save($data)) {
                // Errores de validación del modelo
                return [
                    'status' => 'error',
                    'message' => $this->errors()
                ];
            }

            // Éxito
            return [
                'status' => 'success',
                'message' => 'Datos insertados correctamente.'
            ];
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // Capturar error de clave duplicada
            if ($e->getCode() === 1062) { // Código de error 1062 en MySQL
                return [
                    'status' => 'error',
                    'message' => 'Error: Registro duplicado en la base de datos.'
                ];
            }

            // Otros errores de base de datos
            return [
                'status' => 'error',
                'message' => 'Ocurrió un error al insertar los datos: ' . $e->getMessage()
            ];
        }
    }
	public function exists($nombre, $nombre_corto)
    {
		$this->clase = $this->getClassAndMethod();
        // Buscar un registro con nombre y nombre_corto (activo=1)
        $record = $this->where('nombre', $nombre)
                       ->where('nombre_corto', $nombre_corto)
                    //   ->where('activo', 1)
                       ->first();
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - registro: ' . implode(' ',$record));	
        // Si el registro existe, retornar true; si no, retornar false
        return $record ? true : false;
    }

    // Función para insertar o actualizar
    public function saveOrUpdate($data)
    {
		$this->clase = $this->getClassAndMethod();
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - estoy en el Modelo saveOrUpdate.');	
        // Verificar si el registro ya existe con los mismos valores de nombre y nombre_corto
        if ($this->exists($data['nombre'], $data['nombre_corto'])) {
    		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - Existe el Nombre y Nombre_corto.');	
			//return true; // Si existe, no hacer el insert o update
        }else{
			log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - NO Existe el Nombre y Nombre_corto.');	
		}
		
        // Si no existe, insertar o actualizar el registro
        $existingRecord = $this->where('nombre', $data['nombre'])
                               //->where('activo', 1)
                               ->first();

        if ($existingRecord) {
            // Si el registro existe, hacer un UPDATE
			log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - Existe hacemos UPDATE.');	
            return $this->update($existingRecord['id'], $data);
        } else {
            // Si el registro no existe, hacer un INSERT
			log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - NO Existe hacemos INSERT.');	
            return $this->insert($data);
        }
    }
}
?>