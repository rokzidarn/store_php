 <!DOCTYPE html>
 <?php
require_once '../DB/Order.php';
session_start();

if(isset( $_SESSION["clerk"])){
    $user = $_SESSION["clerk"];

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Store management</title>
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
        <h3>Management: <?=$user?></h3>
            </div>  
            <div class="row">
        <table>
            <tr>
                <td><b>Order ID &nbsp;&nbsp;</b></td>
                <td><b>User ID &nbsp;&nbsp;</b></td>
                <td><b>Total &nbsp;&nbsp;</b></td>
                <td><b>Status &nbsp;&nbsp;</b></td>               
            </tr>
            <?php 
            try {
                $allOrders = Order::getAllOrders();
                foreach ($allOrders as $key => $value): 
                    $oid = $value["idorder"];
                    $uid = $value["user_iduser"];
                    $total = $value["sum"];
                    $status = $value["status"];
            ?>
                <tr>
                    <td><?= $oid ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $uid ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $total ?> € &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $status ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <form action="order_detail.php" method="GET">
                            <input type="hidden" name="userid" value="<?=$uid?>"/>                           
                            <input type="hidden" name="oid" value="<?= $oid?>" />
                            <input class="button" type="submit" value="View order details" />
                        </form>
                    </td>                    
                </tr>
            <?php 
            endforeach;
            } catch (Exception $e) {
                echo "ERROR: {$e->getMessage()}";
            }          
            ?>
        </table> 
        <br><br>
        </div>
        </div>
        <footer>
            <a style="text-decoration: none" href="cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>
<?php
}
else {
    header("Location: ../error.php");
}
?>


