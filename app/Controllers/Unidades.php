<?php namespace App\Controllers;

use App\Libraries\Custom;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Libraries\Toastr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\Fpdi;
use Config\Services;
use Hashids\Hashids;
use App\Models\UnidadesModel;
use App\Models\SweetMessageModel;
// use ReflectionMethod;

class Unidades extends BaseController{
	
    protected $clase, $_method, $funcion;
    protected $unidades;
    protected $reglas;
	protected $empresa, $tit, $direcc, $ruc, $today, $fecha_hoy ;
    //protected $empresa;
	protected $hashids;
	protected $miClaveSecreta;
	protected $validation;
	public $threshold = 4;
	
	/* ------------------------------------------------ */
	/* Funcion __construct()                            */
	/* ------------------------------------------------ */	
    public function __construct()
    {
        helper(['form']);

        // $this->session = session();
        $this->empresa = Config('Custom');
		
		$this->tit = $this->empresa->empresaTitulo;
		$this->direcc = $this->empresa->empresaDireccion;
        $this->ruc = $this->empresa->empresaRuc;

        $this->unidades = new UnidadesModel();
        
        // Obtenemos la Fecha del Sistema
        $myTime = Time::now('America/Montevideo', 'la_UY');
        $today       = Time::createFromDate();            // Uses current year, month, and day
        $this->fecha_hoy  = $today->toLocalizedString('dd/MM/yyyy');   // March 9, 2016
        
        // Obtenemos el nombre del Controlador/Metodo
        $router = \Config\Services::router();
        $_method = $router->methodName();
        $_controller = $router->controllerName();         
        $controlador = explode('\\', $_controller) ;
        $this->clase = $controlador[max(array_keys($controlador))] ;
        $this->funcion= $router->methodName();
	
		// Obtener el nombre de la clase actual
        //$this->clase = get_class($this);
        
        // Obtener el nombre del método actual
        //$this->funcion = __METHOD__;
        
		
  // d($this->funcion);
  // d($controlador);
  // d($controlador);
  // d(max(array_keys($controlador)));
  // echo "----------------------- <br/>";
  // $reflection = new \ReflectionClass($this);
		// $refClass = $reflection->getShortName();
		// d($refClass);
// echo "----------------------- <br/>";
// $reflection = new \ReflectionClass($this);
// $methods = $reflection->getMethods();

// foreach ($methods as $method) {
    // echo $method->getName() . "<br/>"; // Muestra el nombre de cada método
// }
// echo "----------------------- <br/>";
//  die();
        // Configura la biblioteca Hashids con una clave secreta
		//$this->miClaveSecreta = env('encryption.key');
        // $this->hashids = new Hashids($this->miClaveSecreta, 10);
		
		$activo = '1';
		
		// Instanciamos el servicio de Validación
		$this->validation = \Config\Services::validation(); 	

        // Variables para nuestras reglas de validac.del Form
        $this->reglas = [
            'nombre' =>  [
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
					'min_length' => 'El campo {field} debe tener al menos 3 caracteres.',
					'max_length' => 'El campo {field} no debe exceder 50 caracteres.',
					],
                ],
            'nombre_corto' => [               
                'rules' => 'required|min_length[2]|max_length[10]',
                'errors' =>  [
                    'required'=> 'El campo {field} es obligatorio.',
					'min_length' => 'El campo {field} debe tener al menos 2 caracteres.',
					'max_length' => 'El campo {field} no debe exceder 10 caracteres.',
					
                    ],
                ],
            ];
    }

	/* ------------------------------------------------ */
	/* Funcion index($activo = 0)                       */
	/* ------------------------------------------------ */	
    public function index($activo = 1){
	
        // Si no está Logueado lo manda a IDENTIFICARSE
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $locale = $this->request->getLocale();  
        //echo $locale;
        //echo lang('Translate.form_validation_required');
		
        $unArray = $this->unidades->where('activo',$activo)->findAll();
		// Instanciamos el Servicio
		$hashids = Services::hashids();
		// Generar el ID encriptado para cada registro
		foreach ($unArray as &$dato) {		
			$dato['id_enc'] = $hashids->encode($dato['id']);
		}
		// ------------------------------------------------------------------
		// IMPORTANTE: Romper la referencia después del bucle
		unset($dato); 
		// SOLO SI NECESITO COMPROBAR "print_r($unidades);"
		// ------------------------------------------------------------------		
        $s2Icono  = null;
	    $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => 'Listado de Unidades',
            's2Icono' => 'info',
            's2ConfirmButtonText' => true, // <!-- $s2ConfirmButtonText, -->
            's2ShowConfirmButton' => true, // <!-- $s2ShowConfirmButton, -->            
            's2Toast' => true,             // <!-- $s2Toast, -->
            's2Footer' => 'PIE Mensaje',   // <!-- $s2Footer, -->
        ];
        $data = [ 
            'titulo'  => $this->clase,
            'datos'   => $unArray,
            's2Icono' => $s2Icono,
			'fecha'  => $this->fecha_hoy,
        ];

		echo view('header');
