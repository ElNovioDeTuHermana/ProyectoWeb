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
    <div class="container sticky-section cem">
    <h1>Nuevo</h1>

    <div class="d-flex flex-row align-items-center ">
        <div class="form-group mr-2">
            <label for="proveedoresSelect">Proveedor</label>
            <select name="proveedorId" id="proveedoresSelect" class="custom-select custom-select-lg" style="width: 250px;">
                <option value="0">Seleccione Un proveedor</option>
                <?php
                foreach ($this->proveedores as $row){?> 
                <option value="<?php echo $row->id; ?>"> <?php echo$row->razonSocial ; ?></option>
                <?php } ?>

            </select>
        </div>
        <button type="button" class="btn btn-success botonModal" data-toggle="modal" data-target="#miModal" id="btnAgregarProducto">
            Agregar producto
        </button>
    </div>

</div>
<br>
    </div>
    <div class="container">
        <!--AQUI AGREGUE EL DIV PARA EL CONTENIDO DE LA TABLA-->
        <div class="table-container">
        <table class="table table-hover table-bordered" id="tablaProductos">
            <thead>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>CANTIDAD</th>
                <th>PRECIO COMPRA</th>
                <th>PRECIO MINIMO VENTA</th>
                <th>PRECIO VENTA</th>
                <th>    <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalEliminar" id="btnFinalizar">
                    Finalizar
                </button></th>
            </thead>
            <tbody id="bodyTablaProductos">
            </tbody>
        </table>
        </div>
    </div>
</div>

<form method="post" id="agregarProductosModal">
      <!-- Modal -->
      <div class="modal" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="Limpiar()">&times;</button>
                </div>

                <!-- Contenido del Modal -->
                <div class="modal-body">
                    <div class=" formulario">
                        <form action="">
                            <label for="">PRODUCTO</label>
                            <select name="producto" id="selectProducto">
                            </select>
                            <button type="submit" class="btn btn-success" >Enviar</button>
                        </form>
                        </div>
                    
                </div>
                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="Limpiar()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Agrega los scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo constant('URL') ?>views/js/nuevoIngreso.js"></script>
</body>
</html>
