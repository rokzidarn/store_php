<?php 
require_once 'DB/Product.php';
?>
<!DOCTYPE html>
 <html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to BE store</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Yellowtail' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="css/main_css.css"/>
        <script src="jquery-1.3.2.min.js" type="text/javascript"></script>
        <script src="data.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <h1><a style="text-decoration: none" href="index.php">BE store</a></h1>
        </header>
        <div id="container">
            
            <div class="row">
                <div id="left">
                    <button id="click" class="button" type="button">BROWSE</button> 
                </div>
                <div></div>               
            </div>
            <div id="browse">
            <table>
                <tr id="t">
                    <td><b>&nbsp;&nbsp;&nbsp;Brand</b></td>
                    <td><b>Model</b></td>
                    <td><b>Category</b></td>
                    <td><b>Color</b></td>
                    <td><b>Price</b></td>
                <br>
                </tr>
                <?php 
                try {
                    $allProducts = Product::getAllProducts();
                    foreach ($allProducts as $key => $value): 
                        $id = $value["idproduct"];
                        $brand = $value["pbrand"];
                        $model = $value["pmodel"];
                        $category = $value["pcategory"];
                        $color = $value["pcolor"];
                        $size = $value["psize"];
                        $price = $value["pprice"];
                ?>
                    <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $brand ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $model ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $category ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= $color ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><?= number_format($price, 2, ',', '.') ?> €&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>                   
                    </tr>
                <?php 
                endforeach;
                } catch (Exception $e) {
                    echo "Error: {$e->getMessage()}";
                }          
                ?>
            </table> 
           <br>
             </div>
            <div class="row">
                <div id="li_box">   
                    <fieldset>
                        <legend>SIGN IN:</legend>
                        <form action="users/signin.php" method="post">
                            E-mail: <input type="text" name="email" required><br>
                            Password: <input type="password" name="password" required><br><br>
                            <input class="button" type="submit" value="SIGN IN">
                        </form>    
                    </fieldset>
                </div>
                <div id="ri_box">   
                    <fieldset>
                        <legend>REGISTRATION:</legend>
                        <form id="reg" action="users/register.php" method="post">
                            First name: <input type="text" name="name" required ><br>
                            Last name: <input type="text" name="lname" required ><br>
                            E-mail: <input type="text" name="remail" required ><br>
                            Address: <input type="text" name="address" required><br>
                            Phone number: <input type="text" name="phone" required><br>
                            Password: <input type="password" name="rpassword" required><br>
                            Confirm password: <input type="password" name="cpassword" required ><br><br>
                            <input class="button" type="submit" value="REGISTER">
                        </form>    
                    </fieldset>
                    <br>
                </div>
            </div>
        </div>
        <footer>
            <a style="text-decoration: none" href="store/cert.php">&COPY; All rights reserved </a>
        </footer>
    </body>
</html>