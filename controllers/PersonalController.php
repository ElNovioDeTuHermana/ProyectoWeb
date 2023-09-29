<?php

require_once 'models/Personal.php';
require_once 'models/Rol.php';

class PersonalController extends ControllerBase{


    function __construct()
    {
        parent::__construct();
        $this->isPublic = false;
    }

    function render()
    {
        if($this->isPublic)
        {
            $this->view->render('Personal/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Personal/index');
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
            $personal = new Personal();
            $personal->nombre = $_POST['nombre'];
            $personal->apellido = $_POST['apellido'];
            $personal->sexo = $_POST['genero'];
            $personal->puesto = $_POST['puesto'];
            $personal->usuario = $_POST['usuario'];
            $personal->direccion = $_POST['direccion'];
            $personal->telefono = $_POST['telefono'];
            $personal->email = $_POST['email'];
            $personal->sueldo = floatval($_POST['sueldo']);
            $personal->rol = new Rol();
            $personal->rol->id = intval($_POST['rol']);
            $contrasena=$_POST['password'];

            $res = $this->model->insert($personal,$contrasena);
            $personal->id = $this->model->getLastId();
            

            
            if($res){
                $mensaje = "Personal Insertado con Exito";
            }
            else{
                $mensaje = "Hubo un erro al insertar el Personal";
            }
        }
        

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $personal
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
            $personal = new Personal();
            $personal->id = intval($_POST['id']);
            $personal->nombre = $_POST['nombre'];
            $personal->apellido = $_POST['apellido'];
            $personal->sexo = $_POST['genero'];
            $personal->puesto = $_POST['puesto'];
            $personal->usuario = $_POST['usuario'];
            $personal->direccion = $_POST['direccion'];
            $personal->telefono = $_POST['telefono'];
            $personal->email = $_POST['email'];
            $personal->sueldo = floatval($_POST['sueldo']);
            $personal->rol = new Rol();
            $personal->rol->id = intval($_POST['rol']);

            $res = $this->model->update($personal);
            
            if($res){
                $mensaje = "Personal Actualizado con Exito";
            }
            else{
                $mensaje = "Hubo un error al Actualizar el Personal";
            }
        }

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $personal
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    
    }

    function Eliminar(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['id']);

            $res = $this->model->delete($id);
            
            if($res){
                $mensaje = "Personal Eliminado con Exito";
            }
            else{
                $mensaje = "Hubo un error al Eliminar el personal";
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