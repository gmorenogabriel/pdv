<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
        <!-- Imprime los errores de las validaciones del Formulario  -->
        <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>        
        <form action="<?php echo base_url(); ?>/menus/actualizar" method="post" enctype="multipart/form-data"  autocomplete="off">
            <input type="hidden" id="id" name="id" value="<?php echo $menus['id']; ?>" />

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
                             value="<?php echo $menus['nombre']; ?>"
                            autofocus required/>
                    </div>
                </div> 
        </div>
<!-- -- -- -- -- -- -- -- -- -- -->

<!-- -- -- -- -- -- -- -- -- -- -->
            <div class="row col-md-12">
                <div class="form-group col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        &nbsp; Link</span>
                        <input type="input"  
                            id="link"
                            name="link" 
                            class="form-control" 
                            aria-label="Sizing example input" 
                            aria-describedby="inputGroup-sizing-default"
                            value="<?php echo $menus['link']; ?>" 
                            required/>
                    </div>
                </div>
<!-- -- -- -- -- -- -- -- -- -- -->
<!-- -- -- -- -- -- -- -- -- -- -->
    </div>
        <fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/menus" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>