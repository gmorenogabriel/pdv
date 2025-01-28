<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
    <h1 class="mt-2"><?php echo $titulo . " - ". $fecha ?></h1>
        <hr color="cyan"></hr>
		   <div class="d-flex justify-content-between">
				<!-- Botones alineados a la izquierda -->
				<div>
				  <span class="float-left me-2"><a href="<?php echo base_url(); ?>flujocaja/entradas" class="btn btn-primary pull-left"> Ingresos</a></span>
				  <span class="float-right me-2"><a href="<?php echo base_url(); ?>flujocaja/salidas" class="btn btn-danger pull-right"> Egresos</a></span>
				</div>
				<!-- Botones alineados a la derecha -->
				<div>
					<span class="float-right me-2"><a href="<?php echo base_url('flujocaja/generaExcel'); ?>" class="btn btn-success pull-right"><i class="fas fa-file-excel"></i> Excel</a></span>
					<span class="float-right me-2"><a href="<?php echo base_url('flujocaja/generaPdf'); ?>" class="btn btn-success pull-right"><i class="fas fa-file-pdf"></i> Pdf</a></span>
				</div>
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
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th style="text-align:right;">Entrada</th>
                                <th style="text-align:right;">Salida</th>
                                <th style="text-align:right;">Saldo</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($datos as $dato){ ?>
                            <tr>
                                <td>&nbsp;&nbsp;<?php echo $dato['id']; ?></td>
                                <td>&nbsp;&nbsp;<?php echo $dato['fecha']; ?></td>
                                <td>&nbsp;&nbsp;<?php echo $dato['descripcion']; ?></td>
                                <td align=right>
                                  <?php echo number_format((float)$dato['entrada'], 2, ",", "."); ?>
                                  &nbsp;&nbsp;
                                </td>
                                <td align=right>
                                  <?php echo number_format((float)$dato['salida'], 2, ",", "."); ?>
                                  &nbsp;&nbsp;
                                </td>
                                <td align=right>
                                  <?php echo number_format((float)$dato['saldo'], 2, ",", "."); ?>
                                  &nbsp;&nbsp;
                                </td>
                            </tr>

                            <?php } ?>
                    </tbody>
                    </table>
                </div>

    </div>
</main>
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