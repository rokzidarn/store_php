<!DOCTYPE html>
<?php
require_once '../DB/Product.php';
require_once '../DB/Order.php';
require_once '../DB/User.php';

session_start();
$user = $_SESSION["user"];
$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';
$u = User::getUserInfo($user);
$uid = $u["iduser"];
$all = 0.0;

if($isPost){
    $u = User::getUserInfo($user);
    $uid = $u["iduser"];


    $validationRules = ['do' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ["regexp" => "/^(update_cart)$/"]
        ],
        'id' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 0]
        ],
        'change' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 0]
        ]
    ];
    $data = filter_input_array(INPUT_POST, $validationRules);
    $pid = $data["id"];
    $c = $data["change"];

    if($url && $data["do"]!=FALSE){ //$c!=FALSE
        if (isset($_SESSION["cart"][$pid])) {
            if ($c != 0) {
                $_SESSION["cart"][$pid] = $c;
            } else if($c == 0) {
                unset($_SESSION["cart"][$pid]);
            }
        }   
    }
    header("Location: cart.php");
}
else {
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
        <p>&nbsp;&nbsp;&nbsp;Username: <?=$user?></p>
        <p>&nbsp;&nbsp;&nbsp;Shopping cart content:</p>
            </div> 
             <div class="row">      
        <table>
            <tr>
                <td><b>&nbsp;&nbsp;&nbsp;Brand</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Model</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Category</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Color</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Size</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Price</b></td>
                <td><b>Quantity</b></td>
            </tr>
            <?php
            $all = 0.0;
            foreach ($_SESSION["cart"] as $id => $quantity):
                $product = Product::getProduct($id);
                $all += $product["pprice"] * $quantity;
                ?>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $product["pbrand"] ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $product["pmodel"] ?></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $product["pcategory"] ?></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $product["pcolor"] ?></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $product["psize"] ?></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= number_format($product["pprice"] * $quantity, 2, ',', '.') ?> €</td>
                    <td>
                        <form action="<?= $url ?>" method="POST">
                            <input type="hidden" name="user" value="<?=$user?>"/>
                            <input type="hidden" name="do" value="update_cart" />
                            <input type="hidden" name="id" value="<?= $product["idproduct"] ?>" />
                            <input type="text" name="change" required pattern="\d" value="<?= $quantity ?>" size="2" />
                            <input class="button" type="submit" value="Update" />
                        </form>
                    </td>                   
                </tr>
            <?php endforeach; ?>
        </table>  
        <p>&nbsp;&nbsp;&nbsp;Total: <b><?= number_format($all, 2, ',', '.') ?> €</b></p>
        <form action="order.php" method="POST">
            <input type="hidden" name="user" value="<?=$user?>"/>
            <input type="hidden" name="sum" value="<?=$all?>"/>
            <input class="button" type="submit" value="Place order"/>
        </form>
             </div>
             <div class="row"><br><hr>
        <p>&nbsp;&nbsp;&nbsp;Orders history:</p>
        <table>
            <tr>
                <td><b>&nbsp;&nbsp;&nbsp;Order ID</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Total</b></td>
                <td><b>&nbsp;&nbsp;&nbsp;Status</b></td>
            </tr>

            <?php
            try {
                $orders = Order::getOrderUser($uid);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
            foreach ($orders as $o):                
                ?>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $o["idorder"] ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $o["status"] ?></td>   
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $o["sum"] ?>0 €</td>      
                    <td>
                        <form action="details.php" method="GET">
                            <input type="hidden" name="oid" value="<?=$o["idorder"]?>"/>
                            <input class="button" type="submit" value="Order details" />
                        </form>
                    </td>                   
                </tr>
            <?php endforeach; ?>   
        </table> <br>
             </div>
         </div>
         <footer>
            <a style="text-decoration: none" href="store/cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>
<?php
}