//		echo view('sweetalert2', $msgToast);    
		echo view('unidades/unidades', $data);
		echo view('footer');
    }

	/* ------------------------------------------------ */
	/* Funcion eliminados($activo = 0)                  */
	/* ------------------------------------------------ */	
    public function eliminados($activo = 0)
    {
        $unidades = $this->unidades->where('activo',$activo)->findAll();
        $data = [ 
            'titulo'	=> 'Unidades eliminadas',
            'datos' 	=> $unidades,
			'fecha'   	=> $this->fecha_hoy,
        ];
		echo view('header');
		echo view('unidades/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
	
	/* ------------------------------------------------ */
	/* Funcion nuevo()                                  */
	/* ------------------------------------------------ */	
	public function nuevo(){
	$validation = \Config\Services::validation(); 	
	$errors = $validation->getErrors();
	//$validation = [];
        $data = [ 
            'titulo' 	=> 'Agregar '.$this->clase,
			'fecha'   	=> $this->fecha_hoy,
            'validation' =>   [],
				 // 'nombre' => [],
				 // 'nombre_corto' => [],
				 // ],
        ];

        echo view('header');
		echo view($this->clase . '/nuevo', $data);
//		echo view('unidades/nuevo', $data);
		echo view('footer');
    }
	
	
	/* ------------------------------------------------ */
	/* Funcion insertar()                               */
	/* ------------------------------------------------ */
	public function insertar()
	{
		// Instanciamos el Modelo de Datos
		$model = model('App\Models\UnidadesModel'); // Cargar el modelo
        // Obtén los datos enviados por POST
        $requestData = $this->request->getPost(esc(['nombre', 'nombre_corto', 'activo']));
		$requestData['activo'] = 1;
		
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - Nombre: ' . $requestData['nombre']);
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - Nombre_corto: ' . $requestData['nombre_corto']);
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - Activo: ' . $requestData['activo']);

		// Las validaciones están en el Modelo de Datos
        // Validar los datos antes de intentar guardarlos con las
		// Reglas cargadas en el Controlador
        // if (!$this->validate($validationRules, $validationMessages)) {

		// Reglas cargadas en el Modelo 
		if (!$model->validate($requestData)) {
			// Obtener errores de validación del modelo
			$errors = $model->errors();
			
			// Formatear errores para SweetAlert2 (unirlos con "\n")
			//$errorMessages = implode("\n", $errors);
			$errorMessages = implode('<br>', $errors);		
			
			if(isset($errorMessages)){
				log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - No valido las reglas: ' . $errorMessages);	
			}

		// Verificar si el registro ya existe
        if ($model->exists($requestData['nombre'], $requestData['nombre_corto'])) {
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - llamo al Modelo saveOrUpdate.');	
        // Llamar al modelo para insertar o actualizar el registro
			$resultado = $model->saveOrUpdate($requestData);
        }

            
			// Retornar respuesta en formato JSON con los errores
            //return $this->response->setJSON([
            //    'status' => 'error',
			//	'message'=> $errorMessages, // Mensajes como texto legible
            //]);
        }
		try {
			// Intentar guardar los datos en la base de datos
			if (!$model->saveOrUpdate($requestData)) {
				// Manejar errores específicos del modelo (por ejemplo, reglas adicionales o errores de BD)
				$modelErrors = $model->errors();
				$errorMessages = implode("<br>", $modelErrors);
				log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - No se pudieron guardar los datos.' . $errorMessages);	
				return $this->response->setJSON([
					'status' => 'error',
					'message' => $errorMessages,
				]);
			}

			// Éxito
			log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - Datos guardados exitosamente.' );	
			return $this->response->setJSON([
				'status' => 'success',
				'message' => 'Datos guardados exitosamente.',
			]);
		} catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
			if ($e->getCode() === 1062) {
				log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - Clave duplicada => 1062 ' . $e->getCode());	
				// Error de clave duplicada
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Error: Clave duplicada. El registro ya existe.',
				]);
			}

			// Otros errores de base de datos
			log_message('error', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - ' . $e->getMessage());
			return $this->response->setJSON([
				'status' => 'error',
				'message' => 'Error en la base de datos: ' . $e->getMessage(),
			]);
		}
	}
	
