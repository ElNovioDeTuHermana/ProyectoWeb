<?php

class CategoriasController extends ControllerBase{


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
            $this->view->render('Categorias/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Categorias/index');
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

        if($rol == 1){
            return true;
        }

        return false;
    }

    function Crear(){
        $mensaje = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $categoria = $_POST['nombreCategoria'];

            $res = $this->model->insert($categoria);
            $id = $this->model->getLastId();
            
            if($res){
                $mensaje = "Categoria Insertada con Exito";
            }
            else{
                $mensaje = "Hubo un erro al insertar la Categoria";
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

    function Listar(){
        $res = $this->model->read();
            
        if(isset($res)){
            $this->view->model = $res;
        }   
    }

    function Actualizar(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['categoriaId']);
            $nombre = $_POST['nombreCategoria'];

            $res = $this->model->update($id, $nombre);
            
            if($res){
                $mensaje = "Categoria Actualizada con Exito";
            }
            else{
                $mensaje = "Hubo un error al Actualizar la Categoria";
            }
        }

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $nombre
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    
    }

    function Eliminar(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['categoriaId']);

            $res = $this->model->delete($id);
            
            if($res){
                $mensaje = "Categoria Eliminada con Exito";
            }
            else{
                $mensaje = "Hubo un error al Eliminar la Categoria";
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

    function LogOut(){
        session_name("LOGIN");
        session_start();
        unset($_SESSION['TrabajadorId']);
        unset($_SESSION['Rol']);
        session_destroy();
        $this->redirect('Login/');
    }
}

?>