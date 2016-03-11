<!DOCTYPE html>
<?php
require_once 'DB/Product.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to BE store</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="css/browse_css.css"/>
    </head>
    <body>
        <header>
            <h1><a style="text-decoration: none" href="index.php">BE store</a></h1>
        </header>
        <div id="container"> 
            <div class="row">
            <table>
                <tr id="t">
                    <td><b>&nbsp;&nbsp;&nbsp;Brand</b></td>
                    <td><b>Model</b></td>
                    <td><b>Category</b></td>
                    <td><b>Color</b></td>
                    <td><b>Size</b></td>
                    <td><b>Price</b></td>
                <br>
                </tr>
                <?php 
                try {
                    $allProducts = Product::getAllProducts();
                    foreach ($allProducts as $key => $value): 
                        $id = $value["idproduct"];
                        $brand = $value["pbrand"];
                        $model = $value["pmodel"];
                        $category = $value["pcategory"];
                        $color = $value["pcolor"];
                        $size = $value["psize"];
                        $price = $value["pprice"];
                ?>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $brand ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $model ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $category ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $color ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $size ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= number_format($price, 2, ',', '.') ?> €&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>                   
                    </tr>
                <?php 
                endforeach;
                } catch (Exception $e) {
                    echo "Error: {$e->getMessage()}";
                }          
                ?>
            </table> 
           <br>
       </div>
        </div>
        <footer>
            <a style="text-decoration: none" href="store/cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>