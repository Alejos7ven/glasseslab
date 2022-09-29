<?php
    require_once('config.php');
    require_once('../model/user.php');
    if (isset($_POST['login'])) {
        try {
            //set PDO CONNECTION
            $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
            $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $user        = new User($connection);
            $username    = strtolower(htmlentities(addslashes($_POST['username']), ENT_QUOTES));
            if ($user->exist($username)) {
                $can     = $user->isOperational($username);
                if ($can) {
                    $user->setUsername($username);
                    $user->setPassword(htmlentities(addslashes($_POST['pass']), ENT_QUOTES));
                    $valid = $user->validateUser();
                    if ($valid) {
                        session_start();
                        $_SESSION['username']    = $user->getUsername();
                        $_SESSION["password"]    = $user->getPassword();
                        $_SESSION['type']        = $user->getType();
                        $_SESSION['last_action'] = date('Y-n-j H:i:s');
                        echo $_SESSION['username'];
                        header('location:./?logged=true');
                    }else {
                        header('location:./?logged=false');
                    }
                }else {
                    header('location:./?banned=true');
                }
            }else {
                header('location:./?logged=false');
            }
            
        } catch (Exception $e) {
            //catch errors
            echo "on line " . $e->getLine() . " " . $e->getFile() . " ";
            die("Error: " . $e->getMessage());
        }
    }else {
        header('location:./');
    }
?>