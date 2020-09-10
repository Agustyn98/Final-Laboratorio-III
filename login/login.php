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
    <title>Log in</title>
    <script src="../validaciones.js"></script> 
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-white bg-white fixed-top border-bottom">
        <div class="container">
            <a class="navbar-brand text-dark" href="../index.php">FORO</a>
            <button class="navbar-toggler" type="button button-dark" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-dark"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="login.php">Iniciar sesion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="registro.php">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
        session_start();
        if(isset($_SESSION["usuario"])){
            header("Location:../index.php");
        }
        if(isset($_POST["boton"])){
            include "conexionUsuario.php";
            $c = new conexionUsuario();
            $res = $c->login($_POST["user"],$_POST["pass"]);
            if($res == 0){
                header("Location:../index.php");
            }else if($res == 1){
                ?>
            <div class="alert alert-danger text-center" role="alert">
                Contraseña incorrecta.
            </div>
    <?php
           // header( "refresh:5;url=../index.php" );
            }else if($res == 2){
               ?>
            <div class="alert alert-danger text-center" role="alert">
                Usuario no existe.
            </div>
               <?php
            }
        }
      ?>

    <div class="container">
        <div class="card mx-auto" style="max-width: 45rem;">
            <div class="card-body">
                <h4 class="text-center">Iniciar sesion</h4>
                <hr class="my-5">
                <form action="login.php" name="formLogIn" method="POST" >
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de usuario</label>
                        <input type="text" name="user" class="form-control" id="formSesion" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" name="pass" class="form-control" id="formSesion" required>
                    </div>
                    <button type="submit" name="boton" class="btn btn-primary my-2">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    <?php include '../footer.html' ?>

</body>

</html>