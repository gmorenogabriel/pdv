print_r($datos);
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

        <form action="<?php echo base_url(); ?>/monedas/actualizar" method="post" autocomplete="off">

        <input type="hidden" value="<?php echo $datos['id']; ?>" name="id"/>
<!-- -->
<div class="row">
        <div class="form-group col-md-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Moneda</span>
                    <input type="text"  
                        id="moneda"
                        name="moneda" 
                        class="form-control" 
                        aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default"
                        value="<?php echo $datos['moneda']; ?>"
                        autofocus required>
                </div>
            </div>
            &nbsp;
            <div class="form-group col-md-4">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                id="inputGroup-sizing-default">Nombre</span>
                <input type="input"  
                    id="nombre"
                    name="nombre" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    value="<?php echo $datos['nombre']; ?>"
                    required>
            </div>
        </div>
        &nbsp;
        <div class="form-group col-md-4">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                id="inputGroup-sizing-default">Nombre corto</span>
                <input type="input"  
                    id="nombre_corto"
                    name="nombre_corto" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    value="<?php echo $datos['nombre_corto']; ?>"
                    required>
            </div>
        </div>
    </div>      
<!-- Segunda Fila de Datos -->
<div class="row">
        <div class="form-group col-md-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Símbolo</span>
                    <input type="input"  
                        id="simbolo"
                        name="simbolo" 
                        class="form-control" 
                        aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default"
                        value="<?php echo $datos['simbolo']; ?>"
                        autofocus required>
                </div>
            </div>
            &nbsp;
            <div class="form-group col-md-4">    
            <div class="input-group-prepend">        
            <span class="input-group-text" id="inputGroup-sizing-default">T.Moneda</span>
                <select class="form-control" id="tipo_moneda" name="tipo_moneda">
                   <?php if($datos['tipo_moneda']=='E'){ ?>
                        <option value="E"><?php echo 'Extranjera'; ?></option>
                   <?php } ?>
                   <?php if($datos['tipo_moneda']=='D'){ ?>
                        <option value="D"><?php echo 'Dolar'; ?></option>
                   <?php } ?>
                   <?php if($datos['tipo_moneda']=='N'){ ?>
                        <option value="N"><?php echo 'Nacional'; ?></option>
                   <?php } ?>                    
                    <option value="N">Nacional</option>
                    <option value="D">Dolar</option>
                    <option value="E">Extranjera</option>                              
                </select>
            </div>
        </div>
        &nbsp;
        <div class="form-group col-md-4">
        <div class="input-group-prepend">        
            <span class="input-group-text" id="inputGroup-sizing-default">DivMult</span>

        <select class="form-control" id="divide_mult" name="divide_mult">
        <?php if($datos['divide_mult']=='D'){ ?>
                        <option value="D"><?php echo 'Divide'; ?></option>
                   <?php } ?>
                   <?php if($datos['divide_mult']=='M'){ ?>
                        <option value="M"><?php echo 'Multiplica'; ?></option>
                   <?php } ?>
                    <option value="D">Divide</option>
                    <option value="M">Multiplica</option>
                    value="<?php echo $datos['divide_mult']; ?>"
                </select>            </div>
        </div>
    </div>      
<!-- Tercera Fila de Datos -->
<div class="row">
    <div class="form-group col-md-3">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                id="inputGroup-sizing-default">Activo</span>
                <input type="input"  
                    id="activo"
                    name="activo" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    value="1"
                    disabled >
            </div>
        </div>
        &nbsp;
        <div class="form-group col-md-4">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">T.C.Compra</span>
                    <input type="input"  
                        id="tc_compra"
                        name="tc_compra" 
                        class="form-control" 
                        aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default"
                        value="<?php echo $datos['tc_compra']; ?>"
                        autofocus required>
                </div>
            </div>
        
            <div class="form-group col-md-4">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                id="inputGroup-sizing-default">T.C.Venta</span>
                <input type="input"  
                    id="tc_venta"
                    name="tc_venta" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    value="<?php echo $datos['tc_venta']; ?>"
                    required>
            </div>
        </div>
        &nbsp;        
    </div>      
<br><br><br><br>
<br><br><br><br>
<br><br><br><br>
<!-- Acciones de botones -->
<fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/monedas" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>
<!-- <script src="<?php echo base_url(); ?>/js/formulario.js"></script> -->

