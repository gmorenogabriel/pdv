<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">
        <h1 class="mt-2"><?php echo $titulo; ?></h1>
        <hr color="cyan">
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/compras/eliminados" class="btn btn-warning">Eliminados</a>
                </p>

            </div>

                <div class="table-responsive">
                  <!--  <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    tabla id=tblEstandard no muestra los botones de Excel y Pdf
                    <table id="tblEstandard" class="table table-bordered btn-hover"> -->
                    <table id="reportes" class="table table-bordered btn-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Folio</th>
                                <th style="text-align:right;">Total</th>
                                <th>Fecha</th>
                                <th width="10%" style="text-align:center;">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($compras as $compra){ ?>
                            <tr>
                                <td>&nbsp;&nbsp;<?php echo $compra['id']; ?></td>
                                <td>&nbsp;&nbsp;<?php echo $compra['folio']; ?></td>
                                <td align=right>
                                  <?php echo number_format((float)$compra['total'], 2, ",", "."); ?>&nbsp;
                                </td>
                                <td>&nbsp;&nbsp;<?php echo $compra['fecha_alta']; ?></td>
                                <td align=center><a href="<?php echo base_url() . '/compras/muestraCompraPdf/' . $compra['id']; ?>;" class="btn btn-success">
                                <i class="fas fa-file-pdf"></i></a></td>

                            </tr>

                            <?php } ?>
                    </tbody>
                    </table>
                </div>

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
<script>

    /* --------------------------------------- */
    /* Tabla general para todas las List Views */
    /* --------------------------------------- */	
    $(document).ready(function(){
      $('#example').DataTable( {
              dom: 'Bfrtip',
              buttons: [
                  {
                      extend: 'excelHtml5',
                      title: $('#tituloreporte').val(),
                      text: '<i class="fa fa-file-excel-o"></i> Excel',
                      exportOptions: {
                          columns: $('#columnasreporte').text(),
                      }
                  }, {
                      extend: 'pdfHtml5',
                      title: $('#tituloreporte').val(),
                      text: '<i class="fa fa-file-pdf-o"></i> Pdf',
                      exportOptions: {
                          columns: $('#columnasreporte').text(),
                      }                    
                  }
              ],
                      language: {
                  "lengthMenu": "Mostrar _MENU_ registros por página",
                  "zeroRecords": "No se encontraron resultados en su busqueda",
                  "searchPlaceholder": "Buscar registros",
                  "info": "Mostrando registros de _START_ al _END_ de un total de  _TOTAL_ registros",
                  "infoEmpty": "No existen registros",
                  "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                  "search": "Buscar:",
                  "paginate": {
                      "first": "Primero",
                      "last": "Último",
                      "next": "Siguiente",
                      "previous": "Anterior"
                  },   }
          });
        });
</script>