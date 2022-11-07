<?php
    require_once('config.php');
    require_once('../model/inventory.php');
    @session_start(); 
    if (!empty($_SESSION['username'])) {
            //set PDO CONNECTION
        $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
        $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $inv        = new Inventory($connection);
        $result = $inv->doQuery("SELECT * FROM inventario", true);
        $list    = []; 
        while($response=$result->fetch(PDO::FETCH_ASSOC)){
            $c = array(
                "id_articulo"        => $response['id_articulo'],
                "nombre"             => $response['nombre'],
                "color"              => $response['color'],
                "marca"              => $response['marca'],
                "tipo"               => $response['tipo'],
                "precio"             => $response['precio'],
                "stock"              => $response['stock']
            ); 
            array_push($list, $c); 
        }  
    }

?>