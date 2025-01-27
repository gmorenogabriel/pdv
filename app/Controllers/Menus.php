<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenusModel;

class Menus extends BaseController{


    protected $clase;
    protected $reglas;

    public function __construct(){
    
        $this->menus = new MenusModel();

        $router = \Config\Services::router();
        $_method = $router->methodName();
        $_controller = $router->controllerName();         
        $controlador = explode('\\', $_controller) ;
        $this->clase = $controlador[max(array_keys($controlador))] ;

    }

    public function index($activo = 1){
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $menus = $this->menus->where('activo',$activo)->findAll();
        $data = [ 
            'titulo'   => $this->clase,
            'datos'    => $menus,
        ];
		echo view('header');
		echo view('menus/menus', $data);
		echo view('footer');
    }
    public function eliminados($activo = 0)
    {
        $menus = $this->menus->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => $this->clase,
            'datos' => $menus
        ];
		echo view('header');
		echo view('menus/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){		

        if (!empty($menus)) {
             $data = [ 
                'titulo'  => 'Agregar '. $this->clase,
            ];
        }else{
            $data = [ 
                'titulo'  => 'Agregar '. $this->clase,
                ];            
        }

        echo view('header');
		echo view('menus/nuevo', $data);
		echo view('footer');
    }

    public function validoReglasRecargaPermisos(){
        $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => 'Datos insertados',
            's2Icono' => 'success',
            's2Toast' => 'true'
        ];

        $menus = $this->menus->where('activo',1)->findAll();

        // $categorias = $this->categorias->where('activo', 1)->findAll();

        $data = [ 
            'titulo' => $this->clase,
            'datos' => $menus,
        ];
        echo view('header');
        echo view('sweetalert2', $msgToast);            
        echo view('menus/permisos', $data);
        echo view('footer');
    }

    public function insertar(){
        if($this->request->getMethod() == "post"){
            $this->menus->save(
                 ['nombre' => $this->request->getPost('nombre'),
                'link'=> $this->request->getPost('link'),
                'activo' => 1
                ]);   
        }       
        return redirect()->to(base_url() . '/menus'); 
    }
    public function editar($id){
        $menus = $this->menus->where('id', $id)->first();
       // $menus = $this->menus->where('id', $id)->where('activo', 1)->first();
    
        $data = [
            'titulo' => 'Editar ' . $this->clase,   
            'menus' => $menus,
            ];
        echo view('header');
        //echo view('sweetalert2', $msgToast);                    
		echo view('menus/editar', $data);
		echo view('footer');
    }
    public function actualizar(){
        $this->menus->update($this->request->getPost('id'),
            ['nombre' => $this->request->getPost('nombre'),
            'link'=> $this->request->getPost('link'),
            'activo'=> 1,
            ]);   

            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Actualizado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $menus = $this->menus->where('activo',1)->findAll();
            $data = [ 
                'titulo' => $this->clase,
                'datos' => $menus
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view($this->clase . '/'. $this->clase, $data);
            echo view('footer');
    }
    public function eliminar($id){
        $this->menus->update($id,
            [
               'activo' => 0
            ]);   
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Eliminado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $menus = $this->menus->where('activo',1)->findAll();
            $data = [ 
                'titulo' =>  $this->clase,
                'datos' => $menus
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('menus/menus', $data);
            echo view('footer');        
    }
    public function reingresar($id){
        $this->menus->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/'.$this->clase);
    }
    public function buscarPorCodigo($id){
        $this->menus->select('*');
        $this->menus->where('id', $id);
        $this->menus->where('activo', '1');
        $datos = $this->menus->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';
        $error = '';
        if($datos){
            $res['datos'] = $datos;
            $res['existe'] = true;
        }else{
            $res['error']  = 'No existe el Menu';
            $res['existe'] = false;
        }
        echo json_encode($res);
    }
}


