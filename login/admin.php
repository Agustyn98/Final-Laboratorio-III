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
    <link rel="stylesheet" href="../estilos.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>

    <style>
        .spoiler {
            color: black;
            background-color: black;
        }

        .spoiler:hover {
            background-color: white;
        }
    </style>
</head>


<body style="margin-top: 0px;">
    <?php
        session_start();
        if(isset($_SESSION["usuario"]) && $_SESSION["admin"]==1 ){
        include_once "conexionUsuario.php";
        $con = new conexionUsuario();
        $usuarios = $con->getTodosUsuarios();
        //var_dump($usuarios);
    ?>


    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-5 text-center"><img
                    src="https://img.icons8.com/wired/64/000000/admin-settings-male.png" /> <strong> Administrar
                    Usuarios</strong> </h1>

        </div>
    </div>

    <div class="container-fluid">

        <table class="table table-bordered table-responsive-sm table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Usuario</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fecha de registro</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Permisos</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Moderar</th>
                </tr>
            </thead>
            <tbody>

                <?php
        if(! empty($usuarios)){
        $numeroDeUsuarios = count($usuarios);
        for($i = ($numeroDeUsuarios-1) ; $i >= 0 ; $i--){
           $idUsuario = $usuarios[$i]["id_usuario"]; 
           $username = $usuarios[$i]["username"];
           $email = $usuarios[$i]["email"];
           $pass = $usuarios[$i]["password"];
           $fechaDeRegistro = $usuarios[$i]["fecha"];
           $esAdmin = $usuarios[$i]["admin"];
           if($esAdmin == 1){
               $tablaEsAdmin = "Administrador";
           }else{
               $tablaEsAdmin = "Ninguno";
           }
           $ban = $usuarios[$i]["ban"];
    ?>
                <tr>
                    <td><strong><?php echo $username ?> </strong> </td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $fechaDeRegistro ?></td>
                    <td><span class="spoiler"><?php echo $pass ?></span></td>
                    <td><?php if($esAdmin == 1){
            echo "<span class='badge badge-success'>Administrador</span>";
      }else{
          echo "Ninguno";
      }
      ?>
                    </td>
                    <td><?php 
        if($ban == 1){
            echo "<span class='badge badge-danger'>Baneado</span>";
      }else{
          echo "Activo";
      }
      ?>
                    </td>
                    <td>
                        <?php $linkPermisos = "cambiarPermisosUsuario.php?id=" . $idUsuario . "&estado=" . $esAdmin  ?>
                        <a href=<?php echo $linkPermisos ?> class="badge badge-info">Cambiar Permismos</a>
                        <?php $linkBan = "banearUsuario.php?id=" . $idUsuario . "&estado=" . $ban  ?>
                        <a href=<?php echo $linkBan ?> class="badge badge-warning">Banear/Desbanear</a>
                    </td>

                </tr>
                <?php
        }
    ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-dark btn-lg my-3">&larr; Volver</a>
    </div>


    <?php
        }else{
            echo "no hay usuarios :(";
        }
    }else{
         echo "No puede acceder a esta página";
    }
    ?>
</body>

</html>