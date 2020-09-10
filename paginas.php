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
    <title>Foro - Últimos Posts</title>
</head>

<body>
    <?php include 'header.html';  include "conexion.php"; ?>
    <div class="container">
        <div class="row">
            <!--Columna ultimos posts-->
            <div class="col-md-8">
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title  mb-0"><img class="mx-2" style="max-height: 2rem; margin-top: -0.3rem;"
                                src="https://img.icons8.com/ios/50/000000/new.png" /> Últimos Posts</h5>
                    </div>
                </div>
                <?php

                    if(!isset($_SESSION["postsPorPagina"])){
                        $_SESSION["postsPorPagina"] = 5;
                    }  
                    if(isset($_POST["cambiarPaginacion"])){
                        $_SESSION["postsPorPagina"] = $_POST["nroPostsPorPagina"];
                    }
                    
                    $postsPorPagina = $_SESSION["postsPorPagina"];

                    $c1 = new conexion();
                    $nroPosts = $c1->nroPosts();
                    $nroPaginas = ceil($nroPosts / $postsPorPagina);
                    //var_dump($nroPaginas); 
                    
                    $paginaActual = (isset($_GET['pagina']) && is_numeric($_GET['pagina']) && $_GET['pagina']>0 ) ? $_GET['pagina'] : 1;
                    if($paginaActual > $nroPaginas){ $paginaActual = $nroPaginas; }
                    
                    $limiteSuperior = $paginaActual * $postsPorPagina; // 1 * 4 = 4
                    $limiteInferior = $limiteSuperior - $postsPorPagina; //4 - 4 = 0
                                       
                    $c = new conexion();
                    $i = $limiteInferior;
                        do{
                        $row = $c->getPost($i);
                        $i++;
                        if(! $row == false){
                            $id = $row["id"];
                            $titulo = $row["titulo"];
                            $fecha = $row["fecha"];
                            $autor = $row["autor"];
                            $imagen = $row["imagen"];
                 ?>
                <?php $link = "post.php?id=" . $id ?>
                <div class="card mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-5">
                            <a href=<?php echo $link ?>>
                                <?php echo '<img class="card-img" src="data:image/jpeg;base64,'.base64_encode( $imagen ).'"/>'; ?></a>
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <a href=<?php echo $link ?>>
                                    <h2 style="color: black;" class="card-title font-weight-bold"><?php echo $titulo ?>
                                    </h2>
                                </a>

                                <ul class="list-inline text-muted">
                                    <li class="list-inline-item"><img style="max-height: 1rem;"
                                            src="https://img.icons8.com/wired/64/000000/user-male.png" />
                                        <?php echo $autor ?></li>
                                    <li class="list-inline-item">|</li>
                                    <li class="list-inline-item"><img style="max-height: 1rem;"
                                            src="https://img.icons8.com/pastel-glyph/50/000000/date-to.png" />
                                        <?php echo $fecha ?></li>
                                    <li class="list-inline-item">|</li>
                                    <?php $c2 = new conexion();
                                              $nroComentarios = $c2->nroComentarios($id);
                                        ?>
                                    <li class="list-inline-item"><img style="max-height: 1rem;"
                                            src="https://img.icons8.com/small/50/000000/topic.png" />
                                        <?php echo $nroComentarios ?></li>
                                </ul>

                                <a type="button" class="btn btn-primary my-3" href=<?php echo $link ?>>Leer más
                                    &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                    }
                }while($i < $limiteSuperior) ?>
                <div class="row">
                    <div class="col-sm-6">
                        <!--Paginacion-->
                        <div class="btn-group btn-group-lg my-5" role="group" aria-label="Navegar"
                            style="max-width: 20rem;">
                            <a href="<?php echo "?pagina=" . ($paginaActual+1) ?>" name="anterior"
                                class="btn btn-info">&larr; Anterior</a>
                            <a href="<?php echo "?pagina=" . ($paginaActual-1) ?>" name="siguiente"
                                class="btn btn-info">Siguiente &rarr;</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- Posts por pagina-->
                        <div class="form-group m-4">
                            <form action="" method="POST">
                                <input type="range" name="nroPostsPorPagina" class="form-control-range"
                                    id="formControlRange" value=<?php echo $postsPorPagina ?> min="3" max="10"
                                    onchange="updateTextInput(this.value);">
                                <p class="text-center mt-2">
                                    <small><input class="m-2" type="text" id="textInput"
                                            value=<?php echo $postsPorPagina ?> style="max-width: 2rem;">
                                        Posts por página</small>
                                </p>
                                <button type="submit" name="cambiarPaginacion"
                                    class="btn btn-info btn-block">Actualizar</button>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function updateTextInput(val) {
                        document.getElementById('textInput').value = val;
                    }
                </script>

            </div>

            <!--Columna derecha-->
            <div class="col-md-4">
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title text-center my-2"> <a class="mx-2" href="crearPost.php"
                                style="color: black;">Nuevo Post!
                            </a> <a href="crearPost.php">
                                <img style="max-height: 2rem;"
                                    src="https://img.icons8.com/fluent/48/000000/up.png" /></a></h5>
                    </div>
                </div>

                <!-- Ultimos comentarios -->
                <?php
                $con = new conexion();
                $nroComentarios = 3;
                $comentarios = $con->getUltimosComentarios($nroComentarios);
  
                ?>

                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title">Últimos Comentarios</h5>
                        <?php 


                        for($i=0 ; $i<$nroComentarios ; $i++){
                        //var_dump($comentarios[$i]);
                        error_reporting(E_ALL ^ E_NOTICE); 
                        if( is_array($comentarios[$i]) ){
                        $texto = $comentarios[$i]["comentario"];
                        $idPost = $comentarios[$i]["id_post"];
                        ?>
                        <div class="card my-2" style="border: 1px solid; border-color:lightgrey">
                            <div class="card-body">
                                <?php echo $texto ?>
                            </div>
                            <?php 
                            $con2 = new conexion();
                            $post = $con2->getPostPorId($idPost);
                            $link = "post.php?id=" . $post["id"];
                            ?>
                            <div class="card-header">
                                <small>En <a href="<?php echo $link ?>"><?php echo $post["titulo"] ?> </a></small>
                            </div>
                        </div>

                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <?php include 'footer.html' ?>
</body>

</html>