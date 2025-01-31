<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
          <div>
            <p>
                <a href="<?php echo base_url(); ?>usuarios/nuevo" class="btn btn-primary"> Agregar</a>
                <a href="<?php echo base_url(); ?>usuarios/eliminados" class="btn btn-warning"> Eliminados</a>
            </p>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="reportes" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Id</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th style="text-align:center;">Caja</th>
                                <th style="text-align:center;">Rol</th>
                                <th width="15%" style="text-align:right;">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($datos as $dato){ ?>
                            <tr>
                                <td align=center>&nbsp;<?php echo $dato['id']; ?></td>
                                <td align=left>&nbsp;<?php echo $dato['usuario']; ?></td>
                                <td align=left>&nbsp;<?php echo $dato['nombre']; ?></td>
                                <td align=center>&nbsp;<?php echo $dato['id_caja']; ?></td>
                                <td align=center>&nbsp;<?php echo $dato['id_rol']; ?></td>
                                <td><a href="<?php echo base_url() . 'usuarios/editar/' . $dato['id']; ?>;" class="btn btn-success">
                                <i class="fas fa-pencil-alt"></i></a>
                                <a href="#" data-href="<?php echo base_url() . 'usuarios/editar/' . $dato['id']; ?>;" 
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
