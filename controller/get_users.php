<?php
    require_once('config.php');
    require_once('../model/user.php');
    @session_start(); 
    if (!empty($_SESSION['username'])) {
            //set PDO CONNECTION
        $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
        $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user        = new User($connection);
        $result = $user->doQuery("SELECT * FROM users WHERE username!='root' AND username!='" . $_SESSION['username'] . "'", true);
        $list    = []; 
        while($response=$result->fetch(PDO::FETCH_ASSOC)){
            $c = array(
                "id"       => $response['id'],
                "username" => $response['username'],
                "type"   => $response['type'],
                "status"    => $response['status']
            ); 
            array_push($list, $c); 
        }  
    }
    
?>