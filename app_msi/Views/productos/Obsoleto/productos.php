<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/productos/nuevo" class="btn btn-primary">Agregar</a>
                    <a href="<?php echo base_url(); ?>/productos/eliminados" class="btn btn-warning">Eliminados</a>
                    <a href="<?php echo base_url(); ?>/productos/generaBarras" class="btn btn-info">Cód.Barras</a>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="reportes" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Id</th>
                            <th style="text-align:left;">Codigo</th>
                            <th>Nombre</th>
                            <th style="text-align:right;">Precio Compra</th>
                            <th style="text-align:right;">Precio Venta</th>
                            <th style="text-align:center;">Stock Min.</th>
                            <th style="text-align:center;">Existencias</th>
                            <th width="10%" style="text-align:right;">Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($datos as $dato){ ?>
                        <tr>
                            <td align=center>
                              <?php echo $dato['id']; ?> 
                            </td>
                            <td align=left>&nbsp;&nbsp;
                              <?php echo $dato['codigo']; ?>
                              <br/>
                              <a href="<?php echo base_url() . '/productos/genBCG/'.$dato['id']; ?>"
                              class="btn btn-default btn-xs"> Barcode<i class="fa fa-barcode fa-lg"></i> 
                            </a>
                            
                            </td>
                            <td>&nbsp;<?php echo $dato['nombre']; ?></td>
                            <td align=right>
                              <?php echo number_format((float)$dato['precio_compra'], 2, ",", "."); ?>&nbsp;&nbsp;
                            </td>
                            <td align=right>
                              <?php echo number_format((float)$dato['precio_venta'], 2, ",", "."); ?>&nbsp;&nbsp;
                            </td>
                            <td align=center>
                              <?php echo $dato['stock_minimo']; ?>
                            </td>                                 
                            <?php if($dato['stock_minimo']>=$dato['existencias']){ ?>
                                <td align=center style="background-color:lemonchiffon; color:black;"><?php echo $dato['existencias']; ?>&nbsp;&nbsp;</td>
                            <?php } else { ?>
                                <td align=center> <?php echo $dato['existencias']; ?>&nbsp;&nbsp;</td>                                 
                            <?php } ?>

                            <td><a href="<?php echo base_url() . '/productos/editar/' . $dato['id']; ?>;" class="btn btn-success">
                            <i class="fas fa-pencil-alt fas-lg"></i></a>
                            <a href="#" data-href="<?php echo base_url() . '/productos/eliminar/' . $dato['id']; ?>;" 
                                    data-toggle="modal" data-target="#modal-confirma" data-placement="top" 
                                    title="Eliminar registro" class="btn btn-danger">
                            <i class="fas fa-trash"></i></a></td>
                        </tr>
                        <?php } ?>
                </tbody>
                </table>
                <?php if(isset($code)){
                  //<?php
                    echo '<img src="data:image/png;base64,'.$code.'" />'; 
                    //?>
                <?php } ?>
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
