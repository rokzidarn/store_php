<?php

require_once '../DB/Order.php';
require_once '../DB/Product.php';
require_once '../DB/Orders_Item.php';
require_once '../DB/User.php';

session_start();
$user = $_SESSION["user"];
if(isset( $_SESSION["user"])){

$u = User::getUserInfo($user);
$uid = $u["iduser"];
$oid = filter_input(INPUT_GET, "oid", FILTER_SANITIZE_SPECIAL_CHARS);
$order = Order::getOrder($oid);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Your shopping cart</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/browse_css.css"/>
    </head>
    <body>
       <header>
            <h1><a style="text-decoration: none" href="../index.php">BE store</a></h1>
        </header>
        <div id="container"> 
            <div class="row">
        <p>&nbsp;&nbsp;&nbsp;ORDER DETAILS</p>
        <p>&nbsp;&nbsp;&nbsp;Username: <?=$user?></p>
        <p>&nbsp;&nbsp;&nbsp;Order ID: <?=$oid?></p>
        <p>&nbsp;&nbsp;&nbsp;Order status: <?=$order["status"]?></p>
        <p>&nbsp;&nbsp;&nbsp;Order total: <?=$order["sum"]?>0 €</p>
            </div>      
       <div class="row">
        <p>&nbsp;&nbsp;&nbsp;Items:</p>
        <table>
            <tr>
                <td><b>&nbsp;&nbsp;&nbsp;Brand</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Model</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Category</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Color</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Size</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Price</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Quantity</b></td>
            </tr>
            <?php
            try {
                $items = Orders_Item::getItemsOrder($oid);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
            foreach ($items as $key => $i):                
                ?>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i["pbrand"] ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i["pmodel"] ?></td>      
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i["pcategory"] ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i["pcolor"] ?></td>      
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i["psize"] ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i["pprice"] ?>0 €</td>      
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $i["quantity"] ?></td>   
                </tr>
            <?php endforeach; ?>   
        </table> 
        <br>
       </div>
        </div>
        
        <footer>
            <a style="text-decoration: none" href="store/cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>
<?php
}
else{
    header("Location: ../error.php");
}