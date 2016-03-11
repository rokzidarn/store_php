<?php

require_once '../DB/MDB.php';

header('Content-Type: application/json');

$http_method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
$server_addr = filter_input(INPUT_SERVER, "SERVER_ADDR", FILTER_SANITIZE_SPECIAL_CHARS);
$php_self = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$script_uri = substr($php_self, 0, strripos($php_self, "/"));
$request = filter_input(INPUT_GET, "request", FILTER_SANITIZE_SPECIAL_CHARS);

$rules = array(
    'pbrand' => FILTER_SANITIZE_SPECIAL_CHARS,
    'pmodel' => FILTER_SANITIZE_SPECIAL_CHARS,
    'pcategory' => FILTER_SANITIZE_SPECIAL_CHARS,
    'pcolor' => FILTER_SANITIZE_SPECIAL_CHARS,
    'pprice' => FILTER_VALIDATE_FLOAT,
    'psize' => FILTER_VALIDATE_INT,
    'idproduct' => array(
        'filter' => FILTER_VALIDATE_INT,
        'options' => array('min_range' => 1)
    ),
);

function returnError($code, $message) {
    http_response_code($code);
    echo json_encode($message);
    exit();
}

if ($request != null) {
    $path = explode("/", $request);
} else {
    returnError(400, "Missing request path.");
}

if (isset($path[0])) {
    $resource = $path[0];
} else {
    returnError(400, "Missing resource.");
}

if (isset($path[1])) {
    $param = $path[1];
} else {
    $param = null;
}

switch ($resource) {
    case "products":
        if ($http_method == "GET" && $param == null) {
            // getAll
            $products = MDB::getAll();
            foreach ($products as $_ => &$product) {
                $product["uri"] = "http://" . $server_addr .
                        $script_uri . "/products/" . $product["idproduct"];
            }

            echo json_encode($products);
        } else if ($http_method == "GET" && $param != null) {
            // get
            $products = MDB::get(["id" => $param]);

            if ($products != null) {
                $product = $products[0];
                $product["uri"] = "http://" . $server_addr . $script_uri . "/products/" . $product["idproduct"];
                echo json_encode($product);
            } else {
                returnError(404, "No entry for id: " . $param);
            }
        } 
        break;
    default:
        returnError(404, "Invalid resource: " . $resource);
        break;
}

