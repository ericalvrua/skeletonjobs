function mostrar() {
    let mostrarCrearCarpeta = document.getElementById("otros");

    if (mostrarCrearCarpeta.style.display == 'none' || mostrarCrearCarpeta.style.display == '') {
        mostrarCrearCarpeta.style.display = 'block';
    } else {
        mostrarCrearCarpeta.style.display = 'none';
    }
}