<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datatables Server Side User_table</title>
     <!-- uery  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     Bootstraps  
     CSS only 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

     Datatables
    <link rel="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
-->
	<!-- jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<!-- datatables -->
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


</head>
<body>
    <div class="container">
        <h2>Codeiniter</h2>
        <hr>
        <table class="table" id="user_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Usuario</th>
                    <th>Nombre</th>            
                    <th>Apellido</th>  
                    <th>Sexo</th>  
                    <th>Password</th>  
                    <th>Status</th>  
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table> 
    </div>
    <script type="text/javascript">
        table = $('#user_table').DataTable({
            "order" : [],
            "proccessing": true,
            "serverSide": true,
            "ajax" : {
                "url" : "<?php echo base_url('Datatables/table_data'); ?>",
                "type" : "POST"
            },
            "columnDefs" : [{
                "targets" : [0],
                "orderable" : false
            }]
        });
    </script>
</body>
</html>