<?php namespace App\Controllers;

use App\Libraries\Custom;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Libraries\Toastr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\Fpdi;
use App\Models\CategoriasModel;

class Categorias extends BaseController
{
    protected $clase;
    protected $categorias;
	protected $pdf, $dir;
    //protected $this->clase;
	 // Declaramos la propiedad
    protected $empresa, $tit, $ruc, $today, $fecha_hoy ;

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
		
		$this->empresa = Config('Custom');
		$this->tit = $this->empresa->empresaTitulo;
		$this->dir = $this->empresa->empresaDireccion;
        $this->ruc = $this->empresa->empresaRuc;
		
		 // Obtenemos la Fecha del Sistema
		$myTime = Time::now('America/Montevideo', 'la_UY');
        $today  = Time::createFromDate();            // Uses current year, month, and day
		$this->fecha_hoy  = $today->toLocalizedString('dd/MM/yyyy');   // March 9, 2016
        
        helper(['form','url','number']);        
        
    }
    public function index($activo = 1){
        // Si no está Logueado lo manda a IDENTIFICARSE
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $categorias = $this->categorias->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Categorias',
            'datos'  => $categorias,
			'fecha'  => $this->fecha_hoy,
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
            'datos' => $categorias,
			'fecha'  => $this->fecha_hoy
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
            'datos'  => $categorias,
		    'fecha'  => $this->fecha_hoy,

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
					'fecha'  => $this->fecha_hoy,				
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
            'datos' => $categorias,
		    'fecha'  => $this->fecha_hoy,			
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
            'datos' => $categorias,
		    'fecha'  => $this->fecha_hoy,			
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
	
    // ----------------------------------------------
	// Genera Excel y Pdf
	// ----------------------------------------------
	public function generaExcel(){
	   try {
			$nombreListado = 'Categorías';
			$extension = 'xlsx';
            // Simulación de datos de entrada
			$todos = $this->categorias->findAll();
			$data = [ 
				'titulo' => $nombreListado,
				'datos'  => $todos,
				'fecha'  => $this->fecha_hoy,
			];
	           // Crear una nueva hoja de cálculo
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
			$sheet->setShowGridlines(false);

            // Agregar título y fecha en el cabezal
			$tituloConFecha = $nombreListado . ' al: ' . $data['fecha'];
			$sheet->setCellValue('A1', $tituloConFecha);

            //$sheet->setCellValue('A1', $data['titulo']);
			$sheet->getStyle('A1')->applyFromArray([
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => [
						'rgb' => '4F81BD', // Fondo azul
					],
				],
				'font' => [
					'color' => ['rgb' => 'FFFFFF'], // Letras blancas
					'bold' => true,
					'size' => 14, // Tamaño de la fuente
				],
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],
			]);
            $sheet->mergeCells('A1:F1'); // Combinar celdas para el título
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
			$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
			
            // Agregar encabezados para las columnas
            $headers = ['ID', 'Nombre', 'Activo'];
            $columnIndex = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($columnIndex . '2', $header);
                $sheet->getStyle($columnIndex . '2')->getFont()->setBold(true);
				$sheet->getStyle($columnIndex . '2')->applyFromArray([
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => [
							'rgb' => '0CB7F2', // Color celeste en formato hexadecimal
						],
					],
				]);

                $columnIndex++;
            }

            // Agregar los datos en las filas
            $rowIndex = 3; // Comenzamos desde la fila 3
            foreach ($data['datos'] as $row) {
                $sheet->setCellValue('A' . $rowIndex, $row['id']);
				// Manejo para recorte de Fechas
//				$time = strtotime($row['nombre']);
//				$newformat = date('Y-m-d',$time);
//              $sheet->setCellValue('B' . $rowIndex, $newformat);

				// Controlamos que venga el campo con datos para que no falle "iconv"
				$nombre = isset($row['nombre']) ? $row['nombre'] : '';
				$nombre = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombre);
				if ($nombre === false) {
					$nombre = '';
				}
				$nombre = substr($nombre, 0, 49);
				$nombre = trim($nombre); // Reemplaza ltrim y rtrim por trim
				$sheet->setCellValue('B' . $rowIndex, $nombre);
                $sheet->setCellValue('C' . $rowIndex, $row['activo']);
                $rowIndex++;
            }
			// Descripcion seteada a la Izquierda
			$sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Ajustar ancho de la columna automáticamente
			$sheet->getColumnDimension('C')->setAutoSize(true);
			// Aplicar estilo a la columna C (Nombre)
			//sheet->getStyle("C1:C{$lastRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			// Ampliamos el ancho de Columna a la fila con mayor largo
			$columns = range('A', 'B'); // Ajusta las columnas desde 'C' hasta 'E'
			foreach ($columns as $column) {
				$sheet->getColumnDimension($column)->setAutoSize(true);
			}
			
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Recorrer la columna 'C' y eliminar espacios en blanco
			for ($row = 1; $row <= $lastRow; $row++) {
				$cellValue = $sheet->getCell("C{$row}")->getValue();
				if (!is_null($cellValue)) {
					// Eliminar espacios en blanco
					$cleanValue = str_replace(' ', '', $cellValue); // Quita todos los espacios en blanco
					$sheet->setCellValue("C{$row}", $cleanValue);
				}
			}
		
			// Ruta del directorio donde se guardarán los Excel
			$directorio = WRITEPATH . 'excel/';
				
			// Generar un nombre de archivo único con fecha/hora
			$timestamp = date('Ymd_His'); // Ejemplo: 20250129_154500
			$nombreArchivo = WRITEPATH . "excel/" . $nombreListado . "_{$timestamp}." . $extension; // Ruta del archivo			

			//$extension = substr(strrchr($nombreArchivo, '.'), 1);
			
			Custom::directorioExiste($directorio, $extension);
			// Guardar el archivo Excel en la carpeta writable
            $writer = new Xlsx($spreadsheet);
            $writer->save($nombreArchivo);
			
			//Verificar si el archivo fue creado correctamente
				if (!file_exists($nombreArchivo)) {
					throw new \Exception('Error al generar el archivo Excel !!!');
				}

				return $this->response->setJSON([
					'status' => 'success',
					'message' => 'El archivo Excel se generó correctamente.',
					//'downloadUrl' => base_url($nombreArchivo),
					'downloadUrl' => $nombreArchivo,
				]);
			} catch (\Exception $e) {
				// Devolver un error controlado
				return $this->response->setJSON([
					'status' => 'error',
					'message' => $e->getMessage(),
				]);
		}
	}
	
	public function generaPdf()
	{
		try{
			$nombreListado = 'Categorías';
			$extension = 'pdf';
			$tituloFecha   = $nombreListado . ' al ' . $this->fecha_hoy;
			// Simulación de datos de entrada
			$todos = $this->categorias->findAll();
			$data = [ 
				'titulo' => $nombreListado,
				'tituloFecha' => $tituloFecha,
				'datos'  => $todos,
				'fecha'  => $this->fecha_hoy,
			];

			// Crear una instancia de FPDI
			$pdf = new Fpdi();

			// Agregar una página
			$pdf->AddPage("portrait");

			// Agregar título al PDF
			$pdf->SetFont('Arial', 'B', 16); // Fuente Arial, Negrita, Tamaño 16
			$pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $data['tituloFecha']), 0, 1, 'C'); // Texto centrado
			$pdf->Ln(5); // Agregar espacio después del título

			// Agregar encabezados de columna
			$headers = ['ID', 'Nombre', 'Activo'];
			$pdf->SetFont('Arial', 'B', 12); // Usar Arial
			$pdf->SetFillColor(12, 183, 242); // Color celeste
			$pdf->Cell(07, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[0]), 1, 0, 'C', true);
			$pdf->Cell(80, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[1]), 1, 0, 'L', true);
			$pdf->Cell(30, 10, $headers[2], 1, 1, 'C', true);

			// Rellenar los datos
			$pdf->SetFont('Arial', '', 12); // Usar Arial
			foreach ($data['datos'] as $row) {
				$pdf->Cell(7, 10, $row['id'], 1, 0, 'C');
				$pdf->Cell(80, 10, ltrim(rtrim(substr(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['nombre']), 0, 78))), 1, 0, 'L'); // "L"-left Descripción alineada a la izquierda
				$pdf->Cell(30, 10, $row['activo'], 1, 1, 'C');
			}

			// Agregar un espacio
			$pdf->Ln(10);

			// Si se genero OK avisamos
			// Ruta del directorio donde se guardarán los Excel
			$directorio = WRITEPATH . 'pdf/';

			// Verificar si el directorio existe; si no, crearlo
			Custom::directorioExiste($directorio, $extension);
			// Generar un nombre de archivo único con fecha/hora
			$timestamp = date('Ymd_His'); // Ejemplo: 20250129_154500
			$nombreArchivo = WRITEPATH . "pdf/" . $nombreListado . "_{$timestamp}." . $extension; // Ruta del archivo


			// Guardar el archivo Excel en la carpeta writable
			//   $writer = new Xlsx($spreadsheet);
			//   $writer->save($nombreArchivo);
				// Salida del archivo PDF al navegador
				//return $this->response
				/*
				return	$this->response
					->setContentType('application/pdf')
					->setBody($pdf->Output('S')); // La opción 'S' envía el contenido como cadena
				*/
			// Guardar el archivo PDF en el servidor
			$pdf->Output($nombreArchivo, 'F'); // Guardar en el servidor
		
			// Verificar si el archivo fue creado correctamente
			if (!file_exists($nombreArchivo)) {
				throw new \Exception('Error al generar el archivo Pdf.');
			}

			return $this->response->setJSON([
				'status' => 'success',
				'message' => 'El archivo Pdf se generó correctamente.',
				//'downloadUrl' => base_url($nombreArchivo),
				'downloadUrl' => $nombreArchivo,
			]);
			} catch (\Exception $e) {
				// Devolver un error controlado
			//	echo "<script>console.log($e->getMessage());</script>";
			//	echo "<script>alert('Exception ' . $e->getMessage());</script>";
				return $this->response->setJSON([
					'status' => 'error',
					'message' => $e->getMessage(),
				]);
		}
	}
// Fin Clase
}