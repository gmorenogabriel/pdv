//$(document).off('.data-api'); // Deshabilitar Bootstrap
const formulario = document.getElementsByName('pdvFormInput');
const ingresos = document.querySelectorAll('#pdvFormInput input');

const expresion = {
    usuario: /^[a-zA-Z0-9\_\-]{4,16}$/,    // Letras, números, guión y guión_bajo
    nombre: /^[a-zA-ZÀ-Ӱ\s]{1,40}$/,       // Letras y espacios, pueden llevar acentos.
    password: /^.{4,12}$/,                 // 4 a 12 dígitos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_.+-]+\.[a-zA-Z0-9-.]+$/, 
   telefono: /^\d{7,14}$/                  // 7 a 14 dígitos.
};
const validarFormulario = (e) => {
    console.log(e.target.name);
    //input.addEventListener('keyup', validarFormulario);    
};
// const cambioColorFondo = () => {
//     input.style.backgroundColor = ;
//     //input.style.backgroundColor = "lightgray";
//     //console.log('Cambio color fondo');
// }
// const cambioBlancoFondo = () => {
//    input.style.backgroundColor = "white";
//    //console.log('Cambio blanco fondo');
// }
// por Consola verificamos el Input
// ingresos.forEach((input) => { 
//     input.addEventListener('keyup', () => {  console.log('tecla levantada');   });
//  });
function manejo(evt) {
    if (evt.type == "click")
        console.log('manejo click: ' + evt.type);
        evt.target.style.backgroundColor = "gray";
    elseif (evt.type == "keyup" )
        console.log('manejo keyup: ' + evt.type);
        evt.target.style.backgroundColor = "gray";
    elseif (evt.type == "blur") 
        console.log('manejo blur: ' + evt.type);
        evt.target.style.backgroundColor = "white";

}
   // input.style.backgroundColor = "white";

ingresos.forEach((input) => {
     input.addEventListener('keyup', manejo);
     input.addEventListener('blur', manejo);
     input.addEventListener('click', manejo);
     
});

formulario.addEventListener('submit', (e) => {
    e.preventDefault();
});

    // input.addEventListener('keyup', cambioColorFondo);
    // input.addEventListener('blur', cambioBlancoFondo);
    // input.addEventListener('keyup', )
    //console.log('levanto el dedo de la tecla');
   
// });
