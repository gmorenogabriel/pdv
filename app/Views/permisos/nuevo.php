<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan">
        <!-- para las validaciones del Formulario -->
        <!-- Imprime los errores de las validaciones del Formulario  -->
        <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>


        <form action="<?php echo base_url(); ?>/permisos/insertar" method="post" autocomplete="off">

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>Menu</label>
                    <select class="form-control" id="menu_id" name="menu_id" required>
                        <!-- <option value="">Seleccionar Menu</option>-->
                        <?php foreach($menus as $menu) { ?>
                            <option value="<?php echo $menu['id']; ?>"><?php echo $menu['nombre']; ?></option>
                            <?php } ?>
                    </select>
                </div>

                <div class="col-12 col-sm-6">
                    <label>Rol</label>
                    <select class="form-control" id="rol_id" name="rol_id" required>
                        <option value="">Seleccionar Rol</option>
                        <?php foreach($roles as $rol) { ?>
                            <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                            <?php } ?>
                    </select>
                </div>
            </div>    
        </div>
<br>
<br>
    <fieldset class="form-group border p-1 col-md-12">
        <legend class="col-md-3 col-form-label pt-0" align="center">Permisos a asignar</legend>
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-3">
                    <label class="radio-inline">Read</label>                
                </div>
                <div class="col-12 col-sm-3">
                    <label class="radio-inline">Insert</label>
                </div>
                    <div class="col-12 col-sm-3">
                    <label class="radio-inline">Update</label>                
                </div>
                <div class="col-12 col-sm-3">
                    <label class="radio-inline">Delete</label>
                </div>
            </div>
        </div>                                    
<!--   Lectura  -->
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-3">
                <label class="radio-inline" >
                    <input type="radio"
                        id="read" name="read" 
                        <?php if(isset($permisos)){ ?>
                            value="1" <?php echo $permisos[0]['read'] == "1" ? "checked":"";?> />SI                                            
                        <?php } ?>                                 
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label class="radio-inline" >
                    <input type="radio"
                        id="read" name="read" 
                         value="0" <?php echo $permisos[0]['read'] == "0" ? "checked":"";?> />NO
                    </label>
                </div>

<!--   Insert  -->
                <div class="col-12 col-sm-3">
                <label class="radio-inline" >
                    <input type="radio"
                        id="insert" name="insert" 
                        <?php if(isset($permisos)){ ?>
                            value="1" <?php echo $permisos[0]['insert'] == "1" ? "checked":"";?> />SI                                            
                        <?php } ?>                                 
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label class="radio-inline" >
                    <input type="radio"
                        id="insert" name="insert" 
                         value="0" <?php echo $permisos[0]['insert'] == "0" ? "checked":"";?> />NO
                    </label>
                </div>

<!--   Update  -->

                <div class="col-12 col-sm-3">
                <label class="radio-inline" >
                    <input type="radio"
                        id="update" name="update" 
                        <?php if(isset($permisos)){ ?>
                            value="1" <?php echo $permisos[0]['update'] == "1" ? "checked":"";?> />SI                                            
                        <?php } ?>                                 
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label class="radio-inline" >
                    <input type="radio"
                        id="update" name="update" 
                         value="0" <?php echo $permisos[0]['update'] == "0" ? "checked":"";?> />NO
                    </label>
                </div>

<!--   Delete  -->
                <div class="col-12 col-sm-3">
                <label class="radio-inline" >
                    <input type="radio"
                        id="delete" name="delete" 
                        <?php if(isset($permisos)){ ?>
                            value="1" <?php echo $permisos[0]['delete'] == "1" ? "checked":"";?> />SI                                            
                        <?php } ?>
                    </label>
                    &nbsp;&nbsp;&nbsp;
                    <label class="radio-inline" >
                    <input type="radio"
                        id="delete" name="delete" 
                         value="0" <?php echo $permisos[0]['delete'] == "0" ? "checked":"";?> />NO
                    </label>
                </div>
                </div>
            </div>                             
        </div>
    </fieldset>                       
<br>
<br>

            <fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/permisos" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main
