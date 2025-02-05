<?php namespace App\Controllers;    
	public function guardarentrada(){
		// Usar el servicio de validación
		$this->reglasEntrada = [
			'entrada' => [
				'rules' => 'required|numeric|is_natural_no_zero',
				'errors' => [
					'required' => 'El campo {field} es obligatorio.',
					'numeric' => 'El campo {field} debe ser numérico.',
					'is_natural_no_zero' => 'El campo {field} debe ser mayor a 0.',
				],
			],
			'descripcion' => [
				'rules' => 'required|min_length[5]|max_length[200]',
				'errors' => [
					'required' => 'El campo "Descripción" es obligatorio.',
					'min_length' => 'El campo {field} debe tener al menos 5 caracteres.',
					'max_length' => 'El campo {field} no debe exceder 200 caracteres.',
				],
			],
		];
		$validation = \Config\Services::validation(); 	
		
	log_message('debug', "Entrada antes del TRIM: " . $this->request->getPost('entrada'));
	log_message('debug', "descripcion antes del TRIM: " . $this->request->getPost('descripcion'));
	
       // Limpiar los datos de entrada y descripción
        $entrada = trim($this->request->getPost('entrada'));
        $descripcion = trim($this->request->getPost('descripcion'));
        $descripcion = preg_replace('/\r|\n/', '', $descripcion); // Limpiar saltos de línea

        // Reemplazar los datos en la solicitud
        $this->request->setGlobal('POST', [
            'entrada' => $entrada,
            'descripcion' => $descripcion,
        ]);
		
		log_message('debug', "Entrada DESPUES del TRIM: " . $this->request->getPost('entrada'));
		log_message('debug', "descripcion DESPUES del TRIM: " . $this->request->getPost('descripcion'));
	
		if($this->request->getMethod() === "POST" &&
		   $validation->setRules($this->reglasEntrada)->run(['entrada'=>$entrada, 'descripcion'=>trim($descripcion)])) {
			// Validado
			// $errors = $validation->getErrors();
			log_message('info', 'Datos validados, proseguimos con la Insercion de los datos.');
		    // si necesito validar las reglas desde el propio controlador entones:
			// //&& $this->validate($this->reglasEntrada)) {
            // Valido las Reglas
            $entrada = $this->request->getPost('entrada') ? $entrada = $this->request->getPost('entrada') : 0;
            $saldo  = $this->flujocaja->saldoActual();
            $entrada= $this->request->getPost('entrada');
            $saldo=$saldo+$entrada;
			
			$data = [
			    'titulo'		=> 'Ingreso de dinero',
                'fecha'			=> $this->request->getPost('fechahoy'),
                'descripcion'	=> $this->request->getPost('descripcion'),
                'entrada'		=> number_format($entrada, 2, ',', '.'),
                'salida'		=> '0',
                'saldo'			=> $saldo,
            ];
			// --------------------------------------
			// Mensajes Alerta SweetAlert 2
			// --------------------------------------
			$msgAlerta	= new SweetMessageModel();
			
			// --------------------------------------
			// --==> Insertamos los datos <==---
			// --------------------------------------
			if ($this->flujocaja->save($data)) {
				// Insercion EXITOSA			
				log_message('info', 'Consulta ejecutada: ' . $query = $this->flujocaja->db->getLastQuery()); // Acceso correcto al objeto db desde el modelo

				// Inserción EX"TOSA - Mensajes Alerta SweetAl 2
				$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'insertar');
				// --------------------------------------
			} else {
			    // ERRORES AL INSERTAR
				// Error en la inserión
				 log_message('error', 'Error al guardar el registro: ' . json_encode($this->flujocaja->errors()));
			
				// Error en la inserción lo toma de la Base de Datos
				$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'info');
			}
			// Traemos todos los registros de la BD
			$data	= $this->flujocaja->obtenerTodosLosRegistros();

			
			// Llamamos a las vistas
			echo view('header');
			echo view('sweetalert2', $msgToast);            
			echo view('flujocaja/flujocaja', $data);
			echo view('footer');			

        }else{
			$errors = $validation->getErrors();

		// Mostrar los errores
			foreach ($errors as $field => $error) {
				log_message('debug', 'Campo: ' . $field . ' Error: ' . $error);
				// echo "Error en el campo $field: $error<br>";
			}
			log_message('info', 'No valido las reglas ' . json_encode($validation->getErrors()));

			// Mensajes Alerta SweetAlert 2 por fallo
			$msgAlerta	= new SweetMessageModel();
			$msgToast   = $msgAlerta->obtenerUnModelo($this->clase, 'reglasinvalidas');
 			// Cargamos $Data para enviar a las vistas
			// Traemos todos los registros de la BD
			$data	= $this->flujocaja->obtenerTodosLosRegistros();
			
			// Llamamos a las vistas
			echo view('header'); 
			echo view('sweetalert2', $msgToast);             
			echo view('flujocaja/entradas', [
				'titulo'		=> 'Ingreso de dinero',
                'fecha'			=> $this->request->getPost('fechahoy'),
                'descripcion'	=> $this->request->getPost('descripcion'),
                'entrada'		=> number_format($entrada, 2, ',', '.'),
                'salida'		=> '0',
                'saldo'			=> 0,
				'validation' 	=> $errors,
						]); 
			echo view('footer');				 

             // return redirect()->to(base_url() . 'flujocaja', ['validation' => $this->validator]);        
		  }
  }
