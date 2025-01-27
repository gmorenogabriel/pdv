<?php
// Genera un IdUnico
$id_compra = uniqid();
?>
<div id="layoutSidenav_content">
<main>
    <div class="container-fluid">

        <form action="<?php echo base_url(); ?>/compras/guarda" method="post" id="form_compra" name="form_compra" autocomplete="off">
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <input type="hidden" id="id_producto" name="id_producto" />
                    <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $id_compra; ?>" />
                    <label>Código</label>
                    <input class="form-control" 
                        id="codigo" name="codigo" 
                        type="text" 
                        placeholfer="Escribe el código"
                        onkeyup ="buscarProducto(event, this, this.value)"
                        autofocus/>
                        <label for="codigo" id="resultado_error" style="color: red"> </label>
                </div>

                <div class="col-12 col-sm-4">
                    <label>Nombre del Producto</label>
                    <input class="form-control" 
                        id="nombre" name="nombre" 
                        type="text" 
                        disabled />
                </div>

                <div class="col-12 col-sm-4">
                    <label>Cantidad</label>
                    <input class="form-control"
                        id="cantidad" name="cantidad" 
                        type="text" class="monto"/>
                </div>                

            </div>
        </div>      

<!-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --> 
<div class="form-group">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <label>Precio de compra</label>
                    <input class="form-control" 
                        id="precio_compra" name="precio_compra" 
                        type="text" style="text-align: right" 
                        disabled/>
                </div>

                <div class="col-12 col-sm-4">
                    <label>Subtotal</label>
                    <input class="form-control" 
                        id="subtotal" name="subtotal"                         
                        type="text" style="text-align: right" 
                        disabled/>
                </div>

                <div class="col-12 col-sm-4">
                    <label><br>&nbsp;</label>
                    <button id="agregar_producto" name="agregar_producto" 
                        type="button" class="btn btn-primary" onclick="agregarProducto(id_producto.value, cantidad.value,'<?php echo $id_compra; ?>');">Agregar Producto</button>
                </div>                

            </div>
        </div>      

        <div class="row">
            <table id="tablaProductos" class="table table-hover table-striped table-sm table-responsive tablaProductos" width="100%">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th width="1%"></th>
                    </thead>
                    <tbody></tbody>
                </table> 
            </div>
            
            <div class="row">
                <div class="col-12 col-sm-6 offset-md-6">
                    <label style="font-weight: bold; font-size: 30px; text-align: center;">Total $</label>
                    <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;" />
                    <button type="button" id="completa_compra" class="btn btn-success">Completar compra</button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    $(document).ready(function(){
        $("#completa_compra").click(function(){
            var nFila = $("#tablaProductos tr").length;
            // esta solo el Cabezal, no hemos agregado filas
            if(nFila < 2 ){  
                // mensaje Modal

            }else{
                // va al controlador de Compra que se llama guardaç
                // id Del Formul.arriba al comienzo
                $("#form_compra").submit(); 
            }
        });
    });
    function buscarProducto(e, tagCodigo, codigo){
        var enterKey = 13;
        if(codigo !=''){
            if(e.which == enterKey){
                $.ajax({
                    url: '<?php echo base_url(); ?>/productos/buscarPorCodigo/' + codigo, 
                    dataType: 'json',
                    success: function(resultado){
                        if(resultado == 0){
                            $(tagCodigo).val('');
                        }else{
                            $("#resultado_error").html(resultado.error);
                            if(resultado.existe){
                                $("#id_producto").val(resultado.datos.id);
                                $("#nombre").val(resultado.datos.nombre);
                                $("#cantidad").val(1);
                                $("#precio_compra").val(resultado.datos.precio_compra);
                                $("#subtotal").val((resultado.datos.precio_compra)*$("#cantidad").val());
                                $("#cantidad").focus();
                            }else{
                                $("#id_producto").val('');
                                $("#nombre").val('');
                                $("#cantidad").val(1);
                                $("#precio_compra").val('');
                                $("#subtotal").val('');
                            }
                        }
                    }
                });
            }
        }
    }
    function agregarProducto(id_producto, cantidad, id_compra){        
        if(id_producto != null && id_producto !=0 && cantidad >0){
            $.ajax({
                url: '<?php echo base_url(); ?>/TemporalCompra/insertar/' + id_producto + "/" + cantidad + "/" + id_compra,
                success: function(resultado){
                    if(resultado == 0){
                        
                    }else{
                        var resultado = JSON.parse(resultado);
                        if(resultado.error == ''){
                            $("#tablaProductos tbody").empty(); // limpia la tabla
                            $("#tablaProductos tbody").append(resultado.datos);
                            $("#total").val(resultado.total);
                            $("#codigo").val('');
                            $("#id_producto").val('');
                            $("#nombre").val('');
                            $("#cantidad").val('');
                            $("#precio_compra").val('');
                            $("#subtotal").val('');
                            $("#codigo").focus();

                        }                            
                    }
                }
            });
        }
    }
    function eliminaProducto(id_producto, id_compra){
        $.ajax({
            url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto + "/" + id_compra,
            success: function(resultado){
                if(resultado == 0){
                    $(tagCodigo).val('');
                }else{
                    var resultado = JSON.parse(resultado);
                    $("#tablaProductos tbody").empty(); // limpia la tabla
                    $("#tablaProductos tbody").append(resultado.datos);
                    $("#total").val(resultado.total);
                }
            }
        });
    }
    function multi(){   
    var cant            = $("#cantidad").val();
    var precio_cantidad = 0;
    var change= false; 
    //$(".monto").each(function(){
    //if (!isNaN(parseFloat($(cant).val()))) {
        change= true;
        precio_cantidad = $("#precio_compra").val();
        total = cant * precio_cantidad;
     //   }
    //});
    // Si se modifico el valor , retornamos la multiplicación
    // caso contrario 0
    total = (change) ? total : 0;
    $("#subtotal").val(cant*precio_cantidad);
    //$("#total").val(total.toFixed(2));
   // $("input[name=total]").val(total.toFixed(2));
    //document.getElementById('subtotal').innerHTML = total;
    }
</script>