<?php

require_once 'models/Personal.php';
require_once 'models/Proveedor.php';

class Ingreso{

    function __construct()
    {
        $this->personal = new Personal();
        $this->proveedor = new Proveedor();
    }

    public int $id;
    public string $fecha;
    public Personal $personal;
    public Proveedor $proveedor;
    public float $total;
}

?>