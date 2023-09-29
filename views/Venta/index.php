<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Electronica</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>views/css/estilosGenerales.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>views/css/background.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>views/css/navBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="shortcut icon" href="/views/img/icon.png" type="image/x-icon">
</head>
<body>
        <!--INICIO DE NAVBAR-->
        <nav class="main-menu">
            <ul>
                <li>
                    <a href="<?php echo constant('URL') ?>Categorias">
                        <i class="fa fa-list fa-2x"></i>
                        <span class="nav-text">
                           Categoria
                        </span>
                    </a>
                  
                </li>
                <li class="has-subnav">
                    <a href="<?php echo constant('URL')?>Clientes">
                        <i class="fa fa-hands-helping fa-2x"></i>

                     
                        <span class="nav-text">
                            Clientes
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="<?php echo constant('URL')?>Facturas">
                        <i class="fa fa-book fa-2x"></i>
                        <span class="nav-text">
                            Facturas
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="<?php echo constant('URL')?>Ingresos">
                        <i class="fa fa-coins fa-2x"></i>
                        <span class="nav-text">
                            Ingresos
                        </span>
                    </a>
                   
                </li>
                <li>
                    <a href="<?php echo constant('URL')?>Personal">
                        
<i class="fa fa-users fa-2x"></i>
                        <span class="nav-text">
                            Personal
                        </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo constant('URL')?>Productos">
                        <i class="fa fa-tag fa-2x"></i>

                        <span class="nav-text">
                           Productos
                        </span>
                    </a>
                </li>
                <li>
                   <a href="<?php echo constant('URL')?>Proveedores">
                    <i class="fa fa-truck fa-2x"></i>

                        <span class="nav-text">
                            Proveedores
                        </span>
                    </a>
                </li>
                <li>
                   <a href="<?php echo constant('URL')?>Stocks">
                    <i class="fa fa-cubes fa-2x"></i>

                        <span class="nav-text">
                            Stocks
                        </span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo constant('URL')?>Venta">
                        <i class="fa fa-dollar-sign fa-2x"></i>

                        <span class="nav-text">
                            Venta
                        </span>
                    </a>
                </li>
            </ul>
    
            <ul class="logout">
                <li>
                   <a href="#">
                         <i class="fa fa-power-off fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </a>
                </li>  
            </ul>
        </nav>
        <!--FIN DE NAVBAR-->
        <div class="content-container">
<div class="container">

    <div class="container sticky-section">
    <h1>Ventas</h1>
    <div class="container">
        <div class="input-group mb-3">
            <input id="inputBuscar" type="text" class="form-control" placeholder="Busca aqui" aria-describedby="basic-addon2" >
            <div class="input-group-append">
              <button class="btn btn-outline-secondary " type="button" style="height: 45px;" id="btnBuscar">
                <img src="<?php echo constant('URL') ?>views/img/icons8-búsqueda.gif" style="height: 20px;" alt="">
            </button>
            </div>
          </div>
    </div>
    </div>
    <div class="table-container">
        <table class="table table-hover table-bordered" id="tablaProductos">
            <thead>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>PRECIO VENTA</th>
                <th>STOCK</th>
                <th>Opcion</th>
            </thead>

            <tbody id="bodyTablaProductos">
            </tbody>

        </table>
    </div>

    <div class="container centrar">
        <div class="container sticky-section">
        <h2>Productos Añadidos</h2>
        <button id="btnFinalizar" type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalActualizar">
            Finalizar
        </button>
    </div>
    </div>
 

    <div class="table-container">   
        <table class="table table-hover table-bordered">
            <thead>
                <th>CANTIDAD</th>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>PRECIO</th>
                <th>Opcion</th>
            </thead>

            <tbody id="bodyProductosVenta">
            </tbody>

        </table>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-2">
                <div class="input-group mb-3">
                    <span class="input-group-text">Q</span>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <span class="input-group-text">.00</span>
                </div>
            </div>
        </div>
    </div>

    <!--DATOS DEL CLIENTE-->
                <!-- Modal -->
                <form method="post" id="datosCliente">
                <div class="modal" id="ModalActualizar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Encabezado del Modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" onclick="LimpiarActualizar()">&times;</button>
                            </div>
        
                            <!-- Contenido del Modal -->
                            <div class="modal-body">
                                <div class=" formulario">
                                    <h2>Actualizar Proveedor</h2>
                                        <label for="">NOMBRE</label>
                                        <input type="text" id="clienteNombre" name="nombre">
                                        <label for="">NIT</label>
                                        <input type="text" id="clienteNit" name="nit">
                                    
                                        <button type="submit" class="btn btn-success">
                                            Enviar Datos
                                        </button>
                                    </div>
                                
                            </div>
        
                            <!-- Pie del Modal -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="LimpiarActualizar()">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

               </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo constant('URL') ?>views/js/ventaApp.js"></script>
<script src="<?php echo constant('URL') ?>views/js/table.js"></script> 
</body>
</html>