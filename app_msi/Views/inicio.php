<style>
  h1 {
      text-align: left;
      padding: 5%;
  }
  .spinner {
    position: auto;
    text-align:center;   
    z-index:1234;
    overflow: auto;
    width: 100px;
  }
</style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">

        <br/>
        <!-- Productos -------------------------->
        <div class="row"> 
            <div class="col-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                    <i class="fa fa-eye" aria-hidden="true"></i> Total de Productos: <?= $totalProductos; ?>
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>/productos"> Ver detalles</a>
                </div>
            </div>

        <!-- Productos -------------------------->
        
            <div class="col-3">
                <div class="card text-white bg-success">
                    <div class="card-body"> 
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Compras del día:   <?= number_format((int)$totalCompras['total'], 2, ",", "."); ?>
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>/compras"> Ver detalles</a>
                </div>
            </div>
        
        <!-- Stock Minimo-------------------------->
        
            <div class="col-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                    <i class="fa fa-truck" aria-hidden="true"></i> 
                        Ventas del día:  <?= number_format((int)$totalCompras['total'], 2, ",", "."); ?>
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>/productos"> Ver detalles</a>
                </div>
            </div>
        
        <!-- Stock Minimo de Productos ---------------->
     
            <div class="col-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                    <i class="fa fa-eye" aria-hidden="true"></i> Productos con stock mínimo:    <?=  $stockMinProd; ?> 
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>/productos"> Ver detalles</a>
                </div>
            </div>
        </div>
        <br>
        <!-- Pagina Covid-19 -------------------------->
        <div class="row"> 
            <div class="col-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <i class="fa fa-heartbeat" aria-hidden="true"></i> 
                        Reporte diario COVID-19
                    </div>
                    <a class="card-footer text-white" 
                        href=" https://www.gub.uy/sistema-nacional-emergencias/pagina-embebida/visualizador-casos-coronavirus-covid-19-uruguay"> Ver detalles 
                        <i style="width: 0.75rem; height: 0.75rem;" class="spinner-border text-primary" id="redondo"></i></a>
                </div>                    
            </div>

            <div class="col-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <i class="fa fa-user"></i>
                        Server Side puro
                    </div>
                        <a class="card-footer text-white" href="http://localhost:8074/dt_serverside/"> Server Side 
                        <i style="width: 0.75rem; height: 0.75rem;" class="spinner-grow text-muted" id="redondo"></i></a>
                    </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                    <i class="fa fa-users"></i>
                    Server Side con Iconos
                    </div>
                    <a class="card-footer text-white" href="http://localhost:8074/dt_ss/"> Server Side 
                    <i style="width: 0.75rem; height: 0.75rem;" class="spinner-grow text-muted" id="redondo"></i></a>
                </div>
            </div>

            <div class="col-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                    <i class="fa fa-envelope"></i>
                    Enviar Mail
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>/EnvioEMail/index"> Ejecutar
                    <i style="width: 0.75rem; height: 0.75rem;" class="spinner-border text-primary" id="redondo"></i></a>
                </div>
            </div>
<!-- 
        <div id="redondo0" class="row col-xs-12 col-md-10" > 
            
            <div class="col-xs-3 col-md-1"></div>

            <div style="width: 1rem; height: 1rem;" class="spinner-grow  text-muted"></div>
            <div style="width: 1rem; height: 1rem;" class="spinner-grow  text-primary"></div>
            <div style="width: 1rem; height: 1rem;" class="spinner-grow  text-success"></div>
            
        </div> -->
    </div>
    <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar mr-1"></i>
                                        Gráfica de Barras - <strong>Productos</strong>
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Gráfica de Torta -  - <strong>Compras</strong>
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                </div>
                            </div>
                        </div>
      
        <!-- Calendario ---------------->
        <br>
        <br>
        <!-- <div class="col-12">
                <div class="card text-white bg-secondary"">
                    <div class="card-body">
                    <h1>Clientes de prueba</h1>
                <div id="holder" class="row" ></div>            
                <table>
                    <?php if(!empty($clientes)):?>
                        <?php foreach($clientes as $row):?>                
                            <tr>
                                <td><?php echo $row->nombre; ?></td>
                                <td><?php echo $row->direccion; ?></td>
                                <td><?php echo $row->correo; ?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>                
            </table>
            </div> 
        </div>-->
        </div>            
</main>

<!-- Personalizado con ajax -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="js/spinners.js"></script> 
<!-- Graficos               -->
<script type="text/javascript">  
  
$(document).ready(function(){

    console.log('Pagina Inicio.php document.ready(function()');

    var base_url="<?php echo base_url();?>";
    var year = (new Date).getFullYear();
    // Barras
    datagrafico(base_url,year);
    // $("#year").on("change", function(){
    //     year = $(this).val();
    //     datagrafico(base_url,year);
    // });
    // Pie
   dataGraficaCompras(base_url);

    });


    function dataGraficaCompras(base_url){
        
    var paramNombre = [];
    var paramCantidad = [];
    console.log('function dataGraficaCompras ' );
        $.post("<?php echo base_url();?>/compras/graficaCompras", function(data){        
            var obj = JSON.parse(data);
            console.log(obj);
            // creamos el Array
            $.each(obj, function(i, item){
                console.log(i + ' - ' + item);
                paramNombre.push(item.nombre);
                //paramExistencias.push(item.stock_minimo);
            // paramCodigos.push(item.codigo);
            paramCantidad.push(item.cantidad);
            });

        // //   var parametromeses = ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'];
        // //   var parametrovalores = [12, 19, 3, 5, 2, 3];
            // sin JQuery
            // var ctx = document.getElementById('myChart');
            // con JQuery
            var ctx = $('#myPieChart');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: paramNombre, // parametromeses, // Horizontal
                    datasets: [{
                        label: '#Compras',
                        data: paramCantidad, // parametrovalores, //
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    }

function datagrafico(base_url,year){
    //$('#myBarChart').click(function(){
        
    var paramCodigos = [];
    var paramExistencias = [];
    console.log('function datagrafico ' );
        $.post("<?php echo base_url();?>/productos/graficastockMinimoProductos", function(data){        
            var obj = JSON.parse(data);
            console.log(obj);
            // creamos el Array
            $.each(obj, function(i, item){
                console.log(i + ' - ' + item);
                paramCodigos.push(item.nombre);
                //paramExistencias.push(item.stock_minimo);
            // paramCodigos.push(item.codigo);
                paramExistencias.push(item.existencias);
            });

        // //   var parametromeses = ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'];
        // //   var parametrovalores = [12, 19, 3, 5, 2, 3];
            // sin JQuery
            // var ctx = document.getElementById('myChart');
            // con JQuery
            var ctx = $('#myBarChart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: paramCodigos, // parametromeses, // Horizontal
                    datasets: [{
                        label: '#Productos en Stock Mínimo',
                        data: paramExistencias, // parametrovalores, //
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    }

</script>