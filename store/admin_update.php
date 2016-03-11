<?php

require_once '../DB/db_init.php';
$url = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';
session_start();
$user = $_SESSION["admin"];
$email = "";

try {
    $dbh = DBInit::getInstance();

    $stmt = $dbh->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bindValue(1, $user);
    $stmt->execute();
    $db = $stmt->fetch();
   
} catch (Exception $ex) {
    die($exc->getMessage());
}
$aname = $db["admin"];
$pass = $db["password"];

if($isPost && $url){
    $rules = [
        'name' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z\s]{3,36}$/"),       
        ),
        'password' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
        ),
        'npassword' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
        )
    ];

    $sent = filter_input_array(INPUT_POST, $rules);    
    try {
        if ($sent["name"]!=FALSE&&$sent["password"]!=FALSE&&$sent["npassword"]!=FALSE) {
            if (password_verify($sent["password"],$pass)) {
                $dbh = DBInit::getInstance();

                $stmt = $dbh->prepare("UPDATE admin SET admin= :name, password= :password WHERE email= :email");
                $stmt->bindParam(":name", $sent["name"]);
                $hash = password_hash($sent["password"], PASSWORD_DEFAULT);
                $stmt->bindParam(":password", $hash);
                $stmt->bindParam(":email", $user);
                $stmt->execute();
                header("Location: admin_management.php");
            }
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
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
                 <p>&nbsp;Admin username: <?=$user?></p>
             </div>
             <div class="row">
        <br>
        <fieldset>
            <legend>Admin information:</legend>
            <form action="<?=$url?>" method="POST">
                <input type="hidden" name="user" value="<?=$user?>"/>
                Name: <input type="text" name="name" required value="<?=$aname?>"><br>
                Current password: <input type="password" required name="password"><br> 
                New password: <input type="password" required name="npassword"><br> <br>               
                <input class="button" type="submit" value="Update admin"/>
            </form>
        </fieldset><br>
        <br><br>
             </div>
        </div>
        <footer>
            <a style="text-decoration: none" href="cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>