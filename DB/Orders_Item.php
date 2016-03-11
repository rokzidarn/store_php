<?php

require_once 'db_init.php';

class Orders_Item {
    
    public static function getItemsOrder($oid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM orders_item INNER JOIN product ON orders_item.product_idproduct=product.idproduct WHERE orders_idorder = :oid");
        $statement->bindParam(":oid", $oid, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
    
     public static function createOrders_Item($oid, $pid ,$q) {
         $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO orders_item (orders_idorder, product_idproduct, quantity) VALUES (:oid, :pid, :q)");
        $statement->bindParam(":oid", $oid, PDO::PARAM_INT);
        $statement->bindParam(":pid", $pid, PDO::PARAM_INT);
        $statement->bindParam(":q", $q);
        $statement->execute();          
     }        
}
