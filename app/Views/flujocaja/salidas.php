<div id="layoutSidenav_content">
<main>
    <div class="container">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan">
        <!-- Imprime los errores de las validaciones del Formulario  -->
        <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form action="<?php echo base_url(); ?>/flujocaja/guardarsalida" method="post" autocomplete="off">
        <!-- para que devuelva la fila del error de validacion -->
<form>
    <div class="row">
        <div class="form-group col-md-3">   
            <div class="input-group-prepend">     
                <span class="input-group-text" id="inputGroup-sizing-default">Fecha: </span>
                <input type="date"
                       name="fechahoy" 
                       type="datetime-local"
                       value="<?php echo date("Y-m-d");?>"
                        disabled />
            </div>
        </div>    
        &nbsp;
        <div class="form-group col-md-4">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Salida $</span>
                <input type="text"  
                id="salida"
                name="salida" 
                class="form-control" 
                value="<?php echo set_value('salida') ?>"
                aria-label="Sizing example input" 
                aria-describedby="inputGroup-sizing-default">
            </div>
        </div>
    </div>

    <div class="form-row">        
        <div class="form-group col-md-7">
            <label>Descripción</label>
            <textarea class="form-control" 
                rows="5" 
                id="descripcion" name="descripcion" 
                style="align-content:left;"
                required
                class="descripcion"><?=set_value('descripcion')?>            
            </textarea>                    
        </div>
    </div>


<!-- Acciones de botones -->
<fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/flujocaja" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>
<!-- <script src="<?php echo base_url(); ?>/js/formulario.js"></script> -->

