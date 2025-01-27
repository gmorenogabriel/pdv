
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

        <form enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/actualizar" method="post"   autocomplete="off">
            <input type="hidden" id="id" name="id" value="<?php echo $producto['id'] ?>" />

        <div class="row col-md-12">
            <div class="form-group col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" 
                    style="color:#f8f9fa; background-color: #0676e7;"
                    id="inputGroup-sizing-default">
                    <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Código</span>
                    <input type="input"  
                        id="codigo"
                        name="codigo" 
                        class="form-control" 
                        aria-label="Sizing example input" 
                        aria-describedby="inputGroup-sizing-default"
                        value="<?php echo $producto['codigo']; ?>" 
                        required/>

                </div>
            </div>

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
                            value="<?php echo $producto['nombre']; ?>" 
                            autofocus required/>
                    </div>
                </div> 
        </div>
<!-- -- -- -- -- -- -- -- -- -- -->

    <div class="row col-md-12">
        <div class="form-group col-md-6">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                style="color:#f8f9fa; background-color: #0676e7;"
                id="inputGroup-sizing-default">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Unidad</span>
                    <select class="form-control" id="id_unidad" name="id_unidad" required>
                        <option value="">Seleccionar unidad</option>
                        <?php foreach($unidades as $unidad) { ?>
                            <option value="<?php echo $unidad['id']; ?>"                                    
                                <?php if($unidad['id'] == $producto['id_unidad']){ 
                                echo 'selected';  }?>><?php echo $unidad['nombre']; ?></option>
                            <?php } ?>
                    </select>
            </div>
        </div>
            <div class="form-group col-md-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Categoría</span>
                            <select class="form-control" id="id_categoria" name="id_categoria" required>
                                <option value="">Seleccionar categoria</option>
                                <?php foreach($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id']; ?>"                                    
                                        <?php if($categoria['id'] == $producto['id_categoria']){ 
                                        echo 'selected'; }?>><?php echo $categoria['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                </div>
            </div>    
        </div>                                            
<!-- -- -- -- -- -- -- -- -- -- -->
            <div class="row col-md-12">
                <div class="form-group col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        &nbsp; $ Compra</span>
                        <input type="input"  
                            id="precio_compra"
                            name="precio_compra" 
                            class="form-control" 
                            aria-label="Sizing example input" 
                            aria-describedby="inputGroup-sizing-default"
                            value="<?php echo $producto['precio_compra']; ?>" 
                            required/>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        &nbsp; $ Venta</span>
                        <input type="input"  
                            id="precio_venta"
                            name="precio_venta" 
                            class="form-control" 
                            aria-label="Sizing example input" 
                            aria-describedby="inputGroup-sizing-default"
                            value="<?php echo $producto['precio_venta']; ?>" 
                            required/>
                            </div>
                        </div>
                    </div>                                           
<!-- -- -- -- -- -- -- -- -- -- -->
            <div class="row col-md-12">
                <div class="form-group col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Stock Min</span>
                        <input type="input"  
                            id="stock_minimo"
                            name="stock_minimo" 
                            class="form-control" 
                            aria-label="Sizing example input" 
                            aria-describedby="inputGroup-sizing-default"
                            value="<?php echo $producto['stock_minimo']; ?>" 
                            required/>
                    </div>
                </div>                             
                <div class="form-group col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Es Inventariable</span>
                            <select class="form-control" id="inventariable" name="inventariable" required>
                                <option value="1" <?php if($producto['inventariable'] == 1) { 
                                    echo 'selected'; }?>>Si</option>
                                <option value="0" <?php if($producto['inventariable'] == 0) {
                                    echo 'selected'; }?>>No</option>
                            </select>
                    </div>
                </div>
            </div>
<!-- -- -- -- -- -- -- -- -- -- -->
            <div class="row col-md-12">
                <div class="form-group col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        <i class="fa fa-barcode" aria-hidden="true"></i>&nbsp; Código de Barras</span>
                        <select class="form-control" id="id_barcod" name="id_barcod" required>
                        <option value="">Seleccionar Código de Barras</option>
                                <?php foreach($codigosbarras as $codigobarra) { ?>
                                    <option value="<?php echo $codigobarra['id']; ?>"                                    
                                        <?php if($codigobarra['id'] == $producto['id_barcod']){ 
                                        echo 'selected'; }?>><?php echo $codigobarra['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                    </div>
                </div> 
                        
                <div class="form-group col-md-5">
                    <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;" 
                           id="inputGroup-sizing-default">                         
                        <i class="fa fa-barcode" aria-hidden="true"></i>&nbsp; Cód.Barras</span>
                    <div class="box-boy" id="imgcodbarra" name="imgcodbarra">
                    <?php if(isset($imgBC)){ ?>
                <!--        <div class="alert alert-danger"> -->
                            <?php echo $imgBC; ?>
                <!--        </div>                               -->
                    <?php } ?>        
                </div> 
            </div>       
        </div>  
    
<br>
<div class="row form-group border p-1 col-md-12">
<?php if($img_producto){ ?>
        <fieldset class="form-group border p-1 col-md-6">
            <legend class="col-md-3 col-form-label pt-0" align="center">Imágen Actual</legend>
                <?php 
                $ord = 1;
                foreach($img_producto as $pic){ ?>
                    <div id="preview">
                        <img id="preview">
                        <img width="70" height="60" class="img-thumbnail" 
                        src="<?php echo base_url() . '/images/productos/'.$producto['id'].'/foto_1.jpg'; ?>" width="50" />
                        <input type="file" name="img_producto" id="img_producto" 
                        style="color: transparent"
                        value="<?= $pic; ?>"

                         accept="image/*"/> 
                    </div> 
                <?php } ?>
        </fieldset>
    
        <fieldset class="form-group border p-1 col-md-6">
            <legend class="col-md-3 col-form-label pt-0" align="center">Imágen Nueva</legend>
                <div id="preview2">
                        <img id="preview2">
                        <img width="70" height="60" class="img-thumbnail" 
                         accept="image/*"/> 
                    </div> 
                </div> 
        </fieldset>

<?php } ?>


<br>
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
</main>