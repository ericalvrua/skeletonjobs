function manejador(evento){

    var miForm = document.forms['formulario'];
    var correo = document.getElementById('correo').value;
    var correo2 = document.getElementById('correo2').value;
    var pass1 = document.getElementById('pass').value;
    var pass2 = document.getElementById('pass2').value;
    var error = false;
    var errorMsj = "";

    if (correo != correo2) {
        error = true;
        errorMsj += "Error: correos distintos "
    }

    if (pass1 != pass2) {
        error = true;
        errorMsj += "Error: contraseñas distintas"
    }

    if(error == false){
        evento.submit;
    } else {
        evento.preventDefault();
        alert(errorMsj);
    }
}