<?php
    class Handler {
        protected $connection;
        public function __construct($connection){
            $this->setConnection($connection);
        }
        public function setConnection(PDO $connection){
            $this->connection=$connection;
        } 
        public function doQuery($sql, $return = false) {
            try {
                $result = $this->connection->query($sql);
            } catch (Exception $e) {
                return false;
            }
            if ($return) {
                return $result;
            }else {
                return true;
            }
        }
        public function getRowCount($sql){
            $result = $this->connection->query($sql);
            $amount = $result->rowCount();
            return $amount;
        }
        public function isOperational($ci) {
            $result = $this->doQuery("SELECT status FROM users WHERE ci LIKE '$ci'",true);
            $status = '';
            while($response=$result->fetch(PDO::FETCH_ASSOC)){
                $status = $response['status'];
            }
            return ($status == 1)?true : false;
        }
    }
?>