<?php

class StocksController extends ControllerBase{


    function __construct()
    {
        parent::__construct();
        $this->isPublic = false;
    }

    function loadModel($model){
        parent::loadModel($model);
        $this->Listar();
    }

    function render()
    {
        if($this->isPublic)
        {
            $this->view->render('Stocks/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Stocks/index');
            }else{
                $this->redirect('Login/');
            }
        }
    }

    function validarAcceso(){
        session_name("LOGIN");
        session_start();
        $trabajadorId = $_SESSION['TrabajadorId'];
        $rol = $_SESSION['Rol'];

        
        if($rol == 1 || $rol == 3){
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
        $res = $this->model->getStocks();
            
        if(isset($res)){
            $this->view->model = $res;
        }   
    }
}

?>