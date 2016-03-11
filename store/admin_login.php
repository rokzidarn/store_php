 <!DOCTYPE html>
<?php
require_once '../DB/db_init.php';

$isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';
$msg = "WRONG";

if ($isPost) {
    $rules = array(
        'password' => array(
            'filters' => FILTER_SANITIZE_SPECIAL_CHARS,
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array("regexp" => "/^[a-zA-Z0-9]{2,18}$/")
        ),
        'email' => array(
            'filter' => FILTER_VALIDATE_EMAIL
        )
    );

    $sent = filter_input_array(INPUT_POST, $rules);

    if (($sent["email"] != FALSE && $sent["email"] != NULL)&&($sent["password"] != FALSE && $sent["password"] != NULL)) {
        try {
            $dbh = DBInit::getInstance();

            $stmt = $dbh->prepare("SELECT password FROM admin WHERE email = ?");
            $stmt->bindValue(1, $sent["email"]);
            $stmt->execute();

            $db = $stmt->fetch();

            if (password_verify($sent["password"],$db["password"])) {
                
                session_start();
                $user = $sent["email"];
                if (!isset($_SESSION[$user])) {
                    $_SESSION["admin"] = $user;
                }
                else {
                    $_SESSION["admin"] = $user;
                }
                header("Location: admin_management.php");
            }
            else{
                 header("Location: ../error.php");
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    else {
        header("Location: ../error.php");
    }
}
else {
    header("Location: ../error.php");
}
