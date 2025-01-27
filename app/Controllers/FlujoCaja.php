<?php namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\FlujoCajaModel;
use App\Libraries\Toastr;

class FlujoCaja extends BaseController{

    protected $flujocaja;
    protected $reglasEntrada, $reglasSalida;
    protected $clase;

    public function __construct()
    {
        $this->empresa = Config('Custom');
		
		$this->tit = $this->empresa->empresaTitulo;
		$this->dir = $this->empresa->empresaDireccion;
        $this->ruc = $this->empresa->empresaRuc;
        
        helper(['form','url','number']);        
        
        $this->flujocaja = new FlujoCajaModel();
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
        $this->reglasEntrada = [
            'entrada' =>  [
                'rules' => 'required|numeric|is_natural_no_zero',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'numeric'=> 'El campo {field} no es numérico.',
                    'is_natural_no_zero'=> 'El campo {field} debe ser mayor a 0.',                    
                ]
            ],
            'descripcion' =>  [
                'rules' => 'trim|required|min_length[5]|max_length[200]',
                'errors' => [
                    'required'=> 'El campo "Descripción" es obligatorio.',
                    'min_length' => 'El largo del campo {field} debe ser mayor a 5.',
                    'max_length' => 'El largo maximo {field} debe ser menor o igual a 200.',

                ]
            ]
        ];
        $this->reglasSalida = [
            'salida' =>  [
                'rules' => 'required|numeric|is_natural_no_zero',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'numeric'=> 'El campo {field} no es numérico.',
                    'is_natural_no_zero'=> 'El campo {field} debe ser mayor a 0.',
                ]
            ],
            'descripcion' =>  [
                'rules' => 'trim|required|max_length[200]',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index()    {
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $locale = $this->request->getLocale();  
        // echo $locale;
        // echo lang('Translate.form_validation_required');
        $flujocaja = $this->flujocaja->findAll();
        $data = [ 
            'titulo' => 'Flujo de Caja',
            'datos'  => $flujocaja,
            'fecha'  => $this->fecha_hoy,
        ];

        echo view('header');
		echo view('flujocaja/flujocaja', $data);
		echo view('footer');
    }
    
    public function salidas()
    {
        $flujocaja = $this->flujocaja->findAll();
        $data = [ 
            'titulo' => 'Egresos de dinero',
            'datos' => $flujocaja,
            'fecha'  => $this->fecha_hoy,
        ];
		echo view('header');
		echo view('flujocaja/salidas', $data);
		echo view('footer');
	}
    public function entradas(){
            
        $data = [
            'titulo' => 'Ingreso de dinero',
            'fecha'  => $this->fecha_hoy,
        ];
        echo view('header');
		echo view('flujocaja/entradas', $data);
		echo view('footer');
    }
    public function guardarentrada(){

        if($this->request->getMethod() == "post" && $this->validate($this->reglasEntrada)){
            // Valido las Reglas
            $entrada = $this->request->getPost('entrada') ? $entrada = $this->request->getPost('entrada') : 0;
            $saldo  = $this->flujocaja->saldoActual();
            $entrada= $this->request->getPost('entrada');
            $saldo=$saldo+$entrada;

            $this->flujocaja->save([
                'fecha' => $this->request->getPost('fechahoy'),
                'descripcion'=> $this->request->getPost('descripcion'),
                'entrada'=> number_format($entrada, 2, ',', '.'),
                'salida'=> '0',
                'saldo'=> $saldo,
            ]);   
            $flujocaja = $this->flujocaja->findAll();
            $data = [ 
                'titulo' => 'Flujo de Caja',
                'datos'  => $flujocaja,
                'fecha'  => $this->fecha_hoy,
            ];    
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto'  => 'Ingreso Actualizado',
                's2Icono'  => 'success',
                's2Toast'  => 'true',
                's2Footer' => 'Error Codigo duplicado',
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
		    echo view('flujocaja/flujocaja', $data);
		    echo view('footer');
            // return redirect()->to(base_url() . '/flujocaja');
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
                echo view('flujocaja/entradas', $data);
                echo view('footer');
        }
    }

    public function guardarsalida(){

        if($this->request->getMethod() == "post" && $this->validate($this->reglasSalida)){
            // Valido las Reglas
            $saldo  = $this->flujocaja->saldoActual();
            $salida=  $this->request->getPost('salida');
            $saldo=$saldo-$salida;

            $this->flujocaja->save([
                'fecha' => $this->request->getPost('fechahoy'),
                'descripcion'=> $this->request->getPost('descripcion'),
                'entrada'=> '0',
                'salida'=> $salida,
                'saldo'=> $saldo,
            ]);   
            $flujocaja = $this->flujocaja->findAll();
            $data = [ 
                'titulo' => 'Flujo de Caja',
                'datos'  => $flujocaja,
                'fecha'  => $this->fecha_hoy,
            ];    
            $msgToast = [
                's2Titulo' => $this->clase,  
                's2Texto' => 'Egreso Actualizado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
		    echo view('flujocaja/flujocaja', $data);
		    echo view('footer');
            //return redirect()->to(base_url() . '/flujocaja');
        }else{
            // Error NO Valido las Reglas
            $data = [ 
                'titulo'     => 'Salida de dinero', 
                'fecha'      => $this->fecha_hoy,
                'validation' => $this->validator,
        ];

            $msgToast = [
                    's2Titulo' => 'FlujoCaja->', 
                    's2Texto' => 'No se validaron las reglas.',
                    's2Icono' => 'warning',
                    's2Toast' => 'true'
                ];
                echo view('header');
                echo view('sweetalert2', $msgToast);
                echo view('flujocaja/salidas', $data);
                echo view('footer');
        } 
    }
}
