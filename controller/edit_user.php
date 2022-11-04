<?php
require_once('config.php');
require_once('../model/user.php');
session_start();
if (!empty($_SESSION['username'])) {
    try {
        $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
        $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user        = new User($connection);
        
        if (isset($_POST["edit-user"])) {
            $can         = $user->isOperational($_SESSION['username']);
                if ($can) {
                    # editting data 
                    $_SESSION['last_action'] = date('Y-n-j H:i:s');
                    $user -> setCI(htmlentities(addslashes($_POST['ci']), ENT_QUOTES));
                    $user -> setId(htmlentities(addslashes($_POST['user_id']), ENT_QUOTES));
                    $user -> setType(htmlentities(addslashes($_POST['type']), ENT_QUOTES));
                    $user -> setName(htmlentities(addslashes($_POST['name']), ENT_QUOTES));
                    $user -> setLastName(htmlentities(addslashes($_POST['last_name']), ENT_QUOTES));
                    $user -> setStatus(htmlentities(addslashes($_POST['status']), ENT_QUOTES));
                    $res  = $user -> updateUser($user);
                    if ($res) { header("location:../view/user.php?editted=true"); }
                    else{ header("location:../view/user.php?editted=false"); }
                    
                }else {
                    header('location:../view/user.php?banned=true');
                } 
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
}else {
    header('location:../view/index.php');
}
?>