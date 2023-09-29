<?php

require_once 'views/Ingresos/IngresosView.php';
require_once 'models/Ingreso.php';
require_once 'models/Stock.php';

class IngresosController extends ControllerBase{

    public $trabajadorId;

    function __construct()
    {
        parent::__construct(new IngresosView());
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
            $this->view->render('Ingresos/index');
        }else{
            if($this->validarAcceso()){
                $this->view->render('Ingresos/index');
            }else{
                $this->redirect('Login/');
            }
        }
    }

    function validarAcceso(){
        session_name("LOGIN");
        session_start();
        $this->trabajadorId = intval($_SESSION['TrabajadorId']);
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
        date_default_timezone_set('America/Guatemala');
        $mensaje = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $ingreso = new Ingreso();
            $ingreso->fecha = date('d/m/Y');
            session_name("LOGIN");
            session_start();
            $ingreso->personal->id = intval($_SESSION['TrabajadorId']);
            $ingreso->proveedor->id = $_POST['proveedorId'];

            $productosJSON = $_POST['stocks'];

            $productos = json_decode($productosJSON, true);
            
            $res = $this->model->insert($ingreso);
            $id = $this->model->getLastId();
            
            if($res){
                $mensaje .= "INGRESO Insertado con Exito";
                if(isset($productos)){
                    foreach($productos as $producto){
                        $stock = new Stock();
                        $stock->producto->id = intval($producto['id']);
                        $stock->stock = intval($producto['cantidad']);
                        $stock->precioCompra = floatval($producto['precioCompra']);
                        $stock->precioVentaMinimo = floatval($producto['precioVentaMinimo']);
                        $stock->precioVenta = floatval($producto['precioVenta']);
                        $stockId = $this->model->insertIntoStocks($stock);
                        $this->model->insertIntoProductosIngresos($id, $stock->producto->id, $stock->stock, $stock->precioCompra, $stockId);
                    }
                }
                else{
                    $mensaje .= "No pude acceder al Objeto JSON";
                }
            }
            else{
                $mensaje .= "Hubo un erro al insertar el producto";
            }
            
        }
        
        
        $respuesta = array(
            'Respuesta' => true,
            'Mensaje' => $mensaje,
            'Valor' => $productosJSON
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

    function Eliminar(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['id']);

            $res = $this->model->delete($id);
            
            if($res){
                $mensaje = "Ingreso Eliminado con Exito";
            }
            else{
                $mensaje = "Hubo un error al Eliminar el Ingreso";
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

    function cargarProductos(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['id']);

            $res = $this->model->getProductosByProveedorId($id);
            
            if(isset($res)){
                $mensaje = "Productos devueltos con exito";
            }
            else{
                $mensaje = "Hubo un error al Eliminar el Ingreso";
            }
        }

        $respuesta = array(
            'Respuesta' => isset($res),
            'Mensaje' => $mensaje,
            'Valor' => $res
        );

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    
    }

    function nuevoIngreso(){
        $this->view->render('Ingresos/nuevoIngreso');
    }

    function productosOfIngresoById(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = intval($_POST['id']);
        }
        $res = $this->model->getProductosOfIngresoById($id);

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