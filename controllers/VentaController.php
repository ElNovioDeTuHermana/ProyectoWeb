<?php

require_once 'models/Venta.php';

class VentaController extends ControllerBase{


    function __construct()
    {
        parent::__construct();
        $this->isPublic = false;
    }

    function render()
    {
        if($this->isPublic)
        {
            $this->view->render('Venta/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Venta/index');
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

        
        if($rol == 1 || $rol == 2){
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
            $venta = new Venta();
            $productosJSON = $_POST['stocks'];

            $productos = json_decode($productosJSON, true);
            $venta->nombre = $_POST['nombre'];
            $venta->nit = $_POST['nit'];
            $venta->fecha = date('d/m/Y');
            session_name("LOGIN");
            session_start();
            $venta->trabajadorId = intval($_SESSION['TrabajadorId']);

            $res = $this->model->insert($productos, $venta);
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
            'Valor' => $id,
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    function busqueda(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $busqueda = $_POST['busqueda'];

            $res = $this->model->search($busqueda);
            
            if($res){
                $mensaje = "Categoria Actualizada con Exito";
            }
            else{
                $mensaje = "Hubo un error al Actualizar la Categoria";
            }
            
            $respuesta = array(
                'Respuesta' => isset($res),
                'Mensaje' => $mensaje,
                'Valor' => $res
            );
            
            header('Content-Type: application/json');
            echo json_encode($respuesta);
        }
    }
}

?>