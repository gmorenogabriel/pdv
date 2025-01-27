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


    <form enctype="multipart/form-data" action="<?php echo base_url(); ?>EnvioEMail/enviaremail" method="post" autocomplete="off">

    <div class="row col-md-12">
        <div class="form-group col-md-6">
            <div class="input-group-prepend">
                <span class="input-group-text" 
                        style="color:#f8f9fa; background-color: #0676e7;"
                        id="inputGroup-sizing-default">
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp; Para:</span>
                <input type="email"  
                    id="para"
                    name="para" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    placeholder="Ingrese E-Mail destinatario"
                    autofocus required>
            </div>
        </div> 
    </div> 
        <div class="row col-md-12">
            <div class="form-group col-md-6">
                <div class="input-group-prepend">
                <span class="input-group-text" 
                style="color:#f8f9fa; background-color: #0676e7;"
                id="inputGroup-sizing-default">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Asunto:</span>
                <input type="input"  
                    id="asunto"
                    name="asunto" 
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    required>
            </div>
        </div>
    </div>
        &nbsp;
        <div class="form-group">
              <div class="row">
              <div class="col-12 col-sm-6">
              <div class="input-group-prepend">
                <span class="input-group-text" 
                style="color:#f8f9fa; background-color: #0676e7;"
                id="inputGroup-sizing-default">
                <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Mensaje:</span>
                    <textarea  rows="8" cols="100" style="align-content:left;" 
                        class="form-control" 
                          id="mensaje" 
                        name="mensaje" 
                       required>
                    </textarea>                    
                </div>                

        &nbsp;
        &nbsp;        
        </div>
        <div class="row col-md-12">
            <div class="form-group col-md-6">
                <div class="input-group-prepend">
                <span class="input-group-text" 
                style="color:#f8f9fa; background-color: #0676e7;"
                id="inputGroup-sizing-default">
                <i class="fa fa-location-arrow" aria-hidden="true"></i>&nbsp; Adjuntar:</span>
                <input type="file"  
                    id="adjunto"
                    name="adjunto" 
                    accept=".doc,.docx,.xls,.xlsx,.pdf,.png,.jpg,.jpeg,.svg"
                    class="form-control" 
                    aria-label="Sizing example input" 
                    aria-describedby="inputGroup-sizing-default"
                    >
            </div>
        </div>


      <div class="form-group mt-3">
        <input type="file" name='images[]' id="fileupload" multiple="" class="form-control"
        accept=".doc,.docx,.xls,.xlsx,.pdf,.png,.jpg,.jpeg,.svg">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-danger">Upload</button>
      </div>

    <!-- <div id="dvPreview"> -->
    <div class="gallery"></div>

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
