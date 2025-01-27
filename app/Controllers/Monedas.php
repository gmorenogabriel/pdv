<?php namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\MonedasModel;
use App\Controllers\Console;

class Monedas extends BaseController{

    protected $monedas;
    protected $reglas;
    //protected $empresa;

    public function __construct()
    {
        $this->empresa = Config('Custom');
		
		$this->tit = $this->empresa->empresaTitulo;
		$this->dir = $this->empresa->empresaDireccion;
        $this->ruc = $this->empresa->empresaRuc;
        
        $this->monedas = new MonedasModel();
      
        helper(['form','url','number']);
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
            'moneda' =>  [
                'rules' => 'required',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',           
                ]
            ],
            'nombre' =>  [
                'rules' => 'trim|required|min_length[5]|max_length[30]',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'min_length' => 'El largo del campo {field} debe ser mayor a 5.',
                    'max_length' => 'El largo maximo {field} debe ser menor o igual a 30.',
                ]
            ],
            'nombre_corto' =>  [
                'rules' => 'trim|required|min_length[3]|max_length[5]',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'min_length' => 'El largo del campo {field} debe ser mayor a 2.',
                    'max_length' => 'El largo maximo {field} debe ser menor o igual a 5.',
                ]
            ],
            'simbolo' =>  [
                'rules' => 'required|min_length[1]|max_length[3]',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'min_length' => 'El largo del campo {field} debe ser mayor a 1.',
                    'max_length' => 'El largo maximo {field} debe ser menor o igual a 3.',
                ]
            ],            
            'tipo_moneda' =>  [
                'rules' => 'trim|required|alpha_numeric',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'alpha_numeric'=> 'El campo {field} es alfa numérico.',
                ]
            ],            
            'divide_mult' =>  [
                'rules' => 'trim|required|alpha_numeric',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'alpha_numeric'=> 'El campo {field} es alfa numérico.',
                ]
            ],            

        ];
    }

    public function index($activo = 1){
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $locale = $this->request->getLocale();  
        //echo lang('Translate.form_validation_required');
        $monedas = $this->monedas->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Monedas',
            'datos' => $monedas
        ];
		echo view('header');
		echo view('monedas/monedas', $data);
		echo view('footer');
    }
    public function eliminados($activo = 0)
    {
        $monedas = $this->monedas->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Monedas eliminadas',
            'datos' => $monedas
        ];
		echo view('header');
		echo view('monedas/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){
        $data = [ 
            'titulo' => 'Agregar moneda'];
        echo view('header');
		echo view('monedas/nuevo', $data);
		echo view('footer');
    }
    public function insertar(){
        
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
        
            $this->monedas->save([
                'moneda'=> $this->request->getPost('moneda'),
                'nombre'=> $this->request->getPost('nombre'),
                'nombre_corto'=> $this->request->getPost('nombre_corto'),
                'simbolo'=> $this->request->getPost('simbolo'),
                'tipo_moneda'=> $this->request->getPost('tipo_moneda'),
                'divide_mult'=> $this->request->getPost('divide_mult'),
                'tc_compra'=> $this->request->getPost('tc_compra'),
                'tc_venta'=> $this->request->getPost('tc_venta'),
                'activo'=> '1',
            ]);   
            // return redirect()->to(base_url() . '/monedas');
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Datos insertados',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $monedas = $this->monedas->where('activo',1)->findAll();
            $data = [ 
                'titulo' => $this->tit,
                'datos' => $monedas
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);    
            echo view('unidades/unidades', $data);
            echo view('footer');            
        }else{
            $data = [ 
                'titulo' => 'Agregar '.$this->clase, 
                'validation' => $this->validator
             ];
    
            echo view('header');
            echo view('monedas/nuevo', $data);
            echo view('footer');
        }        
    }

    public function editar($id, $valid=null){
        $moneda = $this->monedas->where('id',$id)->first();

        if($valid != null){
            $data = [ 
                'titulo' => 'Editar moneda', 
                'datos'  => $moneda,
                'validation' => $valid
            ];
        }else{
            $data = [ 
                'titulo' => 'Editar moneda', 
                'datos'  => $moneda
            ];
        }
        echo view('header');
		echo view('monedas/editar', $data);
		echo view('footer');
    }
    public function actualizar(){
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){

            $this->monedas->update($this->request->getPost('id'),
                [
                'nombre'=> $this->request->getPost('nombre'),
                'nombre_corto'=> $this->request->getPost('nombre_corto')
                ]);   
    //        return redirect()->to(base_url().'/monedas');
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Ingreso Actualizado',
                's2Icono' => 'success',
                's2Toast' => 'true'
                ];           
                $monedas = $this->monedas->where('activo', 1)->findAll();
                $data = [ 
                    'titulo' => $this->clase,
                    'datos' => $monedas
                ];
                echo view('header');
                echo view('sweetalert2', $msgToast);            
                echo view('unidades/unidades', $data);
                echo view('footer');

        }else{

            // return $this->editar($this->request->getPost('id'), $this->validator);
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'No se validaron las reglas.',
                's2Icono' => 'warning',
                's2Toast' => 'true'
            ];
            $monedas = $this->monedas->where('activo',1)->findAll();
            $data = [ 
                'titulo' => $this->tit, 
                'fecha'  => $this->fecha_hoy,
                'datos'  => $monedas
            ];
    
            echo view('header');
            echo view('sweetalert2', $msgToast);
            echo view('flujocaja/entradas', $data);
            echo view('footer');


        }
    }
    public function eliminar($id){
        $this->monedas->update($id,
            [
               'activo' => 0
            ]);   
        return redirect()->to(base_url().'/monedas');
    }
    public function reingresar($id){
        $this->monedas->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/monedas');
    }
}
