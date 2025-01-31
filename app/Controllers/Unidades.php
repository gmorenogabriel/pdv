<?php namespace App\Controllers;

use App\Libraries\Custom;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Libraries\Toastr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use setasign\Fpdi\Fpdi;
use Config\Services;
use Hashids\Hashids;
use App\Models\UnidadesModel;


class Unidades extends BaseController
{
    protected $clase;
    protected $unidades;
    protected $reglas;
	protected $empresa, $tit, $ruc, $today, $fecha_hoy ;
    //protected $empresa;
	protected $hashids;
	protected $miClaveSecreta;
	 
    public function __construct()
    {
        helper(['form']);

        // $this->session = session();
        $this->empresa = Config('Custom');
		
		$this->tit = $this->empresa->empresaTitulo;
		$this->dir = $this->empresa->empresaDireccion;
        $this->ruc = $this->empresa->empresaRuc;

        $this->unidades = new UnidadesModel();
        
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
  
        // Configura la biblioteca Hashids con una clave secreta
		$this->miClaveSecreta = env('encryption.key');
        $this->hashids = new Hashids($this->miClaveSecreta, 10);
		
        // Variables para nuestras reglas de validac.del Form
        $this->reglas = [
            'nombre' =>  [
                'rules' => 'required',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.'
                ]
                ],
            'nombre_corto' => [               
                'rules' => 'required',
                'errors' =>  [
                    'required'=> 'El campo {field} es obligatorio.'
                    ]
                ]
            ];
    }

	public function encodeData($id)
    {
        $hashids = Services::hashids();
        $encoded = $hashids->encode($id);
        echo "Encoded ID: " . $encoded;
    }

    public function decodeData($encoded)
    {
        $hashids = Services::hashids();
        $encoded = $this->miClaveSecreta; //'Z7B8cXJ4';
        $decoded = $hashids->decode($encoded);
        echo "Decoded ID: " . (isset($decoded[0]) ? $decoded[0] : 'Invalid');
    }

    public function index($activo = 1){
        // Si no está Logueado lo manda a IDENTIFICARSE
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
        $locale = $this->request->getLocale();  
        //echo $locale;
        //echo lang('Translate.form_validation_required');
        $unidades = $this->unidades->where('activo',$activo)->findAll();
        $s2Icono  = null;
        $data = [ 
            'titulo'  => $this->clase,
            'datos'   => $unidades,
            's2Icono' => $s2Icono,
			'fecha'  => $this->fecha_hoy,
        ];
		echo view('header');
		echo view('unidades/unidades', $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function eliminados($activo = 0)
    {
        $unidades = $this->unidades->where('activo',$activo)->findAll();
        $data = [ 
            'titulo' => 'Unidades eliminadas',
            'datos' => $unidades
        ];
		echo view('header');
		echo view('unidades/eliminadas', $data);
		echo view('footer');
		//echo view('dashboard');
	}
    public function nuevo(){
        $data = [ 
            'titulo' => 'Agregar '.$this->clase,
            'validation' => null,
        ];

        echo view('header');
		echo view($this->clase.'/nuevo', $data);
		echo view('footer');
    }
    public function insertar(){
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
            // ------------------------------------------
            // FORMA RAPIDA DE GRABAR SIN TRANSACCIONES
            // $this->unidades->save(
            // ['nombre'=> $this->request->getPost('nombre'),
            // 'nombre_corto'=> $this->request->getPost('nombre_corto')
            // ]);   
            // ------------------------------------------
            // Obtenemos los datos de todos los Input
            $dataBD = $this->request->getVar();
            $respuesta = $this->unidades->saveBD($dataBD);

           //$this->unidades = new UnidadesModel();
        //    $this->unidades->db->transBegin();
        //    try {
        //        $this->unidades->insert([
        //            'nombre'=>$this->request->getPost('nombre'),
        //            'nombre_corto'=>$this->request->getPost('nombre_corto')
        //        ]);
   
        //        $unidades_id = $this->unidades->insertID();
        //        // ver de enviar al log de errores
        //        //$unidadesLog = $this->TransLog($this->request->getPost());
        //     //    if($unidadesLog===false){
        //     //        throw new \Exception();
        //     //    }
        //     //    $postCategory = new PostCategoryModel();
        //     //    $postCategory->insert([
        //     //        'post_id'=>$post_id,
        //     //        'category_id'=>$this->request->getPost('category_id')
        //     //    ]);
   
        //        $this->unidades->db->transCommit();
        //    } catch (\Exception $e) {
        //         $this->unidades->db->transRollback();
        //    }
           //   return redirect()->to(base_url() . '/unidades');
        //    if(isset($respuesta)===true){
        //     $s2Texto = 'Datos insertados';   
        //    }else{
        //     $s2Texto = 'No se Insertaron los datos';   
        //    }
         $s2Texto = $respuesta  ===true             ?  'Datos insertados' : 'No se Insertaron los datos'; 
         $s2Icono = $respuesta  ===true             ?  'success'          : 'error'; 
         $s2ConfirmButtonText   = $respuesta===true ?  'Continuar'        : 'Continuar'; 
         $s2ShowConfirmButton   = $respuesta===true ?  'true'             : 'false'; 
         $s2Toast               = $respuesta===true ?  'true'             : 'error'; 
         // Verificamos si ya existe el dato
         //dd($dataBD);
         $duplicado = $this->unidades->where('nombre_corto',$dataBD['nombre_corto'])->first();        

         if ($duplicado=$dataBD['nombre_corto']){
            $s2Footer = $respuesta===true ? 'true' : 'El valor "' . $duplicado . '" ya existe en la columna "Nombre Corto".';
         }else{
            $s2Footer = $respuesta===true ? 'true' : null;
         }
         
         $sweetalert2         = 'sweetalert2'; 

         $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto' => $s2Texto,
            's2Icono' => $s2Icono,
            's2ConfirmButtonText' => $s2ConfirmButtonText,
            's2ShowConfirmButton' => $s2ShowConfirmButton,            
            's2Toast' => $s2Toast,
            's2Footer' => $s2Footer,
        ];
        $unidades = $this->unidades->where('activo',1)->findAll();
        $data = [ 
            'titulo' => $this->tit, //'Unidades',
            'datos' => $unidades
        ];
        echo view('header');
        echo view($sweetalert2, $msgToast);    
		echo view('unidades/unidades', $data);
		echo view('footer');

        }else{
            $data = [ 
                'titulo' => 'Agregar '.$this->clase,
                'validation' => $this->validator 
            ];
            echo view('header');
            echo view('unidades/nuevo', $data);
            echo view('footer');
        }        
    }
    public function editar($id, $valid=null){
		d($id);
		$hash = new Hashids();
        $id_user = $hash->decode($id);
        d($id_user);
		if ( null !== $id) {
			// Controlamos recibir cargado el id Encriptado
            // por si editaron la URL 
   		try {
            $id_desenc = base64_decode($id);
            $unidad = $this->unidades->where('id',$id_desenc)->first();
            
            if($valid != null){
                $data = [ 
                    'titulo' => 'Editar '.$this->clase,
                    'datos'  => $unidad,
                    'validation' => $valid
                ];
            }else{
                $data = [ 
                    'titulo' => 'Editar '.$this->clase, 
                    'datos'  => $unidad,
                    'id_enc' => $id_desenc,
                ];
            }
            echo view('header');
            echo view('unidades/editar', $data);
            echo view('footer');
            } catch (\Exception $e){
                die($e->getMessage());
            }          
        }  else {
             echo "Error al tratar de acceder " . $this->clase;
        }          
    }
    public function actualizar(){
        if($this->request->getMethod() == "post" && $this->validate($this->reglas)){
            try {

                $id = $this->request->getPost('id');   
                $id_desenc = base64_decode($id);
               }catch (\Exception $error){
                      var_dump($error->getMessage());
               }           
            $this->unidades->update($id_desenc,
                [
                'nombre'=> $this->request->getPost('nombre'),
                'nombre_corto'=> $this->request->getPost('nombre_corto')
                ]);   
           // return redirect()->to(base_url().'/unidades');
           $msgToast = [
            's2Titulo' => $this->clase, 
            's2Texto'  => 'Ingreso Actualizado',
            's2Icono'  => 'success',
            's2Toast'  => 'true'
            ];           
            $unidades = $this->unidades->where('activo', 1)->findAll();
            $data = [ 
                'titulo' => $this->clase,
                'datos'  => $unidades
            ];
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('unidades/unidades', $data);
            echo view('footer');    
        }else{
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'No se validaron las reglas.',
                's2Icono' => 'warning',
                's2Toast' => 'true'
            ];
            $unidades = $this->unidades->where('activo', 1)->findAll();
            $data = [ 
                'titulo' => $this->tit, 
                'fecha'  => $this->fecha_hoy,
                'datos'  => $unidades
            ];
    
            echo view('header');
            echo view('sweetalert2', $msgToast);
            echo view('flujocaja/entradas', $data);
            echo view('footer');
        }
    }
    public function eliminar($id){
        $this->unidades->update($id,
            [
               'activo' => 0
            ]);   
        return redirect()->to(base_url().'/unidades');
    }
    public function reingresar($id){
        $this->unidades->update($id,
            [
               'activo' => 1
            ]);   
        return redirect()->to(base_url().'/unidades');
    }
 
    // ----------------------------------------------
	// Genera Excel y Pdf
	// ----------------------------------------------
	public function generaExcel(){
	   try {
			$nombreListado = 'Unidades';
			$extension = 'xlsx';
            // Simulación de datos de entrada
			$todos = $this->unidades->findAll();
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
			
			// --------------------------------------
            // Agregar encabezados para las columnas
			// --------------------------------------- 


            $headers = ['ID', 'Nombre', 'Nombre Abrev.', 'Activo'];
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

			// --------------------------------------
            // Agregar Detalles de las filas
			// --------------------------------------- 
			
            $rowIndex = 3; // Comenzamos desde la fila 3
            foreach ($data['datos'] as $row) {
                $sheet->setCellValue('A' . $rowIndex, $row['id']);
				// Manejo para recorte de Fechas
//				$time = strtotime($row['nombre']);
//				$newformat = date('Y-m-d',$time);
//              $sheet->setCellValue('B' . $rowIndex, $newformat);

				// Procesar y limpiar 'nombre'
				$nombre = isset($row['nombre']) ? $row['nombre'] : '';
				$nombre = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombre);
				$nombre = ltrim(rtrim(substr($nombre, 0, 49))); // Solo elimina los espacios externos
	
				// Procesar y limpiar 'nombre_corto'
				$nombre_corto = isset($row['nombre_corto']) ? $row['nombre_corto'] : '';
				$nombre_corto = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $nombre_corto);
				$nombre_corto = ltrim(rtrim(substr($nombre_corto, 0, 9))); // Solo elimina los espacios externos
	
				$sheet->setCellValue('B' . $rowIndex, $nombre);
				$sheet->setCellValue('C' . $rowIndex, $nombre_corto);
				$sheet->setCellValue('D' . $rowIndex, $row['activo']);
				
                $rowIndex++;
            }
			// Descripcion seteada a la Izquierda
			$sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Ampliamos el ancho de Columna a la fila con mayor largo
			$columns = range('A', 'D'); // Ajusta las columnas desde 'C' hasta 'E'
			foreach ($columns as $column) {
				$sheet->getColumnDimension($column)->setAutoSize(true);
			}
			
			// Obtener la última fila con datos
			$lastRow = $sheet->getHighestRow();

			// Recorrer la columna 'C' y eliminar espacios en blanco
			// for ($row = 1; $row <= $lastRow; $row++) {
				// $cellValue = $sheet->getCell("C{$row}")->getValue();
				// if (!is_null($cellValue)) {
				//	Eliminar espacios en blanco
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
			$nombreListado = 'Unidades';
			$extension = 'pdf';
			$tituloFecha   = $nombreListado . ' al ' . $this->fecha_hoy;
			// Simulación de datos de entrada
			$todos = $this->unidades->findAll();
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
			$headers = ['ID', 'Nombre', 'Nombre Abrev.', 'Activo'];
			$pdf->SetFont('Arial', 'B', 12); // Usar Arial
			$pdf->SetFillColor(12, 183, 242); // Color celeste
			$pdf->Cell(07, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[0]), 1, 0, 'C', true);
			$pdf->Cell(80, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[1]), 1, 0, 'L', true);
			$pdf->Cell(80, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $headers[2]), 1, 0, 'L', true);			
			$pdf->Cell(30, 10, $headers[3], 1, 1, 'C', true);

			// Rellenar los datos
			$pdf->SetFont('Arial', '', 12); // Usar Arial
			foreach ($data['datos'] as $row) {
				$pdf->Cell(7, 10, $row['id'], 1, 0, 'C');
				$pdf->Cell(80, 10, ltrim(rtrim(substr(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['nombre']), 0, 49))), 1, 0, 'L'); // "L"-left Descripción alineada a la izquierda
				$pdf->Cell(80, 10, ltrim(rtrim(substr(iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $row['nombre_corto']), 0, 9))), 1, 0, 'L'); // "L"-left Descripción alineada a la izquierda				
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