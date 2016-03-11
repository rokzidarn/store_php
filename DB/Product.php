<?php

require_once 'db_init.php';

class Product {

    public $id = 0;
    public $brand = null;
    public $model = null;
    public $category = null;
    public $color = null;
    public $size = 0;
    public $price = 0;
    public $stock = 0;

    public function __construct($id, $brand, $model, $category, $color, $size, $price, $stock) {
        $this->id = $id;
        $this->brand = $brand;
        $this->model = $model;
        $this->category = $category;
        $this->color = $color;
        $this->size = $size;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function __toString() {
        return $this->brand . ' ' . $this->model . $this->category . ' ('
                . number_format($this->price, 2, ',', '.') . ' €)';
    }
    
    public static function getAllProducts() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM product");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getProduct($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM product WHERE idproduct = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }
    
    public static function deleteProduct($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM product WHERE idproduct = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        
        $statement->execute();
    }
    
    public static function updateProduct($id, $price) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("UPDATE product SET pprice = :price WHERE idproduct = :id");       
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":price", $price);
        
        $statement->execute();
    }
    
    public static function addProduct($brand, $model, $category, $color, $size, $stock, $price) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO product (pbrand, pmodel, pcategory, pcolor, psize, pstock, pprice) VALUES (:brand, :model, :category, :color, :size, :stock, :price)");
        $statement->bindParam(":brand", $brand);
        $statement->bindParam(":model", $model);
        $statement->bindParam(":category", $category);
        $statement->bindParam(":color", $color);
        $statement->bindParam(":size", $size);
        $statement->bindParam(":price", $price);
        $statement->bindParam(":stock", $stock);
        
        $statement->execute();
    }
}
