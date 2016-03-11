<?php

require_once '../DB/Order.php';
require_once '../DB/Product.php';
require_once '../DB/Orders_Item.php';
require_once '../DB/User.php';

session_start();
$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';

if(isset( $_SESSION["clerk"])){
    $user = $_SESSION["clerk"];

    if($url && $isPost){
        $rules = [
            'oid' => array(
                'filter' => FILTER_VALIDATE_INT       
            ),
            'status' => array(
                'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => array("regexp" => "/^(A|D|W|S)$/")
            )
        ];

        $sent = filter_input_array(INPUT_POST, $rules);
        if($sent["status"]!=FALSE && $sent["oid"]!=FALSE){
            try {
                Order::setOrderStatus($sent["oid"], $sent["status"]);
                header("Location: clerk_orders.php");
            } catch (Exception $ex) {
                die($exc->getMessage());
            }
        }      
    }

    $oid = filter_input(INPUT_GET, "oid", FILTER_SANITIZE_SPECIAL_CHARS);
    $uid = filter_input(INPUT_GET, "userid", FILTER_SANITIZE_SPECIAL_CHARS);
    $user_order = User::getUserInfoID($uid);
    $order = Order::getOrder($oid);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Orders</title>
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
       <h3>ORDER DETAILS</h3><br>
        <p>Email: <?=$user_order["email"]?></p>
        <p>Full name: <?=$user_order["name"]?></p>
        <p>Address: <?=$user_order["address"]?></p>
        <p>Phone number: <?=$user_order["phone"]?></p>
        <p>Order ID: <?=$oid?></p>
        <p>Order status: <?=$order["status"]?></p>   
             </div>
             <div class="row">
        <form action="<?=$url?>" method="POST"> 
            <select name="status">
                <option value="W" selected>Waiting</option>
                <option value="A">Accepted</option>
                <option value="S">Sent</option>
                <option value="D">Declined</option>
            </select>
            <input type="hidden" name="oid" value="<?= $oid?>"/>
            <input class="button" type="submit" value="Change status" />
        </form>
             </div>
             <div class="row">
        <p>Items:</p>
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
        <br><p>Order total: <?=$order["sum"]?>0 €</p>
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