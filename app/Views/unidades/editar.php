<div id="layoutSidenav_content">
<main>
    <div class="container">
        <h1 class="mt-2"><?php echo $titulo . " al " . $fecha . " " . $id_enc; ?></h1>
        <hr color="cyan">
        <!-- para las validaciones del Formulario -->
        <!-- Imprime los errores de las validaciones del Formulario  -->
  <?php if (isset($validation) && !empty($validation) && count($validation)>0) : ?>  
  <?php print_r($validation); ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($validation as $field => $error): ?>
                <li><strong><?= esc($field) ?>:</strong> <?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
        <form action="<?php echo base_url('unidades/actualizar/' . $id_enc); ?>" method="POST" autocomplete="off">
        <input type="hidden" id="id" name="id" value="<?php echo $id_enc; ?>" />
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                <!-- es la variable que viene dentro del array data -->
                    <label>Nombre</label>
                    <input class="form-control" 
                        id="nombre" name="nombre"                         
						type="text" autofocus required
						value="<?= trim($datos['nombre']) ? ltrim(rtrim($datos['nombre'])) : '' ?>" />
                        
                </div>
				<?php if (isset($validation['nombre'])): ?>
					<small class="text-danger"><?= $validation['nombre'] ?></small>
				<?php endif; ?>	
			</div>    
			&nbsp;
			<div class="form-row">        
                <div class="col-12 col-sm-6">
                    <label>Nombre corto</label>
                    <input class="form-control" 
                        id="nombre_corto" name="nombre_corto" 
						type="text" required
						value="<?= trim($datos['nombre_corto']) ? ltrim(rtrim($datos['nombre_corto'])) : '' ?>" />
                        
                </div>
            </div>
				<?php if (isset($validation['nombre_corto'])): ?>
					<small class="text-danger"><?= $validation['nombre_corto'] ?></small>
				<?php endif; ?>			
        </div>      
<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>
<br>

<!-- Acciones de botones -->
<fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url('unidades'); ?>"<i class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>
<!-- <script src="<?php echo base_url(); ?>/js/formulario.js"></script> -->
