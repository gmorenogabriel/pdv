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
<!--
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>js/jquery-3.6.1.min.js"></script>
  <script src="<?php echo base_url(); ?>js/bootstrap-4.3.1.min.js"></script>
  -->
<script src="<?php echo base_url(); ?>js/Chart.js"></script>			
<script type="text/javascript">
  console.log($); // Esto debe mostrar la función de jQuery si está cargada correctamente
var popCanvas = $("#popChart");
var popCanvas = document.getElementById("popChart");
var popCanvas = document.getElementById("popChart").getContext("2d");

var barChart = new Chart(popCanvas, {
  type: 'bar',
  data: {
    labels: ["China", "India", "United States", "Indonesia", "Brazil", "Pakistan", "Nigeria", "Bangladesh", "Russia", "Japan"],
    datasets: [{
      label: 'Population',
      data: [1379302771, 1281935911, 326625791, 260580739, 207353391, 204924861, 190632261, 157826578, 142257519, 126451398],
      backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)',
        'rgba(255, 159, 64, 0.6)',
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)',
        'rgba(153, 102, 255, 0.6)'
      ]
    }]
  }
});
console.log ("Ejecutando en el Documento");
<!-- Graficos de la pagina de Inicio -->
window.onload = function() {
//$(document).ready(function(){
	  $('#modal-confirma').on('show.bs.modal', function(e){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    console.log('Pagina Inicio.php document.ready(function()');

    var base_url="<?php echo base_url();?>";
    var year = (new Date).getFullYear();
	console.log("----------------a--------");
console.log(document.getElementById('myBarChart1')); // Debería mostrar el elemento <canvas>
console.log("----------------aa--------");

    // Barras
	document.addEventListener("DOMContentLoaded", function() {
		datagrafico(base_url,year);
	});

//	document.addEventListener("DOMContentLoaded", function() {
//        dataGraficaCompras(base_url);

//    });
	// $("#year").on("change", function(){
    //     year = $(this).val();
    //     datagrafico(base_url,year);
    // });
    // Pie

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
					
					
					
					// if (ctxPie) {
                        // new Chart(ctxPie, {
                            // type: "pie",
                            // data: {
                                // labels: paramCategorias,
                                // datasets: [{
                                    // data: paramTotales,
                                    // backgroundColor: [
                                        // "rgba(255, 99, 132, 0.6)",
                                        // "rgba(54, 162, 235, 0.6)",
                                        // "rgba(255, 206, 86, 0.6)",
                                    // ],
                                // }],
                            // },
                            // options: {
                                // responsive: true,
                                // plugins: {
                                    // legend: { position: "top" },
                                    // title: { display: true, text: "Distribución de Compras por Categoría" },
                                // },
                            // },
                        // });
                    // } else {
                        // console.error("El canvas 'myPieChart1' no se encontró.");
                    // }
					
					
					
					
					
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
    

    $(document).ready(function(){    

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
         $("#preview").on("change", function(){
            // Cuando viene de la Edicion
            //alert('1- LLEGUE #preview change');
            console.log('1-function preview on Change');

            var fileName = document.getElementById('img_producto').files[0].name;
            console.log('2-function preview archivo seleccionado fileName : ' + fileName);

            var baseURL= "<?php echo base_url(); ?>";
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

        });
    /* --------------------------------------- */
    /* Tabla general para todas las List Views */
    /* --------------------------------------- */	
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
        "iDisplayLength": 5, 
        /* Ordenamos la tabla de Ventas por Fecha Descendente  */
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
<!-- /script> -->
</body>
</html>