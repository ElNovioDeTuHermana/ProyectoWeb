<?php

class LoginModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function validarLogin($usuario, $password){
        
        $trabajador = [];
        $query = "SELECT * FROM Trabajadores WHERE usuario = :usuario ";
        $query2 = "SELECT * FROM Trabajadores WHERE usuario = :usuario AND contraseña = :password";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':usuario', $usuario, PDO::PARAM_STR);

        

        try {
            $resultadoQuery->execute();
            
            if($row = $resultadoQuery->fetch())
            {
                
                $resultadoQuery = $conexion->prepare($query2);
                $resultadoQuery->bindParam(':usuario', $usuario, PDO::PARAM_STR);
                $resultadoQuery->bindParam(':password', $password, PDO::PARAM_STR);
                $resultadoQuery->execute();

                if($row = $resultadoQuery->fetch()){
                    $trabajador[0] = $row['trabajadorId'];
                    $trabajador[1] = $row['rol'];

                    
                    return $trabajador;
                }
                else{
                    return null;
                }
            }
            else{
                return null;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

}

?>