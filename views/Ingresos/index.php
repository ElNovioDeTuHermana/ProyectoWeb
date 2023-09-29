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
                   <a href="<?php echo constant('URL')?>Ingresos/LogOut">
                         <i class="fa fa-power-off fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </a>
                </li>  
            </ul>
        </nav>
        <!--FIN DE NAVBAR-->

        
        <div class="container">
    <div class="container sticky-section">
    <h1>Ingresos</h1>
    <div class="container">
        <!--<div class="input-group mb-3">
            <h2>Buscar:</h2>
            <input type="text" class="form-control w-25" placeholder="Nombre o Codigo" aria-label="Username" aria-describedby="basic-addon1">
        </div>-->
    </div>
    <div class="container">
        
        <button type="button" class="btn btn-success botonModal">
            <a href="<?php echo constant('URL') ?>Ingresos/nuevoIngreso" style="color:aliceblue">Ingreso</a>
        </button>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            
            <h2>Historial de Ingresos</h2>
            <div class="table-container">
                <!-- Contenido de la primera tabla -->
                <table class="table table-hover table-bordered" id="tablaIngresos">
                    <thead>
                        <th>FECHA</th>
                        <th>PROVEEDOR</th>
                        <th>TOTAL</th>
                    </thead>
                    
                    <tbody>
                        <?php 
                        foreach($this->model as $row){
                            echo '<tr model-data="'.$row->id.'">';
                            echo "<td>{$row->fecha}</td>";
                            echo "<td>{$row->proveedor->razonSocial}</td>";
                            echo "<td>Q{$row->total}</td>";
                            echo "</tr>";
                        }
                    
                        ?>
                    </tbody>
              </table>
            </div>
        </div>
        <div class="col-md-6">
            <h2>Detalle Ingreso</h2>
            <div class="table-container">
                <table class="table table-hover table-bordered" id="productosIngreso">
                   <thead>
                       <th>CODIGO</th>
                       <th>NOMBRE</th>
                       <th>CANTIDAD</th>
                       <th>PRECIO COMPRA</th>
                    </thead>

                    <tbody id="bodyTablaProductos">

                    </tbody>
            
            </table>
            </div>
        </div>
    </div>
</div>

<!-- Agrega los scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo constant('URL') ?>views/js/ingresosApp.js"></script>
<script src="<?php echo constant('URL') ?>views/js/table.js"></script>
</body>
</html>
