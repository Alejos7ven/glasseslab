<?php
    require_once('config.php');
    require_once('../model/articles.php');
    @session_start(); 
    if (!empty($_SESSION['username'])) { 
        $inv        = new Article($dbhost, $dbuser, $dbpass);
        $result = $inv->prepareQuery("SELECT * FROM articulos", array(), true);
        $list    = []; 
        foreach ($result as $response) {
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