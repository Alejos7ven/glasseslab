<?php
    class Handler {
        protected $connection;
        protected $dbhost;
        protected $dbpass;
        protected $dbuser;
        public function __construct($dbhost, $dbuser, $dbpass){
            $this->setDBHost($dbhost);
            $this->setDBUser($dbuser);
            $this->setDBPass($dbpass);
            $connection  = new PDO($this->getDBHost(), $this->getDBUser(), $this->getDBPass());//data connection with PDO
            $connection  -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setConnection($connection);
        }
        public function setDBHost($dbhost) {
            $this->dbhost =$dbhost;
        }
        public function getDBHost() {
            return $this->dbhost;
        }
        public function setDBUser($dbname) {
            $this->dbuser =$dbname;
        }
        public function getDBUser() {
            return $this->dbuser;
        }
        public function setDBPass($dbpass) {
            $this->dbpass =$dbpass;
        }
        public function getDBPass() {
            return $this->dbpass;
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
        public function prepareQuery($sql, $params, $return = false) {
            try {
                $pdo = $this->connection->prepare($sql);
                $pdo->execute($params);
                if (strpos($sql,'SELECT') === false) {
                    return true;
                }else {
                    $result = $pdo->fetchAll();
                } 
            } catch (Exception $e) {
                echo $e;
                return false;
            }
            if ($return) {
                return $result;
            }else {
                return true;
            }
        }
        public function getRowCount($sql, $params=array()){
            $pdo = $this->connection->prepare($sql);
            $pdo->execute($params);
            $result = $pdo->rowCount();
            $amount = $result;
            return $amount;
        }
        public function isOperational($ci) {
            $result = $this->prepareQuery("SELECT status FROM users WHERE ci LIKE ?", array($ci),true);
            $status = '';  
            foreach($result as $response){
                $status = $response['status']; 
                echo $response['status'];
            }
            return ($status == 1)?true : false;
        }
    }
?>