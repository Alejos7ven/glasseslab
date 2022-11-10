<?php
    require_once('config.php');
    require_once('../model/articles.php');
    @session_start(); 
    if (!empty($_SESSION['type']) && $_SESSION['type'] == 1) { 
        $inv        = new Article($dbhost, $dbuser, $dbpass);
        $id     = htmlentities(addslashes($_POST['art_id']), ENT_QUOTES);
        $result = $inv->prepareQuery("DELETE FROM articulos WHERE id_articulo=?", array($id));
        if ($result) {
            header('location:../view/articulos.php?deleted=true');
        }else {
            header('location:../view/articulos.php?deleted=false');
        }
    } else { header('location:../view/index.php'); }
    
?>