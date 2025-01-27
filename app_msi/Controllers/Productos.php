<?php 
namespace App\Controllers;
use CodeIgniter\Images\Exceptions\ImageException;
include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Utils/QrCode.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Utils/BarcodeType.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Utils/BarcodeGenerator.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINBarcode.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINBarcode1D.php';//CINBarcode1D.ph
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINColor.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINcode11.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINcode39.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINcode39extended.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINcode128.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINean8.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINean13.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINgs1128.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINDrawing.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINFont.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINFontFile.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINLabel.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINFontPhp.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINParseException.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINupca.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/CINupce.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/Drawer/CINDraw.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/Drawer/CINDrawPNG.php';
 include APPPATH . 'Libraries/CodeItNow/BarcodeBundle/Generator/Drawer/CINDrawJPG.php';

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\CategoriasModel;
use App\Models\CodigosBarraModel;

//useApp\Libraries\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
//use App\Libraries\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Libraries\CodeItNow\BarcodeBundle\Utils\BarcodeType;
use App\Libraries\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Libraries\CodeItNow\BarcodeBundle\Generator\CINColor;
use App\Libraries\CodeItNow\BarcodeBundle\Generator\CINDrawing;
use App\Libraries\CodeItNow\BarcodeBundle\Generator\CINFontFile;

use fpdf;
use eFPDF;


class Productos extends BaseController{

    protected $email;
    protected $clase;
    protected $productos;
    protected $reglas;
    public $barcode;
    public $imgBC, $imgQR;

