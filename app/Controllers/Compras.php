<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalCompraModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;


class Compras extends BaseController
{

    protected $compras, $temporal_compra, $detalle_compra, $productos, $configuracion;
    protected $reglas, $config;
    //protected $empresa;

    public function __construct()
    {
        $this->empresa = Config('Custom');
		
		$config = Config('Custom');
		
		$tit = $config->empresaTitulo;
		$dir = $config->empresaDireccion;
        $ruc = $config->empresaRuc;
 
        $this->compras = new ComprasModel();
        $this->detalle_compra = new DetalleCompraModel();
        $this->configuracion = new ConfiguracionModel();
         //var_dump($this->empresa);
       // helper(['form']);
       
       
    }

    public function index($activo = 1){
        // Si no está Logueado lo manda a IDENTIFICARSE
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
      //  $locale = $this->request->getLocale();  
      //  echo $locale;
      //  echo lang('Translate.form_validation_required');
        $compras = $this->compras->where('activo', $activo)->findAll();
        $data = [ 
            //'titulo' => $this->tit, //
            'titulo'  => 'Compras',
            'compras' => $compras
        ];
		echo view('header');
		echo view('compras/compras', $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function eliminados($activo = 0){
        $compras = $this->compras->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Compras eliminadas',
            'datos' => $compras
        ];
		echo view('header');
		echo view('compras/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){
       // accedemos a la session 
       $session = session();
       if( $session->id_usuario == null){
        return redirect()->to(base_url()."productos");        
       }

        echo view('header');
		echo view('compras/nuevo');
		echo view('footer');
    }
    public function guarda(){
        $id_compra = $this->request->getPost('id_compra');
        $total  = preg_replace('/[\$,]/', '', $this->request->getPost('total'));

        // accedemos a la session 
        $session = session();       

        $resultadoId = $this->compras->insertaCompra($id_compra, $total, $session->id_usuario);        
        $this->temporal_compra = new TemporalCompraModel();

        if($resultadoId){
            // leo todos los registros de mis compras
            $resultadoCompra = $this->temporal_compra->porCompra($id_compra);
            $this->productos = new ProductosModel();

            foreach($resultadoCompra as $row){
                $this->detalle_compra->save([
                    'id_compra' => $resultadoId,
                    'id_producto' => $row['id_producto'],
                    'nombre' => $row['nombre'],
                    'cantidad' => $row['cantidad'],
                    'precio' => $row['precio']
                ]);
                // Actualizamos el Stock de las Existencias
                $this->productos->actualizaStock($row['id_producto'], $row['cantidad']);
            }
            // Eliminamos la tabla Temporal porque no tiene sentido
            // $id_compra= es el id de compra temporal
            $this->temporal_compra->eliminarCompra($id_compra);
        }
        // Antes de crear los pdf's volviamos a ingresar Productos
        // return redirect()->to(base_url()."/productos");
        return redirect()->to(base_url() . "/compras/muestraCompraPdf/" . $resultadoId);
    }

    function muestraCompraPdf($id_compra){
        $data['id_compra'] = $id_compra;
        echo view('header');
		echo view('compras/ver_compra_pdf', $data);
		echo view('footer');
    }
    function generaCompraPdf($id_compra){
        //Necesitamos la Hoja de la Compra
        //la configuracion para desplegar el nombre de la tienda
        $datosCompra = $this->compras->where('id', $id_compra)->first();
        $this->detalle_compra->select('*');
        $this->detalle_compra->where('id_compra', $id_compra);
        $detalleCompra = $this->detalle_compra->findAll();
        
        // Nombre Tienda y Dirección, lo traemos como Objeto y
        // no como Arreglo (valor es la columna que consulto)
        $nombreTienda    = $this->configuracion->select('valor')->where('nombre', 'Tienda_Nombre')->get()->getRow()->valor;
        $direccionTienda = $this->configuracion->select('valor')->where('nombre', 'Tienda_Direccion')->get()->getRow()->valor;
        
        // Agregamos en Config/Autoload.php las $classmap = ['FPDF' => APPPATH . 'ThirdParty......']        
        // Creamos el PDF
        $pdf = new \FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10,10,10);
        $pdf->SetTitle('Compra');
        $pdf->SetFont('Arial','B', 10);
        // Agregamos una fila a nuestro pdf, 
        //ancho 195, alto 5, nombre listado, No muestra bordes de fila=0, Salto Linea=1, Posicion=Centrado
        $pdf->Cell(195, 5, "Entrada de productos", 0, 1, 'C');
        // para el body bajamos el tamaño del font
        $pdf->SetFont('Arial','B', 9);
        // posicion donde ubicaremos el logotipo x, y
        $pdf->image(base_url() . '/images/logo.png', 185, 10, 20, 20, 'PNG');
        // Nombre tienda y direccion
        $pdf->Cell(50, 5, $nombreTienda, 0, 1, 'L');
        $pdf->Cell(16, 5,utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial','', 9);
        $pdf->Cell(50, 5, $direccionTienda, 0, 1, 'L');

        $pdf->Cell(50, 5, 'Fecha y hora compra:'.$datosCompra['fecha_alta'], 0, 1, 'L');

        //Saltos de líneas
        $pdf->Ln();

        $pdf->SetFont('Arial','B', 8);
        // Color del Fondo Negro , SetTextColor letras en Blanco
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(196, 5, 'Detalle de productos', 1, 1, 'C', 1);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Cell(14, 5, 'No.', 1, 0, 'L');
        $pdf->Cell(25, 5, utf8_decode('Código'), 1, 0, 'R');
        $pdf->Cell(77, 5, 'Nombre', 1, 0, 'L');
        $pdf->Cell(25, 5, 'Precio', 1, 0, 'R');
        $pdf->Cell(25, 5, 'Cantidad', 1, 0, 'R');
        $pdf->Cell(30, 5, 'Importe', 1, 1, 'R'); //Ultimo 1 Salto de Lìnea
        // pasamos a fuente normal (quitamos la negrita)
        $pdf->SetFont('Arial','', 8);
        $contador = 1;
        foreach($detalleCompra as $row){
            $pdf->Cell(14, 5, $contador, 1, 0, 'L');
            $pdf->Cell(25, 5, $row['id_producto'], 1, 0, 'R');
            $pdf->Cell(77, 5, $row['nombre'], 1, 0, 'L');
            $pdf->Cell(25, 5, $row['precio'], 1, 0, 'R');
            $pdf->Cell(25, 5, $row['cantidad'], 1, 0, 'R');
            $importe = number_format($row['precio'] * $row['cantidad'], 2 , '.', ',');
            $pdf->Cell(30, 5, '$' . $importe, 1, 1, 'R');
            $contador++;
        }

        //Saltos de líneas
        $pdf->Ln();
        $pdf->SetFont('Arial','B', 8);
        $pdf->Cell(195, 5, 'Total : $'. number_format($datosCompra['total'], 2 , '.', ','), 0, 1, 'R');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output("compra_pdf.pdf", "I"); // la I nos manda al navegador
    }

 /*    public function graficaCompras(){

        $where = "where 1=1";
        $sQuery = "SELECT nombre, cantidad FROM detalle_compra " . $where;

        if(isset($query)){
            echo json_encode($query);
        }else{
            echo json_encode('');
        }
    } */
	
   public function graficacompras(){
        // $model = new DetalleCompraModel(); //$model = $this->compras;
        $model = $this->detalle_compra->getGrafAllDetalleCompra();
		return $this->response->setJSON($model);
        //return json_encode($model);
    }


}


