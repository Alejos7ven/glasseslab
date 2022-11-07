<?php
    require_once('handler.php');

    class Inventory extends Handler {
        private $id_articulo;
        private $nombre;
        private $color;
        private $marca;
        private $tipo;
        private $precio;
        private $stock; 
        //  getters and setters
        public function setId($id){
            $this->id_articulo=$id;
        } 
        public function getId(){
            return $this->id_articulo;
        } 
        public function setNombre($nombre){
            $this->nombre=$nombre;
        } 
        public function getNombre(){
            return $this->nombre;
        } 
        public function setColor($color){
            $this->color=$color;
        } 
        public function getColor(){
            return $this->color;
        } 
        public function setMarca($marca){
            $this->marca=$marca;
        } 
        public function getMarca(){
            return $this->marca;
        } 
        public function setPrecio($precio){
            $this->precio=$precio;
        } 
        public function getPrecio(){
            return $this->precio;
        } 
        public function setTipo($type){
            $this->tipo=$type;
        } 
        public function getTipo(){
            return $this->tipo;
        }
        public function setStock($stock){
            $this->stock=$stock;
        } 
        public function getStock(){
            return $this->stock;
        } 
        public function exist($id) {
            $sql    = "SELECT * FROM inventario WHERE id_articulo = " . $id . "";
            $amount = $this->getRowCount($sql);
            return ($amount != 0)? true:false;
        }
        public function getDatosArticulo($id){
            $sql    = "SELECT * FROM inventario WHERE id_articulo = " . $id . "";
            $amount = $this->getRowCount($sql);
            if ($amount != 0) {
                $result = $this->doQuery($sql, true);
                $row    = array();
                $i      = 0;
                while($response=$result->fetch(PDO::FETCH_ASSOC)){
                    $this    -> setId($response['id_articulo']);
                    $this    -> setNombre($response['nombre']);
                    $this    -> setColor($response['color']);
                    $this    -> setMarca($response['marca']);
                    $this    -> setTipo($response['tipo']);
                    $this    -> setPrecio($response['precio']); 
                    $this    -> setStock($response['stock']);
                    $row[$i] = $this;
                    $i++;
                }
                return $row;
            }else {
                return false;
            }
        }
        public function addArticulo(Inventory $inventory){
			$sql      = "INSERT INTO inventario (nombre, color, marca,tipo, precio,stock) VALUES ('" . $inventory->getNombre() . "','" . $inventory->getColor() . "','" . $inventory->getMarca() . "','" . $inventory->getTipo() . "', " . $inventory->getPrecio() . ", " . $inventory->getStock() . ")";
            $result   = $this->doQuery($sql, true); 
            // $new      = $this->getDatosArticulo($inventory->getId());
            // if (count($new) > 0) {
            //     return true;
            // }else {
            //     return false;
            // } 
            return true;
        }
        public function updateArticulo(Inventory $inventory){
            $sql = "
            UPDATE inventario SET    nombre        = '" . $inventory->getNombre() . "',
                                color         = '" . $inventory->getColor() . "',
                                marca         = '" . $inventory->getMarca() . "',
                                tipo          = '" . $inventory->getTipo() . "',
                                precio        = '" . $inventory->getPrecio() . "'
                    WHERE id_articulo = " . $inventory->getId() . "
            ";
            $result = $this->connection->query($sql); 
            return ($result)? true:false; 
        }
    }
?>