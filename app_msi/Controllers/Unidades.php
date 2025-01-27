<?php namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\UnidadesModel;


class Unidades extends BaseController
{
    protected $clase;
    protected $unidades;
    protected $reglas;
    //protected $empresa;

    public function __construct()
    {
        helper(['form']);

        // $this->session = session();
        $this->empresa = Config('Custom');
		
		$this->tit = $this->empresa->empresaTitulo;
		$this->dir = $this->empresa->empresaDireccion;
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
  
        // Variables para nuestras reglas de validac.del Form
        $this->reglas = [
            'nombre' =>  [
                'rules' => 'required',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.'
                ]
                ],
            'nombre_corto' => [               
                'rules' => 'required',
                'errors' =>  [
                    'required'=> 'El campo {field} es obligatorio.'
                    ]
                ]
            ];

    }
    public function index($activo = 1){
        // Si no está Logueado lo manda a IDENTIFICARSE
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $locale = $this->request->getLocale();  
        //echo $locale;
        //echo lang('Translate.form_validation_required');
        $unidades = $this->unidades->where('activo',$activo)->findAll();
        $s2Icono  = null;
        $data = [ 
            'titulo'  => $this->clase,
            'datos'   => $unidades,
            's2Icono' => $s2Icono,
        ];
		echo view('header');
		echo view('unidades/unidades', $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function eliminados($activo = 0)
    {
        $unidades = $this->unidades->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Unidades eliminadas',
            'datos' => $unidades
        ];
		echo view('header');
		echo view('unidades/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){
        $data = [ 
            'titulo' => 'Agregar '.$this->clase,
            'validation' => null,
        ];

        echo view('header');
		echo view($this->clase.'/nuevo', $data);
		echo view('footer');
    }
    public function insertar(){
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
            // ------------------------------------------
            // FORMA RAPIDA DE GRABAR SIN TRANSACCIONES
            // $this->unidades->save(
            // ['nombre'=> $this->request->getPost('nombre'),
            // 'nombre_corto'=> $this->request->getPost('nombre_corto')
            // ]);   
            // ------------------------------------------
            // Obtenemos los datos de todos los Input
            $dataBD = $this->request->getVar();
            $respuesta = $this->unidades->saveBD($dataBD);

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
         $s2Texto = $respuesta  ===true             ?  'Datos insertados' : 'No se Insertaron los datos'; 
         $s2Icono = $respuesta  ===true             ?  'success'          : 'error'; 
         $s2ConfirmButtonText   = $respuesta===true ?  'Continuar'        : 'Continuar'; 
         $s2ShowConfirmButton   = $respuesta===true ?  'true'             : 'false'; 
         $s2Toast               = $respuesta===true ?  'true'             : 'error'; 
         // Verificamos si ya existe el dato
         //dd($dataBD);
         $duplicado = $this->unidades->where('nombre_corto',$dataBD['nombre_corto'])->first();        

         if ($duplicado=$dataBD['nombre_corto']){
            $s2Footer = $respuesta===true ? 'true' : 'El valor "' . $duplicado . '" ya existe en la columna "Nombre Corto".';
         }else{
            $s2Footer = $respuesta===true ? 'true' : null;
         }
         
         $sweetalert2         = 'sweetalert2'; 

         $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => $s2Texto,
            's2Icono' => $s2Icono,
            's2ConfirmButtonText' => $s2ConfirmButtonText,
            's2ShowConfirmButton' => $s2ShowConfirmButton,            
            's2Toast' => $s2Toast,
            's2Footer' => $s2Footer,
        ];
        $unidades = $this->unidades->where('activo',1)->findAll();
        $data = [ 
            'titulo' => $this->tit, //'Unidades',
            'datos' => $unidades
        ];
        echo view('header');
        echo view($sweetalert2, $msgToast);    
		echo view('unidades/unidades', $data);
		echo view('footer');

        }else{
            $data = [ 
                'titulo' => 'Agregar '.$this->clase,
                'validation' => $this->validator 
            ];
            echo view('header');
            echo view('unidades/nuevo', $data);
            echo view('footer');
        }        
    }
    public function editar($id, $valid=null){
        if ( null !== $id) {
			// Controlamos recibir cargado el id Encriptado
            // por si editaron la URL 
   		try {
            $id_desenc = base64_decode($id);
            $unidad = $this->unidades->where('id',$id_desenc)->first();
            
            if($valid != null){
                $data = [ 
                    'titulo' => 'Editar '.$this->clase,
                    'datos'  => $unidad,
                    'validation' => $valid
                ];
            }else{
                $data = [ 
                    'titulo' => 'Editar '.$this->clase, 
                    'datos'  => $unidad,
                    'id_enc' => $id_desenc,
                ];
            }
            echo view('header');
            echo view('unidades/editar', $data);
            echo view('footer');
            } catch (\Exception $e){
                die($e->getMessage());
            }          
        }  else {
             echo "Error al tratar de acceder " . $this->clase;
        }          
    }
    public function actualizar(){
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
            try {

                $id = $this->request->getPost('id');   
                $id_desenc = base64_decode($id);
               }catch (\Exception $error){
                      var_dump($error->getMessage());
               }           
            $this->unidades->update($id_desenc,
                [
                'nombre'=> $this->request->getPost('nombre'),
                'nombre_corto'=> $this->request->getPost('nombre_corto')
                ]);   
           // return redirect()->to(base_url().'/unidades');
           $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto'  => 'Ingreso Actualizado',
            's2Icono'  => 'success',
            's2Toast'  => 'true'
            ];           
            $unidades = $this->unidades->where('activo', 1)->findAll();
            $data = [ 
                'titulo' => $this->clase,
                'datos'  => $unidades
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('unidades/unidades', $data);
            echo view('footer');    
        }else{
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'No se validaron las reglas.',
                's2Icono' => 'warning',
                's2Toast' => 'true'
            ];
            $unidades = $this->unidades->where('activo', 1)->findAll();
            $data = [ 
                'titulo' => $this->tit, 
                'fecha'  => $this->fecha_hoy,
                'datos'  => $unidades
            ];
    
            echo view('header');
            echo view('sweetalert2', $msgToast);
            echo view('flujocaja/entradas', $data);
            echo view('footer');
        }
    }
    public function eliminar($id){
        $this->unidades->update($id,
            [
               'activo' => 0
            ]);   
        return redirect()->to(base_url().'/unidades');
    }
    public function reingresar($id){
        $this->unidades->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/unidades');
    }
}