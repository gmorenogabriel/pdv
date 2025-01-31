<?php namespace App\Controllers;

use App\Libraries\Custom;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\FlujoCajaModel;
use App\Libraries\Toastr;

//require FCPATH . 'vendor/autoload.php';
//require_once __DIR__ . '/../vendor/autoload.php';
//require_once COMPOSER_PATH;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use setasign\Fpdi\Fpdi;

class FlujoCaja extends BaseController{

    protected $flujocaja, $myTime, $router, $_method, $controlador, $clase;
    protected $reglasEntrada, $reglasSalida, $tituloConFecha;
	protected $pdf, $dir;
    //protected $this->clase;
	 // Declaramos la propiedad
    protected $empresa, $tit, $ruc, $today, $fecha_hoy ;

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
		//d($today->toLocalizedString('dd/MM/yyyy'));   // March 9, 2016)
		//d($time = Time::createFromFormat('Y-M-j', $today->toLocalizedString('dd/MM/yyyy'), 'la_UY'));
		//d($today);
        $this->fecha_hoy  = $today->toLocalizedString('dd/MM/yyyy');   // March 9, 2016

        // Obtenemos el nombre del Controlador/Metodo
        $router = \Config\Services::router();
        $_method = $router->methodName();
        $_controller = $router->controllerName();         
        $controlador = explode('\\', $_controller);
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
	
        // echo $locale;
        // echo lang('Translate.form_validation_required');
        $flujocaja = $this->flujocaja->findAll();
        $data = [ 
            'titulo' => 'Flujo de Caja',
            'datos'  => $flujocaja,
            'fecha'  => $this->fecha_hoy,
        ];

		// Prueba con Bootstrap y Datatables
        // echo view('header_dashboard');
		// echo view('flujocaja/flujocaja', $data);
		// echo view('footer_dashboard');
		
