function validarRegistro() {

    var re = /\S+@\S+\.\S+/;
    $res = re.test(document.forms["formRegistro"]["email"].value);
    if ($res == false) {
        alert("Email no valido");
        return false;
    } else if (document.forms["formRegistro"]["email"].length > 30) {
        alert("Email muy largo");
        return false;
    }
    /* test : busca en un string los caracteres que se le indican
    string re: es un formato, para testear que el email tenga la forma cualquierCosa@cualquierCosa.cualquierCosa
    */

    var username = document.forms["formRegistro"]["user"].value;
    if (username.length <= 2) {
        alert("Usuario debe tener al menos 3 caracteres");
        return false;
    } else if (username.length > 30) {
        alert("Usuario muy largo");
        return false;
    }

    var pass = document.forms["formRegistro"]["password"].value;
    if (pass.length <= 4) {
        alert("Contraseña debe tener al menos 5 caracteres");
        return false;
    } else if (pass.length > 30) {
        alert("Contraseña muy larga");
        return false;
    }
}

function validarComentario() {
    var comentario = document.forms["formComentario"]["texto"].value;
    if (comentario.length > 255) {
        alert("El comentario no puede tener mas de 255 caracteres");
        return false;
    }
}

function contarCaracteres(mostrarEn) {
    var contarDesde = "texto";
    var len = document.getElementById(contarDesde).value.length;
    if (len > 255) {
        document.getElementById(mostrarEn).style.color = "red";
    } else {
        document.getElementById(mostrarEn).style.color = "black";
    }
    document.getElementById(mostrarEn).innerHTML = len;
}

function validarPost() {
    var len = document.getElementById("titulo").value.length;
    if (len <= 4) {
        alert("Titulo demasiado corto");
        return false;
    }
}

function validarTituloPost() {
    var pass = document.forms["miPost"]["titulo"].value;
    if (pass.length > 50) {
        alert("Máximo 50 caracteres en el título");
        return false;
    }
}

