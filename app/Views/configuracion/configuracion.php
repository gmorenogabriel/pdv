<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan">
        <!-- Imprime los errores de las validaciones del Formulario  -->
        <?php if(isset($validation)){ ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>/configuracion/actualizar"  autocomplete="off">
        <!-- para que devuelva la fila del error de validacion -->

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>Nombre de la Tienda</label>
                    <input class="form-control" 
                        id="Tienda_Nombre" name="Tienda_Nombre" 
                        type="text" 
                        value="<?php echo $nombre['valor']; ?>" 
                        autofocus required/>
                </div>

                <div class="col-12 col-sm-6">
                    <label>RUC</label>
                    <input class="form-control" 
                          id="Tienda_Ruc" name="Tienda_Ruc" 
                        type="text"                       
                      value="<?php echo $ruc['valor']; ?>" 
                        required>
                </div>
            </div>
        </div>      
<!--                                       -->
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>Teléfono</label>
                    <input class="form-control" 
                          id="Tienda_Telefono" 
                        name="Tienda_Telefono" 
                        type="text" 
                        value="<?php echo $telefono['valor']; ?>"
                    required/>
                </div>

                <div class="col-12 col-sm-6">
                    <label>E-Mail</label>
                    <input class="form-control" 
                        id="Tienda_Email" name="Tienda_Email" 
                        type="text" 
                        value="<?php echo $email['valor']; ?>"                               
                        required>
                </div>
            </div>
        </div>      

<!--                                       -->
<div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>IVA Tasa Mínima</label>
                    <input class="form-control" 
                          id="Tienda_TasaMinima" 
                        name="Tienda_TasaMinima" 
                        type="text" 
                        value="<?php echo $tasaminima['valor']; ?>"
                    required/>
                </div>

                <div class="col-12 col-sm-6">
                    <label>IVA Tasa Básica</label>
                    <input class="form-control" 
                        id="Tienda_TasaBasica" name="Tienda_TasaBasica" 
                        type="text" 
                        value="<?php echo $tasabasica['valor']; ?>"                               
                        required>
                </div>
            </div>
        </div>      
<!--                                    -->
            <div class="form-group">
              <div class="row">
              <div class="col-12 col-sm-6">
                    <label>Dirección Comercial</label>
                    <textarea style="align-content:left;" 
                        class="form-control" 
                          id="Tienda_Direccion" 
                        name="Tienda_Direccion" 
                       required>
                       <?php echo $direccion['valor']; ?>
                    </textarea>                    
                </div>                

                <div class="col-12 col-sm-6">
                    <label>Leyenda Ticket</label>
                    <textarea class="form-control" style="align-content:left;" 
                        id="Tienda_Leyenda" name="Tienda_Leyenda" 
                        type="text" 
                        required>
                        <?php echo $leyenda['valor']; ?>
                        </textarea>    
                </div>
            </div>
        </div>   
        <div class="form-group">
          <div class="row">
              <div class="col-12 col-sm-6">
                <label>Logotipo</label>
                &nbsp;&nbsp; <img src="<?php echo base_url() . '/images/logotipo.png'; ?>"
                 class="img-responsive" width="100">
                <input type="file" id="Tienda_Logo" name="Tienda_Logo"
                   accept="image/png" />
                   <p class="text-danger">Cargar imagen .png máximo 150x150 px</p>
              </div>
          </div>     
        </div>   

        <!-- Acciones de botones -->
        <fieldset class="form-group border p-1 col-md-12">
                    <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>
                        <div class="row"> 
                            <div class="col clearfix col-md-12"> 
                                <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                                <span class="float-right"><a href="<?php echo base_url(); ?>/configuracion" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                            </div>    
                        </div>     
                <fieldset>
            </form>
        </div>
        </main>


<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>
                            -->
<!-- Modal -->
<div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog dialog-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Confirma eliminar este registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">NO</button>
        <a class="btn btn-danger btn-ok">Sí</a>
      </div>
    </div>
  </div>
</div>
