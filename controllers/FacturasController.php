<?php

class FacturasController extends ControllerBase{


    function __construct()
    {
        parent::__construct();
        $this->isPublic = false;
    }

    function render()
    {
        if($this->isPublic)
        {
            $this->view->render('Facturas/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Facturas/index');
            }else{
                $this->redirect('Login/');
            }
        }
    }

    function loadModel($model){
        parent::loadModel($model);
        $this->Listar();
    }

    function validarAcceso(){
        session_name("LOGIN");
        session_start();
        $trabajadorId = $_SESSION['TrabajadorId'];
        $rol = $_SESSION['Rol'];

        
        if($rol == 1){
            return true;
        }

        return false;
        
    }

    function LogOut(){
        session_name("LOGIN");
        session_start();
        unset($_SESSION['TrabajadorId']);
        unset($_SESSION['Rol']);
        session_destroy();
        $this->redirect('Login/');
    }

    function Listar(){
        $res = $this->model->read();
            
        if(isset($res)){
            $this->view->model = $res;
        }
    }

    function productosOfVentaById(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['id']);
        }
        $res = $this->model->productosOfVentaById($id);

        $respuesta = array(
            'Respuesta' => isset($res),
            'Mensaje' => "Productos del Ingreso",
            'Valor' => $res
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}

?>