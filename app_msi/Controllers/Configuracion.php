<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;


class Configuracion extends BaseController
{
    protected $clase;
    protected $configuracion;
    protected $reglas;

    public function __construct(){
        helper(['form', 'upload']);
        $this->empresa = Config('Custom');
		$this->tit = $this->empresa->empresaTitulo;
		$this->dir = $this->empresa->empresaDireccion;
        $this->ruc = $this->empresa->empresaRuc;        
        $this->configuracion = new ConfiguracionModel();
        
        // Variables para nuestras reglas de validac.del Form
        // $this->reglas = [
        //     'nombre' =>  [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required'=> 'El campo {field} es obligatorio.'
        //         ]
        //         ],
        //     'valor' => [               
        //         'rules' => 'required',
        //         'errors' =>  [
        //             'required'=> 'El campo {field} es obligatorio.'
        //             ]
        //         ]
        //     ];
    }
    public function index(){
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $nombre   = $this->configuracion->where('nombre', 'Tienda_Nombre')->first();
        $ruc      = $this->configuracion->where('nombre', 'Tienda_Ruc')->first();
        $telefono = $this->configuracion->where('nombre', 'Tienda_Telefono')->first();
        $direccion= $this->configuracion->where('nombre', 'Tienda_Direccion')->first();
        $email    = $this->configuracion->where('nombre', 'Tienda_Email')->first();
        $leyenda  = $this->configuracion->where('nombre', 'Tienda_Leyenda')->first();
        $tasaminima = $this->configuracion->where('nombre', 'Tienda_TasaMinima')->first();
        $tasabasica = $this->configuracion->where('nombre', 'Tienda_TasaBasica')->first();
        //$configuracion = $this->configuracion->findAll();
        $data = [ 
            'titulo'    => 'Configuración del Sistema', //$this->tit,
            'nombre'    => $nombre,
            'ruc'       => $ruc,
            'telefono'  => $telefono,
            'direccion' => $direccion,
            'email'     => $email,
            'leyenda'   => $leyenda,
            'tasaminima' => $tasaminima,
            'tasabasica' => $tasabasica,
        ];
		echo view('header');
		echo view('configuracion/configuracion', $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function actualizar(){

        if($this->request->getMethod() == "post"){

        //} && $this->validate($this->reglas)){

        $this->configuracion->whereIn('nombre',['Tienda_Nombre'])->set(['valor'    => $this->request->getPost('Tienda_Nombre')])->update(); 
        $this->configuracion->whereIn('nombre',['Tienda_Ruc'])->set(['valor'       => $this->request->getPost('Tienda_Ruc')])->update(); 
        $this->configuracion->whereIn('nombre',['Tienda_Telefono'])->set(['valor'  => $this->request->getPost('Tienda_Telefono')])->update(); 
        $this->configuracion->whereIn('nombre',['Tienda_Direccion'])->set(['valor' => ltrim($this->request->getPost('Tienda_Direccion'))])->update(); 
        $this->configuracion->whereIn('nombre',['Tienda_Email'])->set(['valor'     => ltrim($this->request->getPost('Tienda_Email'))])->update(); 
        $this->configuracion->whereIn('nombre',['Tienda_Leyenda'])->set(['valor'   => ltrim($this->request->getPost('Tienda_Leyenda'))])->update(); 
        $this->configuracion->whereIn('nombre',['Tienda_TasaMinima'])->set(['valor'=> $this->request->getPost('Tienda_TasaMinima')])->update(); 
        $this->configuracion->whereIn('nombre',['Tienda_TasaBasica'])->set(['valor'=> $this->request->getPost('Tienda_TasaBasica')])->update(); 
        try{
            $img = $this->request->getFile('Tienda_Logo');          
            // $img->move(WRITEPATH. 'uploads');
            // Nombre Imagen
            // echo $img->getName();
            // echo "<br>";
            //  echo $img->getSize();
            //  echo "<br>";
            //  echo $img->getExtension();
            //  echo "<br>";
            //  echo $img->getFileInfo();
            //  echo "<br>";
             $validacion = $this->validate([
                'Tienda_Logo' => [ 'uploaded[Tienda_Logo]',
                'mime_in[Tienda_Logo,image/png]',
                'max_size[Tienda_Logo, 4096]'
                ]
            ]);
            if($validacion){
               $ruta_logo = "./images/logotipo.png";

               if(file_exists($ruta_logo)){
                   unlink($ruta_logo);
               }
                $img = $this->request->getFile('Tienda_Logo');          
                $img->move('./images', 'logotipo.png');
            }else{
                echo 'Error en la validacion';               
            }
            } catch (\Exception $e ){
                echo 'oooohhhhh, algo mal -> '.$e->getMessage();
            }
    $msgToast = [
                's2Titulo' => 'Configuraciones', 
                's2Texto' => 'Actualizado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            //echo view('sweetalert2', $msgToast);
            return redirect()->to(base_url() . '/inicio');      
        }else{
            echo "no supero las reglas!!!";
          //   return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }
}
