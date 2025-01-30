<div id="layoutSidenav_content">
<main>
	<div class="wrapper">
		<div class="container">
			<h1 class="mt-2"><?php echo $titulo . " - ". $fecha ?></h1>
			<hr color="cyan"></hr>
			<div class="d-flex justify-content-between">
			<div>
				  <a href="<?php echo base_url(); ?>categorias/nuevo" class="btn btn-primary"> Agregar</a>
				  <a href="<?php echo base_url(); ?>categorias/eliminados" class="btn btn-warning"> Eliminados</a>
			</div>
				<div>
				
					
			<!--	<a href="< ? php echo base_url('categorias/generaExcel'); ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</a>
					<a href="< ? php echo base_url('categorias/generaExcel'); ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</a>
					<button id="btnGeneraExcelCateg" type="button" class="btn btn-success" data-dismiss="modal"> Generar Excel nuevo</button> 
			-->
					<button id="btnGeneraExcelCateg" type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-file-excel"></i> Excel</a></button>			
					<button id="btnGeneraPdfCateg"   type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-file-pdf"></i> Pdf</a></button>
<!--	<a href="< ? php echo base_url('categorias/generaPdf'); ?>" class="btn btn-success"><i class="fas fa-file-pdf"></i> Pdf</a> -->

				</div>
			</div>  
			<div class="table-responsive mt-3">
				<input type="hidden" id="tituloreporte" value="Reporte de Categorías.">  
				<input type="hidden" id="columnasreporte" value="[0, 1, 2, 3]">        
				<table id="miTabla" class="table table-striped table-bordered">
				  <thead>
					  <tr>
						<th style="text-align:left;">&nbsp;Id</th>
						<th style="text-align:left;">&nbsp;Nombre</th>                                
						<th width="10%" style="text-align:right;">Opciones</th>
					  </tr>
				  </thead>

				  <tbody>
					  <?php foreach($datos as $dato) :?>
					  <tr>
					  <td>&nbsp;&nbsp;<?php echo $dato['id']; ?></td>
					  <td>&nbsp;&nbsp;<?php echo $dato['nombre']; ?></td>
					<!-- Encriptado del Id -->
					  <?php 
						$id_enc = base64_encode($dato['id']); 
					  ?>                            
					  <td align=right>
						  <!-- No permito Modificar solo Altas y Bajas porque es Codigo / Nombre y pueden pisotear mal
							<a href="<?php echo base_url() . '/categorias/editar/' . $id_enc; ?>;" class="btn btn-success">
							<i class="fas fa-pencil-alt"></i></a>
							-->
							<a href="#" data-href="<?php echo base_url() . '/categorias/eliminar/' . $id_enc; ?>;" 
								  data-toggle="modal" data-target="#modal-confirma" data-placement="top" 
								  title="Eliminar registro" class="btn btn-danger">
						  <i class="fas fa-trash"></i></a>
						  </td>
					  </tr>
					<?php endforeach;?>
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


