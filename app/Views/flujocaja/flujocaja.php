<div id="layoutSidenav_content">
    <main>
        <div class="wrapper">
            <div class="container">
                <h1 class="mt-2"><?php echo $titulo . " - ". $fecha ?></h1>
                <hr color="cyan"></hr>
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="<?php echo base_url(); ?>flujocaja/entradas" class="btn btn-primary"> Ingresos</a>
                        <a href="<?php echo base_url(); ?>flujocaja/salidas" class="btn btn-danger"> Egresos</a>
                    </div>
                    <div>
						<button id="btnGeneraExcelFlujo" type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-file-excel"></i> Excel</a></button>			
						<button id="btnGeneraPdfFlujo"   type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-file-pdf"></i> Pdf</a></button>
<!-- si hay algun problema con javascript PARA determinar que sucede, 
	se pueden habilitar estas 2 lineas para poder debugear 					
                        <a href="< ? php echo base_url('flujocaja/generaExcel'); ?>" class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</a>
                        <a href="< ? php echo base_url('flujocaja/generaPdf'); ?>" class="btn btn-success"><i class="fas fa-file-pdf"></i> Pdf</a>
	-->				
                    </div>
                </div>  
                <div class="table-responsive mt-3">
                    <input type="hidden" id="tituloreporte" value="Reporte Flujo de Caja.">  
                    <input type="hidden" id="columnasreporte" value="[0, 1, 2, 3, 4, 5]">        
                    <table id="miTabla" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th style="text-align:right;">Entrada</th>
                                <th style="text-align:right;">Salida</th>
                                <th style="text-align:right;">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($datos as $dato){ ?>
                            <tr>
                                <td><?php echo $dato['id']; ?></td>
                                <td><?php echo $dato['fecha']; ?></td>
                                <td><?php echo $dato['descripcion']; ?></td>
                                <td align="right"><?php echo number_format((float)$dato['entrada'], 2, ",", "."); ?></td>
                                <td align="right"><?php echo number_format((float)$dato['salida'], 2, ",", "."); ?></td>
                                <td align="right"><?php echo number_format((float)$dato['saldo'], 2, ",", "."); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
