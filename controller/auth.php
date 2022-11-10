<?php
    require_once('config.php');
    require_once('../model/user.php');
    if (isset($_POST['login'])) {
        try {
            //set PDO CONNECTION 
            $user        = new User($dbhost, $dbuser, $dbpass);
            $ci          = strtolower(htmlentities(addslashes($_POST['ci']), ENT_QUOTES));
            if ($user->exist($ci)) {
                $can     = $user->isOperational($ci);
                if ($can) {
                    $user->setCI($ci);
                    $user->setPassword(htmlentities(addslashes($_POST['pass']), ENT_QUOTES));
                    $valid = $user->validateUser();
                    if ($valid) {
                        session_start();
                        $_SESSION['username']    = $user->getCI();
                        $_SESSION["password"]    = $user->getPassword();
                        $_SESSION["name"]        = $user->getName();
                        $_SESSION["last_name"]   = $user->getLastName();
                        $_SESSION['type']        = $user->getType();
                        $_SESSION['last_action'] = date('Y-n-j H:i:s');
                        echo $_SESSION['username'];
                        header('location:../view/index.php?logged=true');
                    }else {
                        header('location:../view/index.php?logged=false');
                    }
                }else {
                    header('location:../view/index.php?banned=true');
                }
            }else {
                header('location:../view/index.php?logged=false');
            }
            
        } catch (Exception $e) {
            //catch errors
            echo "on line " . $e->getLine() . " " . $e->getFile() . " ";
            die("Error: " . $e->getMessage());
        }
    }else {
        header('location:../view/index.php');
    }
?>