//===================================================//
// funcion VIEJA
//===================================================//
	    public function insertarVie(){
			
		// Limpiar los datos del Input: ombre y nombre_corto
        $nombre = trim($this->request->getPost('nombre'));
        $nombre_corto = trim($this->request->getPost('nombre_corto'));
        $nombre_corto = preg_replace('/\r|\n/', '', $nombre_corto); // Limpiar saltos de línea
		
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - trim Nombre: ' . $nombre);
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - trim Nombre_corto: ' . $nombre_corto);

		// Obtener los datos del formulario
        $datosValidar = $this->request->getPost();
d($datosValidar);		
        // Validamos Reglas
		if($this->request->getMethod() === "POST" &&
		   $this->validation->setRules($this->reglas)->run($datosValidar)) {
		  // $this->validation->setRules($this->reglas)->run(['nombre'=>$nombre, 'nombre_corto'=>trim($nombre_corto)])) {
			log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - datos validados, proseguimos con la Insercion de los datos.');

            // Valido las Reglas
            $nombre = $this->request->getPost('nombre') ? $nombre = $this->request->getPost('nombre') : '';		
			$data = [
			    'titulo'		=> 'Ingreso de dinero',
                'fecha'			=> $this->request->getPost('fechahoy'),
                'nombre'	    => $nombre,
                'nombre_corto'	=> $nombre_corto,
            ];
			// --------------------------------------
			// Mensajes Alerta SweetAlert 2
			// --------------------------------------
			$msgAlerta	= new SweetMessageModel();
			
			// --------------------------------------
			// --==> Insertamos los datos <==---
			// --------------------------------------
			try {
				// Intenta guardar los datos
				if (!$this->unidades->save($data)) {
					// Validación de errores de CodeIgniter si el save() falla (sin lanzar excepción)
					$errors = $this->unidades->errors();
					if ($errors) {
						return $this->response->setJSON([
							'status' => 'error',
							'message' => $errors
						]);
					}
				}

				// Operación exitosa - Mensaje Alerta SweetAlert2
				log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - Consulta ejecutada satisfactoria: ' . $query = $this->unidades->db->getLastQuery()); 
				$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'insertar');
				// --------------------------------------				
				/* return $this->response->setJSON([
					'status' => 'success',
					'message' => 'Datos guardados exitosamente'
				]);*/
			} catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
				// Captura el error si ocurre un problema con la base de datos
				if ($e->getCode() === 1062) { // Código de error 1062: clave duplicada en MySQL
					// Error en la inserción
					log_message('error', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - Clave duplidada: ' . $e->getCode());
					/*
					return $this->response->setJSON([
						'status' => 'error',
						'message' => 'Clave duplicada: el registro ya existe.'
					]);*/
				}

			// Para otros errores, puedes registrar el problema y enviar una respuesta genérica
			log_message('error', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - Otros errores al insertar: ' . $e->getMessage());
			}
			/*return $this->response->setJSON([
				'status' => 'error',
				'message' => 'Ocurrió un error al guardar los datos. Intenta nuevamente.'
			]);*/

			// Error en la inserción lo toma de la Base de Datos
			$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'info');
			
			// Traemos todos los registros de la BD
			$data	= $this->unidades->obtenerTodosLosRegistros();
			
			// Llamamos a las vistas
			echo view('header');
			echo view('sweetalert2', $msgToast);            
			echo view('unidades/unidades', $data);
			echo view('footer');			

        }else{
			// Captura los errores
			$errors = $this->validation->getErrors();

			// Mostrar los errores
			foreach ($errors as $field => $error) {
				log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ . ' - Campo: ' . $field . ' Error: ' . $error);
				// echo "Error en el campo $field: $error<br>";
			}
			//echo "</pre>";
			log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - No valido las reglas ' . json_encode($this->validation->getErrors()));
			
			// Mensajes Alerta SweetAlert 2 por fallo
			$msgAlerta	= new SweetMessageModel();
			log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - instancio SweetMessageModel');
			$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'reglasinvalidas');
			if (isset($msgToast['accion']) == 'sinReglas') {
				log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - Se deben definir en sweet_message las, las alertas para: ' . $this->clase . '/' . $this->funcion);
				}
 			// Cargamos $Data para enviar a las vistas
			// Traemos todos los registros de la BD
			//$data	= $this->unidades->obtenerTodosLosRegistros();
			
			// Llamamos a las vistas
			echo view('header'); 
			echo view('sweetalert2', $msgToast);             
			echo view('unidades/nuevo', [
				'titulo'		=> 'Ingreso de dinero',
                'fecha'			=> $this->request->getPost('fechahoy'),
                'nombre'		=> $this->request->getPost('nombre'),
                'nombre_corto'	=> $this->request->getPost('nombre_corto'),
				'activo'		=> $this->request->getPost('activo'),
				'validation' 	=> $errors,
				]); 
			echo view('footer');				 

		  }
  }

	
	/* ------------------------------------------------ */
	/* Funcion insertar2()                               */
	/* ------------------------------------------------ */	
    public function insertar2(){

		// Limpiar los datos del Input: ombre y nombre_corto
        $nombre = trim($this->request->getPost('nombre'));
        $nombre_corto = trim($this->request->getPost('nombre_corto'));
        $nombre_corto = preg_replace('/\r|\n/', '', $nombre_corto); // Limpiar saltos de línea
		
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - trim Nombre: ' . $nombre);
		log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - trim Nombre_corto: ' . $nombre_corto);

		// Obtener los datos del formulario
        $datosValidar = $this->request->getPost();
d($datosValidar);		

		if($this->request->getMethod() === "POST" &&
		   $this->validation->setRules($this->reglas)->run($datosValidar)) {
		  // $this->validation->setRules($this->reglas)->run(['nombre'=>$nombre, 'nombre_corto'=>trim($nombre_corto)])) {
			// Validado
			// $errors = $validation->getErrors();
			log_message('info', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ .  ' - datos validados, proseguimos con la Insercion de los datos.');
		    // si necesito validar las reglas desde el propio controlador entones:
			// //&& $this->validate($this->reglasnombre)) {
            // Valido las Reglas
            $nombre = $this->request->getPost('nombre') ? $nombre = $this->request->getPost('nombre') : '';		
			$data = [
			    'titulo'		=> 'Ingreso de dinero',
                'fecha'			=> $this->request->getPost('fechahoy'),
                'nombre'	    => $nombre,
                'nombre_corto'	=> $nombre_corto,
            ];
			// --------------------------------------
			// Mensajes Alerta SweetAlert 2
			// --------------------------------------
			$msgAlerta	= new SweetMessageModel();
			
			// --------------------------------------
			// --==> Insertamos los datos <==---
			// --------------------------------------
			if ($this->unidades->save($data)) {
				// Insercion EXITOSA			
				// Acceso correcto al objeto db desde el modelo
				log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - Consulta ejecutada: ' . $query = $this->unidades->db->getLastQuery()); 

				// Inserción EX"TOSA - Mensajes Alerta SweetAl 2
				$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'insertar');
				// --------------------------------------
			} else {
			   // ERRORES AL INSERTAR
			   // Obtener los errores
 
				// Error en la inserción
				 log_message('error', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - Error al guardar el registro: ' . json_encode($this->unidades->errors()));
			
				// Error en la inserción lo toma de la Base de Datos
				$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'info');
			}
			// Traemos todos los registros de la BD
			$data	= $this->unidades->obtenerTodosLosRegistros();

			
			// Llamamos a las vistas
			echo view('header');
			echo view('sweetalert2', $msgToast);            
			echo view('unidades/unidades', $data);
			echo view('footer');			

        }else{
			// Captura los errores
			$errors = $this->validation->getErrors();

			// Mostrar los errores
			foreach ($errors as $field => $error) {
				log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ . ' - Campo: ' . $field . ' Error: ' . $error);
				// echo "Error en el campo $field: $error<br>";
			}
			//echo "</pre>";
			log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - No valido las reglas ' . json_encode($this->validation->getErrors()));
			

			// Mensajes Alerta SweetAlert 2 por fallo
			$msgAlerta	= new SweetMessageModel();
			log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - instancio SweetMessageModel');
			$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'reglasinvalidas');
			if (isset($msgToast['accion']) == 'sinReglas') {
				log_message('info', $this->clase . '/' . $this->funcion . ' Linea: ' . __LINE__ .  ' - Se deben definir en sweet_message las, las alertas para: ' . $this->clase . '/' . $this->funcion);
				}
 			// Cargamos $Data para enviar a las vistas
			// Traemos todos los registros de la BD
			//$data	= $this->unidades->obtenerTodosLosRegistros();
			
			// Llamamos a las vistas
			echo view('header'); 
			echo view('sweetalert2', $msgToast);             
			echo view('unidades/nuevo', [
				'titulo'		=> 'Ingreso de dinero',
                'fecha'			=> $this->request->getPost('fechahoy'),
                'nombre'		=> $this->request->getPost('nombre'),
                'nombre_corto'	=> $this->request->getPost('nombre_corto'),
				'validation' 	=> $errors,
				]); 
			echo view('footer');				 

		  }
  }

            // ------------------------------------------
            // FORMA RAPIDA DE GRABAR SIN TRANSACCIONES
            // $this->unidades->save(
            // ['nombre'=> $this->request->getPost('nombre'),
            // 'nombre_corto'=> $this->request->getPost('nombre_corto')
            // ]);   
            // ------------------------------------------
            // Obtenemos los datos de todos los Input
        //    $dataBD = $this->request->getVar();
        //    $respuesta = $this->unidades->saveBD($dataBD);

           //$this->unidades = new UnidadesModel();
        //    $this->unidades->db->transBegin();
        //    try {
        //        $this->unidades->insert([
        //            'nombre'=>$this->request->getPost('nombre'),
        //            'nombre_corto'=>$this->request->getPost('nombre_corto')
        //        ]);
   
        //        $unidades_id = $this->unidades->insertID();
        //        // ver de enviar al log de errores
        //        //$unidadesLog = $this->TransLog($this->request->getPost());
        //     //    if($unidadesLog===false){
        //     //        throw new \Exception();
        //     //    }
        //     //    $postCategory = new PostCategoryModel();
        //     //    $postCategory->insert([
        //     //        'post_id'=>$post_id,
        //     //        'category_id'=>$this->request->getPost('category_id')
        //     //    ]);
   
        //        $this->unidades->db->transCommit();
        //    } catch (\Exception $e) {
        //         $this->unidades->db->transRollback();
        //    }
           //   return redirect()->to(base_url() . '/unidades');
        //    if(isset($respuesta)===true){
        //     $s2Texto = 'Datos insertados';   
        //    }else{
        //     $s2Texto = 'No se Insertaron los datos';   
        //    }
         // $s2Texto = $respuesta  ===true             ?  'Datos insertados' : 'No se Insertaron los datos'; 
         // $s2Icono = $respuesta  ===true             ?  'success'          : 'error'; 
         // $s2ConfirmButtonText   = $respuesta===true ?  'Continuar'        : 'Continuar'; 
         // $s2ShowConfirmButton   = $respuesta===true ?  'true'             : 'false'; 
         // $s2Toast               = $respuesta===true ?  'true'             : 'error'; 
         // Verificamos si ya existe el dato
         //dd($dataBD);
         // $duplicado = $this->unidades->where('nombre_corto',$dataBD['nombre_corto'])->first();        

         // if ($duplicado=$dataBD['nombre_corto']){
            // $s2Footer = $respuesta===true ? 'true' : 'El valor "' . $duplicado . '" ya existe en la columna "Nombre Corto".';
         // }else{
            // $s2Footer = $respuesta===true ? 'true' : null;
         // }
         
         // $sweetalert2         = 'sweetalert2'; 

         // $msgToast = [
            // 's2Titulo' => $this->clase, 
            // 's2Texto' => $s2Texto,
            // 's2Icono' => $s2Icono,
            // 's2ConfirmButtonText' => $s2ConfirmButtonText,
            // 's2ShowConfirmButton' => $s2ShowConfirmButton,            
            // 's2Toast' => $s2Toast,
            // 's2Footer' => $s2Footer,
        // ];
        // $unidades = $this->unidades->where('activo',1)->findAll();
        // $data = [ 
            // 'titulo' => $this->tit, //'Unidades',
            // 'datos'  => $unidades,
			// 'fecha'  => $this->fecha_hoy,			
        // ];
		
        // echo view('header');
        // echo view($sweetalert2, $msgToast);    
		// echo view('unidades/unidades', $data);
		// echo view('footer');

        // }else{
            // $data = [ 
                // 'titulo' => 'Agregar '.$this->clase,
				// 'fecha'   	=> $this->fecha_hoy,
                // 'validation' => $this->validator 
            // ];
            // echo view('header');
            // echo view('unidades/nuevo', $data);
            // echo view('footer');
        // }        
    // }
	
	/* ------------------------------------------------ */
	/* Funcion actualizar($id)                          */
	/* ------------------------------------------------ */	
	public function actualizar($id){

		$id_desenc = Custom::desencriptoID($this->clase, $this->funcion, $id);
		log_message('debug', $this->clase . '/' . $this->funcion . ' - retornamos de la libreria Custom::desencriptoID: ' . $id);
		
	  if (!is_string($id)) {
		log_message('debug', this->clase . '/' . $this->funcion . ' - El $id recibido no es un STRING ' . $this->request->getPost('id'));	
        throw new \InvalidArgumentException("El parámetro ID debe ser una cadena de texto.");
		}
				
		// Limpiar los datos del Input: ombre y nombre_corto
        $nombre = ltrim(rtrim($this->request->getPost('nombre')));
        $nombre_corto = ltrim(rtrim($this->request->getPost('nombre_corto')));
       // $nombre_corto = preg_replace('/\r|\n/', '', $nombre_corto); // Limpiar saltos de línea
		log_message('debug', $this->clase . '/' . $this->funcion . ' - nombre DESPUES del TRIM: ' . $nombre);
	   
        // Reemplazar los datos en la solicitud
        $this->request->setGlobal('POST', [
            'nombre' => $nombre,
            'nombre_corto' => $nombre_corto,
        ]);
			
		if($this->request->getMethod() === "POST" &&
		   $this->validation->setRules($this->reglas)->run(['nombre'=>$nombre, 'nombre_corto'=>trim($nombre_corto)])) {
			// Validado
			log_message('info', $this->clase . '/' . $this->funcion . ' - Datos validados, proseguimos con la Insercion de los datos.');
	
			// Valido las Reglas
            $nombre = $this->request->getPost('nombre') ? $nombre = $this->request->getPost('nombre') : '';		
			$data = [
				'id_enc' 		=> $id,
			    'titulo'		=> 'Unidades',
                'fecha'			=> $this->request->getPost('fechahoy'),
                'nombre'	    => $nombre,
                'nombre_corto'	=> $nombre_corto,
            ];
			// --------------------------------------
			// Mensajes Alerta SweetAlert 2
			// --------------------------------------
			$msgAlerta	= new SweetMessageModel();
			
			// Verificamos que ya no exista el registro
			// --------------------------------------
			// --==> Insertamos los datos <==---
			// --------------------------------------
			try {
				$this->unidades->update($id_desenc, $data);
				// Insercion EXITOSA			
				log_message('debug', $this->clase . '/' . $this->funcion . ' - Consulta ejecutada: ' . $query = $this->unidades->db->getLastQuery()); // Acceso correcto al objeto db desde el modelo

				// Inserción EX"TOSA - Mensajes Alerta SweetAl 2
				$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'insertar');	
   
			   } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
					// --------------------------------------

				   // ERRORES AL INSERTAR
				   // Obtener los errores
	 
					// Error en la inserción
					 log_message('error', $this->clase . '/' . $this->funcion . ' - Error al guardar el registro: ' . json_encode($this->unidades->errors()));
				
					// Error en la inserción lo toma de la Base de Datos
					$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'info');
				}
			// Traemos todos los registros de la BD
			$data	= $this->unidades->obtenerTodosLosRegistros();
		
		
		// Leemos toda la tabla
        $unArray = $this->unidades->where('activo','1')->findAll();
		// Instanciamos el Servicio
		// hashids = Services::hashids();
		// Generar el ID encriptado para cada registro
		foreach ($unArray as &$dato) {		
			//$dato['id_enc'] = $hashids->encode($dato['id']);
			$dato['id_enc'] = Encripcion::encodeData($id);
			log_message('debug', $this->clase . '/' . $this->funcion . ' - ' . Encripcion::encodeData($id));
		}
		// ------------------------------------------------------------------
		// IMPORTANTE: Romper la referencia después del bucle
		unset($dato); 
		// SOLO SI NECESITO COMPROBAR "print_r($unidades);"
		// ------------------------------------------------------------------		
        $s2Icono  = null;
        $data = [ 
            'titulo'  => $this->clase,
            'datos'   => $unArray,
            's2Icono' => $s2Icono,
			'fecha'   => $this->fecha_hoy,
        ];		
		
			// Llamamos a las vistas
			echo view('header');
			echo view('sweetalert2', $msgToast);            
			echo view('unidades/unidades', $data);
			echo view('footer');				 

        }else{
			$errors = $this->validation->getErrors();

		// Mostrar los errores
			foreach ($errors as $field => $error) {
				log_message('debug', $this->clase . '/' . $this->funcion . ' - Campo: ' . $field . ' Error: ' . $error);
				echo "Error en el campo $field: $error\n";
			}
			//echo "</pre>";
			log_message('info', $this->clase . '/' . $this->funcion . ' -  No valido las reglas ' . json_encode($this->validation->getErrors()));
			// Captura los errores
			$errors = $this->validation->getErrors();
			
			dd($errors);

			// Mensajes Alerta SweetAlert 2 por fallo
			$msgAlerta	= new SweetMessageModel();
			log_message('debug', $this->clase . '/' . $this->funcion . ' - instancio SweetMessageModel');
			$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'reglasinvalidas');
			if (isset($msgToast['accion']) == 'sinReglas') {
				log_message('debug', $this->clase . '/' . $this->funcion . ' - Se deben definir en sweet_message las, las alertas para: ' . $this->clase . '/' . $this->funcion);
				}
 			// Cargamos $Data para enviar a las vistas
			// Traemos todos los registros de la BD
			//$data	= $this->unidades->obtenerTodosLosRegistros();

			// Leemos toda la tabla
			$unArray = $this->unidades->where('activo','1')->findAll();

			// Llamamos a las vistas
			echo view('header'); 
			echo view('sweetalert2', $msgToast);             
			echo view('unidades/unidades', [
				'id_enc' 		=> $id,			
				'titulo'		=> 'Unidades ',
                'fecha'			=> $this->request->getPost('fechahoy'),
			    'datos'   		=> $unArray,
                'nombre'		=> $nombre,
                'nombre_corto'	=> $nombre_corto,
				'validation' 	=> $errors,
				]); 
			echo view('footer');				 

		  }
  }
	
	/* ------------------------------------------------ */
	/* Funcion editar(string $id)                       */
	/* ------------------------------------------------ */	
    public function editar($id){
			
			$id_desenc = Custom::desencriptoID($this->clase, $this->funcion, $id);
			log_message('debug', $this->clase . ' /' . $this->funcion . ' Línea: ' . __LINE__ . ' - retornamos de la libreria Custom::desencriptoID: ' . $id);
			 
			if ( $id_desenc !== null ) {
				$unArray = $this->unidades->where('id', $id_desenc)->first();
				$unDecodedArray = json_encode($unArray);
				log_message('debug', $this->clase . '/' . $this->funcion . ' Línea: ' . __LINE__ . ' - array de datos: ' . $unDecodedArray);

				try{
					$this->unidades->update($id_desenc,	['activo' => 0]);   
					$data = [ 
						'titulo' => 'Editar '.$this->clase, 
						'datos'  => $unArray,
						'id_enc' => $id,
						'fecha'  => $this->fecha_hoy,
					];

						echo view('header');
						echo view('unidades/editar', $data);
						echo view('footer');
						
					}catch (\Exception $e) {
							return ($e->getMessage());
					}	 
			} else{
					echo "Error al tratar de acceder " . $this->clase;
					return redirect()->to(base_url().'unidades');				
			}         
    }
	
	public function testDev($id){

		print_r($id);
	
	}
	
	/* ------------------------------------------------ */
	/* Funcion eliminar($id)                            */
	/* ------------------------------------------------ */
    public function eliminar($id){
	
		$id_desenc = Custom::desencriptoID($this->clase, $this->funcion, $id);
		log_message('debug', $this->clase . '/' . $this->funcion . ' - retornamos de la libreria Custom::desencriptoID: ' . $id);
		 if ( $id_desenc !== null ) {

			$unArray = $this->unidades->where('id', $id_desenc)->first();
			$unDecodedArray = json_encode($unArray);
			log_message('debug', $this->clase . '/' . $this->funcion . ' - array de datos: ' . $unDecodedArray);

			try{
				$this->unidades->update($id_desenc,	['activo' => 0]);   
				}catch (\Exception $e) {
						return ($e->getMessage());
				}	 
			}else{
				return redirect()->to(base_url().'unidades');				
			}
		return redirect()->to(base_url().'unidades');				
    }

	/* ------------------------------------------------ */
	/* Funcion reingresar($id)                          */
	/* ------------------------------------------------ */
    public function reingresar($id){
        $this->unidades->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/unidades');
    }
 
    // ----------------------------------------------
	// Genera Excel y Pdf
	// ----------------------------------------------
	public function generaExcel(){
	   try {
			$nombreListado = 'Unidades';
			$extension = 'xlsx';
            // Simulación de datos de entrada
			$todos = $this->unidades->findAll();
			$data = [ 
				'titulo' => $nombreListado,
				'datos'  => $todos,
				'fecha'  => $this->fecha_hoy,
			];
	           // Crear una nueva hoja de cálculo
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
			$sheet->setShowGridlines(false);

            // Agregar título y fecha en el cabezal
			$tituloConFecha = $nombreListado . ' al: ' . $data['fecha'];
			$sheet->setCellValue('A1', $tituloConFecha);

            //$sheet->setCellValue('A1', $data['titulo']);
			$sheet->getStyle('A1')->applyFromArray([
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => [
						'rgb' => '4F81BD', // Fondo azul
					],
				],
				'font' => [
					'color' => ['rgb' => 'FFFFFF'], // Letras blancas
					'bold' => true,
					'size' => 14, // Tamaño de la fuente
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],
			]);
            $sheet->mergeCells('A1:F1'); // Combinar celdas para el título
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
			
			// --------------------------------------
            // Agregar encabezados para las columnas
			// --------------------------------------- 


            $headers = ['ID', 'Nombre', 'Nombre Abrev.', 'Activo'];
            $columnIndex = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($columnIndex . '2', $header);
                $sheet->getStyle($columnIndex . '2')->getFont()->setBold(true);
				$sheet->getStyle($columnIndex . '2')->applyFromArray([
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => [
							'rgb' => '0CB7F2', // Color celeste en formato hexadecimal
						],
					],
				]);

                $columnIndex++;
            }

			// --------------------------------------
            // Agregar Detalles de las filas
			// --------------------------------------- 
			
            $rowIndex = 3; // Comenzamos desde la fila 3
            foreach ($data['datos'] as $row) {
                $sheet->setCellValue('A' . $rowIndex, $row['id']);
				// Manejo para recorte de Fechas
//				$time = strtotime($row['nombre']);
//				$newformat = date('Y-m-d',$time);
//              $sheet->setCellValue('B' . $rowIndex, $newformat);

				// Procesar y limpiar 'nombre'
				$nombre = isset($row['nombre']) ? $row['nombre'] : '';
				$nombre = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombre);
				$nombre = ltrim(rtrim(substr($nombre, 0, 49))); // Solo elimina los espacios externos
	
				// Procesar y limpiar 'nombre_corto'
				$nombre_corto = isset($row['nombre_corto']) ? $row['nombre_corto'] : '';
				$nombre_corto = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombre_corto);
				$nombre_corto = ltrim(rtrim(substr($nombre_corto, 0, 9))); // Solo elimina los espacios externos
	
				$sheet->setCellValue('B' . $rowIndex, $nombre);
				$sheet->setCellValue('C' . $rowIndex, $nombre_corto);
				$sheet->setCellValue('D' . $rowIndex, $row['activo']);
				
                $rowIndex++;
            }
			// Descripcion seteada a la Izquierda
			$sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Ampliamos el ancho de Columna a la fila con mayor largo
			$columns = range('A', 'D'); // Ajusta las columnas desde 'C' hasta 'E'
			foreach ($columns as $column) {
				$sheet->getColumnDimension($column)->setAutoSize(true);
			}
			
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Recorrer la columna 'C' y eliminar espacios en blanco
			// for ($row = 1; $row <= $lastRow; $row++) {
				// $cellValue = $sheet->getCell("C{$row}")->getValue();
				// if (!is_null($cellValue)) {
				//	Eliminar espacios en blanco
					// $cleanValue = str_replace(' ', '', $cellValue); // Quita todos los espacios en blanco
					// $sheet->setCellValue("C{$row}", $cleanValue);
				// }
			// }
		
			// Ruta del directorio donde se guardarán los Excel
			$directorio = WRITEPATH . 'excel/';
				
			// Generar un nombre de archivo único con fecha/hora
			$timestamp = date('Ymd_His'); // Ejemplo: 20250129_154500
			$nombreArchivo = WRITEPATH . "excel/" . $nombreListado . "_{$timestamp}." . $extension; // Ruta del archivo		

			//$extension = substr(strrchr($nombreArchivo, '.'), 1);
			
			Custom::directorioExiste($directorio, $extension);
			// Guardar el archivo Excel en la carpeta writable
            $writer = new Xlsx($spreadsheet);
            $writer->save($nombreArchivo);
			
			//Verificar si el archivo fue creado correctamente
				if (!file_exists($nombreArchivo)) {
					throw new \Exception('Error al generar el archivo Excel !!!');
				}

				return $this->response->setJSON([
					'status' => 'success',
					'message' => 'El archivo Excel se generó correctamente.',
					//'downloadUrl' => base_url($nombreArchivo),
					'downloadUrl' => $nombreArchivo,
				]);
			} catch (\Exception $e) {
				// Devolver un error controlado
				return $this->response->setJSON([
					'status' => 'error',
					'message' => $e->getMessage(),
				]);
		}
	}
	
	public function generaPdf()
	{
		try{
			$nombreListado = 'Unidades';
			$extension = 'pdf';
			$tituloFecha   = $nombreListado . ' al ' . $this->fecha_hoy;
			// Simulación de datos de entrada
			$todos = $this->unidades->findAll();
			$data = [ 
				'titulo' => $nombreListado,
				'tituloFecha' => $tituloFecha,
				'datos'  => $todos,
				'fecha'  => $this->fecha_hoy,
			];

			// Crear una instancia de FPDI
			$pdf = new Fpdi();

			// Agregar una página
			$pdf->AddPage("portrait");

			// Agregar título al PDF
			$pdf->SetFont('Arial', 'B', 16); // Fuente Arial, Negrita, Tamaño 16
			$pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $data['tituloFecha']), 0, 1, 'C'); // Texto centrado
			$pdf->Ln(5); // Agregar espacio después del título

			// Agregar encabezados de columna
			$headers = ['ID', 'Nombre', 'Nombre Abrev.', 'Activo'];
			$pdf->SetFont('Arial', 'B', 12); // Usar Arial
			$pdf->SetFillColor(12, 183, 242); // Color celeste
			$pdf->Cell(07, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[0]), 1, 0, 'C', true);
			$pdf->Cell(80, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[1]), 1, 0, 'L', true);
			$pdf->Cell(80, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[2]), 1, 0, 'L', true);			
			$pdf->Cell(30, 10, $headers[3], 1, 1, 'C', true);

			// Rellenar los datos
			$pdf->SetFont('Arial', '', 12); // Usar Arial
			foreach ($data['datos'] as $row) {
				$pdf->Cell(7, 10, $row['id'], 1, 0, 'C');
				$pdf->Cell(80, 10, ltrim(rtrim(substr(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['nombre']), 0, 49))), 1, 0, 'L'); // "L"-left Descripción alineada a la izquierda
				$pdf->Cell(80, 10, ltrim(rtrim(substr(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['nombre_corto']), 0, 9))), 1, 0, 'L'); // "L"-left Descripción alineada a la izquierda				
				$pdf->Cell(30, 10, $row['activo'], 1, 1, 'C');
			}

			// Agregar un espacio
			$pdf->Ln(10);

			// Si se genero OK avisamos
			// Ruta del directorio donde se guardarán los Excel
			$directorio = WRITEPATH . 'pdf/';


			// Verificar si el directorio existe; si no, crearlo
			Custom::directorioExiste($directorio, $extension);
			// Generar un nombre de archivo único con fecha/hora
			$timestamp = date('Ymd_His'); // Ejemplo: 20250129_154500
			$nombreArchivo = WRITEPATH . "pdf/" . $nombreListado . "_{$timestamp}." . $extension; // Ruta del archivo

			// Guardar el archivo Excel en la carpeta writable
			//   $writer = new Xlsx($spreadsheet);
			//   $writer->save($nombreArchivo);
				// Salida del archivo PDF al navegador
				//return $this->response
				/*
				return	$this->response
					->setContentType('application/pdf')
					->setBody($pdf->Output('S')); // La opción 'S' envía el contenido como cadena
				*/
			// Guardar el archivo PDF en el servidor
			$pdf->Output($nombreArchivo, 'F'); // Guardar en el servidor
		
			// Verificar si el archivo fue creado correctamente
			if (!file_exists($nombreArchivo)) {
				throw new \Exception('Error al generar el archivo Pdf.');
			}

			return $this->response->setJSON([
				'status' => 'success',
				'message' => 'El archivo Pdf se generó correctamente.',
				//'downloadUrl' => base_url($nombreArchivo),
				'downloadUrl' => $nombreArchivo,
			]);
			} catch (\Exception $e) {
				// Devolver un error controlado
			//	echo "<script>console.log($e->getMessage());</script>";
			//	echo "<script>alert('Exception ' . $e->getMessage());</script>";
				return $this->response->setJSON([
					'status' => 'error',
					'message' => $e->getMessage(),
				]);
		}
	}
// Fin Clase
}