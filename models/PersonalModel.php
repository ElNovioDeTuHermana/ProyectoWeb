<?php

require_once 'models/Personal.php';
require_once 'models/Rol.php';

class PersonalModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert(Personal $personal, $contrasena){
        $query = "INSERT INTO [dbo].[Trabajadores] 
                    (nombre, apellido, sexo, puesto, usuario, contraseña, direccion, telefono, email, sueldo, rol) VALUES 
                    (:nombre,:apellido,:sexo,:puesto,:usuario,'{$contrasena}',:direccion,:telefono,:email,:sueldo,:rol)";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':nombre', $personal->nombre, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':apellido', $personal->apellido, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':sexo', $personal->sexo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':puesto', $personal->puesto, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':usuario', $personal->usuario, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':direccion', $personal->direccion, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':telefono', $personal->telefono, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':email', $personal->email, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':sueldo', $personal->sueldo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':rol', $personal->rol->id, PDO::PARAM_INT);

        
        
        $resultadoQuery->execute();
        
        if($resultadoQuery->rowCount() == 1)
        {
            return true;
        }
        else{
            return false;
        }
        
        
    }

    public function read(){
        $personalArray = array();
        $query = "SELECT [dbo].[Trabajadores].*, Id, r.nombre as nombrerol FROM Trabajadores
        INNER JOIN Roles as r ON Trabajadores.rol = r.id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {

            
            $personal = new Personal();
            $personal->id = $row['trabajadorId'];
            $personal->nombre = $row['nombre'];
            $personal->apellido = $row['apellido'];
            $personal->sexo = $row['sexo'];
            $personal->puesto = $row['puesto'];
            $personal->usuario = $row['usuario'];
            $personal->direccion = $row['direccion'];
            $personal->telefono = $row['telefono'];
            $personal->email = $row['email'];
            $personal->sueldo = floatval($row['sueldo']);
            $rol = new Rol();
            $rol->id = intval($row['Id']);
            $rol->nombre = $row['nombrerol'];
            $personal->rol = $rol;
            array_push($personalArray, $personal);
        }

        return $personalArray;

    }

    public function update(Personal $personal){
        $query = "UPDATE Trabajadores SET nombre = :nombre, apellido = :apellido, sexo = :sexo, puesto = :puesto, usuario = :usuario, direccion = :direccion, telefono = :telefono, email = :email, sueldo = :sueldo, rol = :rol
        WHERE trabajadorId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':nombre', $personal->nombre, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':apellido', $personal->apellido, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':sexo', $personal->sexo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':puesto', $personal->puesto, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':usuario', $personal->usuario, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':direccion', $personal->direccion, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':telefono', $personal->telefono, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':email', $personal->email, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':sueldo', $personal->sueldo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':rol', $personal->rol->id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':id', $personal->id, PDO::PARAM_INT);

        
        $resultadoQuery->execute();
        
        if($resultadoQuery->rowCount() == 1)
        {
            return true;
        }
        else{
            return false;
        }
        
    }

    public function delete($id){
        $query = "DELETE FROM trabajadores WHERE trabajadorId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':id', $id, PDO::PARAM_INT);

        
        $resultadoQuery->execute();
        
        if($resultadoQuery->rowCount() == 1)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function getLastId(){
        $query = "SELECT TOP(1) * From Trabajadores ORDER BY trabajadorId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
            
        if($row = $resultadoQuery->fetch())
        {
            return $row['trabajadorId'];
        }
        else{
            return 0;
        }
        
    }

}

?>