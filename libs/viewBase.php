<?php
class ViewBase {

    public $model;
    public $mensaje;

    function __construct()
    {
        
    }

    function render($nombre){
        require 'views/'.$nombre.'.php';
    }
}
?>