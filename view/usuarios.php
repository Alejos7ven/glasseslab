<?php
    session_start(); 
    if (!empty($_SESSION["username"])) {
        if ($_SESSION['type'] != 1) {
            header('location:./');
        }
        # validating time inactive
        $last_action  = $_SESSION["last_action"];
        $current_time = date("Y-n-j H:i:s");
        $inactive     = (strtotime($current_time)-strtotime($last_action));
       
        //if session inactive time is 30 minutes close session
        if ($inactive>=1800) {
            header("location:../controller/logout.php");
        }
        
    }else { header('location:../view/index.php');  }
    include_once('../controller/get_users.php');
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <?php include('templates/lib.php'); ?>
    <title>Gestionar Usuarios</title>
</head>
<body>
<?php include('templates/navbar.php'); ?>

    <section class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Gestionar Usuarios</h2>
                </div>
                
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 ">
                     
                    <?php
                        echo "<span class='message-error mt-2 alert ";
                        if (isset($_GET['created']) && $_GET['created'] == 'true') { echo "alert-success'>Usuario creado con éxito."; }
                        else if (isset($_GET['created']) && $_GET['created'] == 'false') { echo "alert-danger'> Fallo al crear usuario."; }
                        else if (isset($_GET['created']) && $_GET['created'] == 'inuse') { echo "alert-info'> Este usuario ya existe."; }
                        else if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') { echo "alert-success'> Usuario borrado con éxito."; }
                        else if (isset($_GET['deleted']) && $_GET['deleted'] == 'false') { echo "alert-danger'> Fallo al borrar usuario."; }
                        else if (isset($_GET['editted']) && $_GET['editted'] == 'true') { echo "alert-success'> Usuario editado con éxito."; }
                        else if (isset($_GET['editted']) && $_GET['editted'] == 'false') { echo "alert-danger'> Fallo al editar usuario."; }
                        else if (isset($_GET['banned']) && $_GET['banned'] == 'true') { echo "alert-danger'> Tu cuenta ha sido limitada."; }
                        else { echo "' style='display:none;'>"; }
                        echo "</span>";
                    ?>
                    
                    <div class="d-inline-block" style="width: 100%;">
                        <input type="text" class="form-control search-bar" name="search-us" id="search-us" placeholder="Buscar">
                        <div class="" style="float: right ;padding-right:10px;"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-user">Registrar</button></div>
                    </div>
                    <div class="table-responsive">
                        <div class='user-main'>
                            <table class="table">
                            <thead style="background-color: #4187A9 !important; color:white;">
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CI</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $user_type = ['Administrador', 'Operador'];
                                    $modals = '';
                                    if (count($list)>0) {
                                        foreach ($list as $u) {
                                            $status = ($u['status'] != 1)?"selected":"";
                                            echo "<tr>";
                                            echo "<td>" . $u['id'] . "</td>";
                                            echo "<td>" . $u['ci'] . "</td>";
                                            echo "<td>" . $u['name'] . "</td>";
                                            echo "<td>" . $u['last_name'] . "</td>";
                                            echo "<td>" . $user_type[$u['type']-1] . "</td>";
                                            echo "<td nowrap style='padding: 0;'><button type='button' class='btn btn-warning' name='edit' id='edit" . $u['id'] . '-' . $u['id'] . "' data-bs-toggle='modal' data-bs-target='#edit-user-" . $u['id'] . "' style='display:block;width:48%;color:white;float:left;margin-right:2%;'><span class='glyphicon glyphicon-pencil'></span></button>
                                            <form action='../controller/delete_user.php' method='POST'><input type='hidden' name='user_id' id='user_id_" . $u['id'] . "' value='" . $u['id'] . "'><button type='submit' class='btn btn-danger' name='delete' id='delete_" . $u['id'] . '-' . $u['id'] . "' style='display:block;width:48%;'><span class='glyphicon glyphicon-trash'></span></button></form>
                                            </td>";
                                            echo "</tr>";
                                            $modals.= '<div class="modal fade" id="edit-user-' . $u['id'] . '" tabindex="1" aria-labelledby="edit-user" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar usuario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="../controller/edit_user.php" method="post" class="edit-user-form" name="edit-user-form" id="edit-user-form">
                                                <input type="hidden" name="user_id" id="user_id_' . $u['id'] . '" value="' . $u['id'] . '">
                                                    <div class="form-group">
                                                        <label class="form-title" for="ci">Cedula de identidad</label>
                                                        <input type="text" name="ci" id="ci" class="form-control form-input" value="' . $u['ci'] . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="name">Nombre</label>
                                                        <input type="text" name="name" id="name" class="form-control form-input" value="' . $u['name'] . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="last_name">Apellido</label>
                                                        <input type="text" name="last_name" id="last_name" class="form-control form-input" value="' . $u['last_name'] . '">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="type">Tipo de usuario</label>
                                                        <select name="type" id="type" class="form-control form-input">
                                                            <option value="2">Operador</option>
                                                            <option value="1">Administrador</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-title" for="status">¿Bloquear usuario?</label>
                                                        <select name="status" id="status" class="form-control form-input">
                                                            <option value="1">No</option>
                                                            <option value="2" ' . $status . '>Si</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary" name="edit-user" id="edit-user">Modificar</button>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            </div>';
                                        } 
                                    }else {
                                        echo "<tr><td colspan=6><center>Aún no hay usuarios.</center></td></tr>";
                                    }
                                    
                                ?>
                            </tbody>
                            </table>
                        </div>
                        <div class='user-search' style="display: none;">
                            <table class="table">
                            <thead style="background-color: #4187A9 !important; color:white;">
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CI</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="user-body"> 
                                <tr>
                                    <td colspan="6"><center>Cargando...</center></td>
                                </tr>
                            </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <?php echo $modals; ?> 
    <div class="modal fade" id="create-user" tabindex="-1" aria-labelledby="create-user" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="../controller/create_user.php" method="post" name="create-user-form" id="create-user-form">
            <div class="form-group">
                <label class='form-title' for="ci">Cedula de identidad</label>
                <input type="text" name='ci' id='ci' class='form-control form-input'>
            </div>
            <div class="form-group">
                <label class='form-title' for="name">Nombre</label>
                <input type="text" name='name' id='name' class='form-control form-input'>
            </div>
            <div class="form-group">
                <label class='form-title' for="last_name">Apellido</label>
                <input type="text" name='last_name' id='last_name' class='form-control form-input'>
            </div>
            <div class="form-group">
                <label class='form-title' for="username">Tipo de usuario</label>
                <select name='type' id='type' class='form-control form-input'>
                    <option value="2">Operador</option>
                    <option value="1">Administrador</option>
                </select>
            </div>
            <div class="form-group">
                <label class='form-title' for="pass">Contraseña</label>
                <input type="password" name='pass' id='pass' class='form-control form-input'>
            </div>
            <div class="form-group">
                <label class='form-title' for="rpass">Repetir Contraseña</label>
                <input type="password" name='rpass' id='rpass' class='form-control form-input'>
            </div> 
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" name='create' id='create'>Registrar</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <?php include('templates/footer.php'); ?>
    
    <script src="lib/bootstrap.js"></script>
    <script src="js/validate.js"></script>
    <script src="js/buscador.js" ></script>
</body>
</html>