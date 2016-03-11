<?php
    require_once '../DB/db_init.php';
    $isPost = filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST';

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

    if (($sent["email"] != FALSE && $sent["password"] != FALSE) && ($sent["email"] != NULL && $sent["password"] != NULL)) {
        try {
            $dbh = DBInit::getInstance();

            $stmt = $dbh->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bindValue(1, $sent["email"]);
            $stmt->execute();

            $db = $stmt->fetch();

            if (password_verify($sent["password"],$db["password"])&& $db["status"]=='A') {
                
                session_start();
                $user = $sent["email"];
                if (!isset($_SESSION["user"])) {
                    $_SESSION["user"] = $user;
                    $_SESSION["cart"] = array();
                }
                else{
                    $_SESSION["user"] = $user;
                } 
                header("Location: store.php");
            }
            else {
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