    public function __construct(){
    
    
        $this->productos = new ProductosModel();
        $this->unidades = new UnidadesModel();
        $this->categorias = new CategoriasModel();
        $this->codigosbarra = new CodigosBarraModel();

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
            'codigo' =>  [
                'rules' => 'required|is_unique[productos.codigo]',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'is_unique'=> 'El campo {field} debe ser único.'
                ]
            ],
            'email' => [               
                'rules' => 'required|valid_email',
                'errors' =>  [
                    'required'=> 'El campo {field} es obligatorio.',
                    'valid_email'=> 'El campo {field} no es válido.'
                    ]
                ]
            ];
    }

    public function index($activo = 1){
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $productos = $this->productos->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Productos',
            'datos' => $productos
        ];
		echo view('header');
		echo view('productos/productos', $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function eliminados($activo = 0)
    {
        $productos = $this->productos->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Productos eliminadas',
            'datos' => $productos
        ];
		echo view('header');
		echo view('productos/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){		

        $unidades = $this->unidades->where('activo', 1 )->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $codigosbarras= $this->codigosbarra->where('activo', 1)->findAll();
        $data = [ 
            'titulo'     => 'Agregar producto',
            'unidades'   => $unidades,
            'categorias' => $categorias,
            'codigosbarras'=> $codigosbarras,
            'img_producto'  => '',
            ];
        echo view('header');
		echo view('productos/nuevo', $data);
		echo view('footer');
    }
    public function validoReglasRecargaProductos(){
        $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => 'Datos insertados',
            's2Icono' => 'success',
            's2Toast' => 'true'
        ];
        $productos = $this->productos->where('activo',1)->findAll();
        $unidades = $this->unidades->where('activo', 1 )->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $data = [ 
            'titulo' => $this->clase,
            'datos' => $productos,
            'unidades'   => $unidades,
            'categorias' => $categorias,
        ];
        echo view('header');
        echo view('sweetalert2', $msgToast);            
        echo view('productos/productos', $data);
        echo view('footer');
    }
    public function novalidoReglasRecargaProductos(){
        $unidades = $this->unidades->where('activo', 1 )->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $codigosbarras= $this->codigosbarra->where('activo', 1)->findAll();

        $data = [ 
            'titulo'     => $this->clase,
            'unidades'   => $unidades,
            'categorias' => $categorias,
            'validation' => $this->validator,
            'codigosbarras' => $codigosbarras,
            ];        
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => "No existe la ruta al archivo",
                's2Icono' => 'error',
                's2ConfirmButtonText' => true,
                's2ShowConfirmButton' => true,            
                's2Toast' => false,
                's2Footer' => 'Error Codigo duplicado',
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);                    
            echo view('productos/productos', $data);
            echo view('footer');
    }
    public function insertar(){

        $codigo = $this->request->getPost('codigo');
        $existeCodigo = $this->productos->where('id',$codigo)->where('activo', 1)->first();
        if($existeCodigo){
        
            if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
                // 
                // Devuelve el Array de todos los campos Input
                //
                //$serialize = $this->request->getVar();
                //dd($serialize);
                //die();
                // Valido las Reglas
                $data = 
                    ['codigo' => $this->request->getPost('codigo'),
                    'nombre'=> $this->request->getPost('nombre'),
                    'precio_venta'=> $this->request->getPost('precio_venta'),
                    'precio_compra'=> $this->request->getPost('precio_compra'),
                    'stock_minimo'=> $this->request->getPost('stock_minimo'),
                    'inventariable'=> $this->request->getPost('inventariable'),
                    'id_unidad'=> $this->request->getPost('id_unidad'),
                    'id_categoria'=> $this->request->getPost('id_categoria'),
                    'id_barcod'=> $this->request->getPost('new_id_barcod'),
                    ];
            
                if ($this->productos->save($data) === false){
                    //return view('updateUser', ['errors' => $model->errors()]);
                    $this->novalidoReglasRecargaProductos();
                }
                // Obtenemos el Id Insertado en la base para
                // asignarselo a la Imagen en images/productos
                $id = $this->productos->insertID(); 
                
                if($imagefile = $this->request->getFiles()){
                    $ord = 1;
                    foreach($imagefile['img_producto'] as $img){

                        $ruta = "images/productos/".$id;
                        if(!file_exists($ruta)){
                                mkdir($ruta, 0777, true);
                        }

                        if ($img->isValid() && ! $img->hasMoved())
                        {
                                $img->move('./images/productos/', $id.'/foto_'.$ord.'.jpg');
                                $ord++;
                            /* Genera un random
                            $newName = $img->getRandomName();
                            $img->move(WRITEPATH.'uploads', $newName);
                            */
                        }
                    }
                }
                
                $this->validoReglasRecargaProductos();
            }else{
                $this->novalidoReglasRecargaProductos();
            }
        }else{
                $unidades     = $this->unidades->where('activo', 1 )->findAll();
                $categorias   = $this->categorias->where('activo', 1)->findAll();
                $codigosbarras= $this->codigosbarra->where('activo', 1)->findAll();
                $productos    = $this->productos->where('activo',1)->findAll();
                $data = [ 
                'titulo'     => $this->clase,
                'unidades'   => $unidades,
                'categorias' => $categorias,
                'datos'      => $productos,
                'validation' => $this->validator,
                'codigosbarras' => $codigosbarras,
                ];        
                $msgToast = [
                    's2Titulo' => $this->clase,
                    's2Texto' => "Ya existe el código !!!",
                    's2Icono' => 'error',
                    's2ConfirmButtonText' => true,
                    's2ShowConfirmButton' => true,            
                    's2Toast' => false,
                    's2Footer' => 'Error Codigo duplicado',
                ];
                echo view('header');
                echo view('sweetalert2', $msgToast);                    
                echo view('productos/productos', $data);
                echo view('footer');
            }
        }        
    public function editar($id){
        $id = (int) $id;
        $producto = $this->productos->where('id',$id)->where('activo', 1)->first();

        $unidades = $this->unidades->where('activo', 1 )->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();        
        $codigosbarras= $this->codigosbarra->where('activo', 1)->findAll();

        $codigo = $producto['codigo'];
//        echo "Id: ". $producto['id'] . "  Codigo: " . $producto['codigo'] . "    Nombre: " . $producto['nombre'] . "    TipoBarCod: " . $producto['id_barcod'];
//        echo "<br>";
        $this->imgBC= $this->genBCG2($producto['codigo'], $producto['id_barcod']); // enviar $codigo, $tipobarcod
        $this->imgQR= $this->genQR2($producto['id'], $producto['codigo']);
        helper('filesystem');
        $ruta = './images/productos/'.$id.'/';
        $ord = 1;
        
        $files = get_filenames($ruta);
        //dd($ruta);
        //dd($files);
        if($files){
            foreach($files as $img){
                $img_producto[] = $img;            
                //$img_producto[] = "data:image/png;base64,'.$img.'";
            }
        }else{
            $img_producto[] = '';
        }
        $data = 
            [
            'titulo' => 'Editar ' . $this->clase,   
            'unidades'   => $unidades,
            'categorias' => $categorias,
            'producto'  => $producto,
            'codigosbarras' => $codigosbarras,
            'imgBC' => $this->imgBC,
            'imgQR' => $this->imgQR,
            'img_producto' => $img_producto,
            ];
        echo view('header');
        //echo view('sweetalert2', $msgToast);                    
		echo view('productos/editar', $data);
		echo view('footer');
    }

    public function imgTratamiento($ruta, $salida, $imgNueva, $imgFija){
        
        helper('filesystem');

        try{
        if(!file_exists($salida)){
             mkdir($salida, 0777, true);
             echo "tiene permisos...";
        }
        //dd($imgNueva);
        // Invocamos la librería
        $imagen=\Config\Services::image()
        ->withFile($imgNueva)
        // fit recorta la imagen
        ->fit(100,100) 
        ->save($salida.$imgFija);
        }catch (ImageException $e){
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => $e->getMessage(),
                's2Icono' => 'error',
                's2ConfirmButtonText' => true,
                's2ShowConfirmButton' => true,            
                's2Toast' => false,
                's2Footer' => 'Error Codigo duplicado',
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);                    
            echo view('productos/');
            echo view('footer');
                    //echo $e->getMessage();
        }
    }    


    public function actualizar(){
        $id       = $this->request->getPost('id');
        $imgNueva = $this->request->getFile('img_producto');
       //dd($imgNueva);
        $ruta     = './images/';
        $salida   = './images/productos/'.$id.'/';       
        $imgFija  = 'foto_1.jpg';

        if($imgNueva !=''){
            // Si seleccionaron una imagen la cambio
            $this->imgTratamiento($ruta,$salida,$imgNueva, $imgFija);
        }        

        $this->productos->update($this->request->getPost('id'),
            ['codigo' => $this->request->getPost('codigo'),
            'nombre'=> $this->request->getPost('nombre'),
            'precio_venta'=> $this->request->getPost('precio_venta'),
            'precio_compra'=> $this->request->getPost('precio_compra'),
            'stock_minimo'=> $this->request->getPost('stock_minimo'),
            'inventariable'=> $this->request->getPost('inventariable'),
            'id_unidad'=> $this->request->getPost('id_unidad'),
            'id_categoria'=> $this->request->getPost('id_categoria'),
            'id_barcod'=> $this->request->getPost('id_barcod'), //guarda el Id
            ]);   

            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Actualizado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];  
            $productos = $this->productos->where('activo',1)->findAll();
            $data = [ 
                'titulo' => 'Productos',
                'datos' => $productos
            ];

            echo view('header');
            echo view('productos/productos', $data);
            echo view('footer');
            
    
    }
    public function eliminar($id){
        $this->productos->update($id,
            [
               'activo' => 0
            ]);   
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Eliminado',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $productos = $this->productos->where('activo',1)->findAll();
            $data = [ 
                'titulo' => 'Productos',
                'datos' => $productos
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('productos/productos', $data);
            echo view('footer');   

    }
    public function reingresar($id){
        $this->productos->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/'.$this->clase);

    }
    public function buscarPorCodigo($codigo){
        $this->productos->select('*');
        $this->productos->where('codigo', $codigo);
        $this->productos->where('activo', '1');
        $datos = $this->productos->get()->getRow();

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
    public function generaBarras(){
        // Genera todos lo Productos desde el Botón
        // 10.Punto de venta con CI4, Dashboard, códigos de barra y reportes 59:06
        // P=Pagina mm=milimetros, 
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10,10,10);
        $pdf->SetTitle("Codigos de Barra");

        $productos = $this->productos->where('activo',1)->findAll();

        foreach($productos as $producto){
            $codigo = $producto['codigo'];
            $generaBarCode= new \barcode_genera();
            //$generaBarCode->barcode($codigo .".png", $codigo, 20, "horizontal", "code39", true);
            $generaBarCode->barcode($codigo .".png", $codigo, 20, "horizontal", "code128", true);
            $pdf->Image($codigo . ".png");
        }
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('Codigo.pdf', 'I'); // I es para mandarlo por pantalla
    }

    
    public function genBCG($id){
        
        $producto = $this->productos->where('id',$id)->where('activo',1)->first();
        $codigoProd = $producto['codigo'];

        // Contiene el del Codigo de Barra a Generar por Ej: Code11 o Code39 o Ean8 Ean13, etc
        $tipoBarCode= $this->codigosbarra->select('tipobarcod')->where('id', $producto['id_barcod'])->first();
        $codigoProd = $producto['codigo'];
        
//         print_r($producto);
//         echo "<br>";
//         print_r ($tipoBarCode['tipobarcod']);
//         echo "<br>";
//         print_r ($codigoProd);
// echo "<br>";
        // Nos quedamos con el String del Nombre del Codigo de Barras
        $tipoBarCode=$tipoBarCode['tipobarcod'];
        if(isset($codigoProd)){
            $pdf = new \FPDF('P', 'mm', 'letter');
            $pdf->AddPage();
            $pdf->SetMargins(10,10,10);
            $pdf->SetFont('Arial','', 8);
            $pdf->SetTitle("Codigos de Barra");
        try {
            $this->barcode = new \CodeItNow\BarcodeBundle\Utils\BarcodeGenerator();
            $this->barcode->setText($codigoProd);
            switch ($tipoBarCode){
                case "Code11":
                    $tipoBarCode='Code11';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code11);
                    break;
                case "Code39":
                    $tipoBarCode='Code39';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39);
                    break;
                case "Code39Extended":
                    $tipoBarCode='Code39Extended';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39Extended);
                    break;
                case "Code128":
                    $tipoBarCode='Code128';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code128);
                    break;
                case "Ean8":
                    $tipoBarCode='Ean8';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean8);
                    break;
                case "Ean13":
                    $tipoBarCode='Ean13';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean13);
                    break;
                case "Ean128":
                    $tipoBarCode='Ean128';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean128);
                    break;
                case "Upca":
                        $tipoBarCode='upca';
                        $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Upca);
                        break;
                case "Upce":
                    $tipoBarCode='upce';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Upce);
                    break;                        
                default:
                    $tipoBarCode='Code39-por-Defecto';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39);
                };
            //$this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code128);
            $this->barcode->setScale(2);
            $this->barcode->setThickness(25);
            $this->barcode->setFontSize(10);
            $this->barcode->setBackgroundColor('white');
            $this->barcode->setForegroundColor('black');
            //echo ("antes de Generate()"); echo "<br>";
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Actualizando Barcode' . $tipoBarCode,
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $code = $this->barcode->generate();
            $this->imgBC = '<img src="data:image/png;base64,'.$code.'" />';
            return $this->imgBC;

        } catch (\Exception $e ){
            echo 'oooohhhhh, algo mal -> '.$e->getMessage();
        }
      } 
    }
    public function  genIMGDIV($id, $fileName){
        if(isset($fileName)){  
            $this->imgDiv = '<img src="data:image/png;base64,'.$fileName.'" />';
            return $this->imgDiv;
        }

    }
    public function genBCG2($codigoProd, $id_barcod){

        $tipo= $this->codigosbarra->select('tipobarcod')->where('id', $id_barcod)->first();
        // Contiene el del Codigo de Barra a Generar por Ej: Code11 o Code39 o Ean8 Ean13, etc
        $tipoBarCode=$tipo['tipobarcod'];
       
        if(isset($codigoProd)){

            $pdf = new \FPDF('P', 'mm', 'letter');
            $pdf->AddPage();
            $pdf->SetMargins(10,10,10);
            $pdf->SetFont('Arial','', 8);
            $pdf->SetTitle("Codigos de Barra");

        //try {
            $this->barcode = new \CodeItNow\BarcodeBundle\Utils\BarcodeGenerator();
            $this->barcode->setText($codigoProd);
            //$this->barcode->setText("2021010267890123333333333333333333333333221110000000000");
            switch ($tipoBarCode){
                case "Code11":
                    $tipoBarCode='Code11';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code11);
                    break;
                case "Code39":
                    $tipoBarCode='Code39';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39);
                    break;
                case "Code39Extended":
                    $tipoBarCode='Code39Extended';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39Extended);
                    break;
                case "Code128":
                    $tipoBarCode='Code128';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code128);
                    break;
                case "Ean8":
                    $tipoBarCode='Ean8';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean8);
                    break;
                case "Ean13":
                    $tipoBarCode='Ean13';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean13);
                    break;
                case "Ean128":
                    $tipoBarCode='Ean128';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean128);
                    break;
                case "Upca":
                    $tipoBarCode='upca';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Upca);
                    break;
                case "Upce":
                    $tipoBarCode='upce';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Upce);
                    break;                                            
                default:
                    $tipoBarCode='Code39-por-Defecto';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39);
                };
            //$this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code128);
            $this->barcode->setScale(1);
            $this->barcode->setThickness(25);
            $this->barcode->setFontSize(10);
            $this->barcode->setBackgroundColor('white');
            $this->barcode->setForegroundColor('black');
            //echo ("antes de Generate()"); echo "<br>";
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Actualizando Barcode' . $tipoBarCode,
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $code = $this->barcode->generate();
            $this->imgBC = '<img src="data:image/png;base64,'.$code.'" />';
            return $this->imgBC;
        }
    }
    public function genBCGNuevo($new_id_barcod){
        // llamado desde Nuevo new_id_barcod --> Ajax
        //$producto = $this->productos->where('id',$id)->first();
        $codigoProd = $this->request->getPost('codigo');
        $tipo= $this->codigosbarra->select('tipobarcod')->where('id', $new_id_barcod)->first();
        // Contiene el del Codigo de Barra a Generar por Ej: Code11 o Code39 o Ean8 Ean13, etc
        $tipoBarCode=$tipo['tipobarcod'];

        if(isset($codigoProd)){

            $pdf = new \FPDF('P', 'mm', 'letter');
            $pdf->AddPage();
            $pdf->SetMargins(10,10,10);
            $pdf->SetFont('Arial','', 8);
            $pdf->SetTitle("Codigos de Barra");

        //try {
            $this->barcode = new \CodeItNow\BarcodeBundle\Utils\BarcodeGenerator();
            $this->barcode->setText($codigoProd);
            //$this->barcode->setText("2021010267890123333333333333333333333333221110000000000");
            switch ($tipoBarCode){
                case "Code11":
                    $tipoBarCode='Code11';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code11);
                    break;
                case "Code39":
                    $tipoBarCode='Code39';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39);
                    break;
                case "Code39Extended":
                    $tipoBarCode='Code39Extended';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39Extended);
                    break;
                case "Code128":
                    $tipoBarCode='Code128';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code128);
                    break;
                case "Ean8":
                    $tipoBarCode='Ean8';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean8);
                    break;
                case "Ean13":
                    $tipoBarCode='Ean13';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean13);
                    break;
                    case "Ean128":
                    $tipoBarCode='Ean128';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Ean128);
                    break;
                default:
                    $tipoBarCode='Code39-por-Defecto';
                    $this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code39);
                };
            //$this->barcode->setType(\CodeItNow\BarcodeBundle\Utils\BarcodeGenerator::Code128);
            $this->barcode->setScale(2);
            $this->barcode->setThickness(25);
            $this->barcode->setFontSize(10);
            $this->barcode->setBackgroundColor('white');
            $this->barcode->setForegroundColor('black');
            //echo ("antes de Generate()"); echo "<br>";
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Actualizando Barcode' . $tipoBarCode,
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            $code = $this->barcode->generate();
            $this->imgBC = '<img src="data:image/png;base64,'.$code.'" />';
            return $this->imgBC;
        }
    }
    public function genBarras($id, $id_codbarra){
        // Vista en Barcode despliega el Cód.Barras y QR
        $imgBC = $this->genBCG2($id, $id_codbarra);
        $imgQR = $this->genQR2($id, $id_codbarra);
        $data = [
            'titulo' => 'Barcode',
            'titulo2' => 'Qr Code',
            'imgBC' => $this->imgBC,
            'imgQR' => $this->imgQR,
        ];
        $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => 'Actualizando Barcode',
            's2Icono' => 'success',
            's2Toast' => 'true'
        ];
        echo "<br>";
        echo view('header');
        echo view('sweetalert2', $msgToast);            
        echo view('productos/barcode', $data);
        echo view('footer');        
    }
    public function genQR($id, $id_codbarra){
        
            $producto = $this->productos->where('id',$id)->first();
            $codigoProd = $producto['codigo'];

            $tipo= $this->codigosbarra->select('tipobarcod')->where('id', $id_codbarra)->first();
            // Contiene el del Codigo de Barra a Generar por Ej: Code11 o Code39 o Ean8 Ean13, etc
            $tipoBarCode=$tipo['tipobarcod'];

            /* Generamos Codigo QR */
            $this->qrCode = new \CodeItNow\BarcodeBundle\Utils\QrCode();
            $this->qrCode->setText($codigoProd);
            $this->qrCode->setPadding(10);
            $this->qrCode->setErrorCorrection('high');
            $this->qrCode->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0));
            $this->qrCode->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
            $this->qrCode->setLabel('Scan Qr Code');
            $this->qrCode->setLabelFontSize(16);
            $this->qrCode->setImageType(\CodeItNow\BarcodeBundle\Utils\QrCode::IMAGE_TYPE_PNG);
        try{
            $this->imgQR = '<img src="data:'.$this->qrCode->getContentType().';base64,'.$this->qrCode->generate().'" />';

            $data = [
                'titulo' => 'Barcode',
                'titulo2' => 'Qr Code',
                'imgBC' => $this->imgBC,
                'imgQR' => $this->imgQR,
            ];
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'Actualizando Barcode' . $tipoBarCode,
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            echo "<br>";
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('productos/barcode', $data);
            echo view('footer');        
                
        } catch (\Exception $e ){
            echo 'oooohhhhh, algo mal -> '.$e->getMessage();
        }
      } 
      
    /* Tomado de: https://packagist.org/packages/codeitnowin/barcode   */
    public function genQR2($id){
        // llamado desde Edit --> Ajax
        $producto = $this->productos->where('id',$id)->first();
        $tipoBarCode= $this->codigosbarra->select('tipobarcod')->where('id', $producto['id_barcod'])->first();
        $codigo = $producto['codigo'];
        
        
        if(isset($codigo)){
            try {
                $this->qrCode = new \CodeItNow\BarcodeBundle\Utils\QrCode();
                $this->qrCode->setText($codigo);
                $this->qrCode->setPadding(10);
                $this->qrCode->setErrorCorrection('high');
                $this->qrCode->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0));
                $this->qrCode->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
                $this->qrCode->setLabel('Scan Qr Code');
                $this->qrCode->setLabelFontSize(16);
                $this->qrCode->setImageType(\CodeItNow\BarcodeBundle\Utils\QrCode::IMAGE_TYPE_PNG);
                $this->imgQR = '<img src="data:'.$this->qrCode->getContentType().';base64,'.$this->qrCode->generate().'" />';
                return $this->imgQR;
            } catch (\Exception $e ){
                return $this->imgQR = 'oooops, algo salió mal -> '.$e->getMessage();

            }
        } 
    }
    /* Tomado de: https://packagist.org/packages/codeitnowin/barcode   */
    public function genQRNuevo($codigo, $id_barcod){
        // llamado desde Edit --> Ajax
        $tipoBarCode= $this->codigosbarra->select('tipobarcod')->where('id', $id_barcod)->first();        
        
        if(isset($codigo)){
            try {
                $this->qrCode = new \CodeItNow\BarcodeBundle\Utils\QrCode();
                $this->qrCode->setText($codigo);
                $this->qrCode->setPadding(10);
                $this->qrCode->setErrorCorrection('high');
                $this->qrCode->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0));
                $this->qrCode->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
                $this->qrCode->setLabel('Scan Qr Code');
                $this->qrCode->setLabelFontSize(16);
                $this->qrCode->setImageType(\CodeItNow\BarcodeBundle\Utils\QrCode::IMAGE_TYPE_PNG);
                $this->imgQR = '<img src="data:'.$this->qrCode->getContentType().';base64,'.$this->qrCode->generate().'" />';
                return $this->imgQR;
            } catch (\Exception $e ){
                return $this->imgQR = 'oooops, algo salió mal -> '.$e->getMessage();

            }
        } 
    }
     

    public function generaBarras_revisar(){
        $fontSize = 2.4;
        $marge = 1;
        $x =  100;
        $y =  220;
        $height = 9; //9
        $width = 0.37;
        $angle = 0;
        $code = "1234567";
        $type = 'code128';
        $black = array('0','0','0');
    
        $productos = $this->productos->where('activo',1)->findAll();
    
        $fontSize = 2.4;
        $x=200;$y=200;
        $height   = 50;   // barcode height in 1D ; module size in 2D
        $width    = 2;    // barcode height in 1D ; not use in 2D
        $angle    = 0;   // rotation in degrees
        
        $code     = '12345678'; // barcode, of course ;)
       // $type     = 'ean8';
        $pdf = new \eFPDF('L', 'mm','A4');
        $pdf->AddPage();
        $pdf->SetMargins(10,10,10);
        $pdf->SetFont('Arial','', 8);
        //$pdf->SetFont('Arial','B',$fontSize);
        $pdf->SetTitle("Codigos de Barra");
        $pdf->SetXY(0, 0);
        
        foreach($productos as $producto){
            $codigo = $producto['codigo'];

           $generaBarCode= new \Barcode();
           //Barcode::fpdf                      ($res, $color,    $x, $y, $angle, $type, $datas, $width = null, $height = null);
           $data = $generaBarCode->Barcode::fpdf($pdf, '000000', 100, 220,  0, $type, $code, $width=2, $height=50);         
        }
        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('prueba.pdf','I');
     }

 public function envioEMailNuevo($para, $asunto, $mensaje, $adjunto=null ){
     // Load Services in Controller
     $this->email->setTo($para);
     $this->email->setSubject($asunto);
     $this->email->setMessage($mensaje);
     if($adjunto){
         $adjunto= base_url() . '/images/logo.png';
         $this->email->attach($adjunto);    
     }        
     if($this->email->send()){       
         $data = [
             'titulo' => 'Envío de E-Mail',
             'titulo2' => 'E-Mail enviado correctamente',
         ];
         $msgToast = [
             's2Titulo' => $this->clase, 
             's2Texto' => 'E-Mail enviado correctamente',
             's2Icono' => 'success',
             's2Toast' => 'true'
         ];
         echo "<br>";
         echo view('header');
         echo view('sweetalert2', $msgToast);            
         echo view('enviomail/enviomail', $data);
         echo view('footer');             
     }else{
         $data = $this->email->printDebugger(['headers']);
         print_r($data);
     }
 }


    public function envioEMail(){
        // Load Services in Controller
        $email= \Config\Services::email();
        $email->setTo('gmorenogabriel@gmail.com');
        $email->setFrom('scf3487@gmail.com', 'Info');
       // $email->setBCC('1961gamt@gmail.com');
       // $email->setCC('1961gamt@gmail.com');
        $email->setSubject('EMail desde Codeigniter 4, Test');
        $email->setMessage('Texto del Mensaje enviado como prueba desde Codeigniter 4 /productos/envioEMail' );
        $filepath= base_url() . '/images/logo.png';
        $email->attach($filepath);
        if($email->send()){       
            $data = [
                'titulo' => 'Envío de E-Mail',
                'titulo2' => 'E-Mail enviado correctamente',
            ];
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'E-Mail enviado correctamente',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            echo "<br>";
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('enviomail/enviomail', $data);
            echo view('footer');             
        }else{
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
    
    public function graficastockMinimoProductos(){
        // $result = $this->productos->graficaStMinProd();
        // echo json_encode($result);
        $where = "where stock_minimo >= existencias AND inventariable='1' AND activo='1'";
        $sQuery = "SELECT nombre, existencias FROM productos " . $where;
        
        $db = db_connect();
        $query = $db->query($sQuery)->getResultArray();
       
        if(isset($query)){
            echo json_encode($query);
        }else{
            echo json_encode('');
        }
    }

    public function imagenManipulacion(){
        helper('filesystem');
        try{
        $ruta = './images/productos/30/';
        $salida= './images/';
        if(!file_exists($salida)){
             mkdir($salida, 0777, true);
        }
        //dd($salida);
        $files = get_filenames($ruta);
        $arcUno  = $this->request->getFiles($ruta);
        $arcMul  = $this->request->getFileMultiple($ruta);
        $ord = 0;
        $data = [
            'titulo' => $this->clase,
            'ruta'   => $ruta,
            'salida' => $salida,
        ];
        // obtener la informacion de la imagen        
            foreach($files as $img){
                $info=\Config\Services::image()
                ->withFile($ruta . $img)
                ->getFile()
                ->getProperties(true);
                $ancho = $info['width'];
                $alto  = $info['height'];
                // echo "<br>";
                 echo "Procesando : " . $ruta . $img . " de ancho original " . $ancho . " y Alto Original : ".$alto;
                 echo "<br>";
                 echo "Procesado  : " . $salida . $img . " de ancho original " . $ancho . " y Alto Original : ".$alto;
                 echo "<br>";
                // Invocamos la librería
                $imagen=\Config\Services::image()
                ->withFile($ruta.$img)
                //->reorient()
                //->rotate(180)
                // fit recorta la imagen
                ->fit(100,100) 
                //->resize($ancho/2, $alto/2)
                //->crop(48,48,10,0)
                ->save($salida . $img);
                $data['img'][$ord] = $img;
                $ord++;
            } 
            echo view('header');          
            echo view('productos/imagen', $data);
            echo view('footer');        
        }catch (ImageException $e){
                    echo $e->getMessage();
        }
        //->reorient()
        //->rotate(180)
        // fit recorta la imagen
        //->fit(48,48,'left') 
        //->resize($ancho/2, $alto/2)
        //->crop(48,48,10,0)
        //->save('images/logo_pequeño.png');
//dd($data);    
    }
}