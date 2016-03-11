<?php

require_once 'db_init.php';

class Order {
    
    public static function getAllOrders() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM orders");
        $statement->execute();

        return $statement->fetchAll();
    }
    
    public static function getOrderUser($uid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM orders WHERE user_iduser = :id");
        $statement->bindParam(":id", $uid, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetchAll();
    }

    public static function getOrder($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM orders WHERE idorder = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }
    
    public static function setOrderStatus($id,$status) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE orders SET status =:status WHERE idorder = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":status", $status);
        $statement->execute();
    }
    
     public static function createOrder($uid, $sum) {
         $db = DBInit::getInstance();
         $s = 'W';

        $statement = $db->prepare("INSERT INTO orders (user_iduser, sum, status) VALUES (:uid, :sum, :s)");
        $statement->bindParam(":uid", $uid, PDO::PARAM_INT);
        $statement->bindParam(":sum", $sum);
        $statement->bindParam(":s", $s);
        $statement->execute();  
        
        $statementg = $db->prepare("SELECT MAX(idorder) AS moid FROM orders WHERE user_iduser =:uid");
        $statementg->bindParam(":uid", $uid, PDO::PARAM_INT);
        $statementg->execute();  
        
        return $statementg->fetch();         
     }        
}
