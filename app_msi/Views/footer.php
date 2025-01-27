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

<script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>/js/app.js"></script> -->
<script src="<?php echo base_url(); ?>/js/scripts.js"></script>
<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/js/dataTables.bootstrap4.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>/assets/demo/datatables-demo.js"></script>-->
<!-- Pdf Excel -->
<script src="<?php echo base_url();?>/js/datatables-export/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>/js/datatables-export/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url();?>/js/datatables-export/js/jszip.min.js"></script>
<script src="<?php echo base_url();?>/js/datatables-export/js/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>/js/datatables-export/js/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>/js/datatables-export/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>/js/datatables-export/js/buttons.print.min.js"></script>
<script>
    $('#modal-confirma').on('show.bs.modal', function(e){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<!--     Ver ejemplos en www.codexworld.com -->
<script type="text/javascript">  

    
    
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


    const chooseFile = document.getElementById("img_producto");
        const imgPreview = document.getElementById("preview2");

        chooseFile.addEventListener("change", function () {
            //alert(chooseFile);
        getImgData();
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
</script>
</body>
</html>