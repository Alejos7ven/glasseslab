<?php
    require_once('config.php');
    require_once('../model/user.php');
    @session_start(); 
    if (!empty($_SESSION['type']) && $_SESSION['type'] == 1) {
            //set PDO CONNECTION
        $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
        $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user        = new User($connection);
        $id     = htmlentities(addslashes($_POST['user_id']), ENT_QUOTES);
        $result = $user->doQuery("DELETE FROM users WHERE id=" . $id);
        if ($result) {
            header('location:./user?deleted=true');
        }else {
            header('location:./user?deleted=false');
        }
    } else { header('location:./'); }
    
?>