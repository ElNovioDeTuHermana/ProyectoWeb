<?php

class CategoriasModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($categoria){
        $query = "INSERT into Categorias (nombre) VALUES (:nombre)";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':nombre', $categoria, PDO::PARAM_STR);

        try {
            $resultadoQuery->execute();
            
            if($resultadoQuery->rowCount() == 1)
            {
                return true;
            }
            else{
                return false;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function read(){
        $categorias = array();
        $query = "SELECT * FROM categorias";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        try {
            $resultadoQuery->execute();
            
            while ($row = $resultadoQuery->fetch()) {
                $cat = array($row['categoriaId'], $row['nombre']);
                array_push($categorias, $cat);
            }

            return $categorias;
        } 
        catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function update($id, $nombre){
        $query = "UPDATE Categorias SET nombre = :nombre WHERE categoriaId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':id', $id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':nombre', $nombre, PDO::PARAM_STR);

        try {
            $resultadoQuery->execute();
            
            if($resultadoQuery->rowCount() == 1)
            {
                return true;
            }
            else{
                return false;
            }

        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id){
        $query = "DELETE FROM Categorias WHERE categoriaId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $resultadoQuery->execute();
            
            if($resultadoQuery->rowCount() == 1)
            {
                return true;
            }
            else{
                return false;
            }

        } catch (PDOException $e) {
            return false;
        }
    }

    public function getLastId(){
        $query = "SELECT TOP(1) * From Categorias ORDER BY categoriaId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
            
        if($row = $resultadoQuery->fetch())
        {
            return $row['categoriaId'];
        }
        else{
            return 0;
        }
        
    }

}

?>