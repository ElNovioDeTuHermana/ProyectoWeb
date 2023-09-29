<?php

class ClientesModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($Cliente){
        $query = "INSERT INTO Clientes (nombre, apellido, sexo, nit, direccion, telefono, email) VALUES (:nombre, :apellido, :sexo, :nit, :direccion, :telefono, :email)";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':nombre', $Cliente->nombre, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':apellido', $Cliente->apellido, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':sexo', $Cliente->sexo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':nit', $Cliente->nit, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':direccion', $Cliente->direccion, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':telefono', $Cliente->telefono, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':email', $Cliente->email, PDO::PARAM_STR);
        
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
        $clientes = array();
        $query = "SELECT * FROM Clientes";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $cliente = new Cliente();

            $cliente->id=$row['clienteId'];
            $cliente->nombre=$row['nombre'];
            $cliente->apellido=$row['apellido'];
            $cliente->sexo=$row['sexo'];
            $cliente->nit=$row['nit'];
            $cliente->direccion=$row['direccion'];
            $cliente->telefono=$row['telefono'];
            $cliente->email=$row['email'];
            array_push($clientes, $cliente);
        }

        return $clientes;
    }

    public function update($Cliente){
        $query = "UPDATE Clientes SET nombre = :nombre, apellido = :apellido, sexo = :sexo, nit = :nit, direccion = :direccion, telefono = :telefono, email = :email
        WHERE clienteId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':id', $Cliente->id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':nombre', $Cliente->nombre, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':apellido', $Cliente->apellido, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':sexo', $Cliente->sexo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':nit', $Cliente->nit, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':direccion', $Cliente->direccion, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':telefono', $Cliente->telefono, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':email', $Cliente->email, PDO::PARAM_STR);

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
        $query = "DELETE FROM Clientes WHERE clienteId = :id";
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
        $query = "SELECT TOP(1) * From Clientes ORDER BY clienteId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
            
        if($row = $resultadoQuery->fetch())
        {
            return $row['clienteId'];
        }
        else{
            return 0;
        }
        
    }

}

?>