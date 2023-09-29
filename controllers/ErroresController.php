<?php
class Errores extends ControllerBase{



    function __construct()
    {
        parent::__construct();
        $this->view->mensaje = "Hubo un error en la solicitud o no existe la pagina";
        $this->view->render('Errores/index');
        echo "<p> Error al cargar el recurso </p>";
    }
}
?>