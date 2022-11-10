<?php
    require_once('config.php');
    require_once('../model/user.php');
    @session_start(); 
    if (!empty($_SESSION['type']) && $_SESSION['type'] == 1) { 
        $user        = new User($dbhost, $dbuser, $dbpass);
        $id     = htmlentities(addslashes($_POST['user_id']), ENT_QUOTES);
        $result = $user->prepareQuery("DELETE FROM users WHERE id=?",array($id));
        if ($result) {
            header('location:../view/usuarios.php?deleted=true');
        }else {
            header('location:../view/usuarios.php?deleted=false');
        }
    } else { header('location:../view/index.php'); }
    
?>