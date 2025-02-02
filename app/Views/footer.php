<footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Mis Puntos de Venta <?php echo date('Y'); ?></div>
                            <div>
                                <a href="https://facebook.com/xxxx" target="_blank">Facebook personalizado</a>
                                &middot;
                                <!-- Politicas -->
                                <a href="http://website.com/xxxx" target="_blank">PuestoDeVenta</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
<!-- Al final de tu archivo footer.php -->

<!-- <script src="<?php echo base_url(); ?>js/Chart.js"></script> -->
 <!-- JS de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
	<!-- SB Admin 2 JS -->
	<script src="<?php echo base_url(); ?>js/sb-admin-2.min.js"></script>
    <!-- JS personalizado -->
    <script src="<?php echo base_url(); ?>js/mis-js/genera_excel_pdf.js"></script>
<script src="<?php echo base_url(); ?>font-awesome/js/all.js" crossorigin="anonymous"></script>
<!-- <script src="<?php echo base_url(); ?>js/sweetalert2.all.min.js" crossorigin="anonymous"></script> -->
<script src="<?php echo base_url(); ?>js/mis-js/genera_excel_pdf.js"></script>


<script>
    $(document).ready(function() {
		console.log ("Ejecutando en el Documento");
            $('#miTabla').DataTable({
			    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
				pageLength: 10, 		// Valor predeterminado para mostrar
                paging: true,           // Habilita la paginación
                searching: true,        // Habilita la barra de búsqueda
                lengthChange: true,     // Habilita el selector "Mostrar X filas"
                ordering: true,         // Habilita el ordenamiento de columnas
                info: true,             // Muestra información de la tabla
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" // Traducción al español
                }
            });
/* Este codigo paso a public/js/mis-js/genera_excel_pdf.js
	    despues de realizar las pruebas necesarias quitar
		de footer.php 
		para que quede ordenado

function generarArchivo(titulo, mensaje, url, botonDescarga = "Descargar archivo") {
    // Mostrar alerta mientras se procesa
	//	console.log(`Titulo: ${titulo},  Mensaje: ${mensaje}, URL: 0${url}`);
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
/* Categorias 
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
/* Flujo Caja 
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
/* Unidades 
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
*/
	document.addEventListener("DOMContentLoaded", function () {
		console.log(document.getElementById('myBarChart'));
		console.log(document.getElementById('myPieChart'));

    function datagrafico(base_url, year) {
        var paramCodigos = [];
        var paramExistencias = [];
        console.log("function datagrafico");

        $.post(`${base_url}productos/graficastockMinimoProductos`, { year: year })
            .done(function (data) {
                try {
                    var obj = JSON.parse(data); // Convertir el JSON recibido
                    console.log("Datos recibidos:", obj);

		console.log('Labels:', labels); // ¿Muestra un array con etiquetas válidas?
		console.log('Data:', data);     // ¿Muestra un array con datos numéricos?

                    // Procesar los datos recibidos
                    $.each(obj, function (i, item) {
                        paramCodigos.push(item.codigo);
                        paramExistencias.push(item.existencias);
                    });

                    // Crear gráfico de barras
                    var ctxBar = document.getElementById("myBarChart1");
                    if (ctxBar) {
                        new Chart(ctxBar, {
                            type: "bar",
                            data: {
                                labels: paramCodigos,
                                datasets: [{
                                    label: "Existencias",
                                    data: paramExistencias,
                                    backgroundColor: "rgba(75, 192, 192, 0.6)",
                                    borderColor: "rgba(75, 192, 192, 1)",
                                    borderWidth: 1,
                                }],
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { position: "top" },
                                    title: { display: true, text: "Stock Mínimo por Producto" },
                                },
                            },
                        });
                    } else {
                        console.error("El canvas 'myBarChart1' no se encontró.");
                    }
                } catch (e) {
                    console.log("Error al parsear el JSON:", e, data);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud:", textStatus, errorThrown);
            });
    }

    function dataGraficaCompras(base_url) {
        var paramCategorias = [];
        var paramTotales = [];
        console.log("function dataGraficaCompras");
		console.log("----------------b--------");
		console.log(document.getElementById('myBarChart1')); // Debería mostrar el elemento <canvas>
		console.log("----------------bb--------");

        $.post(`${base_url}compras/graficastockCategorias`)
            .done(function (data) {
                try {
                    var obj = JSON.parse(data); // Convertir el JSON recibido
                    console.log("Datos recibidos:", obj);

                    // Procesar los datos recibidos
                    $.each(obj, function (i, item) {
                        paramCategorias.push(item.categoria);
                        paramTotales.push(item.total);
                    });

                    // Crear gráfico de pastel
                    var ctxPie = document.getElementById("myPieChart1");
                    var ctx = document.getElementById('myBarChart');
					new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
							datasets: [{
								label: 'Ventas',
								data: [10, 20, 30, 40, 50],
								backgroundColor: 'rgba(75, 192, 192, 0.2)',
								borderColor: 'rgba(75, 192, 192, 1)',
								borderWidth: 1
							}]
						},
						options: {
							responsive: true,
							scales: {
								y: {
									beginAtZero: true
								}
							}
						}
					});				
                } catch (e) {
                    console.log("Error al parsear el JSON:", e, data);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud:", textStatus, errorThrown);
            });
    }

    // Llamar a las funciones con los parámetros necesarios
    var base_url = "http://localhost:8084/pdv/public";
    var year = new Date().getFullYear();

    datagrafico(base_url, year);
    dataGraficaCompras(base_url);
	});
