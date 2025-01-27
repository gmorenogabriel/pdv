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

        <form  enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/insertar" method="post" autocomplete="off">

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
                        autofocus required/>

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
                <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Unidad</span>
                    <select class="form-control" id="id_unidad" name="id_unidad" required>
                        <option value="">Seleccionar unidad</option>
                        <?php foreach($unidades as $unidad) { ?>
                            <option value="<?php echo $unidad['id']; ?>"><?php echo $unidad['nombre']; ?></option>
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
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
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
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                    </div>
                </div>
<!-- -- -- -- -- -- -- -- -- -- -->
            <div class="col-12 col-sm-6">
                <div class="input-group-prepend">
                        <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        <i class="fa fa-barcode" aria-hidden="true"></i>&nbsp; Código de Barras</span>
                        <select class="form-control" id="new_id_barcod" name="new_id_barcod" required>
                        <option value="">Seleccionar Código de Barras</option>
                                <?php foreach($codigosbarras as $codigobarra) { ?>
                                    <option value="<?php echo $codigobarra['id']; ?>"><?php echo $codigobarra['nombre']; ?></option>
                                    <?php } ?>
                          </select>
                    </div>
                </div> 
            </div>  
    &nbsp;                                              
    <!-- -- -- -- -- -- -- -- -- -- -->            
    <div class="input-group input-group-sm mb-6 col border border-danger">
        <fieldset class="form-group border p-1 col-md-6" align="center">
        <legend class="col-md-4 col-form-label pt-0">Código de Barra</legend>                 
            <div class="row justify-content-center"> 
                <div class="col clearfix col-md-12"> 
                    <div class="box-boy" id="imgcodbarra" name="imgcodbarra">
                    <?php if(isset($imgBC)){ ?>
                        <div class="alert alert-danger">
                            <?php echo $imgBC; ?>
                        </div>
                    <?php } ?>        
                </div> 
            </div>
        </fieldset>    
        <!-- <fieldset class="form-group border p-1 col-md-6">
        <legend class="col-md-4 col-form-label pt-0" align="center">Código QR</legend>                 
            <div class="row justify-content-center"> 
                <div class="col clearfix col-md-6"> 
                    <div class="box-body" id="imgcodQR" name="imgcodQR">
                    <?php if(isset($imgQR)){ ?>
                        <div class="alert alert-danger center">
                            <?php echo $imgQR; ?>
                        </div>
                    <?php } ?>
                    </div> 
                 </div>
            </fieldset> -->


    <fieldset class="form-group border p-1 col-md-6" align="center">
        <legend class="col-md-4 col-form-label pt-0">Imágen</legend>                 
            <div class="row justify-content-center"> 
                <div class="col clearfix col-md-12"> 
                 <img id="preview" src="#" />
                <input type="file" id="img_producto" name="img_producto[]" 
                   accept="image/jpg" multiple />
                   <p class="text-danger">Cargar imagen .png máximo 150x150 px</p>
              </div>
            </div>
        </fieldset>   
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
