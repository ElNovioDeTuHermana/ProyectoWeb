<?php

require_once 'models/Stock.php';

class StocksModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert(Ingreso $ingreso){
        $query = "INSERT INTO Ingresos (fecha, trabajadorId, proveedorId) VALUES (:fecha, :trabajadorId, :proveedorId )";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':fecha', $ingreso->fecha, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':trabajadorId', $ingreso->personal->id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':proveedorId', $ingreso->proveedor->id, PDO::PARAM_INT);
        
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
        $ingresos = array();
        $query = "SELECT i.ingresoId, i.fecha, t.trabajadorId, t.nombre, t.apellido, p.proveedorId, p.razonSocial FROM Ingresos as i
                        INNER JOIN [dbo].[Trabajadores] as t ON i.trabajadorId = t.trabajadorId
                        INNER JOIN [dbo].[Proveedores] as p ON i.proveedorId = p.proveedorId
                        ORDER BY i.ingresoId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $ingreso = new Ingreso();

            $ingreso->id=$row['ingresoId'];
            $ingreso->fecha=$row['fecha'];
            $ingreso->personal->id=$row['trabajadorId'];
            $ingreso->personal->nombre=$row['nombre'];
            $ingreso->personal->apellido=$row['apellido'];
            $ingreso->proveedor->id=$row['proveedorId'];
            $ingreso->proveedor->razonSocial = $row['razonSocial'];
            
            array_push($ingresos, $ingreso);
        }

        return $ingresos;
    }

    public function getStocks(){
        $stocks = array();
        $query = "SELECT p.productoId, p.codigo, p.nombre, s.*,
                    (SELECT STRING_AGG(razonSocial, ', ') FROM Proveedores pr
                                                            WHERE pr.proveedorId = p.proveedorId) as razonSocial
                                                            FROM Stocks as s
                    INNER JOIN Productos as p ON s.productoId = p.productoId
                    WHERE s.stock > 0";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $stock = new Stock();

            $stock->id = $row['stockId'];
            $stock->producto->codigo=$row['codigo'];
            $stock->producto->nombre=$row['nombre'];
            $stock->producto->proveedor->razonSocial=$row['razonSocial'];
            $stock->stock=$row['stock'];
            $stock->precioCompra=$row['precio_compra'];
            $stock->precioVenta=$row['precio_venta_sugerido'];
            $stock->precioVentaMinimo=$row['precio_minimo'];
            
            array_push($stocks, $stock);
        }

        return $stocks;
    }


    public function delete($id){
        $query = "DELETE FROM Ingresos WHERE ingresoId = :id";
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
        $query = "SELECT TOP(1) * From Ingresos ORDER BY ingresoId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
            
        if($row = $resultadoQuery->fetch())
        {
            return $row['ingresoId'];
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

    public function getProductosByProveedorId($id){
        $productos = array();
        $query = "SELECT * FROM Productos WHERE proveedorId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);   
        $resultadoQuery->bindParam(':id', $id, PDO::PARAM_INT);

        
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
    

}

?>