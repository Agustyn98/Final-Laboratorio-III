<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
    <link rel="icon" href="imagenes/foroLogo.JPG">
    <link rel="stylesheet" href="estilos.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Post</title>
</head>

<body>
    <?php include 'header.html' ?>

    <?php
        
        if(isset($_SESSION["usuario"])){
            if($_SESSION["ban"] == 0){
            ?>

    <?php
    ?>

    <?php

        if(isset($_POST["boton"])){
            include "conexion.php";
            $c = new conexion();
            $titulo = $_POST["titulo"];
            $texto = $_POST["texto"];
            $isValidImage = 0;
            if(is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                $maxSize = 16000000; // 16 MBytes
                if($_FILES['imagen']['size'] < $maxSize){
                    $allowed = array('gif', 'png', 'jpg','PNG','JPG');
                    $filename = $_FILES['imagen']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(in_array($ext, $allowed)){
                        $imagenBinario = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
                        $isValidImage = 1;
                    }
                }
            }

            if($isValidImage == 1 && !empty($titulo)){
                if(empty($texto)){
                    $seSubio = $c->subirPost($titulo,$imagenBinario,$_SESSION["usuario"]);
                    if($seSubio == 0){
                        echo " <script>
                            alert('Su post fue enviado con exito');
                            window.location = 'paginas.php';
                        </script>";
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                        Error al subir el post a la base de datos.
                        </div>";
                    }
                }else{
                    $seSubio = $c->subirPostConTexto($titulo,$texto,$imagenBinario,$_SESSION["usuario"]);
                    if($seSubio == 0){

                        echo " <script>
                            alert('Su post fue enviado con exito');
                            window.location = 'paginas.php';
                        </script>";
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                        Error al subir el post a la base de datos.
                        </div>";
                    }
                }
            }else if($isValidImage == 0){
                ?>
    <div class="alert alert-danger" role="alert">
        Error al subir la imagen.
    </div>
    <?php
            }else{
                ?>
    <div class="alert alert-danger" role="alert">
        Ha ocurrido un error
    </div>
    <?php
            }
        }
    ?>




    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-5 text-center font-weight-bold"><img
                    src="https://img.icons8.com/color/50/000000/rich-text-converter.png" />Nuevo Post</h1>
        </div>
    </div>
    <div class="container">
        <form action="crearPost.php" method="POST" name="miPost" enctype="multipart/form-data"
            onsubmit="return validarTituloPost();">
            <div class="form-group">
                <label for="titulo">
                    <h4>Título </h4>
                </label>
                <div class="row">
                    <div class="col-md-9">
                        <input type="text" class="form-control form-control-lg my-2" name="titulo" id="titulo"
                            style="max-width: 48rem;" onkeyup="contarCaracteres('nroCaracteres');"
                            onkeydown="contarCaracteres('nroCaracteres');"
                            onmouseout="contarCaracteres('nroCaracteres');" required>
                        <small id="nroCaracteres"></small>
                    </div>
                    <div class="col-md-3">
                        <button name="boton" type="submit" class="btn btn-primary my-2 p-1 font-weight-bold"
                            style="padding: 0.62rem; width: 15rem;">Post
                            <img style="max-width: 15%; max-height: 15%;"
                                src="https://img.icons8.com/plasticine/100/000000/long-arrow-right.png" /></button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">
                    <h4>Texto (opcional) </h4>
                </label>
                <textarea class="form-control form-control-lg" name="texto" id="exampleFormControlTextarea1"
                    rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">
                    <h4>Imagen</h4>
                </label>
                <input type="file" class="form-control-file" name="imagen" id="imagen" required>
            </div>

        </form>
    </div>
    <?php }else{
        ?>
    <div class="alert alert-danger text-center" role="alert">
        Tu cuenta ha sido bloqueada.
    </div>
    <?php
    }
    
    }else{
        ?>
    <div class="alert alert-warning text-center" role="alert">
        Tenes que iniciar sesión para publicar.
    </div>
    <p class="text-center"><a href="login/login.php">Iniciar sesión</a> - <a href="login/registro.php"> Registrarse</a>
    </p>

    <?php
       // header( "refresh:4;url=index.php" );
    } ?>
</body>

</html>

<script>
    function validarTituloPost() {
        var pass = document.forms["miPost"]["titulo"].value;
        if (pass.length > 50) {
            alert("Máximo 50 caracteres en el título");
            return false;
        }
    }
    function contarCaracteres(mostrarEn) {
        var contarDesde = "titulo";
        var len = document.getElementById(contarDesde).value.length;
        if (len > 50) {
            document.getElementById(mostrarEn).style.color = "red";
        } else {
            document.getElementById(mostrarEn).style.color = "black";
        }
        document.getElementById(mostrarEn).innerHTML = "Caracteres: " + len;
    }
</script>