		// Funcionamiento con Bootstrap 
        echo view('header');
		echo view('flujocaja/flujocaja', $data);
		echo view('footer');
    }
    
    public function salidas()
    {
        $flujocaja = $this->flujocaja->findAll();
        $data = [ 
            'titulo' => 'Egresos de dinero',
            'datos'  => $flujocaja,
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
    // ----------------------------------------------
	// Genera Excel y Pdf
	// ----------------------------------------------	
	public function generaExcel(){
	   try {
			$nombreListado = 'Flujo de Caja';
			$extension = 'xlsx';
            // Simulación de datos de entrada
			$flujocaja = $this->flujocaja->findAll();
			$data = [ 
				'titulo' => $nombreListado,
				'datos'  => $flujocaja,
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
			
			// --------------------------------------
            // Agregar encabezados para las columnas
			// --------------------------------------- 

            $headers = ['ID', 'Fecha', 'Descripción', 'Entrada', 'Salida', 'Saldo'];
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
				$time = strtotime($row['fecha']);
				$newformat = date('Y-m-d',$time);
                $sheet->setCellValue('B' . $rowIndex, $newformat);
                //$sheet->setCellValue('C' . $rowIndex, $row['descripcion']);
				$descripcion = isset($row['descripcion']) ? $row['descripcion'] : '';
				$descripcion = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $descripcion);
				if ($descripcion === false) {
					$descripcion = '';
				}
				$descripcion = substr($descripcion, 0, 78);
				$descripcion = trim($descripcion); // Reemplaza ltrim y rtrim por trim
				$sheet->setCellValue('C' . $rowIndex, $descripcion);
				
				    // Formatear el valor numérico con puntos y comas
				$entradaFormateado = number_format($row['entrada'], 2, ',', '.'); // Ejemplo: 1.234,56
				$sheet->setCellValue('D' . $rowIndex, $entradaFormateado);

				$salidaFormateado = number_format($row['salida'], 2, ',', '.'); // Ejemplo: 1.234,56
				$sheet->setCellValue('E' . $rowIndex, $salidaFormateado);

				$saldoFormateado = number_format($row['saldo'], 2, ',', '.'); // Ejemplo: 1.234,56
				$sheet->setCellValue('F' . $rowIndex, $saldoFormateado);

         /*        $sheet->setCellValue('D' . $rowIndex, $row['entrada']);
					$sheet->setCellValue('E' . $rowIndex, $row['salida']);
					$sheet->setCellValue('F' . $rowIndex, $row['saldo']); 
		*/
                $rowIndex++;
            }
			// Descripcion seteada a la Izquierda
			$sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Aplicar estilo a la columna C (Descripción)
			$sheet->getStyle("C1:C{$lastRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->getStyle("D1:F{$lastRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			
			// Ampliamos el ancho de Columna a la fila con mayor largo
			$columns = range('B', 'E'); // Ajusta las columnas desde 'C' hasta 'E'
			foreach ($columns as $column) {
				$sheet->getColumnDimension($column)->setAutoSize(true);
			}

			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Recorrer la columna 'C' y eliminar espacios en blanco
			// for ($row = 1; $row <= $lastRow; $row++) {
				// $cellValue = $sheet->getCell("C{$row}")->getValue();
				// if (!is_null($cellValue)) {
					//Eliminar espacios en blanco
					// $cleanValue = str_replace(' ', '', $cellValue); // Quita todos los espacios en blanco
					// $sheet->setCellValue("C{$row}", $cleanValue);
				// }
			// }
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
			
			// Verificar si el archivo fue creado correctamente
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
			$nombreListado = 'Flujo Caja';
			$extension = 'pdf';
			$tituloFecha   = $nombreListado . ' al ' . $this->fecha_hoy;
			// Simulación de datos de entrada
			$todos = $this->flujocaja->findAll();
			$data = [ 
				'titulo' => 'Flujo de Caja',
				'tituloFecha' => $tituloFecha,			
				'datos'  => $todos,
				'fecha'  => $this->fecha_hoy,
				];
	   // Crear una instancia de FPDI
			$pdf = new Fpdi();

			// Agregar una página
			$pdf->AddPage("landscape");

		// Agregar título al PDF
			$pdf->SetFont('Arial', 'B', 16); // Fuente Arial, Negrita, Tamaño 16
			$pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $data['tituloFecha']), 0, 1, 'C'); // Texto centrado
			$pdf->Ln(5); // Agregar espacio después del título

			// Configurar la fuente
			$pdf->SetFont('Arial', 'B', 16);

		 // Agregar encabezados de columna
			$headers = ['ID', 'Fecha', 'Descripción', 'Entrada', 'Salida', 'Saldo'];
			$pdf->SetFont('Arial', 'B', 12); // Usar Arial
			$pdf->SetFillColor(12, 183, 242); // Color celeste
			$pdf->Cell(07, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[0]), 1, 0, 'C', true);
			//$pdf->Cell(07, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Texto con tildes: á, é, í, ó, ú y ñ.'), 1, 0, 'C', true);
			$pdf->Cell(30, 10, $headers[1], 1, 0, 'C', true);

			// Controlamos que venga el campo con datos para que no falle "iconv"
			$descripcion = isset($row['descripcion']) ? $row['descripcion'] : '';
			$descripcion = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $descripcion);
			if ($descripcion === false) {
				$descripcion = '';
			}
			$descripcion = substr($descripcion, 0, 49);
			$descripcion = trim($descripcion); // Reemplaza ltrim y rtrim por trim
			$pdf->Cell(80, 10, $descripcion, 1, 0, 'L', true);
			$pdf->Cell(30, 10, $headers[3], 1, 0, 'R', true);
			$pdf->Cell(30, 10, $headers[4], 1, 0, 'R', true);
			$pdf->Cell(30, 10, $headers[5], 1, 1, 'R', true);
			
			// Rellenar los datos
			$pdf->SetFont('Arial', '', 12); // Usar Arial
			foreach ($data['datos'] as $row) {
				$pdf->Cell(7, 10, $row['id'] , 1, 0, 'C');
				$time = strtotime($row['fecha']);
				$newformat = date('Y-m-d',$time);
				$pdf->Cell(30, 10, $newformat, 1, 0, 'C');
				$pdf->Cell(80, 10, ltrim(rtrim(substr(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['descripcion']),0,78))) , 1, 0, 'L'); // "L"-left Descripción alineada a la izquierda
				$pdf->Cell(30, 10, $row['entrada'] , 1, 0, 'R');
				$pdf->Cell(30, 10, $row['salida'] , 1, 0, 'R');
				$pdf->Cell(30, 10, $row['saldo'] , 1, 1, 'R');
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