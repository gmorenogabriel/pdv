<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
        <!-- Imprime los errores de las validaciones del Formulario  -->
            <?php if($img[0]){ ?>
            <fieldset class="form-group border p-1 col-md-12">
                <legend class="col-md-3 col-form-label pt-0" align="center">Imagenes asociadas</legend>            
                <div class="row">
                    &nbsp;&nbsp;&nbsp;
                    <?php 
                    foreach($img as $pic){ ?>
                        <div id="preview">
                            <img id="preview" width="70" height="60" class="img-thumbnail" 
                            src="<?= base_url() . '/images/productos/30/' . $pic; ?>" />
                            <input type="file" name="img_producto[]" id="img_producto" 
                            style="color: transparent"
                            value="<?= $pic; ?>"
                            accept="image/*" multiple /> 
                        </div> 
                    <?php } ?>
                </div> 
            </fieldset>
    <?php } ?>
    <br><br>
    <?php if($img[1]){ ?>
            <fieldset class="form-group border p-1 col-md-12">
                <legend class="col-md-3 col-form-label pt-0" align="center">Imagenes Ajustadas</legend>            
                <div class="row">
                    &nbsp;&nbsp;&nbsp;
                    <?php 
                    foreach($img as $pic){ ?>
                        <div id="preview">
                            <img id="preview" width="70" height="60" class="img-thumbnail" 
                            src="<?= base_url() . $salida . $pic; ?>" />
                            <input type="file" name="img_producto[]" id="img_producto" 
                            style="color: transparent"
                            value="<?= $pic; ?>"
                            accept="image/*" multiple /> 
                        </div> 
                    <?php } ?>
                </div> 
            </fieldset>
    <?php } ?>
<br>

<div id="uploaded_images"></div>

        <fieldset class="form-group border p-1 col-md-12">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/productos" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        </fieldset>
    </form>
</div>
</main>
<script>
$(document).ready(function(){(
    $('#img_producto').change(function(){
        var files = $('#img_producto')[0].files;
        var error = '';
        var form_data = new FormData();
        for(var count=0; count<files.length; count++ ){
            var name = files[count].name;
            var extension = name.split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1){
                error += "Invalid " + count + " Image File"
            }else{
                form_data.append("files[]", files[count]);

            }
        }
        if(error == ''){
            $.ajax({
                url:"<?php echo base_url(); ?>upload_multiple/upload",
                method:"post",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function(){
                    $('#uploaded_images').html("<label class='text-success'>Cargando...</label>");

                },
                success:function(data){
                    $('#uploaded_images').html(data);
                    $('#img_producto').val('');
                }


            })
        }else{
            alert(error);
        }
    )};
)};
</script>