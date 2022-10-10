<?php
    require_once('handler.php');
    class User extends Handler {
        private $id;
        private $ci;
        private $password;
        private $name;
        private $last_name;
        private $type;
        private $status; 
        //  getters and setters
        public function setId($id){
            $this->id=$id;
        } 
        public function getId(){
            return $this->id;
        } 
        public function setCI($ci){
            $this->ci=$ci;
        } 
        public function getCI(){
            return $this->ci;
        } 
        public function setPassword($psw){
            $this->password=$psw;
        } 
        public function getPassword(){
            return $this->password;
        } 
        public function setName($name){
            $this->name=$name;
        } 
        public function getName(){
            return $this->name;
        } 
        public function setLastName($name){
            $this->last_name=$name;
        } 
        public function getLastName(){
            return $this->last_name;
        } 
        public function setType($type){
            $this->type=$type;
        } 
        public function getType(){
            return $this->type;
        }
        public function setStatus($stt){
            $this->status=$stt;
        } 
        public function getStatus(){
            return $this->status;
        } 
        public function exist($ci) {
            $sql    = "SELECT * FROM users WHERE ci LIKE '" . $ci . "'";
            $amount = $this->getRowCount($sql);
            return ($amount != 0)? true:false;
        }
        public function getDataUser($ci){
            $sql    = "SELECT * FROM users WHERE ci LIKE '" . $ci . "'";
            $amount = $this->getRowCount($sql);
            if ($amount != 0) {
                $result = $this->doQuery($sql, true);
                $row    = array();
                $i      = 0;
                while($response=$result->fetch(PDO::FETCH_ASSOC)){
                    $this    -> setId($response['id']);
                    $this    -> setCI($response['ci']);
                    $this    -> setPassword($response['password']);
                    $this    -> setName($response['name']);
                    $this    -> setLastName($response['last_name']);
                    $this    -> setStatus($response['status']); 
                    $this    -> setType($response['type']);
                    $row[$i] = $this;
                    $i++;
                }
                return $row;
            }else {
                return false;
            }
        } 
        public function validateUser(){
            $ci    = $this -> getCI();
            $psw    = $this -> getPassword();
            $result = $this -> getDataUser($ci);
            if ($result) {
                foreach($result as $a){
                    if ($a->getStatus() == 0) {
                        return false;
                    }else {
                        $message = ($a->getCI() == $ci && password_verify($psw,$a->getPassword()))? true : false;
                    } 
                }
                return $message;
            }else { return false; }
        }
        public function userAreLocked($ci) {
            $aux = new User($this->connection);
            $data = $aux->getDataUser($ci);
            $type = $data[0]->getStatus();
            $response = ($type == 1) ? true : false;
            return $response;
        }
        public function registerNewUser(User $user, $creator){ 
            $allowed  = $this->userAreLocked($creator);
            if (!$allowed) { return false; }
			$ci       = strtolower($user->getCI()); 
			$pass     = $user->getPassword();
            $encrypt  = password_hash($pass, PASSWORD_DEFAULT);
            $name     = $user->getName();
            $last_name= $user->getLastName();  
            $type     = $user->getType();
			$sql      = "INSERT INTO users (ci, password, name,last_name, type) VALUES ('" . $ci . "','" . $encrypt . "','" . $name . "','" . $last_name . "', $type)";
            $result   = $this->doQuery($sql, true); 
            $new = $this->getDataUser($user->getCI());
            if (count($new) > 0) {
                return true;
            }else {
                return false;
            } 
        }
        public function validatePassword($psw, $ci){
            $result = $this->doQuery("SELECT password FROM users WHERE ci LIKE '" . $ci . "'", true);
            $row    = []; 
            while($response=$result->fetch(PDO::FETCH_ASSOC)){
                $pass = $response['password']; 
            }
            return (password_verify($psw, $pass))?true:false;
        }
        public function updatePassword($old, $newPass, $ci){
            $valid   = $this->validatePassword($old, $ci);
            if ($valid) {
                $encrypt = password_hash($newPass, PASSWORD_DEFAULT);
                $this->doQuery("UPDATE users SET password='$encrypt' WHERE ci LIKE '$ci'");
                $changed = $this->validatePassword($newPass, $ci);
                return ($changed)?true:false;
            }else{
                return false;
            }
            
        }
        public function updateUser(User $user){
            $sql = "
            UPDATE users SET    ci        = '" . $user->getCI() . "',
                                name      = '" . $user->getName() . "',
                                last_name = '" . $user->getLastName() . "',
                                type      = '" . $user->getType() . "',
                                status    = '" . $user->getStatus() . "'
                    WHERE id = " . $user->getId() . "
            ";
            $result = $this->connection->query($sql); 
            return ($result)? true:false; 
        }
    }
?>