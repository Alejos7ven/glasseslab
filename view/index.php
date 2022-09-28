<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="view/css/style.css">
    <title>Laboratorio del Lente</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4187A9;">
        <div class="container-fluid">
            <!-- <a href="#" class="navbar-brand">Navbar</a> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="./inventory" class="nav-link" aria-current="page" >Inventario</a>
                </li>
                <li class="nav-item">
                    <a href="./movement" class="nav-link">Movimientos</a>
                </li>
                <li class="nav-item">
                    <a href="./client" class="nav-link">Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="./history" class="nav-link">Historial</a>
                </li>
                <li class="nav-item">
                    <a href="./user" class="nav-link">Usuarios</a>
                </li>
            </ul>
            <ul class="navbar-nav d-flex" role="login">
                <li class="nav-item"><a href="./" class="nav-link active">Iniciar sesión</a></li>
            </ul>
            </div>
        </div>
    </nav>

    <section class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                    <form class="mt-2">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="keep">
                            <label class="form-check-label" for="keep">Mantener sesión activa</label>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Ingresar</button>
                        <center><a href="#">¿Olvidaste la contraseña? Recuperala aquí.</a></center>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <br>
    <footer class="footer bg text-light" style="min-height:2.5rem;">
    <div class="container-fluid">
        <div class="row pt-2 pb-2">
        <div class="col-12 text-left" style='margin-top: 5px;'>&copy; <?php
    $fromYear = 2022;
    $thisYear = (int)date('Y');
    echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '');?> UPTAEB. </div>
        </div>
    </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>