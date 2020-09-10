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
    <title>Foro</title>

</head>

<body>
    <?php include 'header.html' ?>
    <?php
        include "conexion.php";
        $c1 = new conexion();
        $res = $c1->contarPostsPorComentarios();
        //var_dump($res);
        error_reporting(E_ALL ^ E_NOTICE); 
        $idMasComentados = [
            "1" => $res[0]["id_post"],
            "2" => $res[1]["id_post"],
            "3" => $res[2]["id_post"],
        ];

        //var_dump($idMasComentados);
        
        

    ?>
    <!-- Container de todo-->
    <div class="container">
        <!-- Columna izquierda-->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title mb-0 text-center font-weight-bold"><img
                                style="max-height: 3rem; margin-top: -0.5rem;"
                                src="https://img.icons8.com/nolan/64/leaderboard.png" /> Posts Destacados </h3>
                    </div>
                </div>
                <?php
                $c = new conexion();
                for($i = 1; $i<4 ;$i++){
                    $post = $c->getPostPorId($idMasComentados[$i]);
                    if($post != false){
                    $titulo = $post["titulo"];
                    $imagen = $post["imagen"];
                    $id = $idMasComentados[$i];
                ?>
                <div class="card my-3">
                    <div class="card-body">
                        <?php $link = "post.php?id=" . $id ?>
                        <a href=<?php echo $link ?>>
                            <h4 class="card-title font-weight-bold" style="font-size: 180%; color: black;">
                                <?php echo $titulo ?></h4>
                        </a>
                        <hr class="mb-0">
                    </div>
                    <?php echo '<img class="card-img" src="data:image/jpeg;base64,'.base64_encode( $imagen ).'" />'; ?>
                    <a href=<?php echo $link ?> type="button" class="btn btn-primary my-3 mx-2">Leer más &rarr;</a>
                </div>
                <?php }
                }
                 ?>
            </div>

            <!-- Columna derecha-->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-center my-2"> <a href="paginas.php" style="color: black;">Ver Todo
                            </a> <a href="paginas.php">
                                <img style="height: 2rem;" class="mx-2"
                                    src="https://img.icons8.com/flat_round/64/000000/arrow-right.png" /></a></h5>
                    </div>
                </div>
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title"> <img style="max-width: 1.5rem;"
                                src="https://img.icons8.com/material-sharp/50/000000/search.png" /> Buscar</h5>
                        <form action="busqueda.php" method="get">
                            <input type="text" class="form-control my-3" name="busqueda" id="busqueda" required>
                            <button type="submit" class="btn btn-primary float-right" style="width: 10rem;">Ir</button>
                        </form>
                    </div>
                </div>
                <div class="card my-3">
                    <div class="card-body p-0">
                        <h5 class="card-title mx-3 my-3"><img style="max-width: 1.3rem;"
                                src="https://img.icons8.com/pastel-glyph/64/000000/line-chart.png" /> Estadisticas</h5>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Número de usuarios registrados</td>
                                    <?php $con1 = new conexion();
                                          $nroMiembros = $con1->nroMiembros();  
                                        ?>
                                    <td style="color:royalblue"><?php echo $nroMiembros ?></td>
                                </tr>
                                <tr>
                                    <td>Número de posts</td>
                                    <?php $con1 = new conexion();
                                          $nroPosts = $con1->nroPosts();  
                                        ?>
                                    <td style="color:royalblue"><?php echo $nroPosts ?></td>
                                </tr>
                                <tr>
                                    <td>Número de posts de hoy</td>
                                    <?php $con1 = new conexion();
                                          $nroPostsHoy = $con1->nroPostsHoy();  
                                        ?>
                                    <td style="color:royalblue"><?php echo $nroPostsHoy ?></td>
                                </tr>
                                <tr>
                                    <td>Número de comentarios</td>
                                    <?php $con1 = new conexion();
                                          $nroComentarios = $con1->nroComentariosTotal();  
                                        ?>
                                    <td style="color:royalblue"><?php echo $nroComentarios ?></td>
                                </tr>
                                <tr>
                                    <td>Número de comentarios de hoy</td>
                                    <?php $con1 = new conexion();
                                          $nroComentariosHoy = $con1->nroComentarioHoy();  
                                        ?>
                                    <td style="color:royalblue"><?php echo $nroComentariosHoy ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><img
                                src="https://img.icons8.com/wired/24/000000/social-network.png" /> Redes sociales</h5>
                        <hr>
                        <a href="https://twitter.com/elonmusk?ref_src=twsrc%5Etfw" class="twitter-follow-button"
                            data-size="large" data-show-count="true">Follow @elonmusk</a>
                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        <hr>
                        <a class="m-3" target="_blank"
                            href="https://api.whatsapp.com/send?text=Foro%20Argentino:%20http://localhost/lab3final"><img
                                src="https://img.icons8.com/officel/40/000000/whatsapp.png" /> </a>
                        <a href="https://instagram.com/elonmusk" target="_blank"><img
                                src="https://img.icons8.com/fluent/48/000000/instagram-new.png" /></a>

                    </div>
                </div>
                <?php 
                    if(isset($_SESSION["usuario"]) && $_SESSION["admin"] == 1){
                ?>
                <a href="login/admin.php" class="btn btn-warning my-5 btn-block"><strong>Administrar
                        cuentas</strong></a>

                <?php } ?>
            </div>
        </div>
    </div>
    <?php include 'footer.html' ?>
</body>

</html>