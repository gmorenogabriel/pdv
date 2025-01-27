<?php namespace App\Controllers;

//include APPPATH . 'Libraries/Backend_lib.php';

use App\Controllers\BaseController;
use App\Models\CategoriasModel;


class Categorias extends BaseController
{
    protected $clase;
    protected $categorias;

    public function __construct(){
        //$this->session = session();
        helper(['url','security']);
        //$this->config         = new \Config\Encryption();
        $this->categorias = new CategoriasModel();
        $router = \Config\Services::router();
        $_method = $router->methodName();
        $_controller = $router->controllerName();         
        $controlador = explode('\\', $_controller) ;
        $this->clase = $controlador[max(array_keys($controlador))] ;	
    }
    public function index($activo = 1){
        // Si no está Logueado lo manda a IDENTIFICARSE
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $categorias = $this->categorias->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Categorias',
            'datos' => $categorias
        ];
		echo view('header');
		echo view('categorias/categorias', $data);
		echo view('footer');
    }
    public function eliminados($activo = 0)
    {
        $categorias = $this->categorias->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Categorias eliminadas',
            'datos' => $categorias
        ];
		echo view('header');
		echo view('categorias/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){
        $data = [ 
            'titulo' => 'Agregar categoría'];

        echo view('header');
		echo view('categorias/nuevo', $data);
		echo view('footer');
    }
    public function insertar(){
        $this->categorias->save(
            ['nombre'=> $this->request->getPost('nombre')
            ]);   
//        return redirect()->to(base_url().'/categorias');
        $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => 'Datos insertados',
            's2Icono' => 'success',
            's2Toast' => 'true'
        ];
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $data = [ 
            'titulo' => $this->clase,
            'datos' => $categorias
        ];
        echo view('header');
        echo view('sweetalert2', $msgToast);            
        echo view($this->clase.'/'.$this->clase, $data);
        echo view('footer');        
    }
    public function editar($id){
        if ( null !== $id) {
			// Controlamos recibir cargado el id Encriptado
            // por si editaron la URL 
   		try {
                $id_desenc = base64_decode($id);
                echo $id_desenc;
                echo "<br>";
                $categoria = $this->categorias->where('id', $id_desenc)->where('activo', 1)->first();
                $allCat    = $this->categorias->where('activo', 1)->findAll();
                $data = [ 
                    'titulo'   => 'Editar ' . $this->clase, 
                    'una_cat'  => $categoria,
                    'todascat' => $allCat,
                    'id_enc'   => $id_desenc,
                ];
                // foreach ($allCat as $key){
                //     var_dump($key['id']); 
                //     echo "<br>";
                // }
                // echo ("Seleccionado id: ") ;
                //  var_dump($data['id_cat']) ;
                // echo "<br>";
                // die();
                echo view('header');
                echo view('categorias/editar', $data);
                echo view('footer');
                } catch (\Exception $e){
						die($e->getMessage());
				}       
		}
    }
    public function actualizar(){
        try {

            $id = $this->request->getPost('id');   
            $id_desenc = base64_decode($id);
		   }catch (\Exception $error){
				  var_dump($error->getMessage());
		   }           
        //$this->categorias->update($this->request->getPost('id'),
        
        $this->categorias->update($id_desenc,
            [
            'nombre'=> $this->request->getPost('nombre')
            ]);               
        
        //return redirect()->to(base_url().'/categorias');
        $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => 'Actualizado',
            's2Icono' => 'success',
            's2Toast' => 'true'
        ];
        $categorias = $this->categorias->where('activo',1)->findAll();
        $data = [ 
            'titulo' => $this->clase,
            'datos' => $categorias
        ];
        echo view('header');
        echo view('sweetalert2', $msgToast);            
		echo view($this->clase . '/'. $this->clase, $data);
		echo view('footer');
    }
    public function eliminar($id){
        try {
            $id = $this->categorias->request->getPost('id');    
            $id_desenc = base64_decode($id);
		   }catch (\Exception $error){
				  var_dump($error->getMessage());
		   }         
        $this->categorias->update($id_desenc,
            [
               'activo' => 0
            ]);   
       // return redirect()->to(base_url().'/categorias');
       $msgToast = [
        's2Titulo' => $this->clase, 
        's2Texto' => 'Eliminado',
        's2Icono' => 'success',
        's2Toast' => 'true'
        ];
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $data = [ 
            'titulo' => 'Categorias',
            'datos' => $categorias
        ];
        echo view('header');
        echo view('sweetalert2', $msgToast);            
        echo view('categorias/categorias', $data);
        echo view('footer');

    }
    public function reingresar($id){
    try {        
        $id_desenc = base64_decode($id);
       }catch (\Exception $error){
              var_dump($error->getMessage());
       }         

        $this->categorias->update($id_desenc,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/' . $this->clase );
    }
}