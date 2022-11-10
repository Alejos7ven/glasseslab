<?php
    session_start();
    if (!empty($_SESSION['username'])) {
        require_once('config.php');
        require_once('../model/user.php');
        if (isset($_POST['changepsw'])) {
            try { 
                $user  = new User($dbhost, $dbuser, $dbpass);
                $can   = $user->isOperational($_SESSION['username']);
                if ($can) {
                    $old   = htmlentities(addslashes($_POST['old']), ENT_QUOTES);
                    $new   = htmlentities(addslashes($_POST['newpsw']), ENT_QUOTES); 
                    $valid = $user->updatePassword($old, $new, $_SESSION['username']);
                    if ($valid) { 
                        session_destroy();
                        header('location:../view/index.php?changed=true');
                    }else {
                        header('location:../view/index.php?changed=false');
                    }
                }else {
                    header('location:../view/index.php?banned=true');
                } 
            } catch (Exception $e) {
                //catch errors
                echo "on line " . $e->getLine() . " " . $e->getFile() . " ";
                die("Error: " . $e->getMessage());
            }
        }else {
            header('location:../view/index.php');
        }
    }
    
?>