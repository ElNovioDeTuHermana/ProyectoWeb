<?php

require_once 'models/Producto.php';

class Stock{

    function __construct()
    {
        $this->producto = new Producto();
    }

    public int $id;
    public Producto $producto;
    public int $stock;
    public float $precioCompra;
    public float $precioVentaMinimo;
    public float $precioVenta;
}

?>