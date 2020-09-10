<?php

    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["admin"]==1 ){
    include_once "conexionUsuario.php";
    $con = new conexionUsuario();
    $idUsuario = $_GET["id"];
    $estadoActual = $_GET["estado"];
    $con->banearUsuario($idUsuario , $estadoActual);
    header("Location:admin.php");
    }
?>