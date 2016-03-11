<?php

require_once 'AbstractDB.php';

class MDB extends AbstractDB {

    public static function get(array $id) {
        return parent::query("SELECT idproduct, pbrand, pmodel, pcategory, pcolor, psize, pprice"
                        . " FROM product"
                        . " WHERE idproduct = :id", $id);
    }

    public static function getAll() {
        return parent::query("SELECT idproduct, pbrand, pmodel, pcategory, pprice"
                        . " FROM product"
                        . " ORDER BY pmodel ASC");
    }

}
