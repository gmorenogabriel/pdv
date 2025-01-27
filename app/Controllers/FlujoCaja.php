<?php namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\FlujoCajaModel;
use App\Libraries\Toastr;

//require FCPATH . 'vendor/autoload.php';
//require_once __DIR__ . '/../vendor/autoload.php';
//require_once COMPOSER_PATH;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
	public function generaExcel(){
	   try {
            // Simulación de datos de entrada
			$flujocaja = $this->flujocaja->findAll();
			$data = [ 
				'titulo' => 'Flujo de Caja',
				'datos'  => $flujocaja,
				'fecha'  => $this->fecha_hoy,
			];
	           // Crear una nueva hoja de cálculo
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
			$sheet->setShowGridlines(false);

            // Agregar título y fecha en el cabezal
			$tituloConFecha = 'Flujo de Caja al: ' . $data['fecha'];
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
			

            //$sheet->setCellValue('G1', 'Fecha: ' . $data['fecha']);
            //$sheet->getStyle('G1')->getAlignment()->setHorizontal('right');

            // Agregar encabezados para las columnas
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
                $sheet->setCellValue('B' . $rowIndex, $row['fecha']);
                $sheet->setCellValue('C' . $rowIndex, $row['descripcion']);
                $sheet->setCellValue('D' . $rowIndex, $row['entrada']);
                $sheet->setCellValue('E' . $rowIndex, $row['salida']);
                $sheet->setCellValue('F' . $rowIndex, $row['saldo']);
                $rowIndex++;
            }
			// Descripcion seteada a la Izquierda
			$sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Aplicar estilo a la columna C (Descripción)
			$sheet->getStyle("C1:C{$lastRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
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

            // Guardar el archivo Excel en la carpeta writable
            $filePath = ROOTPATH . 'writable/Reporte_FlujoCaja.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            // Confirmar que el archivo fue generado
            return 'Archivo Excel generado exitosamente en: ' . $filePath;
        } catch (\Exception $e) {
            // Manejo de errores
            return 'Error al generar el archivo Excel: ' . $e->getMessage();
        }
    }
	
	public function generaExcelvie(){
		$i=0;
	    $i = $i++;
	    $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $writer = new Xlsx($spreadsheet);
		
		try{
			$fileName = ROOTPATH . 'writable/Excel_' . $i . '.xlsx';
			$writer->save($fileName);
			$flujocaja = $this->flujocaja->findAll();
			$data = [ 
				'titulo' => 'Flujo de Caja',
				'datos'  => $flujocaja,
				'fecha'  => $this->fecha_hoy,
			];
			  // Definir las cabeceras necesarias para la descarga del archivo
		   /* return $this->response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
				->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
				->setHeader('Cache-Control', 'max-age=0')
				->setBody($writer->save('php://output')); // Enviar el archivo directamente al navegador
			*/
					$msgToast = [
						's2Titulo' => 'FlujoCaja->', 
						's2Texto' => 'Se genero el archivo: ' . $fileName,
						's2Icono' => 'info',
						's2Toast' => 'true'
					];
					echo view('header');
					echo view('sweetalert2', $msgToast);
					//echo view('flujocaja/index', $data);
					echo view('footer');
		//			return redirect()->to('flujocaja');

			return redirect()->to(base_url('flujocaja'));

			} catch (\Exception $e) {
				throw new \Exception('Error al generar el archivo: ' . $fileName . '. Detalles: ' . $e->getMessage());
					$msgToast = [
						's2Titulo' => 'FlujoCaja->', 
						's2Texto' => 'NO se genero el archivo: ' . $fileName,
						's2Icono' => 'error',
						's2Toast' => 'true'
					];
					echo view('header');
					echo view('sweetalert2', $msgToast);
//					echo view('flujocaja/index', $msgToast);
					echo view('footer');
					return redirect()->to(base_url('flujocaja'));

			}
	}
}
