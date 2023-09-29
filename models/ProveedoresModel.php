<?php

require_once 'models/Proveedor.php';

class ProveedoresModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert(Proveedor $proveedor){
        $query = "INSERT into Proveedores (razonSocial, direccion, telefono) VALUES (:razonSocial, :direccion, :telefono)";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':razonSocial', $proveedor->razonSocial, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':direccion', $proveedor->direccion, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':telefono', $proveedor->telefono, PDO::PARAM_STR);

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
        $proveedores = array();
        $query = "SELECT * FROM Proveedores";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $proveedor = new Proveedor();
            $proveedor->id = $row['proveedorId'];
            $proveedor->razonSocial = $row['razonSocial'];
            $proveedor->direccion = $row['direccion'];
            $proveedor->telefono = $row['telefono'];

            array_push($proveedores, $proveedor);
        }

        return $proveedores;
         
    }

    public function update(Proveedor $proveedor){
        $query = "UPDATE Proveedores SET razonSocial = :razonSocial, direccion = :direccion, telefono = :telefono WHERE proveedorId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':id', $proveedor->id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':razonSocial', $proveedor->razonSocial, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':direccion', $proveedor->direccion, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':telefono', $proveedor->telefono, PDO::PARAM_STR);

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
        $query = "DELETE FROM Proveedores WHERE proveedorId = :id";
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
        $query = "SELECT TOP(1) * From Proveedores ORDER BY proveedorId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
            
        if($row = $resultadoQuery->fetch())
        {
            return intval($row['proveedorId']);
        }
        else{
            return 0;
        }
        
    }

}

?>