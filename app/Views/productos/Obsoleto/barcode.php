<div i<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
        <!-- Imprime los errores de las validaciones del Formulario  -->

        <div class="input-group input-group-sm mb-6 col border border-danger">
    <fieldset class="form-group border p-1 col-md-6">
    <legend class="col-md-4 col-form-label pt-0">Código de Barra</legend>                 
        <div class="row"> 
            <div class="col clearfix col-md-12"> 
                <div class="box-boy" id="imgcodbarra" name="imgcodbarra">
                &nbsp;&nbsp;&nbsp; 
                <?php if(isset($imgBC)){ ?>
                    <div class="alert alert-danger">
                        <?php echo $imgBC; ?>
                    </div>
                <?php } ?>        
            </div> 
        </div>
    </fieldset>    

    <fieldset class="form-group border p-1 col-md-6">
    <legend class="col-md-4 col-form-label pt-0">Código QR</legend>                 
        <div class="row"> 
            <div class="col clearfix col-md-6"> 
                <div class="box-body" id="imgcodQR" name="imgcodQR">
                &nbsp;&nbsp;&nbsp; 

                <?php if(isset($imgQR)){ ?>
                    <div class="alert alert-danger">
                        <?php echo $imgQR; ?>
                    </div>
                <?php } ?>                        <br>

            </div> 
        </div>
    </fieldset>    
</div>
</main>