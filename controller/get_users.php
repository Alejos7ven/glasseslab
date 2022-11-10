<?php
    require_once('config.php');
    require_once('../model/user.php');
    @session_start();  
    if (!empty($_SESSION['username'])) { 
        $user        = new User($dbhost, $dbuser, $dbpass); 
        $result = $user->prepareQuery("SELECT * FROM users WHERE ci!='root' AND ci!=?", array($_SESSION['username']), true);
        $list    = [];
        foreach ($result as $response) {
            $c = array(
                "id"        => $response['id'],
                "ci"        => $response['ci'],
                "name"      => $response['name'],
                "last_name" => $response['last_name'],
                "type"      => $response['type'],
                "status"    => $response['status']
            ); 
            array_push($list, $c); 
        } 
    }
    
?>