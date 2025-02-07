    <div id="layoutSidenav_content">
        <main>
            <!-- Contenido principal -->
            <div class="wrapper">
                <div class="container">
                    <h1 class="mt-2"><?php echo esc($titulo) . " - " . esc($fecha); ?></h1>
<!-- ? php dd($datos); ?>					
		
				< ? php d($datos[0]); ?>  
					< ? php foreach ($datos as $dato) { ?>
						< ? php echo $dato['id'] . ' ' .$dato['nombre'] . ' ' . $dato['id_enc'] . '<br/>'; ?>
					 < ? php } ?>
 -->					
					<hr color="cyan"></hr>					
          	<!--      
					<hr class="border border-info"> -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?php echo base_url('unidades/nuevo'); ?>" class="btn btn-primary">Agregar</a>
                            <a href="<?php echo base_url('unidades/eliminados'); ?>" class="btn btn-warning">Eliminados</a>
                        </div>
                        <div>
                            <button id="btnGeneraExcelUnidades" type="button" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button id="btnGeneraPdfUnidades" type="button" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
					<input type="hidden" id="tituloreporte" value="Unidades.">  
                    <input type="hidden" id="columnasreporte" value="[0, 1, 2]">        
					<!-- DataTables -->
					<table id="miTabla" class="table table-striped table-bordered">
					<!-- Bootstrap
                        <table class="table table-bordered" id="reportes" width="100%" cellspacing="0"> 
						-->
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Nombre corto</th>
                                    <th width="10%" style="text-align:right;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datos as $dato) { ?>
                                    <tr>
                                        <td><?= esc($dato['id']); ?></td>
                                        <td><?= esc($dato['nombre']); ?></td>
                                        <td><?= esc($dato['nombre_corto']); ?></td>
                                        <td>
                                            <a href="<?php echo base_url('unidades/editar/' . $dato['id_enc']); ?>" class="btn btn-success">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
<a href="<?php echo base_url('unidades/eliminar/' . $dato['id_enc'] ); ?>" id="btnEliminar" class="btn btn-danger">
    EliminarN
</a>
<!-- 
<a href="#" class="btn btn-danger delete-link" data-id="<?php echo $dato['id_enc']; ?>" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar">
    Eliminar
</a> -->


                                                <i class="fas fa-cash"></i>
                                            </a>											
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
<script>
// Función para mostrar el SweetAlert y pasar la ID
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `Se eliminará el elemento con ID: ${dato['id_enc']}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Acción de eliminación
            eliminarElemento(id);
        } else if (result.isDismissed) {
            console.log('Operación cancelada');
        }
    });
}

// Función de eliminación (puedes reemplazarla por tu lógica)
function eliminarElemento(id) {
    console.log(`Eliminando el elemento con ID: ${id}`);
    // Aquí puedes realizar una solicitud AJAX o cualquier lógica para eliminar
    // Por ejemplo: unidades/eliminar/
    //
    fetch(`/unidades/eliminar/${dato['id_enc']}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire('Eliminado!', 'El elemento ha sido eliminado.', 'success');
    })
    .catch(error => {
        Swal.fire('Error', 'No se pudo eliminar el elemento.', 'error');
    });
    
}

// Llamar la función
document.getElementById('btnEliminar').addEventListener('click', function() {
    const id = this.getAttribute('data-id'); // Suponiendo que el botón tiene el ID como atributo
    confirmarEliminacion(id);
});

</script>
</body>
</html>