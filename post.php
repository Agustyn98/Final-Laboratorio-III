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
    <title>Post</title>
    <script src="validaciones.js"></script>

</head>

<body>
    <div>
        <?php 
            include 'header.html';
            include "conexion.php";
            $id = $_GET["id"];
            $conComentario = new conexion();
            $c = new conexion();
            if(isset($_POST["comentario"])){
                if(isset($_SESSION["usuario"])){
                    if($_SESSION["ban"] == 0){
                        $usuario = $_SESSION["usuario"];
                        $conComentario->enviarComentario($id,$usuario,$_POST["texto"]);
                    }else{
                        ?>
        <div class="alert alert-danger text-center" role="alert">
            Tu cuenta ha sido bloqueada.
        </div>
        <?php
                    }
                }else{
                    ?>
        <script>
            alert("Tenes que iniciar sesión antes!");
        </script>
        <?php
                }
            }else if(isset($_POST["eliminar"])){
                if( isset($_SESSION["admin"]) ){
                    $c2 = new conexion();
                    $c2->eliminarComentarioPorPost($id);
                    $c->eliminarPost($id);
                    header("Location:paginas.php");
                }
            }else if(isset($_POST["eliminarComentario"])){
                if( isset($_SESSION["admin"]) ){
                $c1 = new conexion();
                //var_dump($_POST["idComentario"]);
                $c1->eliminarComentario($_POST["idComentario"]);
                }
            }
            
            $row = $c->getPostPorId($id);
            if($row != false){
            $id = $row["id"];
            $titulo = $row["titulo"];
            $fecha = $row["fecha"];
            $autor = $row["autor"];
            $imagen = $row["imagen"];
            $cuerpo = $row["cuerpo"];
            include_once "login/conexionUsuario.php";
            $c2 = new conexionUsuario();
            $datosAutor = $c2->getDatosUsuario($autor);
            //var_dump($datosAutor);
            $emailAutor = $datosAutor["email"];
            $registroAutor = $datosAutor["fecha"];
            $esAdmin = $datosAutor["admin"];
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="p-2">
                            <p class="text-center"><img class="img-thumbnail"
                                    src="https://img.icons8.com/officel/100/000000/user.png" /></p>

                            <h5 class="text-primary text-center"><?php echo $autor ?> </h5>
                            <p class="mb-0">Usuario desde: </p>
                            <p><?php echo $registroAutor ?></p>
                            <p class="mb-0">Email: </p>
                            <p><?php echo $emailAutor ?> </p>
                        </div>
                    </div>
                    <!-- Twitter  y whatsapp-->
                    <div class="pt-5 p-2 text-center">
                        <a target="_blank" href="https://twitter.com/share?ref_src=twsrc%5Etfw"
                            class="twitter-share-button" data-size="large" data-text="Mi Post: "
                            data-show-count="true">Tweet</a>
                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        <p></p>
                        <?php 
                            $link = "https://api.whatsapp.com/send?text=Mi%20Post:%20http://" . $_SERVER['PHP_SELF'] . "?id=" . $id;
                        ?>
                        <a class="mx-3" target="_blank" href=<?php echo $link ?>><img
                                src="https://img.icons8.com/officel/40/000000/whatsapp.png" /> </a>
                    </div>
                    <!-- Botones eliminar/editar  -->
                    <?php 
                    if( isset($_SESSION["admin"]) ){ ?>
                    <div class="my-5 p-3 border border-dark">
                        <?php $link = "editarPost.php?id=" . $id  ?>
                        <a type="button my-3" href=<?php echo $link ?> class="btn btn-warning btn-block">Editar</a>
                        <form action="" method="POST">
                            <button type="submit" name="eliminar" class="btn btn-danger btn-block mt-3"
                                onclick="return confirm('Eliminar Post?');">Eliminar</button>
                        </form>
                    </div>
                    <?php } ?>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <?php echo '<img class="mb-5 card-img" src="data:image/jpeg;base64,'.base64_encode( $imagen ).'"/>'; //class="card-image" ?>
                            </div>
                            <hr class="mb-4">
                            <p class="text-right m-3">
                                <?php echo $fecha?>
                            </p>
                            <h2 class="font-weight-bold my-3"><?php echo $titulo ?></h2>
                            <?php if(!empty($cuerpo)){ ?>
                            <hr class="my-4">
                            <p style="font-size: larger;">
                                <?php echo $cuerpo ?>
                            </p>
                            <?php } ?>
                        </div>

                    </div>
                </div>


            </div>
            <!--Dejar comentario-->
            <hr class="my-5">

            <div class="card mx-auto" style="max-width: 40rem;">
                <div class="card-body bg-white">
                    <h5>Deja tu comentario <img style="max-height: 1.7rem;" class="mx-2"
                            src="https://img.icons8.com/ios/50/000000/comments.png" /></h5>
                </div>
                <form class="p-2" action="" method="post" name="formComentario" onsubmit="return validarComentario();">
                    <textarea class="form-control" id="texto" name="texto" rows="3"
                        onkeyup="contarCaracteres('nroCaracteres');" onkeydown="contarCaracteres('nroCaracteres');"
                        onmouseout="contarCaracteres('nroCaracteres');"></textarea>
                    <button type="submit" name="comentario" class="btn btn-primary ml-2 float-right my-2"
                        style="width: 20rem;">Enviar</button>
                    <p class="m-3" id="nroCaracteres">Caracteres</p>
                </form>
            </div>

            <!--Comentarios: -->
            <hr class="my-5">

            <?php 
            $con = new conexion();
            $comentarios = $con->getComentarios($id);
            if($comentarios == false){
                ?>
            <div class="alert alert-success text-center p-4" role="alert">
                <h4>No hay comentarios</h4>
                <h5>¡Se el primero!</h5>
            </div>

            <?php
            }else{
                ?>
            <div style="overflow-y: scroll; max-height: 50vh;">
                <?php
                $numeroComentarios = count($comentarios);
            for ($i = ($numeroComentarios-1); $i>=0 ; $i-- ){
                $idComentario = $comentarios[$i]["id"];
                $autor = $comentarios[$i]["usuario"];
                $comentario = $comentarios[$i]["comentario"];
                $fecha = $comentarios[$i]["fecha"];
            ?>
                <div class="card m-1">
                    <div class="card-header">
                        <h5 class="float-left text-primary"><?php echo $autor ?></h5>
                        <p class="float-right text-muted"><?php echo $fecha ?></p>
                    </div>
                    <div class="card-body">
                        <p><?php echo $comentario ?></p>
                        <?php  if(isset($_SESSION["admin"] )){ ?>
                        <form action="" method="post">
                            <input type="hidden" name="idComentario" value="<?php echo $idComentario ?>">
                            <button type="submit" name="eliminarComentario" class="btn btn-danger btn-sm float-right"
                                onclick="return confirm('Eliminar Comentario?');">Eliminar</button>
                        </form>
                        <?php  } ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <?php
            }
                ?>

        </div>
    </div>
    <?php 
    include 'footer.html' ;
    }else{ ?>
    <div class="alert alert-danger text-center my-5" role="alert">
        Error. No existe este post.
    </div>
    <?php
    }
    ?>
</body>

</html>