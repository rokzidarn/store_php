<?php

require_once 'db_init.php';

class Clerk {

    public static function getClerk($username) {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT idclerk FROM clerk WHERE cemail = ?");
        $stmt->bindValue(1, $username);
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    
    public static function getCertificates() {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT cert FROM clerk");
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public static function getAllClerks() {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT * FROM clerk");
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    public static function getClerkInfo($username) {
        $db = DBInit::getInstance();

        $stmt = $db->prepare("SELECT * FROM clerk WHERE cemail = :cemail");
        $stmt->bindParam(":cemail", $username);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    public static function updateClerk($username,$cname,$cpassword) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE clerk SET cname=:cname, cpassword=:cpassword WHERE cemail= :username");
        
        $statement->bindParam(":username", $username);
        $hash = password_hash($cpassword, PASSWORD_DEFAULT);

        $statement->bindParam(":cname", $cname);
        $statement->bindParam(":cpassword", $hash);
        
        $statement->execute();
    }
    
    public static function clerkStatusUpdate($username,$cstatus) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE clerk SET cstatus= :c WHERE cemail= :username");
        
        $statement->bindParam(":username", $username);
        $statement->bindParam(":c", $cstatus);
        
        $statement->execute();
    }
    
    public static function insertNewClerk($cemail, $cname, $cpassword, $cert){
        $db = DBInit::getInstance();
        $hash = password_hash($cpassword, PASSWORD_DEFAULT);
        $s = 'D';

        $statement = $db->prepare("INSERT INTO clerk (cemail, cname, cpassword, cstatus, cert) VALUES (:cemail, :cname, :cpassword, :s, :cert)");
        $statement->bindParam(":cemail", $cemail);
        $statement->bindParam(":cpassword", $hash);
        $statement->bindParam(":cname", $cname);
         $statement->bindParam(":cert", $cert);
        $statement->bindParam(":s", $s);
        
        $statement->execute();
    }
}

