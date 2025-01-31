<div id="layoutSidenav_content">
    <main>
        <div class="wrapper">
            <div class="container">
                <h1 class="mt-2"><?php echo $titulo . " - ". $fecha ?></h1>
                <hr color="cyan"></hr>
                <div class="d-flex justify-content-between">
                    <div>
						  <a href="<?php echo base_url(); ?>unidades/nuevo" class="btn btn-primary"> Agregar</a>
						  <a href="<?php echo base_url(); ?>unidades/eliminados" class="btn btn-warning"> Eliminados</a>
                    </div>					
                    <div>
						<button id="btnGeneraExcelUnidades" type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-file-excel"></i> Excel</a></button>			
						<button id="btnGeneraPdfUnidades"   type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-file-pdf"></i> Pdf</a></button>
						
  
<!-- si hay algun problema con javascript PARA determinar que sucede, 
	se pueden habilitar estas 2 lineas para poder debugear 					
<a href="<?php echo base_url('unidades/generaExcel'); ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</a>
  <a href="<?php echo base_url('unidades/generaPdf'); ?>" class="btn btn-success"><i class="fas fa-file-pdf"></i> Pdf</a>							-->				
                    </div>
            </div>
              <div class="table-responsive mt-3">
                  <table class="table table-bordered" id="reportes" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <td>&nbsp;&nbsp;Id</th>
                            <td>&nbsp;&nbsp;Nombre</th>
                            <td>&nbsp;&nbsp;Nombre corto</th>
                            <th width="10%" style="text-align:right;">Opciones</th>                          
                          </tr>
                      </thead>

                      <tbody>
                          <?php foreach($datos as $dato){ ?>
                          <tr>
                          <td>&nbsp;&nbsp;<?php echo $dato['id']; ?></td>
                          <td>&nbsp;&nbsp;<?php echo $dato['nombre']; ?></td>
                          <td>&nbsp;&nbsp;<?php echo $dato['nombre_corto']; ?></td>
                        <!-- Encriptado del Id -->
                        <?php 
                          $id_enc = base64_encode($dato['id']); 
                        ?>                            
                          <td>&nbsp;&nbsp;<a href="<?php echo base_url('unidades/editar/') . $id_enc; ?>;" class="btn btn-success">
                              <i class="fas fa-pencil-alt"></i></a>
                              <a href="#" data-href="<?php echo base_url() . 'unidades/eliminar/' . $id_enc; ?>;" 
                                      data-toggle="modal" data-target="#modal-confirma" data-placement="top" 
                                      title="Eliminar registro" class="btn btn-danger">
                              <i class="fas fa-trash"></i></a></td>
                          </tr>
                          <?php } ?>
                  </tbody>
                  </table>
              </div>
    </div>
</main>
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>
                            -->
<!-- Modal -->
<div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog dialog-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Confirma eliminar este registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">NO</button>
        <a class="btn btn-danger btn-ok">Sí</a>
      </div>
    </div>
  </div>
</div>