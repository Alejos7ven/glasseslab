<?php
require_once('config.php');
require_once('../model/user.php');
require_once('../model/inventory.php');
session_start();
if (!empty($_SESSION['username'])) {
    try {
        $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
        $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user        = new User($connection);
        $inv         = new Inventory($connection);
        if (isset($_POST["edit-item"])) {
            $can         = $user->isOperational($_SESSION['username']);
            if ($can) {
                # editting data 
                $_SESSION['last_action'] = date('Y-n-j H:i:s');
                $inv -> setNombre(htmlentities(addslashes($_POST['nombre']), ENT_QUOTES)); 
                $inv -> setColor(htmlentities(addslashes($_POST['color']), ENT_QUOTES));
                $inv -> setMarca(htmlentities(addslashes($_POST['marca']), ENT_QUOTES));
                $inv -> setTipo(htmlentities(addslashes($_POST['tipo']), ENT_QUOTES));
                $inv -> setPrecio(htmlentities(addslashes($_POST['precio']), ENT_QUOTES));
                $inv -> setId($_POST['art_id']);
                $res  = $inv -> updateArticulo($inv);
                if ($res) { header("location:../view/inventario.php?editted=true"); }
                else{ header("location:../view/inventario.php?editted=false"); }
                
            }else {
                header('location:../view/inventario.php?banned=true');
            } 
        }else{
            echo "???";
        }
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
    }
}else {
    header('location:../view/index.php');
}
?>