<?php

class LoginController extends ControllerBase{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->render('Login/index');
    }

    
    function ingresar(){
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        
        $ingreso = $this->model->validarLogin($usuario, $password);

        if(isset($ingreso)){
            session_name("LOGIN");
            session_start();
            $_SESSION['TrabajadorId'] = $ingreso[0];
            $_SESSION['Rol'] = $ingreso[1];
            if($ingreso[1] == 3){
                $this->redirect('Stocks/');
            }
            else{
                $this->redirect('Venta/');
            }
            
        }
        else{
            $this->redirect('Login/');
        }
        
    }
    

    

}

?>