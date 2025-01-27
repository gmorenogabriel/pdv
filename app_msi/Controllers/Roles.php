<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermisosModel;
use App\Models\RolesModel;
use App\Models\MenusModel;

class Roles extends BaseController{


    protected $clase;
    protected $permisos;
    protected $reglas;

    public function __construct(){
        $this->permisos = new PermisosModel();
        $this->roles = new RolesModel();
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
        $permisos = $this->permisos->where('activo',$activo)->findAll();
        $menus = $this->menus->where('activo',$activo)->findAll();
        $roles = $this->roles->where('activo',$activo)->findAll();
        $data = [ 
            'titulo'   => $this->clase,
            'menus'    => $menus,
            'roles'    => $roles,
            'permisos' => $permisos,
        ];
		echo view('header');
		echo view('roles/roles', $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function eliminados($activo = 0)
    {
        $permisos = $this->permisos->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Permisos eliminadas',
            'datos' => $permisos
        ];
		echo view('header');
		echo view('permisos/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){		

        $roles = $this->roles->where('activo', 1 )->findAll();

        $data = [ 
            'titulo'     => 'Agregar permiso',
            'roles'   => $roles,
            ];

        echo view('header');
		echo view('permisos/nuevo', $data);
		echo view('footer');
    }

    public function validoReglasRecargaPermisos(){
        $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => 'Datos insertados',
            's2Icono' => 'success',
            's2Toast' => 'true'
        ];

        $permisos = $this->permisos->where('activo',1)->findAll();
        $roles = $this->roles->where('activo', 1 )->findAll();
        // $categorias = $this->categorias->where('activo', 1)->findAll();

        $data = [ 
            'titulo' => $this->clase,
            'datos' => $permisos,
            'roles'   => $roles,
        ];
        echo view('header');
        echo view('sweetalert2', $msgToast);            
        echo view('permisos/permisos', $data);
        echo view('footer');
    }
    public function novalidoReglasRecargaPermisos(){
        $roles = $this->roles->where('activo', 1 )->findAll();
//        $categorias = $this->categorias->where('activo', 1)->findAll();

        $data = [ 
            'titulo'     => $this->clase,
            'roles'   => $roles,
  //          'categorias' => $categorias,
            'validation' => $this->validator 
            ];        
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'No se validaron las reglas.',
                's2Icono' => 'warning',
                's2Toast' => 'true'
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);                    
            echo view('permisos/nuevo', $data);
            echo view('footer');
    }
    public function insertar(){
        if($this->request->getMethod() == "post"){
            // Valido las Reglas
            $this->permisos->save(
            ['menu_id' => $this->request->getPost('menu_id'),
            'rol'=> $this->request->getPost('rol_id'),
            'rol_id'=> $this->request->getPost('read'),
            'read'=> $this->request->getPost('read'),
            'insert'=> $this->request->getPost('insert'),
            'update'=> $this->request->getPost('update'),
            'delete'=> $this->request->getPost('delete'),
            ]);   

            $this->validoReglasRecargaPermisos();
        }else{
            $this->novalidoReglasRecargaPermisos();
        }        
    }
    public function editar($id){
        
        $permiso = $this->permisos->where('id',$id)->where('activo', 1)->first();

        $roles = $this->roles->where('activo', 1 )->findAll();
        $menus = $this->menus->where('activo', 1)->findAll();       

        $id = $permiso['id'];
    
        $data = [
            'titulo' => 'Editar ' . $this->clase,   
            'menu_id' => $permiso['menu_id'],
            'rol_id'   => $permiso['rol_id'],
            'insert'  => $permiso['insert'],
            'update' => $permiso['update'],
            'delete' => $permiso['delete'],
            ];
        echo view('header');
        //echo view('sweetalert2', $msgToast);                    
		echo view('permisos/editar', $data);
		echo view('footer');
    }
    public function actualizar(){
        $this->permisos->update($this->request->getPost('id'),
            ['menu_id' => $this->request->getPost('menu_id'),
            'rol'=> $this->request->getPost('rol_id'),
            'rol_id'=> $this->request->getPost('read'),
            'read'=> $this->request->getPost('read'),
            'insert'=> $this->request->getPost('insert'),
            'update'=> $this->request->getPost('update'),
            'delete'=> $this->request->getPost('delete'),
            ]);   

            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Actualizado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $permisos = $this->permisos->where('activo',1)->findAll();
            $data = [ 
                'titulo' => $this->clase,
                'datos' => $permisos
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view($this->clase . '/'. $this->clase, $data);
            echo view('footer');
    }
    public function eliminar($id){
        $this->permisos->update($id,
            [
               'activo' => 0
            ]);   
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Eliminado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $permisos = $this->permisos->where('activo',1)->findAll();
            $data = [ 
                'titulo' => 'Permisos',
                'datos' => $permisos
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('permisos/permisos', $data);
            echo view('footer');        
    }
    public function reingresar($id){
        $this->permisos->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/'.$this->clase);
    }
    public function buscarPorCodigo($codigo){
        $this->permisos->select('*');
        $this->permisos->where('codigo', $codigo);
        $this->permisos->where('activo', '1');
        $datos = $this->permisos->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';
        $error = '';
        if($datos){
            $res['datos'] = $datos;
            $res['existe'] = true;
        }else{
            $res['error']  = 'No existe el Producto';
            $res['existe'] = false;
        }
        echo json_encode($res);
    }
}


