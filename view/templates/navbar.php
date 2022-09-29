<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4187A9;">
        <div class="container-fluid">
            <!-- <a href="#" class="navbar-brand">Navbar</a> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if(isset($_SESSION['username'])) { ?>
                <li class="nav-item">
                    <a href="./inventory" class="nav-link " aria-current="page" >Inventario</a>
                </li>
                <li class="nav-item">
                    <a href="./movement" class="nav-link">Movimientos</a>
                </li>
                <li class="nav-item">
                    <a href="./client" class="nav-link">Clientes</a>
                </li>
                <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 1) {  ?>
                <li class="nav-item">
                    <a href="./history" class="nav-link">Historial</a>
                </li>
                <li class="nav-item">
                    <a href="./user" class="nav-link">Usuarios</a>
                </li>
                <?php }} ?>
            </ul>
            <ul class="navbar-nav d-flex" role="login">
                <?php if(isset($_SESSION['username'])) { ?><li class="nav-item"><a href="./logout" class="nav-link ">Cerrar sesión</a></li><?php }else{ ?><li class="nav-item"><a href="./" class="nav-link ">Iniciar sesión</a></li><?php } ?>
            </ul>
            </div>
        </div>
    </nav>