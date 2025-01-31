
	/* <!-- Genera Excel y Pdf <--
    $(document).ready(function() {
		console.log ("Ejecutando en public/js/mis-js/genera_excel_pdf.js");
            // $('#miTabla').DataTable({
			    // lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
				// pageLength: 10, 		// Valor predeterminado para mostrar
                // paging: true,           // Habilita la paginación
                // searching: true,        // Habilita la barra de búsqueda
                // lengthChange: true,     // Habilita el selector "Mostrar X filas"
                // ordering: true,         // Habilita el ordenamiento de columnas
                // info: true,             // Muestra información de la tabla
                // language: {
                    // url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" // Traducción al español
                // }
            // });
	*/
		function generarArchivo(titulo, mensaje, url, botonDescarga = "Descargar archivo") {
			// Mostrar alerta mientras se procesa
		//	console.log(`Titulo: ${titulo},  Mensaje: ${mensaje}, URL: ${url}`);
			Swal.fire({
				title: titulo,
				text: mensaje,
				icon: 'info',
				showConfirmButton: false,
				allowOutsideClick: false,
			});

			// Realizar la solicitud al servidor con AJAX
			$.ajax({
				url: url, // URL dinámica
				type: 'GET', // Cambia a 'POST' si es necesario
				success: function (response) {
					if (response.status === 'success') {
						Swal.fire({
							title: '¡Éxito!',
							text: response.message,
							icon: 'success',
							showConfirmButton: true,
							confirmButtonText: botonDescarga, // Texto dinámico para el botón
						}).then((result) => {
							if (result.isConfirmed) {
								// Redirigir para descargar el archivo
								window.location.href = response.downloadUrl;
							}
						});
					} else {
						Swal.fire({
							title: 'Error',
							text: response.message,
							icon: 'error',
							showConfirmButton: true,
						});
					}
				},
				error: function () {
					Swal.fire({
						title: 'Error',
						text: 'Ocurrió un problema al procesar la solicitud.' . titulo,
						icon: 'error',
						showConfirmButton: true,
					});
				},
			});
		}
		//
		// Para todas los programas hay que cambiar el Boton de Generacion
		//
		/* Categorias */
		$('#btnGeneraExcelCateg').on('click', function (e) {
			//Version Dinamica donde paso parametros
			e.preventDefault();
			generarArchivo(
				'Generando Excel...', // Título de la alerta
				'Por favor, espera mientras se genera el archivo.', // Mensaje de la alerta
				'categorias/generaExcel', // URL donde se realiza la solicitud
				'Descargar Excel' // Texto del botón de descarga
			);
		});

		$('#btnGeneraPdfCateg').on('click', function (e) {
			//Version Dinamica donde paso parametros
			e.preventDefault();
			console.log('btnGeneraPdfCateg');
			generarArchivo(
				'Generando Pdf...', // Título de la alerta
				'Por favor, espera mientras se genera el archivo.', // Mensaje de la alerta
				'categorias/generaPdf', // URL donde se realiza la solicitud
				'Descargar Pdf' // Texto del botón de descarga
			);
		});
		/* Flujo Caja */
		$('#btnGeneraExcelFlujo').on('click', function (e) {
			//Version Dinamica donde paso parametros
			e.preventDefault();
			generarArchivo(
				'Generando Excel...', // Título de la alerta
				'Por favor, espera mientras se genera el archivo.', // Mensaje de la alerta
				'flujocaja/generaExcel', // URL donde se realiza la solicitud
				'Descargar Excel' // Texto del botón de descarga
			);
		});

		$('#btnGeneraPdfFlujo').on('click', function (e) {
			//Version Dinamica donde paso parametros
			e.preventDefault();
			console.log('btnGeneraPdfFlujo');
			generarArchivo(
				'Generando Pdf...', // Título de la alerta
				'Por favor, espera mientras se genera el archivo.', // Mensaje de la alerta
				'flujocaja/generaPdf', // URL donde se realiza la solicitud
				'Descargar Pdf' // Texto del botón de descarga
			);
		});
		/* Unidades */
		$('#btnGeneraExcelUnidades').on('click', function (e) {
			//Version Dinamica donde paso parametros
			e.preventDefault();
			generarArchivo(
				'Generando Excel...', // Título de la alerta
				'Por favor, espera mientras se genera el archivo.', // Mensaje de la alerta
				'unidades/generaExcel', // URL donde se realiza la solicitud
				'Descargar Excel' // Texto del botón de descarga
			);
		});

		$('#btnGeneraPdfUnidades').on('click', function (e) {
			//Version Dinamica donde paso parametros
			e.preventDefault();
			console.log('btnGeneraPdfUnidades');
			generarArchivo(
				'Generando Pdf...', // Título de la alerta
				'Por favor, espera mientras se genera el archivo.', // Mensaje de la alerta
				'unidades/generaPdf', // URL donde se realiza la solicitud
				'Descargar Pdf' // Texto del botón de descarga
			);
		});

		$('#btnGeneraExcelCategVIEJO').on('click', function (e) {
			//Funcion sin parametros ESTATICA
			e.preventDefault(); // Evitar comportamiento predeterminado

			// Mostrar alerta mientras se procesa
			Swal.fire({
				title: 'Generando Excel...',
				text: 'Por favor, espera mientras se genera el archivo.',
				icon: 'info',
				showConfirmButton: false,
				allowOutsideClick: false,
			});

			// Realizar la solicitud al servidor con AJAX
			$.ajax({
				url: 'categorias/generaExcel', // URL del controlador
				type: 'GET', // O 'POST' si es necesario
				success: function (response) {
					if (response.status === 'success') {
						Swal.fire({
							title: '¡Éxito!',
							text: response.message,
							icon: 'success',
							showConfirmButton: true,
							confirmButtonText: 'Descargar archivo',
						}).then((result) => {
							if (result.isConfirmed) {
								// Redirigir para descargar el archivo
								window.location.href = response.downloadUrl;
							}
						});
					} else {
						Swal.fire({
							title: 'Error',
							text: response.message,
							icon: 'error',
							showConfirmButton: true,
						});
					}
				},
				error: function () {
					Swal.fire({
						title: 'Error',
						text: 'Ocurrió un problema al procesar la solicitud.',
						icon: 'error',
						showConfirmButton: true,
					});
				},
			});
		});
/* }); */