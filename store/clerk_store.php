 <!DOCTYPE html>
 <?php
require_once '../DB/Product.php';
session_start();

$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';
$user = $_SESSION["clerk"];

$validationRules = ['do' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => ["regexp" => "/^(delete|update|add)$/"]
    ],
    'id' => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => ['min_range' > 0]
    ],
    'newprice' => [
        'filter' => FILTER_VALIDATE_FLOAT,
        'options' => ['min_range' => 0.0]
    ],
    'brand' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z\s]{2,45}$/")
    ),
    'model' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z\s0-9]{1,45}$/")
    ),
    'category' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z\s]{3,18}$/")
    ),
    'color' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z]{3,18}$/")
    ),
    'price' => [
        'filter' => FILTER_VALIDATE_FLOAT,
        'options' => ['min_range' => 0.0]
    ],
    'stock' => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => ['min_range' => 1]
    ],
    'size' => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => ['min_range' => 1]
    ]
];

$data = filter_input_array(INPUT_POST, $validationRules);

$i = $data["id"]!=FALSE;
$np = $data["newprice"]!=FALSE;
$b = $data["brand"]!=FALSE;
$m = $data["model"]!=FALSE;
$c = $data["category"]!=FALSE;
$p = $data["price"]!=FALSE;
$s = $data["stock"]!=FALSE;
$sz = $data["size"]!=FALSE;
$cr = $data["color"]!=FALSE;

$cleared = $b&&$m&&$c&&$p&&$s&&$sz&&$cr;

switch ($data["do"]) {
    case "delete":
        if($i){
            try {
                $product = Product::getProduct($data["id"]);
                $pid = $product["idproduct"];
                Product::deleteProduct($pid);                     

            } catch (Exception $exc) {
                die($exc->getMessage());
            }
        }
        break;
    case "update":
        if($np){
            try {
                $product = Product::getProduct($data["id"]);
                $pid = $product["idproduct"];
                Product::updateProduct($pid, $data["newprice"]);                       

            } catch (Exception $exc) {
                die($exc->getMessage());
            }
        }
        break;
    case "add":
        if($cleared){
            try {
                Product::addProduct($data["brand"],$data["model"],$data["category"],$data["color"],$data["size"],$data["stock"], $data["price"]);                                
            } catch (Exception $exc) {
                die($exc->getMessage());
            }
        }
        break;
    default:
        break;
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Store management</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/main_css.css"/>
    </head>
    <body>
        <header>
            <h1><a style="text-decoration: none" href="../index.php">BE store</a></h1>
        </header>
        <div id="container"> 
            <div class="row">
                <h3>&nbsp;Management: <?=$user?></h3>
            </div>
            <div class="row">
        <form id="b1" action="clerk_orders.php">
            <input class="button" type="submit" value="View orders"/>
        </form>
        <form id="b2" action="../index.php#reg" method="POST">
            <input class="button" type="submit" value="Register new user"/>
        </form>
        <form id="b3" action="clerk_update.php" method="GET">
            <input class="button" type="submit" value="Update clerk"/>
        </form>
        <form id="b4" action="clerk_logout.php" method="POST">
            <input class="button" type="submit" value="Logout"/>
        </form><br><br>
        
            </div>
            <div class="row">
                <fieldset>
            <legend>Add new product</legend>
            <form action="<?=$url?>" method="POST">
                <input type="hidden" name="do" value="add" />
                <input type="hidden" name="user" value="<?=$user?>"/>  
                Brand: <input type="text" required name="brand" /> <br>
                Model <input type="text" required name="model" />  <br>
                Category: <input type="text" required name="category" />  <br>
                Color: <input type="text" required name="color" />  <br>
                Size: <input type="text" required name="size" />  <br>
                Stock<input type="text" required name="stock" />  <br>
                Price: <input type="text" required name="price" />  <br><br>
                <input class="button" type="submit" value="Add"/>
            </form>
        </fieldset>
        <br>
        </div>
            <div class="row">
        <table>
            <tr id="t">
                <td><b>&nbsp;&nbsp;&nbsp;Brand</b></td>
                <td><b>Model</b></td>
                <td><b>Category</b></td>
                <td><b>Color</b></td>
                <td><b>Size</b></td>
                <td><b>Stock</b></td>&nbsp;
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
                    $pstock = $value["pstock"];
                    $price = $value["pprice"];
            ?>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $brand ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $model ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $category ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $color ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $size ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= $pstock ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><?= number_format($price, 2, ',', '.') ?> € &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <form action="<?= $url ?>" method="POST">
                            <input type="hidden" name="do" value="update" />
                            <input type="text" required name="newprice" size="4"/>
                            <input type="hidden" name="user" value="<?=$user?>"/>                           
                            <input type="hidden" name="id" value="<?= $id?>" />
                            <input class="button" type="submit" value="Update price" />
                        </form>
                    </td>
                    <td>
                        <form action="<?= $url ?>" method="POST">
                            <input type="hidden" name="do" value="delete" />
                            <input type="hidden" name="user" value="<?=$user?>"/>                           
                            <input type="hidden" name="id" value="<?= $id?>" />
                            <input class="button" type="submit" value="Delete product" />
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


