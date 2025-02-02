    <div id="layoutSidenav_content">
        <main>
            <!-- Contenido principal -->
            <div class="wrapper">
                <div class="container">
                    <h1 class="mt-2"><?php echo $titulo . " - " . $fecha; ?></h1>
					<hr color="cyan"></hr>					
               <!--
					<hr class="border border-info"> -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?php echo base_url(); ?>unidades/nuevo" class="btn btn-primary">Agregar</a>
                            <a href="<?php echo base_url(); ?>unidades/eliminados" class="btn btn-warning">Eliminados</a>
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
                                        <td><?php echo $dato['id']; ?></td>
                                        <td><?php echo $dato['nombre']; ?></td>
                                        <td><?php echo $dato['nombre_corto']; ?></td>
                                        <td>
                                            <a href="<?php echo base_url('unidades/editar/' . $dato['id_encriptado']); ?>" class="btn btn-success">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar" data-id="<?php echo $dato['id_encriptado']; ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
 
    <!-- Modal de Confirmación -->
    <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="modalConfirmarEliminarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este elemento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="formEliminar" method="POST" action="">
                        <input type="hidden" name="id" id="idEliminar" value="">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  <script>
        // Configuración del modal para eliminar
        const modalConfirmarEliminar = document.getElementById('modalConfirmarEliminar');
        modalConfirmarEliminar.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            document.getElementById('idEliminar').value = id;
        });

        // Inicialización de DataTables
        $(document).ready(function () {
            $('#reportes').DataTable();
        });
    </script>
</body>
</html>