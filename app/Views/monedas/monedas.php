<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
          <div>
            <p>

                  <span class="float-left"><a href="<?php echo base_url(); ?>/monedas/nuevo" class="btn btn-primary pull-left">Alta</a></span>
                  <!-- <span class="float-right"><a href="<?php echo base_url(); ?>/monedas/eliminados" class="btn btn-danger pull-right">Baja</a></span> -->
            </p>
                </div>
              </div>  
        &nbsp;
                   <div class="row">
                    <div class="col-md-12">
                    <div class="table-responsive">
                             <!-- Pasamos el Nombre del Reporte y las Columnas a Mostrar al footer.php 
                                     para Excel y PDF 
                                <table id="compras" class="table table-bordered btn-hover">
                                -->
                                    <input type="hidden" id="tituloreporte"   value="Reporte Flujo de Caja.">  
                                    <input type="hidden" id="columnasreporte" value="[ 0, 1, 2, 3, 4, 5]">        
                                    <table id="reportes" class="table table-bordered btn-hover">                                    
                                <!--  Fin 
                         
                         <table class="table table-bordered" id="tblEstandard" width="100%" cellspacing="0">
 -->                        
                        <thead>
                            <tr>
                              <th style="text-align:left;">Id</th>
                                <th style="text-align:center;">Moneda</th>
                                <th style="text-align:left;">Nombre</th>
                                <th style="text-align:left;">Nombre corto</th>
                                <th style="text-align:center;">Símbolo</th>
                                <th style="text-align:center;">Tipo</th>
                                <th style="text-align:center;">DivMul</th>
                                <th style="text-align:right;">T.C.Compra</th>
                                <th style="text-align:right;">T.C.Venta</th>
                                <th style="text-align:right;">Activo</th>
                                <th width="10%" style="text-align:right;">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($datos as $dato){ ?>
                            <tr>
                                <td align="center"><?php echo $dato['id']; ?></td>
                                <td align="center"><?php echo $dato['moneda']; ?></td>
                                <td align="left">&nbsp;&nbsp;<?php echo $dato['nombre']; ?></td>
                                <td align="center"><?php echo $dato['nombre_corto']; ?></td>
                                <td align="center"><?php echo $dato['simbolo']; ?></td>
                                <td align="center"><?php echo $dato['tipo_moneda']; ?></td>
                                <td align="center"><?php echo $dato['divide_mult']; ?></td>
                                <td align=right>
                                  <?php echo number_format((float)$dato['tc_compra'], 2, ",", "."); ?>&nbsp;&nbsp;
                                </td>
                                <td align=right>
                                  <?php echo number_format((float)$dato['tc_venta'], 2, ",", "."); ?>&nbsp;&nbsp;
                                </td>
                                <td align=center><?php echo $dato['activo']; ?></td>
                                <td><a href="<?php echo base_url() . '/monedas/editar/' . $dato['id']; ?>;" class="btn btn-success">
                                <i class="fas fa-pencil-alt"></i></a>
                                <a href="#" data-href="<?php echo base_url() . '/monedas/eliminar/' . $dato['id']; ?>;" 
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