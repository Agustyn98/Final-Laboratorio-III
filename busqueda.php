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
    <title>Busqueda</title>
</head>

<body>
    <?php include "header.html" ?>

    <div class="container">
        <?php 
        $busqueda = $_GET["busqueda"];
        include "conexion.php";
        $c = new conexion();
        $res = $c->busqueda($busqueda);
        //var_dump($res);
        //var_dump($res[1]["id"]);

        
    ?>

        <div class="card mb-5">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Resultados de la busqueda " <?php echo $busqueda ?> "</h5>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Título y fecha</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Link</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($res == false){
                        $numeroDeResultados =0;
                    }else{
                        $numeroDeResultados = count($res);
                    }
                    //var_dump($numeroDeResultados);
                    for($i = ($numeroDeResultados-1) ; $i >= 0 ; $i--){
                        $id = $res[$i]["id"];
                        $titulo = $res[$i]["titulo"];
                        $texto = $res[$i]["cuerpo"];
                        $imagen = $res[$i]["imagen"];
                        $fecha = $res[$i]["fecha"];
                ?>
                <tr>
                    <td>
                        <h4><?php echo $titulo ?> </h4> <small><img style="max-height: 1rem;"
                                src="https://img.icons8.com/pastel-glyph/50/000000/date-to.png" />
                            <?php echo $fecha ?></small>
                    </td>
                    <td><?php echo '<img style="max-height: 100px; max-width: 100px;" class="card-image" src="data:image/jpeg;base64,'.base64_encode( $imagen ).'"/>'; ?>
                    </td>
                    <?php $link = "post.php?id=" . $id  ?>
                    <td> <a href="<?php echo $link ?>">
                            <h5>Ir &rarr;</h5>
                        </a></td>
                </tr>

                <?php 
                        }
                ?>
            </tbody>
        </table>
    </div>


</body>

</html>