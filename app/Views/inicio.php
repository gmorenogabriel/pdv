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
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>productos"> Ver detalles</a>
                </div>
            </div>

        <!-- Productos -------------------------->
        
            <div class="col-3">
                <div class="card text-white bg-success">
                    <div class="card-body"> 
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Compras del día:   <?= number_format((int)$totalCompras['total'], 2, ",", "."); ?>
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>compras"> Ver detalles</a>
                </div>
            </div>
        
        <!-- Stock Minimo-------------------------->
        
            <div class="col-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                    <i class="fa fa-truck" aria-hidden="true"></i> 
                        Ventas del día:  <?= number_format((int)$totalCompras['total'], 2, ",", "."); ?>
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>productos"> Ver detalles</a>
                </div>
            </div>
        
        <!-- Stock Minimo de Productos ---------------->
     
            <div class="col-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                    <i class="fa fa-eye" aria-hidden="true"></i> Productos con stock mínimo:    <?=  $stockMinProd; ?> 
                    </div>
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>productos"> Ver detalles</a>
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
                    <a class="card-footer text-white" href="<?php echo base_url(); ?>EnvioEMail/index"> Ejecutar
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
                                    <div class="card-body"><canvas id="myBarChart1" width="600%" height="200"></canvas></div>
                                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Gráfica de Torta -  - <strong>Compras</strong>
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart1" width="600%" height="200"></canvas></div>
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
                <div id="PieCer" class="row" ></div>            
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Grafico 1
  /*
  const ctx1 = document.getElementById('myBarChart1');
	console.log("myBarChart1: ", ctx1);
  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  
  // Grafico 2
  const ctx2 = document.getElementById('myPieChart1');
  console.log("myPieChart1: ", ctx2);
  new Chart(ctx2, {
    type: 'pie',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  */
 
    // Elemento del canvas
    const ctx1 = document.getElementById('myBarChart1').getContext('2d');
ctx1.canvas.width = 600;
ctx1.canvas.height = 300;

    // Fetch para obtener los datos
    fetch("<?php echo base_url(); ?>productos/graficastockMinimoProductos", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        }
    })
    .then(response => {
        // Verifica si la respuesta es JSON válida
        if (!response.ok) throw new Error("Error en la respuesta del servidor");
        return response.json();
    })
    .then(data => {
        console.log("Datos recibidos:", data);

        // Procesar los datos: extraer nombres y existencias
        const paramCodigos = data.map(item => item.nombre); // Extrae los nombres de los productos
        const paramExistencias = data.map(item => item.existencias); // Extrae las existencias

        console.log("Nombres:", paramCodigos);
        console.log("Existencias:", paramExistencias);

        // Crear el gráfico con los datos procesados
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: paramCodigos, // Nombres en el eje X
                datasets: [{
                    label: '# Productos en Stock Mínimo',
                    data: paramExistencias, // Existencias en el eje Y
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
					responsive: false, // Desactiva el ajuste automático
			//		maintainAspectRatio: false, // Ignora la relación de aspecto
                scales: {
                    y: {
                        beginAtZero: true // Empieza el eje Y en 0
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error("Error al cargar los datos:", error);
    });
	
	// -----------------------------------------------
	// Cargamos el Grafico de Detalle de Compras
	// -----------------------------------------------
	var paramNombre = [];
    var paramCantidad = [];
	const ctx2 = document.getElementById('myPieChart1').getContext('2d');

ctx2.canvas.width = 600;
ctx2.canvas.height = 300;
    // Fetch para obtener los datos
    fetch("<?php echo base_url();?>compras/graficacompras", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        }
    })
    .then(response => {
        // Verifica si la respuesta es JSON válida
        if (!response.ok) throw new Error("Error en la respuesta del servidor");
        return response.json();
    })
    .then(data => {
        console.log("Datos recibidos:", data);

        // Procesar los datos: extraer nombres y existencias
        const paramNombre = data.map(item => item.nombre); // Extrae los nombres de los productos
        const paramCantidad = data.map(item => item.cantidad); // Extrae las existencias

        console.log("Nombres:", paramNombre);
        console.log("Cantidad:", paramCantidad);

        // Crear el gráfico con los datos procesados
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: paramNombre, // Nombres en el eje X
                datasets: [{
                    label: '# Productos en Stock Mínimo',
                    data: paramCantidad, // Existencias en el eje Y
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
					responsive: false, // Desactiva el ajuste automático
					//maintainAspectRatio: false, // Ignora la relación de aspecto
				
                scales: {
                    y: {
                        beginAtZero: true // Empieza el eje Y en 0
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error("Error al cargar los datos:", error);
    });
</script>

<!-- </script> -->