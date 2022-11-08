<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4187A9;">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand"><img src="img/PG.png" width="80px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if(isset($_SESSION['username'])) { ?>
                <li class="nav-item">
                    <a href="inventario.php" class="nav-link " aria-current="page" >Inventario</a>
                </li>
                <!-- <li class="nav-item">
                    <a href="movimientos.php" class="nav-link">Compra/Venta</a>
                </li>
                <li class="nav-item">
                    <a href="actores.php" class="nav-link">Clientes/Proveedores</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a href="pedidos.php" class="nav-link">Pedidos</a>
                </li> -->
                <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 1) {  ?> 
                <li class="nav-item">
                    <a href="usuarios.php" class="nav-link">Usuarios</a>
                </li>
                <?php }} ?>
            </ul>
            <ul class="navbar-nav d-flex" role="login">
                <?php if(isset($_SESSION['username'])) { ?><li class="nav-item"><a href="../controller/logout.php" class="nav-link ">Cerrar sesión</a></li><?php }else{ ?><li class="nav-item"><a href="./" class="nav-link ">Iniciar sesión</a></li><?php } ?>
            </ul>
            </div>
        </div>
    </nav>