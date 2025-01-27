$(document).ready(function(){
    $("#redondo").show();
    $("#btnSubmit").click(function(){
        // Super-fast:
        $("#redondo").hide();
        // Deshabilitamosspinner el boton
        $(this).prop("disabled", true); 
        
        // añadimos el spinner
        $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
        
    });


//     $('form').submit(function(e){
//         e.preventDefault();
//         //$('.sr-only').css('loading','inline');
//         $('.sr-only').css('loading','inline');
//         // data contiene el formulario y serializamos username, password
//         var data= $(this).serializeArray();
//         // Agregamos al Arreglo un item "tag" y valor "login"
//         data.push({name: 'tag', value: 'login'});
//         $.ajax({
//             url: 'php/process.php',
//             type: 'POST',
//             dataType: 'JSON',
//             data: data,
//             beforeSend: function(){
//                 $('#one').addClass('<span class="spinner-border spinner-border-sm mr-4"></span>');
// //                $('#one').addClass('<img src="gif/spinner_16x16.gif">');         
// //                $('#one').css( "background-color", "orange");
// //                jQuery('#one').show();
//                 jQuery('#one').prepend('<img id="theImg" src="gif/spinner_16x16.gif" />');
//                 jQuery('#one').trigger('refresh'); 
//                 //$('#one').button("refresh");
//             }
//         })
//         .done(function(){ //true
//             //console.log("success");
//             $("#dos > .accesodos").text("Acceso habilitado!!!");
//             alert('H A B I L I T A D O');

//         })
//         .fail(function(){ //false
//             //console.log("error");
//             alert('D E N E G A D O');
//             setTimeout(function(){
//                 $("#dos > .accesodos").text("Acceso denegado!!!");
//             }, 100);
          
//             // alert('.fail apago spinner');            
//             //alert('se fue');
//         })
//         .always(function(){ //Siempre se va a ejecutar
//             //console.log("complete");
//             setTimeout(function(){
//                 $('#one').addClass('#spinner').show();
//             }, 1000);
//             $('#spinner').hide();
//             var image = jQuery('#one').children("img").remove();
//         });
//     });     
});