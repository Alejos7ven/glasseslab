<?php
    require_once('config.php');
    require_once('../model/user.php');
    session_start();
    if (!empty($_SESSION['username'])) {
        try {
            $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
            $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $user        = new User($connection); 
            if (isset($_POST['create'])) { 
                $can         = $user->isOperational($_SESSION['username']);
                if ($can) {
                    $user -> setCI(htmlentities(addslashes($_POST['ci']), ENT_QUOTES));
                    $aux  = new User($connection);
                    $data = $aux->getRowCount("SELECT * FROM users WHERE ci LIKE '" . $user->getCI() . "'");
                    if ($data == 0) {
                        $user->setPassword(htmlentities(addslashes($_POST['pass']), ENT_QUOTES));
                        $user->setType(htmlentities(addslashes($_POST['type']), ENT_QUOTES));
                        $user->setName(htmlentities(addslashes($_POST['name']), ENT_QUOTES));
                        $user->setLastName(htmlentities(addslashes($_POST['last_name']), ENT_QUOTES));
                        $created = $user->registerNewUser($user, $_SESSION['username']);
                        if ($created) {
                            $_SESSION['last_action'] = date('Y-n-j H:i:s');
                            header('location:./user?created=true');
                        }else {
                            header('location:./user?created=false');
                        }
                    }else {
                        header('location:./user?created=inuse');
                    }
                }else {
                    header('location:./user?banned=true');
                } 
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }else {
        header('location:./');
    }
    

?>