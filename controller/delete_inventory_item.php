<?php
    require_once('config.php');
    require_once('../model/inventory.php');
    @session_start(); 
    if (!empty($_SESSION['type']) && $_SESSION['type'] == 1) {
            //set PDO CONNECTION
        $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
        $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $inv        = new Inventory($connection);
        $id     = htmlentities(addslashes($_POST['art_id']), ENT_QUOTES);
        $result = $inv->doQuery("DELETE FROM inventario WHERE id_articulo=" . $id);
        if ($result) {
            header('location:../view/inventario.php?deleted=true');
        }else {
            header('location:../view/inventario.php?deleted=false');
        }
    } else { header('location:../view/index.php'); }
    
?>