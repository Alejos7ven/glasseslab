<?php
    session_start(); 
    if (!empty($_SESSION["username"])) {
        
        # validating time inactive
        $last_action  = $_SESSION["last_action"];
        $current_time = date("Y-n-j H:i:s");
        $inactive     = (strtotime($current_time)-strtotime($last_action));
       
        //if session inactive time is 30 minutes close session
        if ($inactive>=1800) {
            header("location:../controller/logout.php");
        }
        
    }else { header('location:../view/index.php');  }
    include_once('../controller/get_inventory.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('templates/lib.php'); ?>  
    <title>Gestionar Inventario</title>
</head>
<body>
    <?php include('templates/navbar.php'); ?>

    <section class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Gestionar Inventario</h2>
                </div>
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                    <?php
                        echo "<span class='message-error mt-2 alert ";
                        if (isset($_GET['created']) && $_GET['created'] == 'true') { echo "alert-success'>Artículo agregado con éxito."; }
                        else if (isset($_GET['created']) && $_GET['created'] == 'false') { echo "alert-danger'> Fallo al agregar artículo."; }
                        else if (isset($_GET['created']) && $_GET['created'] == 'inuse') { echo "alert-info'> Este artículo ya existe."; }
                        else if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') { echo "alert-success'> Artículo borrado con éxito."; }
                        else if (isset($_GET['deleted']) && $_GET['deleted'] == 'false') { echo "alert-danger'> Fallo al borrar artículo."; }
                        else if (isset($_GET['editted']) && $_GET['editted'] == 'true') { echo "alert-success'> Artículo editado con éxito."; }
                        else if (isset($_GET['editted']) && $_GET['editted'] == 'false') { echo "alert-danger'> Fallo al editar artículo."; }
                        else if (isset($_GET['banned']) && $_GET['banned'] == 'true') { echo "alert-danger'> Tu cuenta ha sido limitada."; }
                        else { echo "' style='display:none;'>"; }
                        echo "</span>";
                    ?>
                    <div class="d-inline-block" style="width: 100%;">
                        <input type="number" class="form-control search-bar" name="search-art" id="search-art" placeholder="Buscar">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-item" style="float: right ;">Agregar</button>
                    </div>
                    <div class="table-responsive">
                        <div class='articulo-main'>
                            <table class="table">
                            <thead style="background-color: #4187A9 !important; color:white;">
                                <tr>
                                <th scope="col">ID</th> 
                                <th scope="col">Nombre</th>
                                <th scope="col">Color</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                    $modals = '';
                                    if (count($list)>0) {
                                        foreach ($list as $u) { 
                                            echo "<tr>";
                                            echo "<td>" . $u['id_articulo'] . "</td>";
                                            echo "<td>" . $u['nombre'] . "</td>";
                                            echo "<td>" . $u['color'] . "</td>";
                                            echo "<td>" . $u['marca'] . "</td>";
                                            echo "<td>" . $u['precio'] . "</td>";
                                            echo "<td>" . $u['tipo'] . "</td>";
                                            echo "<td>" . $u['stock'] . "</td>";
                                            echo "<td nowrap><form action='../controller/delete_inventory_item.php' method='POST'><input type='hidden' name='art_id' id='art_id_" . $u['id_articulo'] . "' value='" . $u['id_articulo'] . "'><button type='submit' class='btn btn-danger' name='delete' id='delete_" . $u['id_articulo'] . '-' . $u['id_articulo'] . "' style='display:block;float:left;width:49%;'><span class='glyphicon glyphicon-trash'></span></button></form>
                                            <button type='button' class='btn btn-warning' name='edit' id='edit" . $u['id_articulo'] . '-' . $u['id_articulo'] . "' data-bs-toggle='modal' data-bs-target='#edit-inventory-" . $u['id_articulo'] . "' style='display:block;width:49%;color:white;'><span class='glyphicon glyphicon-pencil'></span></button></td>";
                                            echo "</tr>";
                                            $modals.= '<div class="modal fade" id="edit-inventory-' . $u['id_articulo'] . '" tabindex="1" aria-labelledby="edit-user" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Editar articulo</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="../controller/edit_inventory_item.php" method="post" class="edit-item-form" name="edit-item-form" id="edit-item-form">
                                                <input type="hidden" name="art_id" id="art_id_' . $u['id_articulo'] . '" value="' . $u['id_articulo'] . '">
                                                    <div class="form-group">
                                                        <label class="form-title" for="nombre">Nombre</label>
                                                        <input type="text" name="nombre" id="nombre" class="form-control form-input" value="' . $u['nombre'] . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="color">Color</label>
                                                        <input type="text" name="color" id="color" class="form-control form-input" value="' . $u['color'] . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="marca">Marca</label>
                                                        <input type="text" name="marca" id="marca" class="form-control form-input" value="' . $u['marca'] . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="precio">Precio</label>
                                                        <input type="text" name="precio" id="precio" class="form-control form-input" value="' . $u['precio'] . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="tipo">Tipo de articulo</label>
                                                        <select name="tipo" id="tipo" class="form-control form-input">
                                                            <option value="lente">Lente</option>
                                                            <option value="accesorio">Accesorio</option>
                                                        </select>
                                                    </div> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary" name="edit-item" id="edit-item">Editar</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            </div>';
                                        }  
                                    }else {
                                        echo "<tr><td colspan=8><center>Aún no hay artículos.</center></td></tr>";
                                    }
                                    
                                ?>
                                
                            </tbody>
                            </table>
                        </div>  
                        <div class='articulo-search' style="display: none;">
                            <table class="table">
                            <thead style="background-color: #4187A9 !important; color:white;">
                                <tr>
                                <th scope="col">ID</th> 
                                <th scope="col">Nombre</th>
                                <th scope="col">Color</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="articulo-body"> 
                                <tr>
                                    <td colspan="8"><center>Cargando...</center></td>
                                </tr>
                            </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        <div>
    </section>
    <?php echo $modals; ?>
    <div class="modal fade" id="create-item" tabindex="1" aria-labelledby="create-item" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"> 
                    <h5 class="modal-title" id="exampleModalLabel">Agregar articulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../controller/create_inventory_item.php" method="post" name="create-item-form" id="create-item-form">
                    <div class="form-group">
                        <label class="form-title" for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-title" for="color">Color</label>
                        <input type="text" name="color" id="color" class="form-control form-input" >
                    </div>
                    <div class="form-group">
                        <label class="form-title" for="marca">Marca</label>
                        <input type="text" name="marca" id="marca" class="form-control form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-title" for="precio">Precio</label>
                        <input type="text" name="precio" id="precio" class="form-control form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-title" for="tipo">Tipo de articulo</label>
                        <select name="tipo" id="tipo" class="form-control form-input">
                            <option value="lente">Lente</option>
                            <option value="accesorio">Accesorio</option>
                        </select>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" name="create-item-button" id="create-item-button">Agregar</button>
                    </form>
                </div>
            </div> 
        </div>
    </div>
    <?php include('templates/footer.php'); ?>
    <script src="lib/bootstrap.js" ></script>
    <script src="js/buscador.js" ></script>
    <script src="js/validate.js" ></script>
</body>
</html>