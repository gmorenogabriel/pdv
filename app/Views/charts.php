<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard - SB Admin</title>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> -->
	<script src="<?php echo base_url(); ?>js/Chart.js"></script>	
    <script src="<?php echo base_url(); ?>/js/jquery-3.5.1.slim.min.js"></script>
</head>
<body>
    <input type="button" id="btnBuscar" value="Graficar">
    <canvas id="myChart" width="400" height="150"></canvas>
<script>
var paramCodigos = [];
var paramExistencias = [];

$('#btnBuscar').click(function(){

    $.post("<?php echo base_url();?>productos/graficastockMinimoProductos", function(data){        
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
        var ctx = $('#myChart');
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
});
</script>
</body>
</html>