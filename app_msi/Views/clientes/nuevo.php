<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-4"><?php echo $titulo; ?></h1>
        <hr color="cyan">
        <!-- para las validaciones del Formulario -->
        <!-- Imprime los errores de las validaciones del Formulario  -->
        <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

    <form action="<?php echo base_url(); ?>/clientes/insertar" method="post" autocomplete="off">
    <div class="row col-md-12">
        <div class="form-group col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" 
                         style="color:#f8f9fa; background-color: #0676e7;"
                            id="inputGroup-sizing-default">
                            <i class="fa fa-user" aria-hidden="true"></i>&nbsp; Nombre</span>
                    <input type="text"  
                        id="nombre"
                        name="nombre" 
                        class="form-control" 
                        aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default"
                        autofocus required>
                </div>
            </div> 
            <div class="form-group col-md-6">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                style="color:#f8f9fa; background-color: #0676e7;"
                id="inputGroup-sizing-default">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Direccion</span>
                <input type="input"  
                    id="direccion"
                    name="direccion" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    required>
            </div>
        </div>
    </div>
        &nbsp;
        <div class="row col-md-12">
        <div class="form-group col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" 
                    style="color:#f8f9fa; background-color: #0676e7;"
                    id="inputGroup-sizing-default">
                    <i class="fa fa-phone" aria-hidden="true"></i>&nbsp; Telefono</span>
                    <input type="text"  
                        id="telefono"
                        name="telefono" 
                        class="form-control" 
                        aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default"
                        autofocus required>
                </div>
            </div>

            <div class="form-group col-md-6">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                style="color:#f8f9fa; background-color: #0676e7;"
                id="inputGroup-sizing-default">
                <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Correo</span>
                <input type="input"  
                    id="correo"
                    name="correo" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    required>
            </div>
        </div>
    </div>
        &nbsp;


<!-- Acciones de botones -->
<fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>
