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
            header("location:./logout");
        }
        
    }else { header('location:./');  }
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
                
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                     
                    <?php
                        echo "<span class='message-error mt-2 alert ";
                        if (isset($_GET['created']) && $_GET['created'] == 'true') { echo "alert-success'>Usuario creado con éxito."; }
                        else if (isset($_GET['created']) && $_GET['created'] == 'false') { echo "alert-danger'> Fallo al crear usuario."; }
                        else if (isset($_GET['created']) && $_GET['created'] == 'inuse') { echo "alert-info'> Este usuario ya existe."; }
                        else if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') { echo "alert-success'> Usuario borrado con éxito."; }
                        else if (isset($_GET['deleted']) && $_GET['deleted'] == 'false') { echo "alert-danger'> Fallo al borrar usuario."; }
                        else { echo "' style='display:none;'>"; }
                        echo "</span>";
                    ?>
                    
                    <div class="d-inline-block" style="width: 100%;">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-user" style="float: right ;">Crear</button>
                    </div>
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
                            if (count($list)>0) {
                                foreach ($list as $u) {
                                    echo "<tr>";
                                    echo "<td>" . $u['id'] . "</td>";
                                    echo "<td>" . $u['ci'] . "</td>";
                                    echo "<td>" . $u['name'] . "</td>";
                                    echo "<td>" . $u['last_name'] . "</td>";
                                    echo "<td>" . $user_type[$u['type']-1] . "</td>";
                                    echo "<td><form action='deleteuser' method='POST'><input type='hidden' name='user_id' id='user_id_" . $u['id'] . "' value='" . $u['id'] . "'><button type='submit' class='btn btn-danger' name='delete' id='delete_" . $u['id'] . '-' . $u['id'] . "'><span class='glyphicon glyphicon-trash'></span></button></form></td>";
                                    echo "</tr>";
                                } 
                            }else {
                                echo "<tr><td colspan=6><center>Aún no hay usuarios.</center></td></tr>";
                            }
                            
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="create-user" tabindex="-1" aria-labelledby="create-user" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="./create" method="post" name="create-user-form" id="create-user-form">
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
            <button type="submit" class="btn btn-primary" name='create' id='create'>Crear</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <?php include('templates/footer.php'); ?>
    <script src="view/js/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>