<?php

require_once '../DB/User.php';

session_start();
$user = $_SESSION["user"];
$uinfo = User::getUserInfo($user);

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Enjoy your shopping at BE store</title>
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
        <p>&nbsp;&nbsp;&nbsp;Username: <?=$user?></p>
            </div>
             <div class="row">
                <form id="b1" action="cart.php" method="POST">
                    <input type="hidden" name="user" value="<?=$user?>"/>
                    <input class="button" type="submit" value="View cart"/>
                </form>
                <form id="b2" action="signout.php" method="POST">
                    <input type="hidden" name="user" value="<?=$user?>"/>
                    <input class="button" type="submit" value="Log out"/>
                </form>
             </div>
             <div class="row">
                <fieldset>
                    <legend>My account information:</legend>
                    <form action="update.php" method="POST">
                        <input type="hidden" name="user" value="<?=$user?>"/>
                        Name: <input type="text" name="name" value="<?=$uinfo["name"]?>" required><br>
                        Current password: <input type="password" required  name="pass"><br>   
                        New password: <input type="password" required  name="npass"><br>
                        Address: <input type="text" name="address" required value="<?=$uinfo["address"]?>"><br>
                        Phone: <input type="text" name="phone" required value="<?=$uinfo["phone"]?>"><br><br>
                        <input class="button" type="submit" value="Update"/>
                    </form>
                </fieldset>
                 <br>
             </div>
            </div>
        <footer>
            <a style="text-decoration: none" href="store/cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>       
</html>