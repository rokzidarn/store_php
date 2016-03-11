<?php

require_once 'db_init.php';

class User {

    public static function getUserExists($username) {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT iduser FROM user WHERE email = ?");
        $stmt->bindValue(1, $username);
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    
    public static function getUserInfo($username) {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(":email", $username);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public static function getUserInfoID($id) {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT * FROM user WHERE iduser = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public static function updateUser($username,$name,$password,$address,$phone) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE user SET name=:name, password=:password, address=:address, phone=:phone WHERE email= :username");
        
        $statement->bindParam(":username", $username);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":password", $hash);
        $statement->bindParam(":address", $address);
        $statement->bindParam(":phone", $phone);
        
        $statement->execute();
    }
    
    public static function insertNewUser($name, $lname, $username, $password, $address, $phone){
        $db = DBInit::getInstance();
        
        $fname = $name . " " . $lname;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $s = 'D';
        
        $statement = $db->prepare("INSERT INTO user (email, password, name, address, phone, status) VALUES (:email, :password, :name, :address, :phone, :s)");
        $statement->bindParam(":email", $username);
        $statement->bindParam(":password", $hash);
        $statement->bindParam(":name", $fname);
        $statement->bindParam(":address", $address);
        $statement->bindParam(":phone", $phone);
        $statement->bindParam(":s", $s);
        
        $statement->execute();
    }
}

