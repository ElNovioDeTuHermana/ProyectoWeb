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
                   <a href="<?php echo constant('URL')?>Clientes/LogOut">
                         <i class="fa fa-power-off fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </a>
                </li>  
            </ul>
        </nav>
        <!--FIN DE NAVBAR-->
    
    <div class="container mt-5">
        <div class="container sticky-section">
            <h1>Clientes</h1>
            <div class="container">
                <!--<div class="input-group mb-3">
                    <h2>Buscar:</h2>
                    <input type="text" class="form-control w-25" placeholder="Nombre o Codigo" aria-label="Username" aria-describedby="basic-addon1">
                </div>-->
                
            </div>
            <div class="container">
            <!-- Botón para abrir el modal -->
            <button type="button" class="btn btn-success botonModal" data-toggle="modal" data-target="#miModal">
                Nuevo Cliente
            </button>
            </div>
        </div>


        <div class="container">
        <h2>Lista de Clientes</h2>
            <div class="table-container">
                <table class="table table-hover table-bordered">
                    <tbody id="CuerpoTabla">
                        <tr>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>GENERO</th>
                                <th>NIT</th>
                                <th>DIRECCION</th>
                                <th>TELEFONO</th>
                                <th>EMAIL</th>
                                <th>Opciones</th>
                        </tr>
                        <?php
                            foreach ($this->model as $key => $row) {
                                echo '<tr model-target="'.$row->id.'">';
                                echo "<td>{$row->nombre}</td>";
                                echo "<td>{$row->apellido}</td>";
                                echo "<td>{$row->sexo}</td>";
                                echo "<td>{$row->nit}</td>";
                                echo "<td>{$row->direccion}</td>";
                                echo "<td>{$row->telefono}</td>";
                                echo "<td>{$row->email}</td>";
                                echo "<td>";
                                echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalEliminar" onclick="Eliminar('.$row->id.')">
                                    Eliminar
                                    </button>';
                                echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalActualizar" onclick="Actualizar('.$row->id.",'".$row->nombre."','".$row->apellido."','".$row->sexo."','".$row->nit."','".$row->direccion."','".$row->telefono."','".$row->email."')".'">
                                    Actualizar
                                    </button> ';
                                echo "</td>";
                                echo "</tr>";
                            }
                        ?>
    
                    </tbody>

                </table>
            </div>
        </div>
        <form method="post" id="actualizarCliente">
             <!--ACTUALIZAR PRODUCTO-->
                <!-- Modal -->
                <div class="modal" id="ModalActualizar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Encabezado del Modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" onclick="LimpiarActualizar()">&times;</button>
                            </div>
                            <!-- Contenido del Modal -->
                            <div class="modal-body">
                                    
                                    <h2>Actualizar cliente</h2>
                                        <label for="">NOMBRE</label>
                                        <input type="text" id="nombreActualizar" name="nombre" autocomplete="off">
                                        <label for="">APELLIDO</label>
                                        <input type="text" id="apellidoActualizar" name="apellido" autocomplete="off">
                                        <label for="">GENERO</label>
                                        <select name="genero" id="generoActualizar">
                                        <option value="">Seleccione un genero</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="femenino">Femenino</option>
                                        </select>
                                        <label for="">NIT</label>
                                        <input type="text" id="nitActualizar" name="nit" autocomplete="off">
                                        <label for="">DIRECCION</label>
                                        <input type="text" id="direccionActualizar" name="direccion" autocomplete="off">
                                        <label for="">TELEFONO</label>
                                        <input type="text" id="telefonoActualizar" name="telefono" autocomplete="off">
                                        <label for="">EMAIL</label>
                                        <input type="text" id="emailActualizar" name="email" autocomplete="off">
                                        <!--Pie de modal-->
                                        <button type="submit" class="btn btn-success">Actualizar cliente</button>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="LimpiarActualizar()">Cerrar</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

              <form method="post" id="eliminarCliente">
                    <!--ELIMINAR PRODUCTO-->
                    <!-- Modal -->
                    <div class="modal" id="ModalEliminar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Encabezado del Modal -->
                                <div class="modal-header">
                                    <img width="48" height="48" src="https://img.icons8.com/fluency/48/general-warning-sign.png" alt="general-warning-sign"/>
                                    <button type="button" class="close" data-dismiss="modal" onclick="LimpiarEliminar()">&times;</button>
                                </div>
                                <!-- Contenido del Modal -->
                                <div class="modal-body">
                                    <div class=" formulario">
                                        <h2>Desea eliminar el Cliente?</h2>
                                    </div>
                                </div>
                                <!-- Pie del Modal -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Si</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="LimpiarEliminar()">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
              </form>  

              <form method="post" id="agregarCliente" action="<?php echo constant('URL').'Clientes/Crear' ?>">
                  <!--AGREGAR CLIENTE-->
                        <!-- Modal -->
                    <div class="modal" id="miModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Encabezado del Modal -->
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" onclick="LimpiarCrear()">&times;</button>
                                </div>

                                <!-- Contenido del Modal -->
                                <div class="modal-body">
                                    <div class=" formulario">
                                        
                                        <h2>Agregar Cliente</h2>
                                            <label for="">NOMBRE</label>
                                            <input type="text" id="nombreCrear" name="nombre" autocomplete="off">
                                            <label for="">APELLIDO</label>
                                            <input type="text" id="apellidoCrear" name="apellido" autocomplete="off">
                                            <label for="">GENERO</label>
                                            <select name="genero" id="generoCrear">
                                            <option value="">Seleccione un genero</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                            <label for="">NIT</label>
                                            <input type="text" id="nitCrear" name="nit" autocomplete="off">
                                            <label for="">DIRECCION</label>
                                            <input type="text" id="direccionCrear" name="direccion" autocomplete="off">
                                            <label for="">TELEFONO</label>
                                            <input type="text" id="telefonoCrear" name="telefono" autocomplete="off">
                                            <label for="">EMAIL</label>
                                            <input type="text" id="emailCrear" name="email" autocomplete="off">
                
                        
                                            <button type="submit " class="btn btn-success">Agregar cliente</button>
                                        
                                        </div>
                                    
                                </div>

                                <!-- Pie del Modal -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="LimpiarCrear()">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
              </form>
    </div>

    <!-- Agrega los scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?php echo constant('URL') ?>views/js/clienteApp.js"></script>
    <script src="<?php echo constant('URL') ?>views/js/table.js"></script>
</body>
</html>