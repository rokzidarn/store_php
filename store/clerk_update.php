<?php
require_once '../DB/Clerk.php';

$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
session_start();
$user = $_SESSION["clerk"];
$cinfo = Clerk::getClerkInfo($user);

$rules = [
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
    'npass' => array(
        'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
    )
];

    $sent = filter_input_array(INPUT_POST, $rules);    
    try {
        if ($sent["cname"]!=FALSE&&$sent["cpass"]!=FALSE&&$sent["npass"]!=FALSE) {
            $db = Clerk::getClerkInfo($user);
            if(password_verify($sent["cpass"], $db["cpassword"])){
                Clerk::updateClerk($user, $sent["cname"], $sent["npass"]);
                header("Location: clerk_store.php");
            }
            else {
                header("Location: ../error.php");
            }
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Update clerk info</title>
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
        <p>Clerk username: <?=$user?></p>
             </div>
             <div class="row">
        <br>
        <fieldset>
            <legend>Clerk information:</legend>
            <form action="<?=$url?>" method="POST">
                <input type="hidden" name="user" value="<?=$user?>"/>
                Name: <input type="text" name="cname" required value="<?=$cinfo["cname"]?>"><br>
                Current password: <input type="password" required name="cpass"><br> 
                New password: <input type="password" required name="npass"><br> <br>               
                <input class="button" type="submit" value="Update clerk"/>
            </form>
        </fieldset><br>
        <br>
             </div>
        </div>
        <footer>
            <a style="text-decoration: none" href="cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>