<?php

require_once 'models/Stock.php';
require_once 'models/Venta.php';

class VentaModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($productos, Venta $venta){
        $query = "INSERT INTO [dbo].[Ventas] (trabajadorId, fecha, nombre, nit)
                    VALUES (:trabajadorId, CONVERT(datetime, :fecha ,103), :nombre, :nit)";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':fecha', $venta->fecha, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':trabajadorId', $venta->trabajadorId, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':nombre', $venta->nombre, PDO::PARAM_STR);
        $resultadoQuery->bindParam(':nit', $venta->nit, PDO::PARAM_STR);
        
        $resultadoQuery->execute();
        
        if($resultadoQuery->rowCount() == 1)
        {
            $id = $this->getLastId();
            foreach($productos as $producto){
                $this->insertProductosVenta($producto,$id);
                $this->restarStock($producto);
            }
            return true;
        }
        else{
            return false;
        }
    }

    private function insertProductosVenta($producto, $ventaId){
        
        $query = "INSERT INTO Productos_Ventas (ventaId, stockId, cantidad, precio_venta)
                    VALUES (:ventaId, :stockId, :cantidad, :precio_venta)";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $resultadoQuery->bindParam(':ventaId', $ventaId, PDO::PARAM_INT);
        $id = intval($producto["id"]);
        $cantidad = intval($producto["cantidad"]);
        $precioVenta = floatval($producto["precioVenta"]);
        $resultadoQuery->bindParam(':stockId', $id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':precio_venta', $precioVenta, PDO::PARAM_STR);

        $resultadoQuery->execute();
    }

    private function restarStock($producto){
        $query = "UPDATE stocks SET stock = ( (SELECT stock FROM stocks WHERE stockId = :stockId) - :cantidad) WHERE stockId = :stockId2";
    
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);
        $id = intval($producto["id"]);
        $cantidad = intval($producto["cantidad"]);
        $resultadoQuery->bindParam(':stockId', $id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':stockId2', $id, PDO::PARAM_INT);
        $resultadoQuery->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $resultadoQuery->execute();
    }

    public function search($busqueda){
        $stocks = array();
        $query = "SELECT * FROM [dbo].[Productos] as p
                    INNER JOIN [dbo].[Stocks] as s ON p.productoId = s.productoId
                    WHERE p.nombre like '%{$busqueda}%' OR p.codigo like '%{$busqueda}%'";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $stock = new Stock();
            $stock->id = intval($row['stockId']);
            $stock->producto->id = intval($row['productoId']);
            $stock->producto->codigo = $row['codigo'];
            $stock->producto->nombre = $row['nombre'];
            $stock->stock = intval($row['stock']);
            $stock->precioCompra = floatval($row['precio_compra']);
            $stock->precioVenta = floatval($row['precio_venta_sugerido']);
            $stock->precioVentaMinimo = floatval($row['precio_minimo']);
            array_push($stocks, $stock);
        }

        return $stocks;
    }

    public function getLastId(){
        $query = "SELECT TOP(1) * From Ventas ORDER BY ventaId desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
            
        if($row = $resultadoQuery->fetch())
        {
            return $row['ventaId'];
        }
        else{
            return 0;
        }
        
    }
}

?>