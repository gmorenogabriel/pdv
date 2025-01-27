<?php namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\ClientesModel;
use App\Libraries\Toastr; 

class Clientes extends BaseController{

    protected $clientes;
    protected $reglas;
    protected $clase;

    public function __construct(){
        $this->session = session();
        $this->clientes = new ClientesModel();

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

		// Encripta/Desencripta
    //	$this->CI->load->library('encryption');        helper(['form']);
        helper(['form']);
        // Variables para nuestras reglas de validac.del Form
        $this->reglas = [
            'nombre' => [               
                'rules' => 'required',
                'errors' =>  [
                    'required'=> 'El campo {field} es obligatorio.'
                    ]
                ],

            'direccion' =>  [
                    'rules' => 'required',
                    'errors' => [
                        'required'=> 'El campo {field} es obligatorio.',
                        'is_unique'=> 'El campo {field} debe ser único.'
                    ]
                ]
            ];
    }

    public function index($activo = 1)
    {
        // Si no está Logueado lo manda a IDENTIFICARSE
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        
        $clientes = $this->clientes->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Clientes',
            'datos' => $clientes
        ];
		echo view('header');
		echo view($this->clase.'/'.$this->clase, $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function eliminados($activo = 0)
    {
        $clientes = $this->clientes->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Clientes eliminadas',
            'datos' => $clientes
        ];
		echo view('header');
		echo view('clientes/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){		

    //    $unidades = $this->unidades->where('activo', 1 )->findAll();
    //    $categorias = $this->categorias->where('activo', 1)->findAll();

        $data = [ 
            'titulo'     => 'Agregar '.$this->clase];
            /*,
            'unidades'   => $unidades,
            'categorias' => $categorias,
            ];
            */
        echo view('header');
        echo view($this->clase.'/nuevo', $data);
		echo view('footer');
    }
    public function insertar(){
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
        
            $this->clientes->save(
            ['codigo' => $this->request->getPost('codigo'),
            'nombre'=> $this->request->getPost('nombre'),
            'precio_venta'=> $this->request->getPost('precio_venta'),
            'precio_compra'=> $this->request->getPost('precio_compra'),
            'stock_minimo'=> $this->request->getPost('stock_minimo'),
            'inventariable'=> $this->request->getPost('inventariable'),
            'id_unidad'=> $this->request->getPost('id_unidad'),
            'id_categoria'=> $this->request->getPost('id_categoria')
            ]);   
           // return redirect()->to(base_url().'/clientes');
           $clientes = $this->clientes->findAll();
           $data = [ 
               'titulo' => $this->clase,
               'datos'  => $clientes,
               'fecha'  => $this->fecha_hoy,
           ];    
           $msgToast = [
               's2Titulo' => $this->clase, 
               's2Texto'  => 'Ingreso Actualizado',
               's2Icono'  => 'success',
               's2Toast'  => 'true'
           ];
           echo view('header');
           echo view('sweetalert2', $msgToast);            
           echo view($this->clase.'/'.$this->clase, $data);
           echo view('footer');

        }else{
            // Error NO Valido las Reglas
            $data = [ 
                'titulo'     => 'Ingreso de dinero', 
                'fecha'      => $this->fecha_hoy,
                'validation' => $this->validator,
        ];
            $msgToast = [
                    's2Titulo' => $this->clase, 
                    's2Texto' => 'No se validaron las reglas.',
                    's2Icono' => 'warning',
                    's2Toast' => 'true'
                ];
                echo view('header');
                echo view('sweetalert2', $msgToast);
                echo view($this->clase.'/'.$this->clase, $data);
                echo view('footer');
        }
    }

    public function editar($id){
        // $unidades = $this->unidades->where('activo', 1 )->findAll();
        // $categorias = $this->categorias->where('activo', 1)->findAll();
        $clientes = $this->clientes->where('id', $id)->first();
        $data = [ 
            'titulo' => 'Editar '.$this->clase, 
            'clientes'  => $clientes
        ];
            // 'unidades'   => $unidades
            // 'categorias' => $categorias,
            // 
        echo view('header');
		echo view('clientes/editar', $data);
		echo view('footer');
    }
    public function actualizar(){
        
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
        
            $this->clientes->update($this->request->getPost('id'),
                [
                'nombre'=> $this->request->getPost('nombre'),
                'direccion'=> $this->request->getPost('direccion'),
                'telefono'=> $this->request->getPost('telefono'),
                'correo'=> $this->request->getPost('correo'),
                ]);   
        
            // return redirect()->to(base_url().'/clientes');
            $msgToast = [
                's2Titulo' => $this->clase,
                's2Texto'  => 'Ingreso Actualizado',
                's2Icono'  => 'success',
                's2Toast'  => 'true'
            ];
            $clientes = $this->clientes->findAll();
            $data = [ 
                'titulo' => $this->clase,
                'datos'  => $clientes,
                'fecha'  => $this->fecha_hoy,
            ];    
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view($this->clase .'/'.$this->clase, $data);
            echo view('footer');
        }else{
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'No se validaron las reglas.',
                's2Icono' => 'warning',
                's2Toast' => 'true'
            ];
            $clientes = $this->clientes->where('activo',1)->findAll();
            $data = [ 
                'titulo' => $this->clase,
                'fecha'  => $this->fecha_hoy,
                'datos'  => $clientes
            ];
    
            echo view('header');
            echo view('sweetalert2', $msgToast);
            echo view('flujocaja/entradas', $data);
            echo view('footer');
        }
    }
    public function eliminar($id){
        $this->clientes->update($id,
            [
               'activo' => 0
            ]);   
        return redirect()->to(base_url().'/clientes');
    }
    public function reingresar($id){
        $this->clientes->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/clientes');
    }
}


