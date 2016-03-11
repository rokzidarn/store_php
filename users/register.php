 <!DOCTYPE html>
<?php
require_once '../DB/db_init.php';
require_once '../DB/User.php';

$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';
$msg = "WRONG!";

if ($isPost) {
    $rules = array(
        'name' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z\s]{3,18}$/")
        ),
        'lname' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z\s]{3,18}$/")
        ),
        'remail' => array(
            'filter' => FILTER_VALIDATE_EMAIL
        ),
        'address' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9.\s]{4,45}$/")
        ),
        'phone' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[0-9]{9,11}$/")
        ),
        'rpassword' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
        ),
        'cpassword' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
        )
    );
    
     $sent = filter_input_array(INPUT_POST, $rules);
     $cp = ($sent["cpassword"]!=FALSE);
     $rp = ($sent["rpassword"]!=FALSE);
     $p = ($sent["phone"]!=FALSE);
     $a = ($sent["address"]!=FALSE);
     $rm = ($sent["remail"]!=FALSE);
     $n = ($sent["name"]!=FALSE);
     $ln = ($sent["lname"]!=FALSE);
     //var_dump($sent);
    
    if($rp&&$cp&&$a&&$p&&$a&&$rm&&$n&&$ln){
         if($sent["rpassword"] == $sent["cpassword"]){
            try {
                 $exists = User::getUserExists($sent['remail']);
                 if($exists == 0){
                     User::insertNewUser($sent["name"],$sent["lname"],$sent["remail"],$sent["rpassword"],$sent["address"],$sent["phone"]);
                     $msg="Your have been registered!";
                 }
                 else{
                     $msg="User already exists!";
                 }

             } catch (Exception $e) {
                 echo "Prišlo je do napake: {$e->getMessage()}";
             } 
         }
        else {
            $msg="Make sure your passwords match!";
        }    
    }
    else {
        header("Location: ../error.php");
    }
}
else {
    header("Location: ../error.php");
}
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
                <br><br><p>&nbsp;&nbsp;&nbsp;<?=$msg?></p><br><br><br><br><br><br><br><br><br><br>
            </div>             
        </div>        
        <footer>
            <a style="text-decoration: none" href="store/cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>