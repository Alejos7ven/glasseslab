<?php
require_once('config.php');
require_once('../model/user.php');
require_once('../model/inventory.php');
@session_start(); 
if (!empty($_SESSION['username'])) {
        //set PDO CONNECTION
    $connection  = new PDO($dbhost, $dbuser, $dbpass);//data connection with PDO
    $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $user        = new User($connection);
    $inv         = new Inventory($connection);
    if (isset($_POST['table'])) {
        switch($_POST['table']) {
            case 'articulo':
                $param = $_POST['param'];
                $data = $inv->doQuery("SELECT * FROM inventario WHERE id_articulo=" . $param, true);
                $item = []; 
                while($response=$data->fetch(PDO::FETCH_ASSOC)){
                    $u = array(
                        "id_articulo"        => $response['id_articulo'],
                        "nombre"             => $response['nombre'],
                        "color"              => $response['color'],
                        "marca"              => $response['marca'],
                        "tipo"               => $response['tipo'],
                        "precio"             => $response['precio'],
                        "stock"              => $response['stock']
                    ); 
                    $text= '';
                    $text .= "<tr>";
                    $text .= "<td>" . $u['id_articulo'] . "</td>";
                    $text .= "<td>" . $u['nombre'] . "</td>";
                    $text .= "<td>" . $u['color'] . "</td>";
                    $text .= "<td>" . $u['marca'] . "</td>";
                    $text .= "<td>" . $u['precio'] . "</td>";
                    $text .= "<td>" . $u['tipo'] . "</td>";
                    $text .= "<td>" . $u['stock'] . "</td>";
                    $text .= "<td nowrap><form action='../controller/delete_inventory_item.php' method='POST'><input type='hidden' name='art_id' id='art_id_" . $u['id_articulo'] . "' value='" . $u['id_articulo'] . "'><button type='submit' class='btn btn-danger' name='delete' id='delete_" . $u['id_articulo'] . '-' . $u['id_articulo'] . "' style='display:block;float:left;width:49%;'><span class='glyphicon glyphicon-trash'></span></button></form>
                    <button type='button' class='btn btn-warning' name='edit' id='edit" . $u['id_articulo'] . '-' . $u['id_articulo'] . "' data-bs-toggle='modal' data-bs-target='#edit-inventory-" . $u['id_articulo'] . "' style='display:block;width:49%;color:white;'><span class='glyphicon glyphicon-pencil'></span></button></td>";
                    $text .= "</tr>"; 
                    array_push($item,array( "text"=>$text));
                }
                if (count($item)>0) { 
                    echo json_encode(array("estado"=>"ok","datos"=>$item));
                }else{
                    echo json_encode(array("estado"=>"ok","datos"=>[]));
                }
                
                break;
            case 'user':
                $param = $_POST['param'];
                $data = $inv->doQuery("SELECT * FROM users WHERE ci LIKE '%" . $param . "%'", true);
                $item = []; 
                $user_type = ['Administrador', 'Operador'];
                $text= '';
                while($response=$data->fetch(PDO::FETCH_ASSOC)){
                    $u = array(
                        "id"        => $response['id'],
                        "ci"        => $response['ci'],
                        "name"      => $response['name'],
                        "last_name" => $response['last_name'],
                        "type"      => $response['type'],
                        "status"    => $response['status']
                    ); 
                    $text.= "<tr>";
                    $text.= "<td>" . $u['id'] . "</td>";
                    $text.= "<td>" . $u['ci'] . "</td>";
                    $text.= "<td>" . $u['name'] . "</td>";
                    $text.= "<td>" . $u['last_name'] . "</td>";
                    $text.= "<td>" . $user_type[$u['type']-1] . "</td>";
                    $text.= "<td nowrap><form action='../controller/delete_user.php' method='POST'><input type='hidden' name='user_id' id='user_id_" . $u['id'] . "' value='" . $u['id'] . "'><button type='submit' class='btn btn-danger' name='delete' id='delete_" . $u['id'] . '-' . $u['id'] . "' style='display:block;float:left;width:49%;'><span class='glyphicon glyphicon-trash'></span></button></form>
                    <button type='button' class='btn btn-warning' name='edit' id='edit" . $u['id'] . '-' . $u['id'] . "' data-bs-toggle='modal' data-bs-target='#edit-user-" . $u['id'] . "' style='display:block;width:49%;color:white;'><span class='glyphicon glyphicon-pencil'></span></button></td>";
                    $text.= "</tr>"; 
                }
                array_push($item,array("text"=>$text));
                if (count($item)>0) { 
                    echo json_encode(array("estado"=>"ok", "datos"=>$item));
                }else{
                    echo json_encode(array("estado"=>"ok", "datos"=>[]));
                }
                
                break;  
            default:
                echo json_encode(array("estado"=>"error"));
                break;
        }
    } else {
        //throw $th;
        echo json_encode(array("estado"=>"error"));
    }
}else {
    echo json_encode(array("estado"=>"error"));
}

?> 