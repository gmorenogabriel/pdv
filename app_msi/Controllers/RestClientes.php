<?php
 
namespace App\Controllers;
 
//use App\Models\CategoryModel;
use App\Models\ClientesModel;
use CodeIgniter\RESTful\ResourceController;
 
class RestClientes extends ResourceController
{
 
    protected $modelName = 'App\Models\ClientesModel';
    protected $format = 'json';

    public function metodos($var = null){
        
        if ($var == "metodos") {
            // Obtenemos el nombre del Controlador/Metodo
            $router = \Config\Services::router();
            $_method = $router->methodName();
            $_controller = $router->controllerName();         
            $controlador = explode('\\', $_controller) ;
            $this->clase = $controlador[max(array_keys($controlador))] ;
            
            echo "<pre>";
            echo "Ip: \t";
        //    echo ($this->require->getServer(['SERVER_PROTOCOL', 'REQUEST_URI']));
            var_dump( $this->request->uri->getSegments() ); echo "<br/>";
            var_dump($_ENV["aempresaRuc"]);
            echo $_SERVER['REMOTE_ADDR']; echo "<br/>";
            echo $this->require->getServer(['SERVER_PROTOCOL', 'REQUEST_URI']);; echo "<br/>";
           // echo ( $this->input->server(array('HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR')));
            echo "\t";
            print_r($this->request->getEnv($controlador));
            print_r($this->clase); echo "<br/>";
            echo "\t";
            print_r("index"); echo "<br/>";
            print_r("show"); echo "<br/>";
            print_r("create"); echo "<br/>";
            print_r("update"); echo "<br/>";
            print_r("delete"); echo "<br/>";
            echo "</pre>";
        }
    }

    public function index()
    {
     
        return $this->genericResponse($this->model->findAll(), null, 200);
    }
 
    public function show($id = null)
    {
        return $this->genericResponse($this->model->find($id), null, 200);
    }
 
    public function delete($id = null)
    {
 
        $cliente = new ClientesModel();
        $cliente->delete($id);
 
        return $this->genericResponse("Cliente eliminado", null, 200);
    }
 
    public function create()
    {
 
        $cliente = new ClientesModel();
        // $category = new CategoryModel();
 
        if ($this->validate('clientes')) {
 
            // if (!$this->request->getPost('category_id'))
            //     return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);
 
            // if (!$category->get($this->request->getPost('category_id'))) {
            //     return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);
            // }
 
            $id = $cliente->insert([
                'nombre' => $this->request->getPost('nombre'),
                'direccion' => $this->request->getPost('direccion'),
                'telefono' => $this->request->getPost('telefono'),
                'correo' => $this->request->getPost('correo'),
                'activo' => '1', //$this->request->getPost('activo'),
            ]);
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }
 
        $validation = \Config\Services::validation();
 
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }
 
    public function update($id = null)
    {
 
        $cliente = new ClientesModel();
    //    $category = new CategoryModel();
 
          $data = $this->request->getRawInput();
 
        if ($this->validate('clientes')) {
 
            // if (!$data['category_id'])
            //     return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);
 
            if (!$cliente->get($id)) {
                return $this->genericResponse(null, array("id" => "Cliente no existe"), 500);
            }
 
            // if (!$category->get($data['category_id'])) {
            //     return $this->genericResponse(null, array("category_id" => "Categoría no existe"), 500);
            // }
 
            $cliente->update($id, [
                'nombre' => $data['nombre'],
                'direccion' => $data['direccion'],
                'telefono' => $data['telefono'],
                'correo' => $data['correo'],
            ]);
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }
 
        $validation = \Config\Services::validation();
 
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }
 
    private function genericResponse($data, $msj, $code)
    {
 
        if ($code == 200) {
            return $this->respond(array(
                "data" => $data,
                "code" => $code
            )); //, 404, "No hay nada"
        } else {
            return $this->respond(array(
                "msj" => $msj,
                "code" => $code
            ));
        }
    }
}