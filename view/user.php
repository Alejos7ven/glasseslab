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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="view/css/bootstrap-glyphicon.css">
    <link rel="stylesheet" href="view/css/style.css">
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
                    <div class="d-inline-block" style="width: 100%;">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-user" style="float: right ;">Crear</button>
                    </div>
                    <table class="table">
                    <thead style="background-color: #4187A9 !important; color:white;">
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Usuario</th>
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
                                    echo "<td>" . $u['username'] . "</td>";
                                    echo "<td>" . $user_type[$u['type']-1] . "</td>";
                                    echo "<td><form action='deleteuser' method='POST'><input type='hidden' name='user_id' id='user_id_" . $u['id'] . "' value='" . $u['id'] . "'><button type='submit' class='btn btn-danger' name='delete' id='delete'><span class='glyphicon glyphicon-trash'></span></button></form></td>";
                                    echo "</tr>";
                                } 
                            }else {
                                echo "<tr><td colspan=4><center>Aún no hay usuarios.</center></td></tr>";
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
        <form action="./create" method="post">
            <div class="form-group">
                <label class='form-title' for="username">Nombre de usuario</label>
                <input type="text" name='username' id='username' class='form-control form-input'>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>