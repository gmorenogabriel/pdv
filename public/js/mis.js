const formulario = document.getElementById('pdvFormInput');
const inputs = document.querySelectorAll('#pdvFormInput input');

const expresion = {
    usuario: /^[a-zA-Z0-9\_\-]{4,16}$/,    // Letras, números, guión y guión_bajo
    nombre: /^[a-zA-ZÀ-Ӱ\s]{1,40}$/,       // Letras y espacios, pueden llevar acentos.
    password: /^.{4,12}$/,                 // 4 a 12 dígitos.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_.+-]+\.[a-zA-Z0-9-.]+$/, 
   telefono: /^\d{7,14}$/                  // 7 a 14 dígitos.
}

// formulario.addEventListener('submit', (e) => {
//    e.preventDefault();
//    alert('input data') ;
// });
