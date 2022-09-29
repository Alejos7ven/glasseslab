<?php
    session_start();
    if (!empty($_SESSION['username'])) {
        require_once('config.php');
        require_once('../model/user.php');
        if (isset($_POST['changepsw'])) {
            try {
                //set PDO CONNECTION
                $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
                $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $user  = new User($connection);
                $can   = $user->isOperational($_SESSION['username']);
                if ($can) {
                    $old   = htmlentities(addslashes($_POST['old']), ENT_QUOTES);
                    $new   = htmlentities(addslashes($_POST['newpsw']), ENT_QUOTES); 
                    $valid = $user->updatePassword($old, $new, $_SESSION['username']);
                    if ($valid) { 
                        session_destroy();
                        header('location:./?changed=true');
                    }else {
                        header('location:./?changed=false');
                    }
                }else {
                    header('location:./?banned=true');
                } 
            } catch (Exception $e) {
                //catch errors
                echo "on line " . $e->getLine() . " " . $e->getFile() . " ";
                die("Error: " . $e->getMessage());
            }
        }else {
            header('location:./');
        }
    }
    
?>