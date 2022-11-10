<?php
    require_once('handler.php');

    class Article extends Handler {
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
            $sql    = "SELECT * FROM articulos WHERE id_articulo = ?";
            $amount = $this->getRowCount($sql, array($id));
            return ($amount != 0)? true:false;
        }
        public function getDatosArticulo($id){
            $sql    = "SELECT * FROM articulos WHERE id_articulo = ?";
            $amount = $this->getRowCount($sql, array($id));
            if ($amount != 0) {
                $result = $this->prepareQuery($sql, array($id), true);
                $row    = array();
                $i      = 0;
                foreach($result as $response){
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
        public function addArticulo(Article $articles){
            $params = array($articles->getNombre(), $articles->getColor(), $articles->getMarca(), $articles->getTipo(), $articles->getPrecio(), $articles->getStock());
			$sql      = "INSERT INTO articulos (nombre, color, marca,tipo, precio,stock) VALUES (?,?,?,?,?,?)";
            $result   = $this->prepareQuery($sql,$params, true);   
            return true;
        }
        public function updateArticulo(Article $articles){
            $params = array($articles->getNombre(), $articles->getColor(), $articles->getMarca(), $articles->getTipo(), $articles->getPrecio(), $articles->getId());
            $sql = "UPDATE articulos SET nombre = ?, color = ?, marca = ?, tipo = ?, precio = ? WHERE id_articulo = ?";
            $result = $this->prepareQuery($sql, $params); 
            return ($result)? true:false; 
        }
    }
?>