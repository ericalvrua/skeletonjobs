function manejador(evento){

    var miForm = document.forms['formulario'];
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);


    var error = false;
    var errorMsj = "";

    
    if (checkedOne == false) {
        error = true;
        errorMsj += "Error: Seleccione una isla"
    }

    if(error == false){
        evento.submit;
    } else {
        alert(errorMsj);
        evento.preventDefault();
    }
}