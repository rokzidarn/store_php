<?php
require_once '../DB/Order.php';
require_once '../DB/Product.php';
require_once '../DB/Orders_Item.php';
require_once '../DB/User.php';

session_start();
$user = $_SESSION["user"];
$sum = filter_input(INPUT_POST,"sum",FILTER_SANITIZE_SPECIAL_CHARS);
$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);

$u = User::getUserInfo($user);
$uid = $u["iduser"];
$orderid = 0;
try {
    $order = Order::createOrder($uid, $sum);
    $orderid = intval($order["moid"]);
    
} catch (PDOException $e) {
    die($e->getMessage());
}
foreach ($_SESSION["cart"] as $pid => $quantity):
    $product = Product::getProduct($pid);
    Orders_Item::createOrders_Item($orderid,$pid, $quantity);   
endforeach;

unset($_SESSION["cart"]);
$_SESSION["cart"] = array();

header("Location: cart.php");