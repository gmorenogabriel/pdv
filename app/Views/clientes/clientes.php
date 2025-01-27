<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-4"><?php echo $titulo; ?></h1>
        <hr color="cyan">
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/clientes/nuevo" class="btn btn-primary">Agregar</a>
                    <a href="<?php echo base_url(); ?>/clientes/eliminados" class="btn btn-warning">Eliminados</a>
                </p>

            </div>

                <div class="table-responsive">
                    <!-- table id="dataTable" no muestra "Excel" ni "PDF"
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> -->
                    <table class="table table-bordered" id="reportes" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Direccion</th>
                                <th>telefono</th>
                                <th>Correo</th>
                                <th width="10%" style="text-align:right;">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($datos as $dato){ ?>
                            <tr>
                                <td align=left>&nbsp;&nbsp;<?php echo $dato['id']; ?></td>
                                <td align=left>&nbsp;&nbsp;<?php echo $dato['nombre']; ?></td>
                                <td align=left>&nbsp;&nbsp;<?php echo $dato['direccion']; ?></td>
                                <td align=left>&nbsp;&nbsp;<?php echo $dato['telefono']; ?></td>
                                <td align=left>&nbsp;&nbsp;<?php echo $dato['correo']; ?></td>
                                <td align=right><a href="<?php echo base_url() . '/clientes/editar/' . $dato['id']; ?>;" class="btn btn-success">
                                <i class="fas fa-pencil-alt"></i></a>
                                 <a href="#" data-href="<?php echo base_url() . '/clientes/eliminar/' . $dato['id']; ?>;" 
                                       data-toggle="modal" data-target="#modal-confirma" data-placement="top" 
                                       title="Eliminar registro" class="btn btn-danger">
                                <i class="fas fa-trash"></i></a></td>
                            </tr>

                            <?php } ?>
                    </tbody>
                    </table>
                </div>
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

</div>
