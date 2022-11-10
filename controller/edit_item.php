<?php
require_once('config.php');
require_once('../model/user.php');
require_once('../model/articles.php');
session_start();
if (!empty($_SESSION['username'])) {
    try { 
        $user        = new User($dbhost, $dbuser, $dbpass);
        $inv         = new Article($dbhost, $dbuser, $dbpass);
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
                if ($res) { header("location:../view/articulos.php?editted=true"); }
                else{ header("location:../view/articulos.php?editted=false"); }
                
            }else {
                header('location:../view/articulos.php?banned=true');
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