<!-- Fin de los graficos de la pagina de Inicio ->
   
    function generaCodQR(){
        let baseURL= "<?php echo base_url(); ?>";
        console.log('Estoy en generaCodQR()');
            //$("#imgcodQR").on("change", function(){
            var id = $("#id").val();                 // Id del Producto
            var id_barcod = $("#id_barcod").val();  // Id del Codigo Barras
            var acceso=baseURL+'/productos/genQR2';
            //alert ('Acceso: ' + acceso+'/'+id+'/'+id_barcod);
            $.ajax({  
                url: acceso+'/'+id+'/'+id_barcod,
                type:'post',  
                success:function(res){ 
                    if(res != 0){
                          $('#imgcodQR').html(res);
                          console.log('success #imgcodQR actualizada');
                    }else{
                        console.log('Error footer  $(#imgcodQR)' + res);
                        //alert('error');
                    }
                }
            });
        }

    function generaCodQRNuevo(){
            let baseURL= "<?php echo base_url(); ?>";
            console.log('Estoy en generaCodQRNuevo()');
            var codigo = $("#codigo").val();                 // Id del Producto
            console.log('cargado codigo: '+codigo);
            var new_id_barcod = $("#new_id_barcod").val();  // Id del Codigo Barras
            var acceso=baseURL+'/productos/genQRNuevo';
            //alert ('Acceso: ' + acceso+'/'+id+'/'+id_barcod);
            $.ajax({  
                url: acceso+'/'+codigo+'/'+new_id_barcod,
                type:'post',  
                success:function(res){ 
                    if(res != 0){
                          $('#imgcodQR').html(res);
                          console.log('success #imgcodQR actualizada');
                    }else{
                        console.log('Error footer  $(#imgcodQR)' + res);
                        //alert('error');
                    }
                }
            });
        }

    function readURL(input) {
        // alert('funcion readURL');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log('1 function readURL reader: ' + reader);
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $('#imgDiv').attr('src', e.target.result);
                $('#img_producto').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            console.log('2 function readURL reader: ' + reader.readAsDataURL(input.files[0]));
            alert('3 function readURL  file.nanme : ' + reader.readAsDataURL(input.files[0]).name);
        }
    }

	document.addEventListener("DOMContentLoaded", function() {
		var chooseFile = document.getElementById('chooseFile'); // Asegúrate de que el ID sea correcto
		if (chooseFile) {
			chooseFile.addEventListener("change", function() {
				getImgData();
			});
		} else {
			console.log("El elemento chooseFile no se encontró.");
		}
	});

    function getImgData() {
        const files = chooseFile.files[0];
        console.log('1-getImgData() '+ files);
        if (files) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(files);
            fileReader.addEventListener("load", function () {
            imgPreview.style.display = "block";
            imgPreview.innerHTML = '<img src="' + this.result + '" />';
            });    
        }
    }  

    console.log('Inicio document.ready(function()');
    $("#new_id_barcod").on("change", function(){
        console.log('NUEVO');
            // Cuando es Nuevo Codigo
            console.log('Estoy en #new_id_barcod on Change');
            var baseURL= "<?php echo base_url(); ?>";
            console.log('baseURL : ' + baseURL);
            var codigo = $("#codigo").val();                 // Id del Producto
            console.log('cargado codigo: '+codigo);
            var new_id_barcod = $("#new_id_barcod").val();  // Id del Codigo Barras
            console.log('cargado new_id_barcod: '+new_id_barcod); 
            var acceso = "<?php echo base_url(); ?>"+'/productos/genBCG2';
            console.log('accesso: '+acceso);
          //  alert ('Acceso: ' + acceso+'/'+id+'/'+id_barcod);
            $.ajax({  
                url: acceso+'/'+codigo+"/"+new_id_barcod,               
                type:'post',  
                success:function(res){ 
                    if(res != 0){
                          $('#imgcodbarra').html(res);
                          console.log('success #imgcodbarra actualizada');
                    }else{
                        console.log('Error footer  $(#new_id_barcod)' + res);
                        alert('error');
                    }
                }
            });
            console.log('voy a generaCodQRNuevo()');
            generaCodQRNuevo();
        });

    $("#id_barcod").on("change", function(){
            // Cuando viene de la Edicion
            alert('2- LLEGUE #id_barcod change');
            console.log('Estoy en #id_barcod on Change');
            var baseURL= "<?php echo base_url(); ?>";
            console.log('baseURL : ' + baseURL);
            var id = $("#id").val();                 // Id del Producto
            console.log('cargado id: '+id);
            var codigo = $("#codigo").val();                 // Id del Producto
            console.log('cargado codigo: '+codigo);

            var id_barcod = $("#id_barcod").val();  // Id del Codigo Barras
            console.log('cargado id_barcod: '+id_barcod); 

            var acceso = "<?php echo base_url(); ?>"+'/productos/genBCG2';
            console.log('accesso: '+acceso);
          //  alert ('Acceso: ' + acceso+'/'+id+'/'+id_barcod);
            $.ajax({  
                //url: acceso+'/'+id+'/'+codigo+"/"+id_barcod,ç
                url: acceso+'/'+codigo+"/"+id_barcod,
                type:'post',  
                success:function(res){ 
                    if(res != 0){
                          $('#imgcodbarra').html(res);
                          console.log('success #imgcodbarra actualizada - codigo: ' + codigo + '   id_barcod: '+id_barcod);
                    }else{
                        console.log('Error footer  $(#id_barcod)' + res);
                        alert('error');
                    }
                }
            });
            console.log('voy a generaCodQR()');
            generaCodQR();
        });
    $("#id_barcod").change(function(){
          //alert('1- LLEGUE #id_barcod change');
          readURL(img_producto);
         });

         /* --- Preview IMAGE Productos/Edit */
		 
		 /*
         $("#preview").on("change", function(){
            // Cuando viene de la Edicion
            //alert('1- LLEGUE #preview change');
            console.log('1-function preview on Change');

            var fileName = document.getElementById('img_producto').files[0].name;
            console.log('2-function preview archivo seleccionado fileName : ' + fileName);

            var baseURL= "< ?  php echo base_url(); ?>";
            console.log('3-function preview baseURL : ' + baseURL);
            var id = $("#id").val();                 // Id del Producto
            console.log('4-function preview cargado id: '+id);
            //$('#imgDiv').html('<img src="data:image/png;base64,' +fileName + '" />');
            $('#imgDiv').innerHTML = '<img src="' + fileName + '" />';
            //console.log('voy a generaCodQR()');
            //generaCodQR();
            getImgData();
        });


         $("#preview").change(function(){
            // alert('LLEGUE #id_barcod change');
          readURL(img_producto);
         });

    /* --------------------------------------- */
    /* Tabla general para todas las List Views */
    /* --------------------------------------- */
	/*
    $('#reportes').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: $('#tituloreporte').val(),
                    text: '<span style="color:#1acc2b;"><i class="fas fa-file-excel style=color:green"></i> Excel</span>',
                    exportOptions: {
                        columns: $('#columnasreporte').text(),
                    }
                }, {
                    extend: 'pdfHtml5',
                    title: $('#tituloreporte').val(),
                    text: '<span style="color:#ff0000;"><i class="fas fa-file-pdf"></i> Pdf</span>',
                    exportOptions: {
                        columns: $('#columnasreporte').text(),
                    }                    
                }, {
                    extend: 'pdfHtml5',
                    title: $('#tituloreporte').val(),
                    text: '<span style="color:#0000FF;"><i class="fa fa-envelope-open" aria-hidden="true"></i> Mail</span>',                                        
                }
                ],
                    language: {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados en su busqueda",
                "searchPlaceholder": "Buscar registros",
                "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                "infoEmpty": "No existen registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },   }
        });
     $('#tblEstandard').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: "Listado de Ventas",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: "Listado de Ventas",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    }                    
                },
                {
                extend:    'gmailHtml5',
                text:      '<i class="fa fa-envelope-open" aria-hidden="true"></i>',
                titleAttr: 'CSV'
            }          
            ],
                    language: {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados en su busqueda",
                "searchPlaceholder": "Buscar registros",
                "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                "infoEmpty": "No existen registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            }
        });
    $('#example1').DataTable({
        /* Configuramos 5  filas por pagina */
/*     "iDisplayLength": 5, 
        /* Ordenamos la tabla de Ventas por Fecha Descendente  */
		/*
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados en su bÃºsqueda",
            "searchPlaceholder": "Buscar registros",
            "info": "Mostrando registros de _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "No existen registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        }
    });	
	// Tiempo Maximo de Inactividad para realizar el LogOut
	// 3 Minutos
	(function() {
        let time;
        const maxInactivity = 3 * 60 * 1000; // 3 minutos en milisegundos

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(logout, maxInactivity);
        }
 
        function logout() {
            alert("Sesión cerrada por inactividad.");
            window.location.href = "< ? = base_url('usuarios/logout') ?>"; // Ruta para cerrar sesión
        }

        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        document.onclick = resetTimer;
        document.onscroll = resetTimer;
    })();
	
*/
	});
</script>
<!-- /script> -->
</body>
</html>