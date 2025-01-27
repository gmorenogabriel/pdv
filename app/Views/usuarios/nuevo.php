<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-4"><?php echo $titulo; ?></h1>
        
        <!-- Imprime los errores de las validaciones del Formulario  -->
        <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>/usuarios/insertar" method="post" autocomplete="off">
        <!-- para que devuelva la fila del error de validacion -->

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>Usuario</label>
                    <input class="form-control" 
                        id="usuario" name="usuario" 
                        type="text" 
                        value="<?php echo set_value('usuario'); ?>"
                        autofocus required/>
                </div>

                <div class="col-12 col-sm-6">
                    <label>Nombre</label>
                    <input class="form-control" 
                        id="nombre" name="nombre" 
                        type="text" 
                        value="<?php echo set_value('nombre'); ?>"
                        required/>
                </div>
            </div>
        </div>      

        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>Contraseña</label>
                    <input class="form-control" 
                        id="password" name="password" 
                        type="password" 
                        value="<?php echo set_value('password'); ?>"
                        required/>
                </div>

                <div class="col-12 col-sm-6">
                    <label>Repite Contraseña</label>
                    <input class="form-control" 
                        id="repassword" name="repassword" 
                        type="password" 
                        value="<?php echo set_value('repassword'); ?>"
                        required/>
                </div>
            </div>
        </div>      
        <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->     
                <!-- -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Caja</label>
                            <select class="form-control" id="id_caja" name="id_caja" required>
                                <option value="">Seleccionar caja</option>
                                <?php foreach($cajas as $caja) { ?>
                                    <option value="<?php echo $caja['id']; ?>"><?php echo $caja['nombre']; ?></option>
                                    <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Rol</label>
                            <select class="form-control" id="id_rol" name="id_rol" required>
                                <option value="">Seleccionar rol</option>
                                <?php foreach($roles as $rol) { ?>
                                    <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>    
                </div>
<br><br><br><br>
<br><br>
<br><br>         
<!-- Acciones de botones -->
<fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>
<!-- <script src="<?php echo base_url(); ?>/js/formulario.js"></script> -->


