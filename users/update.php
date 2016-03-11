 <!DOCTYPE html>
<?php
require_once '../DB/db_init.php';
require_once '../DB/User.php';

session_start();
$user = $_SESSION["user"];

$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';

if ($isPost) {
    $rules = array(
        'name' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z\s]{6,36}$/")
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
        'pass' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
        ),
        'npass' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
        )
    );
    
     $sent = filter_input_array(INPUT_POST, $rules);
     $n = $sent["name"]!=NULL && $sent["name"]!=FALSE;
     $a = $sent["address"]!=NULL && $sent["address"]!=FALSE;
     $p = $sent["phone"]!=NULL && $sent["phone"]!=FALSE;
     $np = $sent["pass"]!=NULL && $sent["pass"]!=FALSE;
     $nps = $sent["npass"]!=NULL && $sent["npass"]!=FALSE;
    if($n && $a && $n && $np && $nps){
        try {
            $u = User::getUserInfo($user);
            $up = $u["password"];
            if(password_verify($sent["pass"], $up)){
                User::updateUser($user,$sent["name"], $sent["npass"], $sent["address"], $sent["phone"]);
                $msg = "You have been updated";
                header("Location: info.php");
            }
            else {
                $msg = "Wrong password";
                header("Location: ../error.php");
            }
         } catch (Exception $e) {
             echo "ERROR: {$e->getMessage()}";
         } 
    }  
    else {
        header("Location: ../error.php");
    }
}
else {
    header("Location: ../error.php");
}
