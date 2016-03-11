<?php

require_once '../DB/Clerk.php';

$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
session_start();
$user = $_SESSION["admin"];
$cinfo = Clerk::getClerkInfo($user);

$rules = [
    'cemail' => array(
        'filter' => FILTER_VALIDATE_EMAIL
    ),
    'cname' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z\s]{3,36}$/"),
    ),
    'cpass' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
    ),
    'cert' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z\s]{2,18}$/")
    )
];

$sent = filter_input_array(INPUT_POST, $rules);    
try {
    if ($sent["cname"]!=FALSE&&$sent["cpass"]!=FALSE&&$sent["cemail"]!=FALSE&&$sent["cert"]!=FALSE) {
        $exists = Clerk::getClerkInfo($sent["cemail"]);
        if($exists == 0){
            Clerk::insertNewClerk($sent["cemail"], $sent["cname"], $sent["cpass"], $sent["cert"]);
        }
        else {
            header("Location: ../error.php");
        }
    }
    else {
        header("Location: ../error.php");
    }
} catch (PDOException $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
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
                <br><br><p>&nbsp;&nbsp;&nbsp;A new clerk has been created!</p><br><br><br><br><br><br><br><br><br><br>
            </div>             
        </div>        
        <footer>
            <a style="text-decoration: none" href="cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>

