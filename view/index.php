<?php
    session_start(); 
    if (!empty($_SESSION["username"])) {
        
        # validating time inactive
        $last_action  = $_SESSION["last_action"];
        $current_time = date("Y-n-j H:i:s");
        $inactive     = (strtotime($current_time)-strtotime($last_action));
       
        //if session inactive time is 30 minutes close session
        if ($inactive>=1800) {
            header("location:./logout");
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('templates/lib.php'); ?>
    <title>Laboratorio del Lente</title>
</head>
<body>
    <?php include('templates/navbar.php'); ?>

    <section class="wrapper">
        <div class="container">
            <div class="row">
                
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                     
                        <?php
                            echo "<span class='message-error mt-2 alert ";
                            if (isset($_GET['logged']) && $_GET['logged'] == 'false') { echo "alert-danger'> Usuario o contraseña incorrecta"; }
                            else if (isset($_GET['logged']) && $_GET['logged'] == 'true') { echo "alert-success'> Inicio de sesión exitoso"; }
                            else if (isset($_GET['banned']) && $_GET['banned'] == 'true') { echo "alert-info'> Tu cuenta esta baneada."; }
                            else if (isset($_GET['changed']) && $_GET['changed'] == 'true') { echo "alert-success'> Tu contraseña ha sido cambiada."; }
                            else if (isset($_GET['changed']) && $_GET['changed'] == 'false') { echo "alert-danger'> Fallo al cambiar contraseña."; }
                            else if (isset($_GET['banned']) && $_GET['banned'] == 'true') { echo "alert-danger'> Tu cuenta ha sido limitada."; }
                            else { echo "' style='display:none;'>"; }
                            echo "</span>";
                        ?>
                        
                    <?php if (isset($_SESSION['username'])) { ?>
                        <h2>Bienvenido, <?php echo $_SESSION['name'] . " " . $_SESSION['last_name']; ?>. </h2>
                        <p>
                            Privilegios: <?php echo ($_SESSION['type'] == 1)?'Administrador':'Operador'; ?>.<br>
                            Cedula de Identidad:  <?php echo $_SESSION['username']; ?>.
                        </p>
                        <form action="./changepsw" method="post" name='change' id='change'>
                            <h3>Cambia tu contraseña</h3>
                            <div class="form-group">
                                <label class='form-title' for="old">Contraseña actual</label>
                                <input type="password" name='old' id='old' class='form-control form-input'>
                            </div>
                            <div class="form-group">
                                <label class='form-title' for="newpsw">Contraseña nueva</label>
                                <input type="password" name='newpsw' id='newpsw' class='form-control form-input'>
                            </div>
                            <div class="mb-3 form-group">
                                <label class='form-title' for="rnewpsw">Repetir contraseña</label>
                                <input type="password" name='rnewpsw' id='rnewpsw' class='form-control form-input'>
                            </div>
                            <button type="submit" class="btn btn-success" name='changepsw' id='changepsw' style="width: 100%;">Cambiar</button>
                        </form>

                    <?php }else{  ?>
                    <form action="auth" class="mt-2" method="POST" name="login-form" id="login-form">
                        <div class="mb-3">
                            <label for="ci" class="form-label">Cedula de identidad</label>
                            <input type="text" class="form-control" id="ci" name="ci">
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="pass" name="pass">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="keep" id="keep">
                            <label class="form-check-label" for="keep">Mantener sesión activa</label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="login" name="login" style="width: 100%;">Ingresar</button>
                        
                    </form>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </section>

    <?php include('templates/footer.php'); ?>
    <script src="view/js/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>