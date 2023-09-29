<?php

require_once "models/Venta.php";
require_once "models/Stock.php";

class FacturasModel extends ModelBase {

    public function __construct()
    {
        parent::__construct();
    }

    public function read(){
        $ventas = array();
        $query = "SELECT TOP(100) v.*, 
                    (SELECT SUM(cantidad*precio_venta) FROM Productos_Ventas WHERE ventaId = v.ventaId) as total
                    FROM Ventas as v
                    LEFT JOIN Clientes as c ON v.clienteId = c.clienteId
                    INNER JOIN trabajadores as t ON v.trabajadorId = t.trabajadorId

                    ORDER BY v.ventaId Desc";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $venta = new Venta();

            $venta->id=$row['ventaId'];
            $venta->nombre=$row['nombre'];
            $venta->nit=$row['nit'];
            $venta->fecha=$row['fecha'];
            $venta->total = $row["total"];
            array_push($ventas, $venta);
        }

        return $ventas;
    }
    function productosOfVentaById(int $id){
        $stocks = array();
        $query = "SELECT * FROM Productos_Ventas as pv
                    INNER JOIN Stocks as s ON pv.stockId = s.stockId
                    INNER JOIN Productos as p ON s.productoId = p.productoId
                    WHERE pv.ventaId = :id";
        $conexion = $this->db->connect();
        $resultadoQuery = $conexion->prepare($query);   
        $resultadoQuery->bindParam(':id', $id, PDO::PARAM_INT);

        
        $resultadoQuery->execute();
        
        while ($row = $resultadoQuery->fetch()) {
            $stock = new Stock();

            $stock->producto->codigo = $row['codigo'];
            $stock->producto->nombre=$row['nombre'];
            $stock->precioVenta=$row['precio_venta'];
            $stock->stock=$row['cantidad'];
            
            array_push($stocks, $stock);
        }

        return $stocks;
    }

}

?>