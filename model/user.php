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
            $sql    = "SELECT * FROM users WHERE ci LIKE ?";
            $amount = $this->getRowCount($sql, array($ci));
            return ($amount != 0)? true:false;
        }
        public function getDataUser($ci){
            $sql    = "SELECT * FROM users WHERE ci LIKE ?";
            $amount = $this->getRowCount($sql, array($ci));
            if ($amount != 0) {
                $result = $this->prepareQuery($sql,array($ci), true);
                $row    = array();
                $i      = 0;
                foreach($result as $response){
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
                        // $message = ($a->getCI() == $ci && password_verify($psw,$a->getPassword()))? true : false;
                        $message = ($a->getCI() == $ci && $psw == $a->getPassword())? true : false;
                    } 
                }
                return $message;
            }else { return false; }
        }
        public function userIsLocked($ci) {
            $aux = new User($this->getDBHost(), $this->getDBUser(), $this->getDBPass());
            $data = $aux->getDataUser($ci);
            $type = $data[0]->getStatus();
            $response = ($type == 1) ? true : false;
            return $response;
        }
        public function registerNewUser(User $user, $creator){ 
            $allowed  = $this->userIsLocked($creator);
            if (!$allowed) { return false; } 
			$ci       = strtolower($user->getCI()); 
			$pass     = $user->getPassword();
            // $encrypt  = password_hash($pass, PASSWORD_DEFAULT);
            $name     = $user->getName();
            $last_name= $user->getLastName();  
            $type     = $user->getType();
            $params   = array($ci, $pass, $name, $last_name, $type); 
			$sql      = "INSERT INTO users (ci, password, name,last_name, type) VALUES (?,?,?,?, ?)";
            $result   = $this->prepareQuery($sql,$params, true); 
            $new = $this->getDataUser($user->getCI()); 
            if (count($new) > 0) {
                return true;
            }else {
                return false;
            } 
        }
        public function validatePassword($psw, $ci){
            $result = $this->prepareQuery("SELECT password FROM users WHERE ci LIKE ?",array($ci), true);
            $row    = []; 
            foreach($result as $response){
                $pass = $response['password']; 
            }
            // return (password_verify($psw, $pass))?true:false;
            return ($pass == $psw)?true:false;
        }
        public function updatePassword($old, $newPass, $ci){
            $valid   = $this->validatePassword($old, $ci);
            if ($valid) {
                // $encrypt = password_hash($newPass, PASSWORD_DEFAULT); 
                $this->prepareQuery("UPDATE users SET password=? WHERE ci LIKE ?", array($newPass, $ci));
                $changed = $this->validatePassword($newPass, $ci);
                return ($changed)?true:false;
            }else{
                return false;
            }
            
        }
        public function updateUser(User $user){
            $sql = "UPDATE users SET ci = ?, name = ?, last_name = ?, type = ?, status = ? WHERE id = ?";
            $params = array($user->getCI(), $user->getName(), $user->getLastName(), $user->getType(), $user->getStatus(), $user->getId());
            $result = $this->prepareQuery($sql, $params);
            return ($result)? true:false; 
        }
    }
?>