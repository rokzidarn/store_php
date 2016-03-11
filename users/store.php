<!DOCTYPE html>

<?php
require_once '../DB/Product.php';

session_start();
$user = $_SESSION["user"];
$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';

if($isPost){
    $validationRules = ['do' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ["regexp" => "/^(add_into_cart)$/"]
        ],
        'id' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 0]
        ],
        'quantity' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range' => 0]
        ]
    ];
    $data = filter_input_array(INPUT_POST, $validationRules);

    if($data["do"]!=FALSE){
        switch ($data["do"]) {
            case "add_into_cart":
                if($data["id"]!=FALSE && $data["quantity"]!=FALSE){
                    try {
                        $product = Product::getProduct($data["id"]);
                        $pid = $product["idproduct"];
                        $q = intval($data["quantity"]);

                        if (!isset($_SESSION["cart"][$pid])) {
                            $_SESSION["cart"][$pid] = $q;  
                        } else {
                            $_SESSION["cart"][$pid] += $q; 
                        }                       

                    } catch (Exception $exc) {
                        die($exc->getMessage());
                    }
                }
                break;
            default:
                break;
        }
    }
    header("Location: store.php");
} else{
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Enjoy your shopping at BE store</title>
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
            </div>
            <div class="row">
        <form id="b1" action="info.php" method="GET">
            <input  class="button" type="submit" value="My account"/>
        </form>
        <form id="b2" action="cart.php" method="GET">
            <input  class="button" type="submit" value="View cart"/>
        </form>
        <form id="b3" action="signout.php" method="GET">
            <input  class="button" type="submit" value="Sign out"/>
        </form>
            </div>
             <div class="row">
        <table>
            <tr id="t">
                <td><b>&nbsp;&nbsp;&nbsp;Brand</b></td>
                <td><b>Model</b></td>
                <td><b>Category</b></td>
                <td><b>Color</b></td>
                <td><b>Size</b></td>
                <td><b>Price</b></td>
                <td><b>Quantity</b></td>
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
                    <td>
                        <form action="<?= $url ?>" method="POST">
                            <input type="hidden" name="do" value="add_into_cart" />
                            <input type="hidden" name="user" value="<?=$user?>"/>                           
                            <input type="hidden" name="id" value="<?= $id?>" />
                            <input type="text" name="quantity" required size="2" />
                            <input class="button" type="submit" value="Add into cart" />
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
            <a style="text-decoration: none" href="store/cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>
<?php
}