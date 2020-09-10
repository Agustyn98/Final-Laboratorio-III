<?php
    class conexionUsuario{
        private $conn;
        function __construct(){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "foro";

            // Create connection
            $this->conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
        }

        function login($user,$pass){
            $sql = "SELECT * FROM usuarios WHERE username = '" . $user ."'";
            $result = $this->conn->query($sql);
            if (!empty($result) && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->conn->close();

                if($row["password"] == $pass ){
                    $_SESSION["usuario"] = $user;
                    if($row["admin"] == 1){
                        $_SESSION["admin"] = 1;
                    }
                    if($row["ban"] ==1){
                        $_SESSION["ban"] = 1;
                    }else{
                        $_SESSION["ban"] = 0;
                    }
                    return 0;
                }else{
                    //contra incorrecta
                    return 1;
                }
                
              } else {
                  //usuario incorrect
                return 2;
              }
              
        }
        function verificarDatosRepetidos($user,$email){
            $sql = "SELECT * FROM usuarios WHERE username = '" . $user ."'";
            $result = $this->conn->query($sql);
            if(!empty($result) && $result->num_rows > 0){
                return false;
            }
            return true;
        }
        function registrar($user,$email,$pass){
            //usuario en uso
            $retr=0;
            if($this->verificarDatosRepetidos($user,$email)){
                //algun error al registrar
                $retr =1;
                $fecha = date_create()->format('Y-m-d');
                $sql = " INSERT INTO usuarios (username,email,password,fecha) VALUES ('" . $user . "' , '" . $email . "' , ' " . $pass . "' , '" . $fecha . "')";
                
                if ($this->conn->query($sql) === TRUE) {
                    //Se registro con exito
                    $retr = 2;
                }
                $this->conn->close();
            }
            return $retr;
        }

        function getDatosUsuario($username){
            $sql = "SELECT username,email,admin,fecha FROM usuarios WHERE username = '$username' "; 
            $result = $this->conn->query($sql);
            if (!empty($result) && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row;
                  }
            else{
                return false;
                 }
        }

        function getTodosUsuarios(){
            $sql = "SELECT * FROM usuarios"; 
            $result = $this->conn->query($sql);
            $this->conn->close();
            $arrayDeResultados = [];
            if (!empty($result) && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $arrayDeResultados[] = $row;
                    }
                    return $arrayDeResultados;
                    //array que contiene arrays con los resultados
                  }
            else{
                return false;
                 }
        }

        function banearUsuario($id,$estadoActual){
            if($estadoActual == 0){
                $sql = "UPDATE usuarios SET ban=1 WHERE id_usuario = '$id'";  
            }else if($estadoActual == 1){
                $sql = "UPDATE usuarios SET ban=0 WHERE id_usuario = '$id'";  
            }
            if ($this->conn->query($sql) === TRUE) {
                $return = 0;
            } else {
                $return = 1;
            }
            $this->conn->close();
            return $return;
            }

            function cambiarPermisos($id,$estadoActual){
                if($estadoActual == 0){
                    $sql = "UPDATE usuarios SET admin=1 WHERE id_usuario = '$id'";  
                }else if($estadoActual == 1){
                    $sql = "UPDATE usuarios SET admin=0 WHERE id_usuario = '$id'";  
                }
                if ($this->conn->query($sql) === TRUE) {
                    $return = 0;
                } else {
                    $return = 1;
                }
                $this->conn->close();
                return $return;
                }
    }
?>