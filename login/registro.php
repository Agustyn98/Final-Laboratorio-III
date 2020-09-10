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
    <title>Registrarse</title>
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
        $res = $c->registrar($_POST["user"],$_POST["email"],$_POST["password"]);
        if($res == 0){
            echo "<div class='alert alert-danger text-center' role='alert'>
            Usuario en uso.
             </div>";
        }else if($res == 2){
            ?>
                <script>
                    alert("Se registro con exito. Ya podes iniciar sesión.");
                    window.location = "login.php";
                </script>
            <?php
        }else if($res ==1){
            //otro error
            echo "<div class='alert alert-danger text-center' role='alert'>
            Error al cargar en a base de datos.
             </div>";
        }
        
      }
      ?>

    <div class="container">
        <div class="card mx-auto" style="max-width: 45rem;">
            <div class="card-body">
                <h3 class="text-center">Registrarse </h3>
                <hr class="my-5">
                <form action="registro.php" name="formRegistro" method="POST" onsubmit="return validarRegistro();">
                    <div class="form-group">
                        <label for="formSesion">Email</label>
                        <input type="email" name="email" class="form-control" id="formSesion" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de usuario</label>
                        <input type="text" name="user" class="form-control" id="formSesion">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" name='password' class="form-control" id="formSesion">
                    </div>
                    <button type="submit" name="boton" class="btn btn-primary my-2">Registrarse </button>
                </form>
            </div>
        </div>
    </div>



    <?php include '../footer.html' ?>

</body>

</html>