<?php

require_once 'views/Productos/ProductosView.php';
require_once 'models/Producto.php';

class ProductosController extends ControllerBase{


    function __construct()
    {
        parent::__construct(new ProductosView());
        $this->isPublic = false;
    }

    function loadModel($model){
        parent::loadModel($model);
        $this->view->proveedores = $this->cargarProveedores();
        $this->Listar();
    }

    function render()
    {
        if($this->isPublic)
        {
            $this->view->render('Productos/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Productos/index');
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
            $producto = new Producto();
            $producto->codigo = $_POST['codigo'];
            $producto->nombre = $_POST['nombre'];
            $producto->descripcion = $_POST['descripcion'];
            $producto->proveedor->id = intval($_POST['proveedorId']);

            $res = $this->model->insert($producto);
            $producto->id = $this->model->getLastId();
            
            if($res){
                $mensaje = "Producto Insertado con Exito";
            }
            else{
                $mensaje = "Hubo un erro al insertar el producto";
            }
        }
        

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $producto
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
            $producto = new Producto();
            $producto->id = intval($_POST['id']);
            $producto->codigo = $_POST['codigo'];
            $producto->nombre = $_POST['nombre'];
            $producto->descripcion = $_POST['descripcion'];

            $res = $this->model->update($producto);
            
            if($res){
                $mensaje = "Producto Actualizado con Exito";
            }
            else{
                $mensaje = "Hubo un error al Actualizar el producto";
            }
        }

        $respuesta = array(
            'Respuesta' => $res,
            'Mensaje' => $mensaje,
            'Valor' => $producto->id
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    
    }

    function Eliminar(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['id']);

            $res = $this->model->delete($id);
            
            if($res){
                $mensaje = "producto Eliminado con Exito";
            }
            else{
                $mensaje = "Hubo un error al Eliminar el producto";
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

    function cargarProveedores(){
        $res = $this->model->getProvedores();
        if(isset($res)){
            return $res;
        }
        else{
            return array('No definido');
        }
    }
}

?>