<?php

require_once 'models/Producto.php';

class ProductosModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert(Producto $producto){
        $query = "INSERT INTO Productos (codigo, nombre, descripcion, proveedorId) VALUES (:codigo, :nombre, :descripcion, :proveedorId)";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':codigo', $producto->codigo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':nombre', $producto->nombre, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':descripcion', $producto->descripcion, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':proveedorId', $producto->proveedor->id, PDO::PARAM_INT);
        
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
        $productos = array();
        $query = "SELECT * FROM Productos";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $producto = new Producto();

            $producto->id=$row['productoId'];
            $producto->codigo=$row['codigo'];
            $producto->nombre=$row['nombre'];
            $producto->descripcion=$row['descripcion'];
            
            array_push($productos, $producto);
        }

        return $productos;
    }

    public function update(Producto $producto){
        $query = "UPDATE Productos SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion
        WHERE productoId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':id', $producto->id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':codigo', $producto->codigo, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':nombre', $producto->nombre, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':descripcion', $producto->descripcion, PDO::PARAM_STR);

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
        $query = "DELETE FROM Productos WHERE productoId = :id";
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
        $query = "SELECT TOP(1) * From Productos ORDER BY productoId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
            
        if($row = $resultadoQuery->fetch())
        {
            return $row['productoId'];
        }
        else{
            return 0;
        }
        
    }

    public function getProvedores(){
        $proveedores = array();
        $query = "SELECT * FROM Proveedores";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $proveedor = new Proveedor();

            $proveedor->id=$row['proveedorId'];
            $proveedor->razonSocial=$row['razonSocial'];
            
            array_push($proveedores, $proveedor);
        }

        return $proveedores;
    }

}

?>