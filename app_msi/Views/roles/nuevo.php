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

        <form action="<?php echo base_url(); ?>/productos/insertar" method="post" autocomplete="off">

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>codigo</label>
                    <input class="form-control" 
                        id="codigo" name="codigo" 
                        type="text"
                        value="<?php echo set_value('codigo'); ?>"
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
                <!-- -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Unidad</label>
                            <select class="form-control" id="id_unidad" name="id_unidad" required>
                                <option value="">Seleccionar unidad</option>
                                <?php foreach($unidades as $unidad) { ?>
                                    <option value="<?php echo $unidad['id']; ?>"><?php echo $unidad['nombre']; ?></option>
                                    <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Categoria</label>
                            <select class="form-control" id="id_categoria" name="id_categoria" required>
                                <option value="">Seleccionar categoria</option>
                                <?php foreach($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>    
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                                <label>Precio Compra</label>
                                <input class="form-control" 
                                    id="precio_compra" name="precio_compra" 
                                    type="text"  
                                    value="<?php echo set_value('precio_compra'); ?>"                                        
                                    required/>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label>Precio Venta</label>
                                <input class="form-control" 
                                    id="precio_venta" name="precio_venta" 
                                    type="text" 
                                    value="<?php echo set_value('precio_venta'); ?>"
                                    required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">                            
                            <div class="col-12 col-sm-6">
                                <label>Stock Mínimo</label>
                                <input class="form-control" 
                                    id="stock_minimo" name="stock_minimo" 
                                    type="text" 
                                    value="<?php echo set_value('stock_minimo'); ?>"
                                    required/>
                            </div>
                    
                            <div class="col-12 col-sm-6">
                                <label>Es Inventariable</label>
                                <select class="form-control" id="inventariable" name="inventariable" required>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>                        
                            
                        <div class="col-12 col-sm-6">
                            <label for="id_barcod">Códigos de Barra</label>
                            <select class="form-control" id="id_barcod" name="id_barcod" required>
                            <option value="">Seleccionar Código de Barras</option>
                                <?php foreach($codigosbarras as $codigosbarra) { ?>
                                    <option value="<?php echo $codigosbarra['id']; ?>"><?php echo $codigosbarra['nombre']; ?></option>
                                    <?php } ?>
                                </select>

                        </div>
                    </div>                         
                </div>

            <fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/productos" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main
