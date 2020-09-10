<?php
    class conexion{
        private $conn;
        function __construct(){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "foro";

            $this->conn = new mysqli($servername, $username, $password, $dbname);
            // Comprobar si conecto
            if ($this->conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
        }
        
        function getPost($numero){
            $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $numero, 1"; //numero 0 = ultima, 1 = penultima,etc. Seleccionar la numero X en orden descendiente, y 1 dato desde ahi
            $result = $this->conn->query($sql);
            if (!empty($result) && $result->num_rows > 0) {   
                    $row = $result->fetch_assoc();
                    return $row;
                  }
            else{
                return false;
                 }
             }

        
        function getPostPorId($id){
            $sql = "SELECT * FROM posts WHERE id = '$id' "; 
            $result = $this->conn->query($sql);
            if (!empty($result) && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row;
                  }
            else{
                return false;
                 }
             }

        function nroPosts(){
            $sql = "SELECT id FROM posts";
            $result = $this->conn->query($sql);
            $nroPosts = 0;
            if (!empty($result) && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $nroPosts++;
                    }
                }
                return $nroPosts;
                $this->conn->close();
        }

        function subirPostConTexto($titulo,$texto,$imagen,$autor){
            $fechayHora = date('Y-m-d H:i:s');
            $sql = "INSERT INTO posts (titulo, cuerpo, fecha, imagen, autor)
                        VALUES ('$titulo', '$texto', '$fechayHora' , '$imagen' , '$autor')  ";
            
            $return=0;
            if ($this->conn->query($sql) === TRUE) {
                $return =  0;
            } else {
                $return = 1;
            }
            $this->conn->close();
            return $return;
        }

        function subirPost($titulo,$imagen,$autor){
            $fechayHora = date('Y-m-d H:i:s');
            $sql = "INSERT INTO posts (titulo, fecha, imagen, autor)
                        VALUES ('$titulo', '$fechayHora' , '$imagen' , '$autor')  ";
            
            $return=0;
            if ($this->conn->query($sql) === TRUE) {
                $return =  0;
            } else {
                $return = 1;
            }
            $this->conn->close();
            return $return;
        }

        function editarPost($id,$titulo,$texto,$imagen){
            $return = 0;
            if(empty($imagen)){ //Si no subi una nueva imagen, envio un 0 como parametro
                $sql = "UPDATE posts SET titulo='$titulo', cuerpo = '$texto' WHERE id='$id'";  
                $return = " entro al query sin imagen";
            }else{
                $sql = "UPDATE posts SET titulo='$titulo', cuerpo = '$texto', imagen = '$imagen' WHERE id='$id'";  
            }

            if ($this->conn->query($sql) === TRUE) {
                $return = 0;
              } else {
                $return = 1;
              }
              $this->conn->close();
              return $return;
        }

        function eliminarPost($id){
            
            $sql = "DELETE FROM posts WHERE id= '$id' ";
            if ($this->conn->query($sql) === TRUE) {
                $this->conn->close();
                return 0;
              } else {
                $this->conn->close();
                return 1;
              }
        }


        function busqueda($busqueda){
            $sql = "SELECT * FROM posts WHERE titulo LIKE '%$busqueda%' OR cuerpo LIKE '%$busqueda%' ";
            $result = $this->conn->query($sql);
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

        function enviarComentario($idPost,$usuario,$comentario){
            $fechayHora = date('Y-m-d H:i:s');
            $sql = "INSERT INTO comentarios (id_post,usuario,comentario,fecha) VALUES ('$idPost','$usuario','$comentario','$fechayHora')";
            $return=0;
            if ($this->conn->query($sql) === TRUE) {
                $return =  0;
            } else {
                $return = 1;
            }
            $this->conn->close();
            return $return;
        }

        function getComentarios($idPost){
            $sql = "SELECT * FROM comentarios WHERE id_post = '$idPost' "; 
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

        function getUltimosComentarios($limite){
            $sql = "SELECT * FROM comentarios ORDER BY id DESC LIMIT " . $limite; 
            $result = $this->conn->query($sql);
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

        function eliminarComentario($id){
            
            $sql = "DELETE FROM comentarios WHERE id= '$id' ";
            if ($this->conn->query($sql) === TRUE) {
                $this->conn->close();
                return 0;
              } else {
                $this->conn->close();
                return 1;
              }
        }

        function eliminarComentarioPorPost($idPost){
            $sql = "DELETE FROM comentarios WHERE id_post = '$idPost' ";
            if ($this->conn->query($sql) === TRUE) {
                $this->conn->close();
                return 0;
              } else {
                $this->conn->close();
                return 1;
              }
        }

        function nroComentarios($idPost){
            $sql = "SELECT id FROM comentarios WHERE id_post = '$idPost' "; 
            $result = $this->conn->query($sql);
            $nroComentarios = 0;
            if (!empty($result) && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $nroComentarios++;
                    }
                  }
                  $this->conn->close();
                  return $nroComentarios;
        }

        function nroComentariosTotal(){
            $sql = "SELECT id FROM comentarios"; 
            $result = $this->conn->query($sql);
            $nroComentarios = 0;
            if (!empty($result) && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $nroComentarios++;
                    }
                  }
                  $this->conn->close();
                  return $nroComentarios;
        }

        function nroComentarioHoy(){
            $fecha = date('Y-m-d');
            $fecha = $fecha . " 00:00:00";
            $sql = "SELECT id FROM comentarios WHERE fecha >= '$fecha' "; 
            $result = $this->conn->query($sql);
            $nroComentarios = 0;
            if (!empty($result) && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $nroComentarios++;
                    }
                  }
                  $this->conn->close();
                  return $nroComentarios;
        }

        function nroPostsHoy(){
            $fecha = date('Y-m-d');
            $fecha = $fecha . " 00:00:00";
            $sql = "SELECT id FROM posts WHERE fecha >= '$fecha' "; 
            $result = $this->conn->query($sql);
            $nroPosts = 0;
            if (!empty($result) && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $nroPosts++;
                    }
                  }
                  $this->conn->close();
                  return $nroPosts;
        }

        function contarPostsPorComentarios(){
            $sql = "
            SELECT id_post,COUNT(*) as total 
            FROM comentarios 
            GROUP BY id_post 
            ORDER BY total DESC;
            ";

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

        function nroMiembros(){
            $sql = "SELECT id_usuario FROM usuarios"; 
            $result = $this->conn->query($sql);
            $nroMiembros = 0;
            if (!empty($result) && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $nroMiembros++;
                        }
                  }
                  $this->conn->close();
                  return $nroMiembros;
        }

        
    }
    
?>