<div id="layoutSidenav_content">
<main>
    <div class="container">
        <h1 class="mt-2"><?php echo $titulo . " al " . $fecha; ?></h1>
        <hr color="cyan">
        <!-- para las validaciones del Formulario -->
        <!-- Imprime los errores de las validaciones del Formulario  -->	
  <?php if (isset($validation) && !empty($validation) && count($validation)>0) : ?>
  <!-- ? php print_r($validation); ?> -->
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($validation as $field => $error): ?>
                <li><strong><?= esc($field) ?>:</strong> <?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
        <form id="insertForm" action="<?php echo base_url('unidades/insertar'); ?>" method="POST" autocomplete="off">
        <!-- para que devuelva la fila del error de validacion -->
		
		<!-- Campo oculto 'activo'=1 -->
		<input type="hidden" name="activo" value="1">

<div class="row">
    <div class="form-group col-md-6">
        <!-- Nombre -->
        <div class="d-flex align-items-center mb-3">
            <label for="nombre" class="me-2" style="width: 150px;">Nombre:</label>
            <input class="form-control" 
                   id="nombre" 
                   name="nombre" 
                   type="text" 
				   required
				   value="<?= trim(set_value('nombre')) ? ltrim(rtrim(set_value('nombre'))) : '' ?>">
        </div>
		<!-- &nbsp; -->
        <?php if (isset($validation['nombre'])): ?>
            <small class="text-danger"><?= $validation['nombre'] ?></small>
        <?php endif; ?>

        <!-- Nombre Corto -->
        <div class="d-flex align-items-center">
            <label for="nombre_corto" class="me-2" style="width: 150px;">Nombre Corto:</label>
            <input class="form-control" 
                   id="nombre_corto" 
                   name="nombre_corto" 
                   type="text" 
				   required
				   value="<?= trim(set_value('nombre_corto')) ? ltrim(rtrim(set_value('nombre_corto'))) : '' ?>">
        </div>
        <?php if (isset($validation['nombre_corto'])): ?>
            <small class="text-danger"><?= $validation['nombre_corto'] ?></small>
        <?php endif; ?>
    </div>
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
                    <span class="float-right"><a href="<?php echo base_url(); ?>/unidades" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>

<!-- <script src="< ? php echo base_url(); ?>/js/formulario.js"></script> -->

   <script>
        document.getElementById('insertForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional

            const formData = new FormData(this);

// Recorre todos los datos recibidos
//const formData = new FormData(this);
for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
}


            fetch('<?= site_url('unidades/insertar') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Usar SweetAlert2 para mostrar el resultado
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        html: data.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: data.message,
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: 'Ocurrió un error al procesar la solicitud.',
                });
                console.error('Error:', error);
            });
        });
    </script>
