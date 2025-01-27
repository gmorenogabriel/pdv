<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2">
        <?php echo $titulo; ?></h1>
        <hr color="cyan"></hr>
        <form action="<?php echo base_url(); ?>/categorias/insertar" method="post" autocomplete="off">
    
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label>Nombre</label>
                    <input class="form-control" 
                        id="nombre" name="nombre" 
                        type="text" autofocus required/>
                </div>
            </div>
        </div>      
        <br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

        <fieldset class="form-group border p-1 col-md-7">
            <legend class="col-md-3 col-form-label pt-0" align="center">Acciones</legend>                <div class="row"> 
                <div class="col clearfix col-md-12"> 
                    <span class="float-left"><button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Guardar</button></span>
                    <span class="float-right"><a href="<?php echo base_url(); ?>/categorias" class="btn btn-primary"><i class="fa fa-undo" aria-hidden="true"></i> Regresar</a>
                </div>         
        <fieldset>
    </form>
</div>
</main>