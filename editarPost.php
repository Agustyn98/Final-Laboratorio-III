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
    <title>Editar Post</title>
</head>

<body>
    <?php include 'header.html' ?>

    <?php
        if( isset($_SESSION["admin"]) ){
    ?>

    <?php
        include "conexion.php";
        $id = $_GET["id"];
        if(isset($_POST["boton"])){
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
            }else{
                $isValidImage = 2;
                $imagenBinario = '';
            }

            if(empty($imagenBinario) && !empty($titulo) && $isValidImage==2){
                $res = $c->editarPost($id,$titulo,$texto,$imagenBinario);
                if($res == 0){
                    echo "<div class='alert alert-success' role='alert'>
                    Post editado
                  </div>";
                }else{
                    echo "<div class='alert alert-danger' role='alert'>
                    Error al subir a la base de datos
                  </div>";
                }
            }else{
                if($isValidImage == 1 && !empty($titulo)){
                    $res = $c->editarPost($id,$titulo,$texto,$imagenBinario);
                    if($res == 0){
                        echo "<div class='alert alert-success' role='alert'>
                        Post editado
                      </div>";
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                        Error al subir a la base de datos
                      </div>";
                    }
                }else{
                    //imagen no valida o titulo vacio
                    echo "<div class='alert alert-danger' role='alert'>
                    Error al editar post. Imagen no valida o titulo vacio?.
                  </div>";
                }
            }
        }

        $con = new conexion();
        
        $res = $con->getPostPorId($id);
        $tituloOriginal =$res["titulo"];
        $textoOriginal = $res["cuerpo"];
        $imagenOriginal = $res["imagen"];
    ?>




    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-5 text-center font-weight-bold"><img
                    src="https://img.icons8.com/color/50/000000/rich-text-converter.png" /> Editar Post</h1>
        </div>
    </div>
    <div class="container">
        <?php $link =  "editarPost.php?id=" . $id ?>
        <form action=<?php echo $link ?> method="POST" name="miPost" enctype="multipart/form-data"
            onsubmit="return validarTituloPost();">
            <div class="form-group">
                <label for="titulo">
                    <h4>Título </h4>
                </label>
                <div class="row">
                    <div class="col-md-9">
                        <input type="text" class="form-control form-control-lg my-2" name="titulo" id="titulo"
                            style="max-width: 48rem;" value="<?php echo $tituloOriginal ?>" required
                            onkeyup="contarCaracteres('nroCaracteres');" onkeydown="contarCaracteres('nroCaracteres');"
                            onmouseout="contarCaracteres('nroCaracteres');">
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
                    rows="4"><?php echo $textoOriginal ?></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">
                    <h4>Imagen</h4>
                </label>
                <input type="file" class="form-control-file" name="imagen" id="imagen">
                <?php echo '<img class="my-3" style="max-height: 10%; max-width: 10%;" src="data:image/jpeg;base64,'.base64_encode( $imagenOriginal ).'"/>'; //class="card-image" ?>
            </div>

        </form>
    </div>
    <?php }else{ ?>

    <div class="alert alert-warning text-center" role="alert">
        No puede editar si no es admin.
    </div>

    <?php   } ?>
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