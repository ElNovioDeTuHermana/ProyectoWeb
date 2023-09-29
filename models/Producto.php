<?php

require_once 'models/Proveedor.php';

class Producto{

    public int $id;
    public string $codigo;
    public string $nombre;
    public string $descripcion;
    public string $imagen;
    public Proveedor $proveedor;

    function __construct()
    {
        $this->proveedor = new Proveedor();
    }
}

?>