<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
        <!-- Encriptamos el Id -->
        <?php       // $id_enc = base64_encode($id_enc);
//		d($id_enc);
		?>
        <!-- Imprime los errores de las validaciones del Formulario  -->
        <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>        

        <form action="<?php echo base_url('unidades/actualizar/' . $id_enc); ?>" method="post" autocomplete="off">
        <input type="hidden" id="id" name="id" value="<?php echo $id_enc; ?>" />
<!--    <input type="hidden" value="<?php echo $datos['id']; ?>" name="id"/> -->
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                <!-- es la variable que viene dentro del array data -->
                    <label>Nombre</label>
                    <input class="form-control" 
                        id="nombre" name="nombre"                         
                        value="<?php echo $datos['nombre']; ?>"
                        type="text" autofocus require/>
                </div>

                <div class="col-12 col-sm-6">
                    <label>Nombre corto</label>
                    <input class="form-control" 
                        id="nombre_corto" name="nombre_corto" 
                        value="<?php echo $datos['nombre_corto']; ?>"
                        type="text" require/>
                </div>
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
                    <span class="float-right"><a href="<?php echo base_url('unidades'); ?>"<i class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>
<!-- <script src="<?php echo base_url(); ?>/js/formulario.js"></script> -->
