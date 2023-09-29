<?php

require_once 'models/Proveedor.php';

class ProveedoresController extends ControllerBase{


    function __construct()
    {
        parent::__construct();
        $this->isPublic = false;
    }

    function render()
    {
        if($this->isPublic)
        {
            $this->view->render('Proveedores/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Proveedores/index');
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

    function Crear(){
        $mensaje = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $proveedor = new Proveedor();
            $proveedor->razonSocial = $_POST['razonSocial'];
            $proveedor->direccion = $_POST['direccion'];
            $proveedor->telefono = $_POST['telefono'];

            $res = $this->model->insert($proveedor);
            $id = $this->model->getLastId();
            
            if($res){
                $mensaje = "Proveedor Insertado con Exito";
            }
            else{
                $mensaje = "Hubo un erro al insertar el Proveedor";
            }
        }
        

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $proveedor
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    function Listar(){
        $res = $this->model->read();
            
        if(isset($res)){
            $this->view->model = $res;
        }   
    }

    function Actualizar(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $proveedor = new Proveedor();
            $proveedor->id = intval($_POST['id']);
            $proveedor->razonSocial = $_POST['razonSocial'];
            $proveedor->direccion = $_POST['direccion'];
            $proveedor->telefono = $_POST['telefono'];

            $res = $this->model->update($proveedor);
            
            if($res){
                $mensaje = "Proveedor Actualizado con Exito";
            }
            else{
                $mensaje = "Hubo un error al Actualizar el Proveedor";
            }
        }

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $proveedor
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    
    }

    function Eliminar(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['id']);

            $res = $this->model->delete($id);
            
            if($res){
                $mensaje = "Proveedor Eliminado con Exito";
            }
            else{
                $mensaje = "Hubo un error al Eliminar el Proveedor";
            }
        }

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $id
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    
    }
}

?>