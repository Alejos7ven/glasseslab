<?php
    require_once('config.php');
    require_once('../model/user.php');
    session_start();
    if (!empty($_SESSION['username'])) {
        try { 
            $user        = new User($dbhost, $dbuser, $dbpass); 
            if (isset($_POST['create'])) {  
                $can         = $user->isOperational($_SESSION['username']);
                if ($can) { 
                    $user -> setCI(htmlentities(addslashes($_POST['ci']), ENT_QUOTES));
                    $aux  = new User($dbhost, $dbuser, $dbpass);
                    $data = $aux->getRowCount("SELECT * FROM users WHERE ci LIKE ?", array($user->getCI()));
                    if ($data == 0) { 
                        $user->setPassword(htmlentities(addslashes($_POST['pass']), ENT_QUOTES));
                        $user->setType(htmlentities(addslashes($_POST['type']), ENT_QUOTES));
                        $user->setName(htmlentities(addslashes($_POST['name']), ENT_QUOTES));
                        $user->setLastName(htmlentities(addslashes($_POST['last_name']), ENT_QUOTES));
                        $created = $user->registerNewUser($user, $_SESSION['username']); 
                        if ($created) {
                            $_SESSION['last_action'] = date('Y-n-j H:i:s');
                            header('location:../view/usuarios.php?created=true');
                        }else {
                            header('location:../view/usuarios.php?created=false');
                        }
                    }else {
                        header('location:../view/usuarios.php?created=inuse');
                    }
                }else {
                    header('location:../view/usuarios.php?banned=true');
                } 
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }else {
        header('location:../view/index.php');
    }
    

?>